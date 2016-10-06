<?php  
class ControllerModuleCategory extends Controller {
 protected $category_id = 0;
 protected $path = array();
 
 protected function index() {
  $this->language->load('module/category');
  
  $this->data['heading_title'] = $this->language->get('heading_title');
  
  $this->load->model('catalog/category');
  $this->load->model('tool/seo_url');
  
  if (isset($this->request->get['path'])) {
   $this->path = explode('_', $this->request->get['path']);
   
   $this->category_id = end($this->path);
  }
  // 140404 ET-140404 Begin
  $category_spliter_before = unserialize($this->config->get('category_spliter_before'));
  
  $splitters = (isset($category_spliter_before)? $category_spliter_before : array());
  
  //$this->data['category'] = $this->getCategories(0, '', true);
  $this->data['category'] = $this->getCategories(0, $splitters, '', true);
  // 140404 ET-140404 End
            
  $this->id = 'category';

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/module/category.tpl';
  } else {
   $this->template = 'default/template/module/category.tpl';
  }
  
  $this->render();
   }
 
        // 110816 ET-110816 Category Tree Begin
        /*
 protected function getCategories($parent_id, $current_path = '') {
  $category_id = array_shift($this->path);
  
  $output = '';
  
  $results = $this->model_catalog_category->getCategories($parent_id);
  
  if ($results) { 
   $output .= '<ul>';
                }
  
  foreach ($results as $result) { 
   if (!$current_path) {
    $new_path = $result['category_id'];
   } else {
    $new_path = $current_path . '_' . $result['category_id'];
   }
   
   $output .= '<li>';
   
   $children = '';
   
   // 100223 ALNAUA Site redesign Begin
                        //if ($category_id == $result['category_id']) {
                        if ($this->config->get('category_expand')) {
                        // 100223 ALNAUA Site redesign End
    $children = $this->getCategories($result['category_id'], $new_path);
                                $child = $children;
                        // 100223 ALNAUA Site redesign Begin
   } else {
                              if ($category_id == $result['category_id']) {
                                    $children = $this->getCategories($result['category_id'], $new_path);
                                    $child = $children;
                              } else {
                                    $child = $this->getCategories($result['category_id'], $new_path);
                              }
                        // 100223 ALNAUA Site redesign End
                        }

                        $style = 'style="font-size: 13pt; font-family: Arial, sans-serif;"';

                        if ($this->category_id == $result['category_id']) {
                                if ($children) {
                                        $output .= '<b><a ' . $style . ' href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a></b>';
                                } else {
                                        $output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '"><b>' . $result['name'] . '</b></a>';
                                }
                        } else {
                                if ($children) {
                                        $output .= '<a ' . $style . ' href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a>';
                                } else {
                                        if ($child) {
                                                $output .= '<a ' . $style . ' href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a>';
                                        } else {
                                                $output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a>';
                                        }
                                }
                        }
                            // 100908 Add Category Tips Begin
                            $output .= '<a title="'. $result['name'] .'" class="cat_tip" cat_id="'. $result['category_id'] .'"><img style="position: relative; left: 3px;" src="catalog/view/theme/default/image/qmark.gif" alt="" /></a><span id="cat_id'. $result['category_id'] .'" style="display: none;">'. html_entity_decode($result["tip"], ENT_QUOTES, 'UTF-8') .'</span>';
                            // 100908 Add Category Tips End

                            $output .= $children;

                            $output .= '</li>'; 
  }
 
  if ($results) {
   $output .= '</ul>';
  }
  
  return $output;
 } 
*/
 // 140404 ET-140404 Begin
//protected function getCategories($parent_id, $current_path = '', $firstlevel = false) {
 protected function getCategories($parent_id, $splitters = array(), $current_path = '', $firstlevel = false) {
 // 140404 ET-140404 End
  $category_id = array_shift($this->path);
  
  $output = '';
  
  $results = $this->model_catalog_category->getCategories($parent_id);
  
  if ($results) { 
   $output .= '<ul class="category">';
  }

  $need_to_expand = 0;
  $children = array('html' => null, 'need_to_expand' => $need_to_expand);
  
  foreach ($results as $result) { 
   if (!$current_path) {
    $new_path = $result['category_id'];
   } else {
    $new_path = $current_path . '_' . $result['category_id'];
   }
   // 140404 ET-140404 Begin
   //$children = $this->getCategories($result['category_id'], $new_path);
   $children = $this->getCategories($result['category_id'], $splitters, $new_path);
   // 140404 ET-140404 End

   if (($this->category_id == $result['category_id']) || ($children['need_to_expand'] == 1)) {
       $need_to_expand = 1;
   }

   if (($firstlevel && !$children['html']) || ($firstlevel && $children['need_to_expand'] == 0 && !($this->category_id == $result['category_id']))) {
       $need_to_expand = 0;
   }
   
//   echo $result['category_id'] 
//           . ' / ' . $this->category_id
//           . ' / ' . $children['need_to_expand']
//           . ' / ' . $need_to_expand 
//           .  ' / ' . $result['expanded'] 
//           .  ' / ' . ($result['expanded'] || ($need_to_expand == 1)) . '<br />';
   

   $clases = (($result['expanded'] || ($need_to_expand == 1)) ? ($children['html'] ? ' expanded' : ' leaf') : ($children['html'] ? ' collapsed' : ' leaf')). ($firstlevel ? ' root' : '');
   
   // 140404 ET-140404 Begin   
   //$output .= ($result['category_id'] == 6 ? '<br /><li class="node'. $clases .'">' : '<li class="node'. $clases .'">');
   $output .= (in_array($result['category_id'], $splitters) ? '<br /><li class="node'. $clases .'">' : '<li class="node'. $clases .'">');
   // 140404 ET-140404 End
   $output .= '<div class="expand'.($firstlevel ? ' expand_fl' : '').'"></div>';


   $style = ($firstlevel ? 'firstlevel' : '') . ($this->category_id == $result['category_id'] ? ' category_selected' : '');

   $output .= '<div class="category_content">';
   
   // 120902 ET-120828 External links to categories Begin
   //$output .= '<a class="' . $style . '" href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a>';
   if (!$result['external']){
     $output .= '<a class="' . $style . '" href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">' . $result['name'] . '</a>';
   } else {
     $output .= '<a class="' . $style . '" href="' . $result['external_link'] . '" target="_blank">' . $result['name'] . '</a>';
   }
   
   // 120902 ET-120828 External links to categories End

   //$output .= '<a title="'. $result['name'] .'" class="cat_tip" cat_id="'. $result['category_id'] .'"><img style="position: relative; left: 3px;" src="catalog/view/theme/default/image/qmark.gif" alt="" /></a><span id="cat_id'. $result['category_id'] .'" style="display: none;">'. html_entity_decode($result["tip"], ENT_QUOTES, 'UTF-8') .'</span>';

   $output .= '</div>';

   $output .= $children['html'];

   $output .= '</li>'; 
  }
 
  if ($results) {
   $output .= '</ul>';
  }
  
  return array('html' => $output, 'need_to_expand' => $need_to_expand);
 }
        // 110816 ET-110816 Category Tree End
}
?>
<?php 
class ControllerInformationInformation extends Controller {
 public function index() {  
     $this->language->load('information/information');
  
  $this->load->model('catalog/information');
  
        // (+) ALNAUA 091114 (START)
        $this->document->active = '';
        // (+) ALNAUA 091114 (FINISH)

  $this->document->breadcrumbs = array();

       $this->document->breadcrumbs[] = array(
         'href'      => $this->url->http('common/home'),
         'text'      => $this->language->get('text_home'),
         'separator' => FALSE
       );
  
  if (isset($this->request->get['information_id'])) {
   $information_id = $this->request->get['information_id'];
  } else {
   $information_id = 0;
  }
  
  $information_info = $this->model_catalog_information->getInformation($information_id);
     
  if ($information_info) {
            // 100223 ALNAUA Site redesign Begin
     //$this->document->title = $information_info['title'];
            $this->document->title = ($information_info['page_title'] != '' ? $information_info['page_title'] : $information_info['title']);
            $this->document->description = $information_info['meta_description'];
            $this->document->keywords = $information_info['meta_keywords'];
            // 100223 ALNAUA Site redesign End

            if ($information_info['type'] == 'news') {
              $this->document->breadcrumbs[] = array(
                  'href'      => $this->url->http('information/news'),
                  'text'      => $this->language->get('text_news'),
                  'separator' => $this->language->get('text_separator')
              );
            } elseif ( $information_info['type'] == 'page') {

              $parent_information = $this->model_catalog_information->getInformation($information_info['parent_information_id']);
              if($parent_information) {
               if ($parent_information['name'] == 'shopwork') {
                 $this->document->breadcrumbs[] = array(
                   'href'      => $this->url->http('information/shopwork'),
                   'text'      => $this->language->get('text_shopwork'),
                   'separator' => $this->language->get('text_separator')
                 );
               } elseif ($parent_information['name'] == 'service') {
                 $this->document->breadcrumbs[] = array(
                   'href'      => $this->url->http('information/services'),
                   'text'      => $this->language->get('text_services'),
                   'separator' => $this->language->get('text_separator')
                 );
               }
              }
            }

        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/information&information_id=' . $this->request->get['information_id']),
          'text'      => $information_info['title'],
          'separator' => $this->language->get('text_separator')
        );
      
        $this->data['heading_title'] = $information_info['title'];
   
   $this->data['description'] = html_entity_decode($information_info['description']);
        
            // (+) ALNAUA 091114 (START)
            if ($information_info['parent_information_id'] != 0) {
              $parent_information_info = $this->model_catalog_information->getInformation($information_info['parent_information_id']);

              $this->data['name'] = $parent_information_info['name'];
              
              $shopwork_items = $this->model_catalog_information->getItems($information_info['parent_information_id']);
              
              if ($shopwork_items) {
                $this->data['items'] = 'available';
                
                foreach ($shopwork_items as $result) {

                  $this->data['shopwork_items'][] = array(
                          'information_id' => $result['information_id'],
                          'title'       => $result['title'],
                          'href'        => $this->url->http('information/information&information_id=' . $result['information_id'])
                      );
                }
              } else {
                $this->data['items'] = 'none';
              }
              
              $this->data['information_id'] = $information_id;
              $this->data['button_continue'] = $this->language->get('button_back');
              $this->data['continue'] = $this->url->http('information/shopwork');
              if ($parent_information_info['name'] == 'shopwork') {
                $this->document->active = 'shopwork';
              } elseif ($parent_information_info['name'] == 'service') {
                $this->document->active = 'service';
                $this->data['information_id'] = $information_id;
                $this->data['button_continue'] = $this->language->get('button_back');
                $this->data['continue'] = $this->url->http('information/services');
              }
            } elseif($information_info['type'] == 'news') {
              $this->data['button_continue'] = $this->language->get('button_back');
              $this->data['continue'] = $this->url->http('information/news');
              $this->document->active = 'news';
            } else {
            // (+) ALNAUA 091114 (FINISH)
              $this->data['button_continue'] = $this->language->get('button_continue');
              $this->data['continue'] = $this->url->http('common/home');
            // (+) ALNAUA 091114 (START)
            }
            // (+) ALNAUA 091114 (FINISH)

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/information.tpl';
   } else {
    $this->template = 'default/template/information/information.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );  
   
     $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     } else {
        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/information&information_id=' . $this->request->get['information_id']),
          'text'      => $this->language->get('text_error'),
          'separator' => $this->language->get('text_separator')
        );
    
     $this->document->title = $this->language->get('text_error');
   
        $this->data['heading_title'] = $this->language->get('text_error');

        $this->data['text_error'] = $this->language->get('text_error');

        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['continue'] = $this->url->http('common/home');

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
   } else {
    $this->template = 'default/template/error/not_found.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );
  
     $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     }
   }
}
?>
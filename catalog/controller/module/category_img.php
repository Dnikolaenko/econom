<?php  
class ControllerModuleCategoryImg extends Controller {
	protected $category_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/category_img');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		$this->load->model('tool/seo_url');
		
		if (isset($this->request->get['path'])) {
			$this->path = explode('_', $this->request->get['path']);
			
			$this->category_id = end($this->path);
		}
		
		$this->data['category_img'] = $this->getCategories(0);
												
		$this->id = 'category_img';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_img.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category_img.tpl';
		} else {
			$this->template = 'default/template/module/category_img.tpl';
		}
		
		$this->render();
  	}
	
	protected function getCategories($parent_id, $current_path = '') {
		$category_id = array_shift($this->path);
		
		$output = '';
		
		$results = $this->model_catalog_category->getCategories($parent_id);
		
		foreach ($results as $result) {	
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}
			
			$children = '';
			
			if ($category_id == $result['category_id']) {
				$children = $this->getCategories($result['category_id'], $new_path);
			}
			
            if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}
            $this->load->helper('image');
            
            $image_src = image_resize($image, 38, 38);
            $output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $new_path))  . '">';
            $output .= '<div class="cat" style="background: url(\''.$image_src.'\') no-repeat;">';

			if ($this->category_id == $result['category_id']) {
                $output .= '<b>' . $result['name'] . '</b>';
			} else {
                $output .= $result['name'];
			}
            $output .= '</div></a>';
            
        	$output .= $children;
        
		}
 
		return $output;
	}		
}
?>
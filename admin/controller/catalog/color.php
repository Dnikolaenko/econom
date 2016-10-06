<?php 
class ControllerCatalogColor extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/color');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/color');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/color');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/color');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));
				
				if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
					$data['image'] = strtolower(translite($this->request->files['image']['name']));
				}
			}
			
			$this->model_catalog_color->addColor(array_merge($this->request->post, $data));

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/color'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/color');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/color');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));

				if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
					$data['image'] = strtolower(translite($this->request->files['image']['name']));
				}
			}

			$this->model_catalog_color->editColor($this->request->get['color_id'], array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/color'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/color');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/color');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $color_id) {
				$this->model_catalog_color->deleteColor($color_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('catalog/color'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/color'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->https('catalog/color/insert');
		$this->data['delete'] = $this->url->https('catalog/color/delete');
		
		$this->data['colors'] = array();

        // 100223 ALNAUA Site redesign Begin
		//$results = $this->model_catalog_color->getColors();
        $results = $this->model_catalog_color->getColorsAndCategories();
        // 100223 ALNAUA Site redesign End

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/color/update&color_id=' . $result['color_id'])
			);

            $this->load->helper('image');
					
			$this->data['colors'][] = array(
				'color_id'    => $result['color_id'],
                'category_name' => $result['category_name'],
				'name'        => $result['name'],
                // 100223 ALNAUA Site redesign Begin
                //'image'       => HTTP_IMAGE . $result['image'],
                'image'       => image_resize(($result['image']!=''? $result['image'] : 'no_image.jpg'), 50, 50),
                // 100223 ALNAUA Site redesign End
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['color_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'catalog/color_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_color'] = $this->language->get('entry_color');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_image'] = $this->language->get('entry_image');
        // 100223 ALNAUA Site redesign Begin
        $this->data['entry_colorcategory'] = $this->language->get('entry_colorcategory');
        // 100223 ALNAUA Site redesign End

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/color'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['color_id'])) {
			$this->data['action'] = $this->url->https('catalog/color/insert');
		} else {
			$this->data['action'] = $this->url->https('catalog/color/update&color_id=' . $this->request->get['color_id']);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/color');

		if (isset($this->request->get['color_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$color_info = $this->model_catalog_color->getColor($this->request->get['color_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['color_description'])) {
			$this->data['color_description'] = $this->request->post['color_description'];
		} elseif (isset($color_info)) {
			$this->data['color_description'] = $this->model_catalog_color->getColorDescriptions($this->request->get['color_id']);
		} else {
			$this->data['color_description'] = array();
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($color_info)) {
			$this->data['keyword'] = $color_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

        // 100223 ALNAUA Site redesign Begin
        $this->load->model('catalog/colorcategory');
		$this->data['colorcategories'] = $this->model_catalog_colorcategory->getColorCategories();
        
        if (isset($this->request->post['colorcategory_id'])) {
			$this->data['colorcategory_id'] = $this->request->post['colorcategory_id'];
		} elseif (isset($color_info)) {
			$this->data['colorcategory_id'] = $color_info['colorcategory_id'];
		} else {
			$this->data['colorcategory_id'] = '';
		}
        // 100223 ALNAUA Site redesign End

		$this->load->helper('image');

		if (isset($color_info) && $color_info['image'] && file_exists(DIR_IMAGE . $color_info['image'])) {
			$this->data['preview'] = image_resize($color_info['image'], 100, 100);
		} else {
			$this->data['preview'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($color_info)) {
			$this->data['sort_order'] = $color_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		$this->template = 'catalog/color_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/color')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['color_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
   
  		if ($this->request->files['image']['name']) {
	  		if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
        		$this->error['warning'] = $this->language->get('error_filename');
	  		}

		    $allowed = array(
		    	'image/jpeg',
		    	'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
		    );
				
			if (!in_array($this->request->files['image']['type'], $allowed)) {
				$this->error['warning'] = $this->language->get('error_filetype');
			}
			
			if (!is_writable(DIR_IMAGE)) {
				$this->error['warning'] = $this->language->get('error_writable_image');
			}
			
			if (!is_writable(DIR_IMAGE . 'cache/')) {
				$this->error['warning'] = $this->language->get('error_writable_image_cache');
			}
			
			if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) { 
				$this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['image']['error']);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/color')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return TRUE; 
		} else {
			return FALSE;
		}
	}
}
?>
<?php 
class ControllerCatalogAdvCategory extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/advcategory');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advcategory');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/advcategory');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advcategory');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			$this->model_catalog_advcategory->addAdvCategory(array_merge($this->request->post, $data));

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/advcategory'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/advcategory');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advcategory');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();

			$this->model_catalog_advcategory->editAdvCategory($this->request->get['advcategory_id'], array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/advcategory'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/advcategory');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advcategory');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $advcategory_id) {
				$this->model_catalog_advcategory->deleteAdvCategory($advcategory_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('catalog/advcategory'));
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
       		'href'      => $this->url->https('catalog/advcategory'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->https('catalog/advcategory/insert');
		$this->data['delete'] = $this->url->https('catalog/advcategory/delete');
		
		$this->data['advcategories'] = array();
		
		$results = $this->model_catalog_advcategory->getAdvCategories();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/advcategory/update&advcategory_id=' . $result['advcategory_id'])
			);
					
			$this->data['advcategories'][] = array(
				'advcategory_id' => $result['advcategory_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['advcategory_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
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
		
		$this->template = 'catalog/advcategory_list.tpl';
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
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
       		'href'      => $this->url->https('catalog/advcategory'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['advcategory_id'])) {
			$this->data['action'] = $this->url->https('catalog/advcategory/insert');
		} else {
			$this->data['action'] = $this->url->https('catalog/advcategory/update&advcategory_id=' . $this->request->get['advcategory_id']);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/advcategory');

		if (isset($this->request->get['advcategory_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$advcategory_info = $this->model_catalog_advcategory->getAdvCategory($this->request->get['advcategory_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['advcategory_description'])) {
			$this->data['advcategory_description'] = $this->request->post['advcategory_description'];
		} elseif (isset($advcategory_info)) {
			$this->data['advcategory_description'] = $this->model_catalog_advcategory->getAdvCategoryDescriptions($this->request->get['advcategory_id']);
		} else {
			$this->data['advcategory_description'] = array();
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($advcategory_info)) {
			$this->data['keyword'] = $advcategory_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		$this->data['advcategories'] = $this->model_catalog_advcategory->getAdvCategories();

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($advcategory_info)) {
			$this->data['sort_order'] = $advcategory_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		$this->template = 'catalog/advcategory_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/advcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['advcategory_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
   
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/advcategory')) {
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
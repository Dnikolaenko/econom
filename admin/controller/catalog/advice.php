<?php 
class ControllerCatalogAdvice extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/advice');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advice');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/advice');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advice');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			$this->model_catalog_advice->addAdvice(array_merge($this->request->post, $data));

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/advice'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/advice');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advice');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			$this->model_catalog_advice->editAdvice($this->request->get['advice_id'], array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/advice'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/advice');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/advice');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $advice_id) {
				$this->model_catalog_advice->deleteAdvice($advice_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('catalog/advice'));
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
       		'href'      => $this->url->https('catalog/advice'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->https('catalog/advice/insert');
		$this->data['delete'] = $this->url->https('catalog/advice/delete');
		
		$this->data['advices'] = array();
		
		$results = $this->model_catalog_advice->getAdvices();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/advice/update&advice_id=' . $result['advice_id'])
			);

            //$this->load->model('catalog/advcategory');
            //$advcategory = $this->model_catalog_advcategory->getAdvCategory($result['advcategory_id']);
					
			$this->data['advices'][] = array(
				'advice_id' => $result['advice_id'],
				'name'        => $result['name'],
                //'advcategory_name' => $advcategory['name'],
				'date_added'  => $result['date_added'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['advice_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_advcategory_name'] = $this->language->get('column_advcategory_name');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
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
		
		$this->template = 'catalog/advice_list.tpl';
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
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_date_added'] = $this->language->get('entry_date_added');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');

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
       		'href'      => $this->url->https('catalog/advice'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['advice_id'])) {
			$this->data['action'] = $this->url->https('catalog/advice/insert');
		} else {
			$this->data['action'] = $this->url->https('catalog/advice/update&advice_id=' . $this->request->get['advice_id']);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/advice');

		if (isset($this->request->get['advice_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$advice_info = $this->model_catalog_advice->getAdvice($this->request->get['advice_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['advice_description'])) {
			$this->data['advice_description'] = $this->request->post['advice_description'];
		} elseif (isset($advice_info)) {
			$this->data['advice_description'] = $this->model_catalog_advice->getAdviceDescriptions($this->request->get['advice_id']);
		} else {
			$this->data['advice_description'] = array();
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($advice_info)) {
			$this->data['keyword'] = $advice_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
        $this->load->model('catalog/advcategory');
		$this->data['advcategories'] = $this->model_catalog_advcategory->getAdvCategories();

		if (isset($this->request->post['advcategory_id'])) {
			$this->data['advcategory_id'] = $this->request->post['advcategory_id'];
		} elseif (isset($advice_info)) {
			$this->data['advcategory_id'] = $advice_info['advcategory_id'];
		} else {
			$this->data['advcategory_id'] = 0;
		}

		if (isset($this->request->post['date_added'])) {
			$this->data['date_added'] = $this->request->post['date_added'];
		} elseif (isset($advice_info)) {
			$this->data['date_added'] = $advice_info['date_added'];
		} else {
			$this->data['date_added'] = date('Y') . '-' . date('m') . '-' . date('d');
		}
		
		$this->template = 'catalog/advice_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/advice')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['advice_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'catalog/advice')) {
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
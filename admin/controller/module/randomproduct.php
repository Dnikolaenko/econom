<?php
class ControllerModuleRandomProduct extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/randomproduct');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('randomproduct', $this->request->post);
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->https('extension/module'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		//$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		
		//$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('extension/module'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('module/randomproduct'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->https('module/randomproduct');
		
		$this->data['cancel'] = $this->url->https('extension/module');

//		if (isset($this->request->post['randomproduct_limit'])) {
//			$this->data['randomproduct_limit'] = $this->request->post['randomproduct_limit'];
//		} else {
//			$this->data['randomproduct_limit'] = $this->config->get('randomproduct_limit');
//		}	
		
		if (isset($this->request->post['randomproduct_position'])) {
			$this->data['randomproduct_position'] = $this->request->post['randomproduct_position'];
		} else {
			$this->data['randomproduct_position'] = $this->config->get('randomproduct_position');
		}
		
		if (isset($this->request->post['randomproduct_status'])) {
			$this->data['randomproduct_status'] = $this->request->post['randomproduct_status'];
		} else {
			$this->data['randomproduct_status'] = $this->config->get('randomproduct_status');
		}
		
		if (isset($this->request->post['randomproduct_sort_order'])) {
			$this->data['randomproduct_sort_order'] = $this->request->post['randomproduct_sort_order'];
		} else {
			$this->data['randomproduct_sort_order'] = $this->config->get('randomproduct_sort_order');
		}				
		
		$this->template = 'module/randomproduct.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/randomproduct')) {
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
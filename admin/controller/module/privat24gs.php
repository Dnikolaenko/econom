<?php 
class ControllerModulePrivat24gs extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/privat24gs');

		$this->document->title = ($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('privat24gs', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('extension/module'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_pay'] = $this->language->get('text_pay');
		$this->data['text_card'] = $this->language->get('text_card');
		
		$this->data['entry_merchant'] = $this->language->get('entry_merchant');
		$this->data['entry_signature'] = $this->language->get('entry_signature');
		$this->data['entry_type'] = $this->language->get('entry_type');				
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
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

		if (isset($this->error['merchant'])) { 
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}
		
		if (isset($this->error['signature'])) { 
			$this->data['error_signature'] = $this->error['signature'];
		} else {
			$this->data['error_signature'] = '';
		}
		
		if (isset($this->error['type'])) { 
			$this->data['error_type'] = $this->error['type'];
		} else {
			$this->data['error_type'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->https('common/home'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->https('extension/payment'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->https('payment/privat24gs'),      		
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->https('module/privat24gs');
		
		$this->data['cancel'] = $this->url->https('extension/module');
		
		if (isset($this->request->post['privat24gs_merchant'])) {
			$this->data['privat24gs_merchant'] = $this->request->post['privat24gs_merchant'];
		} else {
			$this->data['privat24gs_merchant'] = $this->config->get('privat24gs_merchant');
		}

		if (isset($this->request->post['privat24gs_signature'])) {
			$this->data['privat24gs_signature'] = $this->request->post['privat24gs_signature'];
		} else {
			$this->data['privat24gs_signature'] = $this->config->get('privat24gs_signature');
		}

		if (isset($this->request->post['privat24gs_type'])) {
			$this->data['privat24gs_type'] = $this->request->post['privat24gs_type'];
		} else {
			$this->data['privat24gs_type'] = $this->config->get('privat24gs_type');
		}
		
		if (isset($this->request->post['privat24gs_total'])) {
			$this->data['privat24gs_total'] = $this->request->post['privat24gs_total'];
		} else {
			$this->data['privat24gs_total'] = $this->config->get('privat24gs_total'); 
		} 
				
		if (isset($this->request->post['privat24gs_order_status_id'])) {
			$this->data['privat24gs_order_status_id'] = $this->request->post['privat24gs_order_status_id'];
		} else {
			$this->data['privat24gs_order_status_id'] = $this->config->get('privat24gs_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['privat24gs_geo_zone_id'])) {
			$this->data['privat24gs_geo_zone_id'] = $this->request->post['privat24gs_geo_zone_id'];
		} else {
			$this->data['privat24gs_geo_zone_id'] = $this->config->get('privat24gs_geo_zone_id'); 
		} 		
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['privat24gs_status'])) {
			$this->data['privat24gs_status'] = $this->request->post['privat24gs_status'];
		} else {
			$this->data['privat24gs_status'] = $this->config->get('privat24gs_status');
		}
		
		if (isset($this->request->post['privat24gs_sort_order'])) {
			$this->data['privat24gs_sort_order'] = $this->request->post['privat24gs_sort_order'];
		} else {
			$this->data['privat24gs_sort_order'] = $this->config->get('privat24gs_sort_order');
		}

		$this->template = 'module/privat24gs.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/privat24gs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['privat24gs_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['privat24gs_signature']) {
			$this->error['signature'] = $this->language->get('error_signature');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>
<?php 
class ControllerTotalOrderDiscount extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('total/order_discount');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('order_discount', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('extension/total'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['entry_discount_from'] = $this->language->get('entry_discount_from');
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
       		'href'      => $this->url->https('extension/total'),
       		'text'      => $this->language->get('text_total'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('total/order_discount'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->https('total/order_discount');
		
		$this->data['cancel'] = $this->url->https('extension/total');

		if (isset($this->request->post['order_discount_status'])) {
			$this->data['order_discount_status'] = $this->request->post['order_discount_status'];
		} else {
			$this->data['order_discount_status'] = $this->config->get('order_discount_status');
		}

		if (isset($this->request->post['order_discount_sort_order'])) {
			$this->data['order_discount_sort_order'] = $this->request->post['order_discount_sort_order'];
		} else {
			$this->data['order_discount_sort_order'] = $this->config->get('order_discount_sort_order');
		}
        
        if (isset($this->request->post['order_discount_sum1'])) {
			$this->data['order_discount_sum1'] = $this->request->post['order_discount_sum1'];
		} else {
			$this->data['order_discount_sum1'] = $this->config->get('order_discount_sum1');
		}
        
        if (isset($this->request->post['order_discount_sum2'])) {
			$this->data['order_discount_sum2'] = $this->request->post['order_discount_sum2'];
		} else {
			$this->data['order_discount_sum2'] = $this->config->get('order_discount_sum2');
		}
        
        if (isset($this->request->post['order_discount_sum3'])) {
			$this->data['order_discount_sum3'] = $this->request->post['order_discount_sum3'];
		} else {
			$this->data['order_discount_sum3'] = $this->config->get('order_discount_sum3');
		}
        
        if (isset($this->request->post['order_discount_sum4'])) {
			$this->data['order_discount_sum4'] = $this->request->post['order_discount_sum4'];
		} else {
			$this->data['order_discount_sum4'] = $this->config->get('order_discount_sum4');
		}
        
        if (isset($this->request->post['order_discount_sum5'])) {
			$this->data['order_discount_sum5'] = $this->request->post['order_discount_sum5'];
		} else {
			$this->data['order_discount_sum5'] = $this->config->get('order_discount_sum5');
		}
        
        if (isset($this->request->post['order_discount_percent1'])) {
			$this->data['order_discount_percent1'] = $this->request->post['order_discount_percent1'];
		} else {
			$this->data['order_discount_percent1'] = $this->config->get('order_discount_percent1');
		}

        if (isset($this->request->post['order_discount_percent2'])) {
			$this->data['order_discount_percent2'] = $this->request->post['order_discount_percent2'];
		} else {
			$this->data['order_discount_percent2'] = $this->config->get('order_discount_percent2');
		}

        if (isset($this->request->post['order_discount_percent3'])) {
			$this->data['order_discount_percent3'] = $this->request->post['order_discount_percent3'];
		} else {
			$this->data['order_discount_percent3'] = $this->config->get('order_discount_percent3');
		}

        if (isset($this->request->post['order_discount_percent4'])) {
			$this->data['order_discount_percent4'] = $this->request->post['order_discount_percent4'];
		} else {
			$this->data['order_discount_percent4'] = $this->config->get('order_discount_percent4');
		}

        if (isset($this->request->post['order_discount_percent5'])) {
			$this->data['order_discount_percent5'] = $this->request->post['order_discount_percent5'];
		} else {
			$this->data['order_discount_percent5'] = $this->config->get('order_discount_percent5');
		}

																				
		$this->template = 'total/order_discount.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/order_discount')) {
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
<?php
class ControllerShippingUsps extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/usps');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('usps', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->https('extension/shipping'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_domestic_0'] = $this->language->get('text_domestic_0');
		$this->data['text_domestic_1'] = $this->language->get('text_domestic_1');
		$this->data['text_domestic_2'] = $this->language->get('text_domestic_2');
		$this->data['text_domestic_3'] = $this->language->get('text_domestic_3');
		$this->data['text_domestic_4'] = $this->language->get('text_domestic_4');
		$this->data['text_domestic_5'] = $this->language->get('text_domestic_5');
		$this->data['text_domestic_6'] = $this->language->get('text_domestic_6');
		$this->data['text_domestic_7'] = $this->language->get('text_domestic_7');
		$this->data['text_domestic_12'] = $this->language->get('text_domestic_12');
		$this->data['text_domestic_13'] = $this->language->get('text_domestic_13');
		$this->data['text_domestic_16'] = $this->language->get('text_domestic_16');
		$this->data['text_domestic_17'] = $this->language->get('text_domestic_17');
		$this->data['text_domestic_18'] = $this->language->get('text_domestic_18');
		$this->data['text_domestic_19'] = $this->language->get('text_domestic_19');
		$this->data['text_domestic_22'] = $this->language->get('text_domestic_22');
		$this->data['text_domestic_23'] = $this->language->get('text_domestic_23');
		$this->data['text_domestic_25'] = $this->language->get('text_domestic_25');
		$this->data['text_domestic_27'] = $this->language->get('text_domestic_27');
		$this->data['text_domestic_28'] = $this->language->get('text_domestic_28');
		$this->data['text_international_1'] = $this->language->get('text_international_1');
		$this->data['text_international_2'] = $this->language->get('text_international_2');
		$this->data['text_international_4'] = $this->language->get('text_international_4');
		$this->data['text_international_5'] = $this->language->get('text_international_5');
		$this->data['text_international_6'] = $this->language->get('text_international_6');
		$this->data['text_international_7'] = $this->language->get('text_international_7');
		$this->data['text_international_8'] = $this->language->get('text_international_8');
		$this->data['text_international_9'] = $this->language->get('text_international_9');
		$this->data['text_international_10'] = $this->language->get('text_international_10');
		$this->data['text_international_11'] = $this->language->get('text_international_11');
		$this->data['text_international_12'] = $this->language->get('text_international_12');
		$this->data['text_international_13'] = $this->language->get('text_international_13');
		$this->data['text_international_14'] = $this->language->get('text_international_14');
		$this->data['text_international_15'] = $this->language->get('text_international_15');
		$this->data['text_international_16'] = $this->language->get('text_international_16');
		$this->data['text_international_21'] = $this->language->get('text_international_21');
		
		$this->data['entry_user_id'] = $this->language->get('entry_user_id');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_domestic'] = $this->language->get('entry_domestic');
		$this->data['entry_international'] = $this->language->get('entry_international');
		$this->data['entry_size'] = $this->language->get('entry_size');
		$this->data['entry_container'] = $this->language->get('entry_container');
		$this->data['entry_machinable'] = $this->language->get('entry_machinable');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_girth'] = $this->language->get('entry_girth');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
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
		
 		if (isset($this->error['user_id'])) {
			$this->data['error_user_id'] = $this->error['user_id'];
		} else {
			$this->data['error_user_id'] = '';
		}

 		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

 		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}
		
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('extension/shipping'),
       		'text'      => $this->language->get('text_shipping'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('shipping/usps'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->https('shipping/usps');
		
		$this->data['cancel'] = $this->url->https('extension/shipping');

		if (isset($this->request->post['usps_user_id'])) {
			$this->data['usps_user_id'] = $this->request->post['usps_user_id'];
		} else {
			$this->data['usps_user_id'] = $this->config->get('usps_user_id');
		}
		
		if (isset($this->request->post['usps_password'])) {
			$this->data['usps_password'] = $this->request->post['usps_password'];
		} else {
			$this->data['usps_password'] = $this->config->get('usps_password');
		}

		if (isset($this->request->post['usps_postcode'])) {
			$this->data['usps_postcode'] = $this->request->post['usps_postcode'];
		} else {
			$this->data['usps_postcode'] = $this->config->get('usps_postcode');
		}
		
		if (isset($this->request->post['usps_domestic_0'])) {
			$this->data['usps_domestic_0'] = $this->request->post['usps_domestic_0'];
		} else {
			$this->data['usps_domestic_0'] = $this->config->get('usps_domestic_0');
		}

		if (isset($this->request->post['usps_domestic_1'])) {
			$this->data['usps_domestic_1'] = $this->request->post['usps_domestic_1'];
		} else {
			$this->data['usps_domestic_1'] = $this->config->get('usps_domestic_1');
		}

		if (isset($this->request->post['usps_domestic_2'])) {
			$this->data['usps_domestic_2'] = $this->request->post['usps_domestic_2'];
		} else {
			$this->data['usps_domestic_2'] = $this->config->get('usps_domestic_2');
		}
	
		if (isset($this->request->post['usps_domestic_3'])) {
			$this->data['usps_domestic_3'] = $this->request->post['usps_domestic_3'];
		} else {
			$this->data['usps_domestic_3'] = $this->config->get('usps_domestic_3');
		}

		if (isset($this->request->post['usps_domestic_4'])) {
			$this->data['usps_domestic_4'] = $this->request->post['usps_domestic_4'];
		} else {
			$this->data['usps_domestic_4'] = $this->config->get('usps_domestic_4');
		}

		if (isset($this->request->post['usps_domestic_5'])) {
			$this->data['usps_domestic_5'] = $this->request->post['usps_domestic_5'];
		} else {
			$this->data['usps_domestic_5'] = $this->config->get('usps_domestic_5');
		}

		if (isset($this->request->post['usps_domestic_6'])) {
			$this->data['usps_domestic_6'] = $this->request->post['usps_domestic_6'];
		} else {
			$this->data['usps_domestic_6'] = $this->config->get('usps_domestic_6');
		}

		if (isset($this->request->post['usps_domestic_7'])) {
			$this->data['usps_domestic_7'] = $this->request->post['usps_domestic_7'];
		} else {
			$this->data['usps_domestic_7'] = $this->config->get('usps_domestic_7');
		}
	
		if (isset($this->request->post['usps_domestic_12'])) {
			$this->data['usps_domestic_12'] = $this->request->post['usps_domestic_12'];
		} else {
			$this->data['usps_domestic_12'] = $this->config->get('usps_domestic_12');
		}
	
		if (isset($this->request->post['usps_domestic_13'])) {
			$this->data['usps_domestic_13'] = $this->request->post['usps_domestic_13'];
		} else {
			$this->data['usps_domestic_13'] = $this->config->get('usps_domestic_13');
		}

		if (isset($this->request->post['usps_domestic_16'])) {
			$this->data['usps_domestic_16'] = $this->request->post['usps_domestic_16'];
		} else {
			$this->data['usps_domestic_16'] = $this->config->get('usps_domestic_16');
		}

		if (isset($this->request->post['usps_domestic_17'])) {
			$this->data['usps_domestic_17'] = $this->request->post['usps_domestic_17'];
		} else {
			$this->data['usps_domestic_17'] = $this->config->get('usps_domestic_17');
		}

		if (isset($this->request->post['usps_domestic_18'])) {
			$this->data['usps_domestic_18'] = $this->request->post['usps_domestic_18'];
		} else {
			$this->data['usps_domestic_18'] = $this->config->get('usps_domestic_18');
		}

		if (isset($this->request->post['usps_domestic_19'])) {
			$this->data['usps_domestic_19'] = $this->request->post['usps_domestic_19'];
		} else {
			$this->data['usps_domestic_19'] = $this->config->get('usps_domestic_19');
		}
	
		if (isset($this->request->post['usps_domestic_22'])) {
			$this->data['usps_domestic_22'] = $this->request->post['usps_domestic_22'];
		} else {
			$this->data['usps_domestic_22'] = $this->config->get('usps_domestic_22');
		}

		if (isset($this->request->post['usps_domestic_23'])) {
			$this->data['usps_domestic_23'] = $this->request->post['usps_domestic_23'];
		} else {
			$this->data['usps_domestic_23'] = $this->config->get('usps_domestic_23');
		}

		if (isset($this->request->post['usps_domestic_25'])) {
			$this->data['usps_domestic_25'] = $this->request->post['usps_domestic_25'];
		} else {
			$this->data['usps_domestic_25'] = $this->config->get('usps_domestic_25');
		}
		
		if (isset($this->request->post['usps_domestic_27'])) {
			$this->data['usps_domestic_27'] = $this->request->post['usps_domestic_27'];
		} else {
			$this->data['usps_domestic_27'] = $this->config->get('usps_domestic_27');
		}

		if (isset($this->request->post['usps_domestic_28'])) {
			$this->data['usps_domestic_28'] = $this->request->post['usps_domestic_28'];
		} else {
			$this->data['usps_domestic_28'] = $this->config->get('usps_domestic_28');
		}

		if (isset($this->request->post['usps_international_1'])) {
			$this->data['usps_international_1'] = $this->request->post['usps_international_1'];
		} else {
			$this->data['usps_international_1'] = $this->config->get('usps_international_1');
		}

		if (isset($this->request->post['usps_international_2'])) {
			$this->data['usps_international_2'] = $this->request->post['usps_international_2'];
		} else {
			$this->data['usps_international_2'] = $this->config->get('usps_international_2');
		}

		if (isset($this->request->post['usps_international_4'])) {
			$this->data['usps_international_4'] = $this->request->post['usps_international_4'];
		} else {
			$this->data['usps_international_4'] = $this->config->get('usps_international_4');
		}

		if (isset($this->request->post['usps_international_5'])) {
			$this->data['usps_international_5'] = $this->request->post['usps_international_5'];
		} else {
			$this->data['usps_international_5'] = $this->config->get('usps_international_5');
		}

		if (isset($this->request->post['usps_international_6'])) {
			$this->data['usps_international_6'] = $this->request->post['usps_international_6'];
		} else {
			$this->data['usps_international_6'] = $this->config->get('usps_international_6');
		}
		
		if (isset($this->request->post['usps_international_7'])) {
			$this->data['usps_international_7'] = $this->request->post['usps_international_7'];
		} else {
			$this->data['usps_international_7'] = $this->config->get('usps_international_7');
		}
		
		if (isset($this->request->post['usps_international_8'])) {
			$this->data['usps_international_8'] = $this->request->post['usps_international_8'];
		} else {
			$this->data['usps_international_8'] = $this->config->get('usps_international_8');
		}

		if (isset($this->request->post['usps_international_9'])) {
			$this->data['usps_international_9'] = $this->request->post['usps_international_9'];
		} else {
			$this->data['usps_international_9'] = $this->config->get('usps_international_9');
		}

		if (isset($this->request->post['usps_international_10'])) {
			$this->data['usps_international_10'] = $this->request->post['usps_international_10'];
		} else {
			$this->data['usps_international_10'] = $this->config->get('usps_international_10');
		}

		if (isset($this->request->post['usps_international_11'])) {
			$this->data['usps_international_11'] = $this->request->post['usps_international_11'];
		} else {
			$this->data['usps_international_11'] = $this->config->get('usps_international_11');
		}
		
		if (isset($this->request->post['usps_international_12'])) {
			$this->data['usps_international_12'] = $this->request->post['usps_international_12'];
		} else {
			$this->data['usps_international_12'] = $this->config->get('usps_international_12');
		}
	
		if (isset($this->request->post['usps_international_13'])) {
			$this->data['usps_international_13'] = $this->request->post['usps_international_13'];
		} else {
			$this->data['usps_international_13'] = $this->config->get('usps_international_13');
		}

		if (isset($this->request->post['usps_international_14'])) {
			$this->data['usps_international_14'] = $this->request->post['usps_international_14'];
		} else {
			$this->data['usps_international_14'] = $this->config->get('usps_international_14');
		}

		if (isset($this->request->post['usps_international_15'])) {
			$this->data['usps_international_15'] = $this->request->post['usps_international_15'];
		} else {
			$this->data['usps_international_15'] = $this->config->get('usps_international_15');
		}
		
		if (isset($this->request->post['usps_international_16'])) {
			$this->data['usps_international_16'] = $this->request->post['usps_international_16'];
		} else {
			$this->data['usps_international_16'] = $this->config->get('usps_international_16');
		}

		if (isset($this->request->post['usps_international_21'])) {
			$this->data['usps_international_21'] = $this->request->post['usps_international_21'];
		} else {
			$this->data['usps_international_21'] = $this->config->get('usps_international_21');
		}
		
		if (isset($this->request->post['usps_size'])) {
			$this->data['usps_size'] = $this->request->post['usps_size'];
		} else {
			$this->data['usps_size'] = $this->config->get('usps_size');
		}
		
		$this->data['sizes'] = array();
		
		$this->data['sizes'][] = array(
			'text'  => $this->language->get('text_regular'),
			'value' => 'REGULAR'
		);

		$this->data['sizes'][] = array(
			'text'  => $this->language->get('text_large'),
			'value' => 'LARGE'
		);
		
		$this->data['sizes'][] = array(
			'text'  => $this->language->get('text_oversize'),
			'value' => 'OVERSIZE'
		);

		if (isset($this->request->post['usps_container'])) {
			$this->data['usps_container'] = $this->request->post['usps_container'];
		} else {
			$this->data['usps_container'] = $this->config->get('usps_container');
		}
		
		$this->data['containers'] = array();
		
		$this->data['containers'][] = array(
			'text'  => $this->language->get('text_rectangular'),
			'value' => 'RECTANGULAR'
		);

		$this->data['containers'][] = array(
			'text'  => $this->language->get('text_non_rectangular'),
			'value' => 'NONRECTANGULAR'
		);
		
		$this->data['containers'][] = array(
			'text'  => $this->language->get('text_variable'),
			'value' => 'VARIABLE'
		);

		if (isset($this->request->post['usps_machinable'])) {
			$this->data['usps_machinable'] = $this->request->post['usps_machinable'];
		} else {
			$this->data['usps_machinable'] = $this->config->get('usps_machinable');
		}
		
		if (isset($this->request->post['usps_length'])) {
			$this->data['usps_length'] = $this->request->post['usps_length'];
		} else {
			$this->data['usps_length'] = $this->config->get('usps_length');
		}
		
		if (isset($this->request->post['usps_width'])) {
			$this->data['usps_width'] = $this->request->post['usps_width'];
		} else {
			$this->data['usps_width'] = $this->config->get('usps_width');
		}
		
		if (isset($this->request->post['usps_height'])) {
			$this->data['usps_height'] = $this->request->post['usps_height'];
		} else {
			$this->data['usps_height'] = $this->config->get('usps_height');
		}

		if (isset($this->request->post['usps_length'])) {
			$this->data['usps_length'] = $this->request->post['usps_length'];
		} else {
			$this->data['usps_length'] = $this->config->get('usps_length');
		}
		
		if (isset($this->request->post['usps_girth'])) {
			$this->data['usps_girth'] = $this->request->post['usps_girth'];
		} else {
			$this->data['usps_girth'] = $this->config->get('usps_girth');
		}
		
		if (isset($this->request->post['usps_tax_class_id'])) {
			$this->data['usps_tax_class_id'] = $this->request->post['usps_tax_class_id'];
		} else {
			$this->data['usps_tax_class_id'] = $this->config->get('usps_tax_class_id');
		}

		if (isset($this->request->post['usps_geo_zone_id'])) {
			$this->data['usps_geo_zone_id'] = $this->request->post['usps_geo_zone_id'];
		} else {
			$this->data['usps_geo_zone_id'] = $this->config->get('usps_geo_zone_id');
		}
	
		if (isset($this->request->post['usps_status'])) {
			$this->data['usps_status'] = $this->request->post['usps_status'];
		} else {
			$this->data['usps_status'] = $this->config->get('usps_status');
		}
		
		if (isset($this->request->post['usps_sort_order'])) {
			$this->data['usps_sort_order'] = $this->request->post['usps_sort_order'];
		} else {
			$this->data['usps_sort_order'] = $this->config->get('usps_sort_order');
		}				
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->template = 'shipping/usps.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/usps')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['usps_user_id']) {
			$this->error['user_id'] = $this->language->get('error_user_id');
		}
		
		if (!$this->request->post['usps_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['usps_postcode']) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>
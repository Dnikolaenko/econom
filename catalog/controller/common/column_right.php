<?php  
class ControllerCommonColumnRight extends Controller {
	protected function index() {
		$module_data = array();
		
		$this->load->model('checkout/extension');
		
		$results = $this->model_checkout_extension->getExtensions('module');

		foreach ($results as $result) {
			if ($this->config->get($result['key'] . '_status') && ($this->config->get($result['key'] . '_position') == 'right')) {
				$module_data[] = array(
					'code'       => $result['key'],
					'sort_order' => $this->config->get($result['key'] . '_sort_order')
				);
				
				$this->children[] = 'module/' . $result['key'];
			}
		}

		$sort_order = array(); 
	  
		foreach ($module_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}

    	array_multisort($sort_order, SORT_ASC, $module_data);			
		
		$this->data['modules'] = $module_data;

        // (+) ALNAUA 100120 Banner Upload (START)
        $this->data['config_banner_display'] = $this->config->get('config_banner_display');
        $this->data['config_banner'] = $this->config->get('config_banner');
        $this->data['config_banner_ext'] = substr($this->config->get('config_banner'), strlen($this->config->get('config_banner'))-3, 3);
        $this->data['config_banner_url'] = $this->config->get('config_banner_url');

        if ($this->config->get('config_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_banner'))) {
			if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
				$this->data['preview_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_banner');
			} else {
				$this->data['preview_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_banner');
			}
        }
        // (+) ALNAUA 100120 Banner Upload (FINISH)
        // 100217 ALNAUA Second right-bottom banner Begin
        $this->data['config_second_banner_display'] = $this->config->get('config_second_banner_display');
        $this->data['config_second_banner'] = $this->config->get('config_second_banner');
        $this->data['config_second_banner_ext'] = substr($this->config->get('config_second_banner'), strlen($this->config->get('config_second_banner'))-3, 3);
        $this->data['config_second_banner_url'] = $this->config->get('config_second_banner_url');

        if ($this->config->get('config_second_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_second_banner'))) {
			if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
				$this->data['preview_second_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_second_banner');
			} else {
				$this->data['preview_second_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_second_banner');
			}
        }
        // 100217 ALNAUA Second right-bottom banner End
		
		$this->id = 'column_right';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/column_right.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/column_right.tpl';
		} else {
			$this->template = 'default/template/common/column_right.tpl';
		}
		
		$this->render();
	}
}
?>
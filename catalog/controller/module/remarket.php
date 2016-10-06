<?php 
Class ControllerModuleRemarket extends Controller {
	public function index() {

    $this->language->load('module/remarket');

	$this->data['text_title'] = $this->language->get('text_title');

	$this->load->model('module/remarket');


	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/remarket.tpl')) {
        $this->template = $this->config->get('config_template') . '/template/module/remarket.tpl';
        } else {
        $this->template = 'default/template/module/remarket.tpl';
	}		
	$this->render();
	}
}
?>
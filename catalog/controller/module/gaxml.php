<?php
Class ControllerModuleGaxml extends Controller {
	protected function index() {
		$this->language->load('module/gaxml');

		$this->data['text_title'] = $this->language->get('text_title');

		$this->load->model('module/gaxml');

	$getxml = $this->model_module_gaxml->getcategories();

	// $this->data[] = $this->getxml;

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/gaxml.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/gaxml.tpl';
		} else {
			$this->template = 'default/template/module/gaxml.tpl';
		}		
		$this->render();
	}
}
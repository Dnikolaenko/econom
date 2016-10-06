<?php 
class ControllerToolExport extends Controller { 
	private $error = array();
	
	public function index() {
		$this->load->language('tool/export');
		$this->document->title = $this->language->get('heading_title');
		$this->load->model('tool/export');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
				//if ($this->model_tool_export->upload($file)) {
                if ($this->model_tool_export->upload_price($file)) {
					$this->session->data['success'] = $this->language->get('text_success');
					$this->redirect($this->url->https('tool/export'));
				}
				else {
					$this->error['warning'] = $this->language->get('error_upload');
				}
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_restore'] = $this->language->get('entry_restore');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['tab_general'] = $this->language->get('tab_general');

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
		
		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'      => $this->url->https('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
			'href'      => $this->url->https('tool/export'),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->https('tool/export');

		$this->data['export'] = $this->url->https('tool/export/download');

		$this->template = 'tool/export.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',	
		);
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}


	public function download() {
		if ($this->validate()) {

			// set appropriate memory and timeout limits
			ini_set("memory_limit", "128M");
			set_time_limit( 1800 );

			// send the categories, products and options as a spreadsheet file
			$this->load->model('tool/export');
			//$this->model_tool_export->download();
            $this->model_tool_export->download_price();

		} else {

			// return a HTTP 404 error
			return $this->forward('error/not_found', 'index');
		}
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export')) {
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
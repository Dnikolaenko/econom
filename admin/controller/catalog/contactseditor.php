<?php
class ControllerCatalogContactsEditor extends Controller {

	public function index() {
		$this->load->language('catalog/contactseditor');

		$this->document->title = $this->language->get('heading_title');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['tab_general'] = $this->language->get('tab_general');

        $this->template = 'catalog/contactseditor.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>
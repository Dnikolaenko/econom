<?php 
class ControllerAccountUnsubscribe extends Controller {
	public function index() {
    	$this->language->load('account/unsubscribe');

        $this->document->title = $this->language->get('heading_title');

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href'      => $this->url->http('common/home'),
            'text'      => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href'      => $this->url->http('account/unsubscribe'),
            'text'      => $this->language->get('heading_title'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        if (($this->request->server['REQUEST_METHOD'] == 'GET') && isset($this->request->get['email'])) {

            $this->load->model('account/customer');

            $total = $this->model_account_customer->getTotalCustomersByEmail($this->request->get['email']);

            if ($total > 0) {
                $this->data['text_message'] = $this->language->get('text_message');
                $this->model_account_customer->unsubscribeNewsletter($this->request->get['email']);
            } else {
                $this->data['text_message'] = $this->language->get('text_error_message');
            }
        } else {
            $this->data['text_message'] = $this->language->get('text_error_message');
        }
		
    	$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->http('common/home');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/unsubscribe.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/unsubscribe.tpl';
		} else {
			$this->template = 'default/template/account/unsubscribe.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));				
  	}
}
?>
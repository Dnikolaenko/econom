<?php
class ControllerModuleLiqPay extends Controller {
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$this->data['action'] = 'https://liqpay.com/?do=click_n_buy';
		
		$xml  = '<request>';
		$xml .= '	<version>1.2</version>';
		$xml .= '	<result_url>' . $this->url->https('checkout/success') . '</result_url>';
		$xml .= '	<server_url>' . $this->url->https('payment/liqpay/callback') . '</server_url>';
		$xml .= '	<merchant_id>' . $this->config->get('liqpay_merchant_id') . '</merchant_id>';
		$xml .= '	<order_id>' . $this->session->data['order_id'] . '</order_id>';
		$xml .= '	<amount>' . $this->currency->format($order_info['total'], $order_info['totone'], $order_info['tottwo'], $order_info['currency'], $order_info['value'], FALSE) . '</amount>';
		$xml .= '	<currency>' . $order_info['currency'] . '</currency>';
		$xml .= '	<description>' . $this->config->get('config_store') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'] . '</description>';
		$xml .= '	<default_phone></default_phone>';
		$xml .= '	<pay_way>' . $this->config->get('liqpay_type') . '</pay_way>';
		$xml .= '</request>';
		
		$this->data['xml'] = base64_encode($xml);
		$this->data['signature'] = base64_encode(sha1($this->config->get('liqpay_signature') . $xml . $this->config->get('liqpay_signature'), TRUE));
		
		if ($this->request->get['route'] != 'checkout/guest/confirm') {
			$this->data['back'] = $this->url->https('checkout/payment');
		} else {
			$this->data['back'] = $this->url->https('checkout/guest');
		}
		
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/liqpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/liqpay.tpl';
		} else {
			$this->template = 'default/template/module/liqpay.tpl';
		}	
		
		$this->render();
	}

	public function callback() {
		$xml = base64_decode($this->request->post['operation_xml']);
		$signature = base64_encode(sha1($this->config->get('liqpay_signature') . $xml . $this->config->get('liqpay_signature'), TRUE));
		
		$posleft = strpos($xml, 'order_id');
		$posright = strpos($xml, '/order_id');
		
		$order_id = substr($xml, $posleft + 9, $posright - $posleft - 10);
		
		if ($signature == $this->request->post['signature']) {
			$this->load->model('checkout/order');
	
			$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));			
		}
	}
}
?>
<?php
class ControllerPaymentInterkassa extends Controller {
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$this->data['action'] = 'https://interkassa.com/lib/payment.php';
		
		$rur_code = 'RUB';
		$rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);

		$this->data['ik_shop_id'] = $this->config->get('interkassa_merchant');
		$this->data['ik_payment_amount'] = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);
		$this->data['ik_payment_id'] = $this->session->data['order_id'];
		$this->data['ik_payment_desc'] = $this->config->get('config_name') . ' - #' . $this->session->data['order_id'];
		$this->data['ik_status_url'] = HTTP_SERVER . 'index.php?route=payment/interkassa/callback';
		$this->data['ik_status_method'] = 'POST';
		$this->data['ik_success_url'] = HTTP_SERVER . 'index.php?route=checkout/success';
		$this->data['ik_success_method'] = 'POST';


		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/interkassa.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/interkassa.tpl';
		} else {
			$this->template = 'default/template/payment/interkassa.tpl';
		}

		$this->render();
	}

	public function callback() {
		$secret_key = $this->config->get('interkassa_security');
		$ik_shop_id = $this->request->post['ik_shop_id'];
		$ik_payment_amount = $this->request->post['ik_payment_amount'];
		$ik_payment_id = $this->request->post['ik_payment_id'];
		$ik_paysystem_alias = $this->request->post['ik_paysystem_alias'];
		$ik_baggage_fields = $this->request->post['ik_baggage_fields'];
		$ik_payment_state = $this->request->post['ik_payment_state'];
		$ik_trans_id = $this->request->post['ik_trans_id'];
		$ik_currency_exch = $this->request->post['ik_currency_exch'];
		$ik_fees_payer = $this->request->post['ik_fees_payer'];
		$ik_sign_hash = $this->request->post['ik_sign_hash'];
		$ik_sign_hash_str = $ik_shop_id . ':' . $ik_payment_amount . ':' . $ik_payment_id . ':' . $ik_paysystem_alias . ':' .
							$ik_baggage_fields . ':' . $ik_payment_state . ':' . $ik_trans_id . ':' . $ik_currency_exch . ':' .
							$ik_fees_payer . ':' . $secret_key;
		if($ik_payment_state == "success" && strtoupper($ik_sign_hash) == strtoupper(md5($ik_sign_hash_str))) {
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($ik_payment_id);

			if($order_info) {
				if(number_format($ik_payment_amount) >= number_format($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE))) {
					$this->model_checkout_order->confirm($ik_payment_id, $this->config->get('interkassa_order_status_id'));
				}
			}
		}
	}
}

?>
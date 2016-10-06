<?php
class ControllerModuleprivat24gs extends Controller {
    protected function index() {
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        
        $this->load->model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $this->model_checkout_order->confirm($this->session->data['order_id'], 1, 'privat24gs');

        if ($order_info['currency_code'] == 'RUB') {$order_info['currency_code'] = 'RUR';}

        $this->data['action'] = 'https://api.privatbank.ua/p24api/ishop';
        
        $this->data['result_url'] = $this->url->https('checkout/success', '', 'SSL');
        $this->data['server_url'] = $this->url->https('payment/privat24gs/callback', '', 'SSL');
        $this->data['merchant_id'] = $this->config->get('privat24gs_merchant');
        $this->data['order_id'] = $this->session->data['order_id'];
        $this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $this->data['currency'] = $order_info['currency_code'];
        $this->data['description'] = $this->config->get('config_name') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'];
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/privat24gs.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/privat24gs.tpl';
        } else {
            $this->template = 'default/template/module/privat24gs.tpl';
        }   
        file_put_contents('order_info.txt',implode("\n",$order_info));

        $this->render();
    }

    public function callback() {
        header('HTTP/1.0 200 OK');
        //file_put_contents('privat24.txt',implode("\n",$_POST));
        if (isset($this->request->post['payment']) && isset($this->request->post['signature'])) {
            //file_put_contents('privat24.txt',"\nisset post\n",FILE_APPEND);
            $payment = html_entity_decode($_POST['payment']);
            parse_str($payment, $result);
            $merchat_pass=$this->config->get('privat24gs_signature');
            $signature = sha1(md5($payment.$merchat_pass));
            //file_put_contents('privat24.txt',$signature."==".$_POST['signature']."\n",FILE_APPEND);
            if ($signature==$_POST['signature']) {
                //file_put_contents('privat24.txt',"state==".$result['state']."\n",FILE_APPEND);
                 if ($result['state']=="ok" || $result['state']=="test")  {
                    $order_id=$result['order'];
                    //file_put_contents('privat24.txt',"order==".$order_id."\n",FILE_APPEND);
                    $this->load->model('checkout/order');
                    //if( $order_info['order_status_id'] == 0) {
                        $this->model_checkout_order->update($order_id, $this->config->get('privat24gs_order_status_id'), 'privat24gs');
                        return TRUE;
                    //}
                }
            }
        }
        echo "OK";
        

    }
}
?>
?>
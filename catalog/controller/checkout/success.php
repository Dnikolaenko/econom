<?php 
class ControllerCheckoutSuccess extends Controller { 
 public function index() { 
  if (isset($this->session->data['order_id'])) {
   // (+) ALNAUA 091114 (START)
   //$this->session->data['orders'][] = $this->session->data['order_id'];
   $current_order_id = (int)$this->session->data['order_id'];
   $secret_code = $this->session->data['secret_code'];
   // (+) ALNAUA 091114 (FINISH)
   $ship_id = $this->session->data['shipment_id'];
   // (+) ALNAUA 091114 (FINISH)
   
   //$this->session->data['shipment_id'];

   $this->cart->clear();
   
   unset($this->session->data['shipping_method']);
   unset($this->session->data['shipping_methods']);
   unset($this->session->data['payment_method']);
   unset($this->session->data['payment_methods']);
   unset($this->session->data['guest']);
   unset($this->session->data['comment']);
   //unset($this->session->data['order_id']);
   unset($this->session->data['coupon']);
   // (+) ALNAUA 091114 (START)
//   unset($this->session->data['secret_code']);
   // (+) ALNAUA 091114 (FINISH)
   // 140323 ET-140323 Begin
   unset($this->session->data['shipment_id']);
   // 140323 ET-140323 End
   // 140606 ET-140606 Begin
   unset($this->session->data['shipment_detail_id']);
   // 140606 ET-140606 End
  } else {
    $current_order_id = 0;
    $secret_code = '';
  }
  
  $this->language->load('checkout/success');
  
  $this->document->title = $this->language->get('heading_title');
  
  // 130623 ET-130617-6 Begin
  $this->load->model('account/order');
  $this->load->model('catalog/product');
  
  //$current_order_id = (int)6844;
  //$secret_code = 'b8cea7';
  
  $order_info = $this->model_account_order->getOrderBySecretCode($current_order_id, $secret_code);
  $products = $this->model_account_order->getOrderProducts($current_order_id);    
  
  if ($order_info) {
   $ga_ecommerce_output = '<script type="text/javascript"><!--'.chr(13);
   $ga_ecommerce_output .= 'ga(\'require\', \'ecommerce\', \'ecommerce.js\');'.chr(13);
   $ga_ecommerce_output .= 'ga(\'ecommerce:addTransaction\', {
  \'id\': \''.(int)$current_order_id.'\',  // Transaction ID. Required.
  \'affiliation\': \''.html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8').'\',  // Affiliation or store name.
  \'revenue\': \''.number_format($order_info['total'],2,".","").'\',  // Grand Total.
  \'currencyCode\': \'UAH\'  // local currency code.
});'.chr(13);

    // 150416 ET-150416 Begin
    $description = $this->language->get('text_order_payment') . $current_order_id;
    $order_id = '#' . $current_order_id;
    $private_key = 'PTpYCP83nL1EhxkahIinFaWbpSfaJ8B46BRuNpF1'; // old nds
    $privates_key = 'NeIMb17CZgUk8zyaVkcC1NWJKdfcBrqzTOAsILGz'; //new no nds
    $public_key = 'i50571680193';  // old nds
    $publics_key = 'i84990509929'; //new no nds
    $type = 'buy';
    $currency = $order_info['currency'];      
    $amount = $this->currency->format(
      $order_info['tottwo'],
      $order_info['currency'],
      $order_info['value'],
      false
    ); // no nds
    $amounts = $this->currency->format(
      $order_info['totone'],
      $order_info['currency'],
      $order_info['value'],
      false
    ); // nds
    
    $version  = '3';
    $pay_way  = 'card,liqpay,delayed,invoice,privat24';
    $language = 'ru';

    $result_url = $this->url->http('common/home');

    $send_data = array(
        'version'     => $version,
        'public_key'  => $publics_key,
        'amount'      => $amount,
        'currency'    => $currency,
        'description' => $description,
        'order_id'    => $order_id,
        'type'        => $type,
        'language'    => $language,
        'pay_way'     => $pay_way,
        'result_url'  => $result_url
        // , 'sandbox'   => 1
        // 'server_url'  => $server_url,
    ); //no nds
    $send_datas = array(
        'version'     => $version,
        'public_key'  => $public_key,
        'amount'      => $amounts,
        'currency'    => $currency,
        'description' => $description,
        'order_id'    => $order_id,
        'type'        => $type,
        'language'    => $language,
        'pay_way'     => $pay_way,
        'result_url'  => $result_url 
    ); // nds
    $data = base64_encode(json_encode($send_data));//no nds
    $datas = base64_encode(json_encode($send_datas));// nds

    $signature = base64_encode(sha1($privates_key.$data.$privates_key, 1));//no nds
    $signatures = base64_encode(sha1($private_key.$datas.$private_key, 1));// nds


    $this->data['data']           = $data;
    $this->data['signature']      = $signature;
    $this->data['datas']          = $datas;
    $this->data['signatures']     = $signatures;
    $this->data['button_pay']     = $this->language->get('text_payment');
    // 150416 ET-150416 End

    $products = $this->model_account_order->getOrderProducts($current_order_id);

//   $payu_option  = array( 'merchant' => 'economto', 'secretkey' => 'O(=Z!G&f2O~9#3*vW0*d' /*, 'debug' => 1*/
//                          , 'button' => '<a onclick="ga(\'send\', \'event\', \'oplata_online\', \'click\', \'button\'); setTimeout(function(){ $(\'#payform\').submit(); }, 500); return;" class="button"><span>'.$this->language->get('text_payment').'</span></a>'
//       );
//
//   $ORDER_PNAME = array();
//   $ORDER_PCODE = array();
//   $ORDER_PINFO = array();
//   $ORDER_PRICE = array();
//   $ORDER_QTY = array();
//   $ORDER_VAT = array();
   
    foreach ($products as $product) {
//    $options = $this->model_account_order->getOrderOptions($current_order_id, $product['order_product_id']);
//
//    $options_text = '';
//
//    foreach ($options as $option) {
//     $options_text .= $option['name'] . ': ' . $option['value'] . '; ';
//    }
//
//    $ORDER_PNAME[] = $product['name'] . ' (' . $product['model'] . ')';
//    $ORDER_PCODE[] = $product['product_id'];
//    $ORDER_PINFO[] = $options_text;
//    $ORDER_PRICE[] = $product['price'];
//    $ORDER_QTY[] = $product['quantity'];
//    $ORDER_VAT[] = 0;
    
    $category = $this->model_catalog_product->getEcommerceCategory($product['product_id']);
    
    $ga_ecommerce_output .= 'ga(\'ecommerce:addItem\', {
  \'id\': \''.(int)$current_order_id.'\',  // Transaction ID. Required.
  \'name\': \''.$product['name'] . ' (' . $product['model'] . ')'.'\',  // Product name. Required.
  \'sku\': \''.$product['product_id'].'\',  // SKU/code.
  \'category\': \''.(isset($category['name']) ? $category['name'] : 'NO CATEGORY').'\',  // Category or variation.
  \'price\': \''.number_format($product['price'],2,".","").'\',  // Unit price.
  \'quantity\': \''.$product['quantity'].'\'  // Quantity.
});'.chr(13);
    
    if ($product['sborka']) {
//     $ORDER_PNAME[] = $this->language->get('text_sborka') . ' ' . $product['name'] . ' (' . $product['model'] . ')';
//     $ORDER_PCODE[] = $product['product_id'].'sborka';
//     $ORDER_PINFO[] = '';
//     $ORDER_PRICE[] = $product['sborka_cost'];
//     $ORDER_QTY[] = $product['quantity'];
//     $ORDER_VAT[] = 0;
     $ga_ecommerce_output .= 'ga(\'ecommerce:addItem\', {
  \'id\': \''.(int)$current_order_id.'\',  // Transaction ID. Required.
  \'name\': \''.$this->language->get('text_sborka') . ' ' . $product['name'] . ' (' . $product['model'] . ')'.'\',  // Product name. Required.
  \'sku\': \''.$product['product_id'].'sborka'.'\',  // SKU/code.
  //\'category\': \'Party Toys\',  // Category or variation.
  \'price\': \''.number_format($product['sborka_cost'],2,".","").'\',  // Unit price.
  \'quantity\': \''.$product['quantity'].'\'  // Quantity.
});'.chr(13);
    }
   }

//   $first_name_array = explode(' ', $order_info['firstname']);
//   $shipment_sort_order = $this->config->get('shipment_sort_order');
//   $order_shipment = $this->model_account_order->getOrderShipment((int)$current_order_id, $shipment_sort_order);
//
//   $forSend = array (
//         'ORDER_REF' => (int)$current_order_id, # Ордер. Если не указывать - создастся автоматически
//         'ORDER_DATE' => $order_info['date_added'], # Дата платежа ( Y-m-d H:i:s ). Необязательный параметр.
//         'ORDER_PNAME' => $ORDER_PNAME, # Массив с названиями товаров
//         'ORDER_PCODE' => $ORDER_PCODE, # Массив с кодами товаров
//         'ORDER_PINFO' => $ORDER_PINFO, # Массив с описанием товаров
//         'ORDER_PRICE' => $ORDER_PRICE, # Массив с ценами
//         'ORDER_QTY' => $ORDER_QTY,  # Массив с колличеством каждого товара
//         'ORDER_VAT' => $ORDER_VAT,  # Массив с указанием НДС для каждого товара
//         'ORDER_SHIPPING' => (isset($order_shipment['value']) ? $order_shipment['value'] : 0), # Стоимость доставки
//         'PRICES_CURRENCY' => "UAH",  # Валюта мерчанта (Внимание! Должно соответствовать валюте мерчанта. )
//         'BILL_FNAME' => (isset($first_name_array[1]) ? $first_name_array[1] : ''),
//         'BILL_LNAME' => $first_name_array[0],
//         'BILL_EMAIL' => $order_info['email'],
//         'BILL_PHONE' => $order_info['telephone'],
//         'BILL_ADDRESS' => $order_info['shipping_address_1'],
//         'LANGUAGE' => "RU",
//         //'TESTORDER' => "TRUE",
//         //'DEBUG' => 1
//       );

//   $pay = PayU::getInst()->setOptions( $payu_option )->setData( $forSend )->LU();

//   $this->data['pay'] = $pay; # вывод формы
   // 130424 ET-130424 End
   
   $ga_ecommerce_output .= 'ga(\'ecommerce:send\');'.chr(13);
   $ga_ecommerce_output .= 'ga(\'ecommerce:clear\');'.chr(13);
   $ga_ecommerce_output .= '//--></script>'.chr(13);
   $this->data['ga_ecommerce_output'] = $ga_ecommerce_output;
   
   $oms_output = '<script type="text/javascript"><!--'.chr(13);
   $oms_output .= '//<![CDATA['.chr(13);
   $oms_output .= 'var _oms = window._oms || [];'.chr(13);
   $oms_output .= '_oms.push(['.chr(13);
   $oms_output .= '"create_order",'.chr(13);
   $oms_output .= '{order_id: "'.(int)$current_order_id.'", sum: '.number_format($order_info['total'],2,".","").'}'.chr(13);
   $oms_output .= ']);'.chr(13);
   $oms_output .= '//]]>'.chr(13);
   $oms_output .= '//--></script>';
   $this->data['oms_output'] = $oms_output;
  } else {
   $this->data['pay'] = '';
   $this->data['ga_ecommerce_output'] = '';
   $this->data['oms_output'] = '';
  }
  
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_message'] = sprintf($this->language->get('text_message'), $this->url->https('account/invoice&order_id='.(int)$current_order_id).'&secret_code='.$secret_code, $this->url->http('information/contact'));

  $this->data['invoice'] = $this->url->http('account/invoice/newinvoice&order_id='. (int)$current_order_id .'&secret_code='.$secret_code);
  
  $this->data['nds_invoice'] = $this->url->http('account/invoice/newndsinvoice&order_id='. (int)$current_order_id.'&secret_code='.$secret_code);
  // 100426 Prepayment Invoice Begin
  $this->data['prepayment_invoice'] = $this->url->http('account/invoice/newprepaymentinvoice&order_id='. (int)$current_order_id .'&secret_code='.$secret_code);
  
  $this->data['prepayment_nds_invoice'] = $this->url->http('account/invoice/newprepaymentndsinvoice&order_id='. (int)$current_order_id .'&secret_code='.$secret_code);
  // 100426 Prepayment Invoice End
  $this->data['oplataone'] = $this->url->http('common/pageone');
  $this->data['oplatatwo'] = $this->url->http('common/pagetwo');
  
  $this->data['order_info_one'] = $order_info['totone'];
  $this->data['order_info_two'] = $order_info['tottwo'];
  
  $this->data['invoice_one'] = $this->language->get('invoice_one');
  
  $this->data['invoice_two'] = $this->language->get('invoice_two');

  $this->data['button_continue'] = $this->language->get('back_to_shop');

  $this->data['button_invoice'] = $this->language->get('button_invoice');

  $this->data['button_nds_invoice'] = $this->language->get('button_nds_invoice');
  // 100426 Prepayment Invoice Begin
  $this->data['button_prepayment_invoice'] = $this->language->get('button_prepayment_invoice');
  // 100426 Prepayment Invoice End
  $this->data['continue'] = $this->url->http('common/home');

  $this->load->model('account/order');

  $products = $this->model_account_order->getOrderProducts($current_order_id);

  foreach ($products as $product) {
    $new = $product['product_id'];
  }

  $perecenka = $this->model_catalog_product->getProduct($new);

  if ($perecenka["nds"] == 1) {
  $bp = TRUE;
  $this->data['bp'] = $bp;
  } 
  else if ($perecenka["nds"] == 0) {
  $bp = FALSE;
  $this->data['bp'] = $bp;
  }

  //var_dump($this->data);
  //var_dump($new);
  
  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/common/success.tpl';
  } else {
   $this->template = 'default/template/common/success.tpl';
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
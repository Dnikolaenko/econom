<?php 
class ControllerAccountInvoicends extends Controller {
public function index() { 
//     if (!$this->customer->isLogged()) {
//   if (isset($this->request->get['order_id'])) {
//    $current_order_id = $this->request->get['order_id'];
//   } else {
//    $current_order_id = 0;
//   }
//
//   $this->session->data['redirect'] = $this->url->https('account/invoice&order_id=' . $order_id);
//
//
//   $this->redirect($this->url->https('account/login'));
//     }
   
     $this->language->load('account/invoice');

     $this->document->title = $this->language->get('heading_title');
       
     $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
       'href'      => $this->url->http('common/home'),
       'text'      => $this->language->get('text_home'),
       'separator' => FALSE
     );

//       $this->document->breadcrumbs[] = array(
//         'href'      => $this->url->http('account/account'),
//         'text'      => $this->language->get('text_account'),
//         'separator' => $this->language->get('text_separator')
//       );
//
//       $this->document->breadcrumbs[] = array(
//         'href'      => $this->url->http('account/history'),
//         'text'      => $this->language->get('text_history'),
//         'separator' => $this->language->get('text_separator')
//       );

  $this->document->breadcrumbs[] = array(
         'href'      => $this->url->http('account/invoicends&order_id=' . $this->request->get['order_id'].'&secret_code='.$this->request->get['secret_code']),
         'text'      => $this->language->get('text_invoice'),
         'separator' => $this->language->get('text_separator')
       );
  
  $this->load->model('account/order');
  $this->load->model('catalog/product');

        // (+) ALNAUA 091114 (START)
//        if (isset($this->request->get['order_id'])) {
//            if (isset($this->session->data['orders'])) {
//                for ($i = 0; $i < sizeof($this->session->data['orders']); $i++) {
//                  if ($this->session->data['orders'][$i] == $this->request->get['order_id']) {
//                    $order_id = $this->session->data['orders'][$i];
//                    break;
//                  } else {
//                    $order_id = 0;
//                  }
//                }
//            } else {
//                $order_id = 0;
//            }
//        } else {
//            $order_id = 0;
//        }

        if (isset($this->request->get['order_id']) && isset($this->request->get['secret_code'])) {
          $current_order_id = $this->request->get['order_id'];
          $secret_code = $this->request->get['secret_code'];
        } else {
          $current_order_id = 0;
          $secret_code = '';
        }
        // (+) ALNAUA 091114 (FINISH)

//  if (isset($this->request->get['order_id'])) {
//   $order_id = $this->request->get['order_id'];
//  } else {
//   $order_id = 0;

  $order_info = $this->model_account_order->getOrderBySecretCode($current_order_id, $secret_code);
  //var_dump($order_info);
  $products = $this->model_account_order->getOrderProducts($current_order_id);  
  
  if ($order_info) {
   $this->data['heading_title'] = $this->language->get('heading_title');

   $this->data['text_order'] = $this->language->get('text_order');
   $this->data['text_no_nds'] = $this->language->get('text_order_no_nds');
   $this->data['text_with_nds'] = $this->language->get('text_order_nds');
   $this->data['text_email'] = $this->language->get('text_email');
   $this->data['text_telephone'] = $this->language->get('text_telephone');
   $this->data['text_fax'] = $this->language->get('text_fax');
   $this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
   $this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
   $this->data['text_payment_address'] = $this->language->get('text_payment_address');
   $this->data['text_payment_method'] = $this->language->get('text_payment_method');
   $this->data['text_order_history'] = $this->language->get('text_order_history');
   $this->data['text_product'] = $this->language->get('text_product');
   $this->data['text_model'] = $this->language->get('text_model');
   $this->data['text_quantity'] = $this->language->get('text_quantity');
   $this->data['text_price'] = $this->language->get('text_price');
   $this->data['text_total'] = $this->language->get('text_total');
   $this->data['text_comment'] = $this->language->get('text_comment');

   // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
   $this->data['text_sborka'] = $this->language->get('text_sborka');
   // 100218 ALNAUA New building mechanism in order, mail and invoice End
   // 20120204 ALNAUA ET-111227 Begin
   $this->data['text_credit'] = $this->language->get('text_credit');
   // 20120204 ALNAUA ET-111227 End

   $this->data['column_date_added'] = $this->language->get('column_date_added');
   $this->data['column_status'] = $this->language->get('column_status');
   $this->data['column_comment'] = $this->language->get('column_comment');

   $this->data['button_continue'] = $this->language->get('back_to_shop');
   $this->data['button_invoice'] = $this->language->get('button_invoice');
   $this->data['button_nds_invoice'] = $this->language->get('button_nds_invoice');
   // 100426 Prepayment Invoice Begin
   $this->data['button_prepayment_invoice'] = $this->language->get('button_prepayment_invoice');
   // 100426 Prepayment Invoice End

   $this->data['order_id'] = $order_info['order_id'];
   $this->data['email'] = $order_info['email'];
   $this->data['telephone'] = $order_info['telephone'];
   $this->data['fax'] = $order_info['fax'];
   

   //$this->data['invoice'] = $this->url->http('account/invoice/newinvoice&order_id=' . (int)$this->request->get['order_id']);
   $this->data['invoice'] = $this->url->http('account/invoice/newinvoice&order_id=' . (int)$this->request->get['order_id'].'&secret_code='.$this->request->get['secret_code']);

   $this->data['nds_invoice'] = $this->url->http('account/invoice/newndsinvoice&order_id=' . (int)$this->request->get['order_id']. '&secret_code=' .$this->request->get['secret_code']);
   // 104164 Prepayment Invoice Begin
   $this->data['prepayment_nds_invoice'] = $this->url->http('account/invoice/newprepaymentndsinvoice&order_id=' . (int)$this->request->get['order_id'].'&secret_code='.$this->request->get['secret_code']);
   // 100426 Prepayment Invoice End

   // 20120204 ALNAUA ET-111227 Begin
   if ($order_info['credit_id'] > 0) {
    $this->load->model('catalog/credit');
    $credit_info = $this->model_catalog_credit->getCredit($order_info['credit_id']);
    $this->data['credit_name'] = $credit_info['name'];
   }
   $this->data['credit_id'] = $order_info['credit_id'];
   // 20120204 ALNAUA ET-111227 End

   if ($order_info['shipping_address_format']) {
         $format = $order_info['shipping_address_format'];
   } else {
    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
   }
  
      $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
      '{address_1}',
      '{address_2}',
      '{city}',
      '{postcode}',
      '{zone}',
      '{country}'
   );
 
   $replace = array(
      'firstname' => $order_info['shipping_firstname'],
      'lastname'  => $order_info['shipping_lastname'],
      'company'   => $order_info['shipping_company'],
         'address_1' => $order_info['shipping_address_1'],
         'address_2' => $order_info['shipping_address_2'],
         'city'      => $order_info['shipping_city'],
         'postcode'  => $order_info['shipping_postcode'],
         'zone'      => $order_info['shipping_zone'],
         'country'   => $order_info['shipping_country']  
   );

   $this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

   $this->data['shipping_method'] = $order_info['shipping_method'];

   if ($order_info['payment_address_format']) {
         $format = $order_info['payment_address_format'];
      } else {
    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
   }
  
      $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
         '{address_1}',
         '{address_2}',
        '{city}',
         '{postcode}',
         '{zone}',
         '{country}'
   );
 
   $replace = array(
      'firstname' => $order_info['payment_firstname'],
      'lastname'  => $order_info['payment_lastname'],
      'company'   => $order_info['payment_company'],
         'address_1' => $order_info['payment_address_1'],
         'address_2' => $order_info['payment_address_2'],
         'city'      => $order_info['payment_city'],
         'postcode'  => $order_info['payment_postcode'],
         'zone'      => $order_info['payment_zone'],
         'country'   => $order_info['payment_country']  
   );
   
   $this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

   $this->data['payment_method'] = $order_info['payment_method'];
   
   $this->data['products'] = array();
   
   // (+) ALNAUA 091114 (START)
   // 100223 ALNAUA Site redesign Begin
   //$this->load->model('catalog/color');
   // 100223 ALNAUA Site redesign End
   // (+) ALNAUA 091114 (FINISH)

    // 150416 ET-150416 Begin
    $description = $this->language->get('text_order_payment') . $current_order_id;
    $pay_order_id = '#' . $current_order_id;
    $private_key = 'PTpYCP83nL1EhxkahIinFaWbpSfaJ8B46BRuNpF1';
    $public_key = 'i50571680193';
    $type = 'buy';
    $currency = $order_info['currency'];
    
    $amount = $this->currency->format(
      $order_info['tottwo'],
      $order_info['currency'],
      $order_info['value'],
      false
    );
    
    $amounts = $this->currency->format(
      $order_info['totone'],
      $order_info['currency'],
      $order_info['value'],
      false
    );   

    $version  = '3';
    $pay_way  = 'card,liqpay,delayed,invoice,privat24';
    $language = 'ru';

    $result_url = $this->url->http('common/home');

    $send_data = array(
      'version'    => $version,
      'public_key'  => $public_key,
      'amount'      => $amount,
      'currency'    => $currency,
      'description' => $description,
      'order_id'    => $pay_order_id,
      'type'        => $type,
      'language'    => $language,
      'pay_way'     => $pay_way,
      'result_url'  => $result_url
    );
    
    $send_datas = array(
        'version'     => $version,
        'public_key'  => $public_key,
        'amount'      => $amounts,
        'currency'    => $currency,
        'description' => $description,
        'order_id'    => $current_order_id,
        'type'        => $type,
        'language'    => $language,
        'pay_way'     => $pay_way,
        'result_url'  => $result_url 
    );

    $data = base64_encode(json_encode($send_data));
    $datas = base64_encode(json_encode($send_datas));

    $signature = base64_encode(sha1($private_key.$data.$private_key, 1));
    $signatures = base64_encode(sha1($private_key.$datas.$private_key, 1));

    $this->data['signature']      = $signature;
    $this->data['data']           = $data;
    
    $this->data['datas']          = $datas;
    $this->data['signatures']     = $signatures;
    
    $this->data['button_pay']     = $this->language->get('text_payment');
    // 150416 ET-150416 End

   $products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
   
   // 130424 ET-130424 Begin
//    $payu_option  = array( 'merchant' => 'economto', 'secretkey' => 'O(=Z!G&f2O~9#3*vW0*d' /*, 'debug' => 1*/
//                          , 'button' => '<a onclick="ga(\'send\', \'event\', \'oplata_online\', \'click\', \'button\'); setTimeout(function(){ $(\'#payform\').submit(); }, 500); return;" class="button"><span>'.$this->language->get('text_payment').'</span></a>'
//        );
//
//    $ORDER_PNAME = array();
//    $ORDER_PCODE = array();
//    $ORDER_PINFO = array();
//    $ORDER_PRICE = array();
//    $ORDER_QTY = array();
//    $ORDER_VAT = array();
   // 130424 ET-130424 End

    

   foreach ($products as $product) {
    $options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

          $option_data = array();

//          $options_text = '';

          foreach ($options as $option) {
             $option_data[] = array(
               'name'  => $option['name'],
               'value' => $option['value'],
             );
//             $options_text .= $option['name'] . ': ' . $option['value'] . '; ';
          }

                // (+) ALNAUA 091114 (START)
                // 100223 ALNAUA Site redesign Begin
                //$color = $this->model_catalog_color->getColor($product['color_id']);
                //$option_data[] = array(
             //  'name'  => $this->language->get('text_color'),
             //  'value' => $color['name'],
            // );
                // 100223 ALNAUA Site redesign End
                // (+) ALNAUA 091114 (FINISH)

          $this->data['products'][] = array(
             'name'     => $product['name'],
             'model'    => $product['model'],
             'option'   => $option_data,
             'quantity' => $product['quantity'],
             'price'    => $this->currency->format($product['price'], $order_info['currency'], $order_info['value']),
             'total'    => $this->currency->format($product['total'], $order_info['currency'], $order_info['value']),
             'nds' => $product['nds'],
             // 100218 ALNAUA New building mechanism in order, mail and invoice Begin, 
             'sborka' => $product['sborka'],
             'sborka_qty' => round($product['quantity'], 4),
             'sborka_cost' => $this->currency->format($product['sborka_cost'], $order_info['currency'], $order_info['value']),
             'sborka_cost_total' => $this->currency->format($product['quantity']*$product['sborka_cost'], $order_info['currency'], $order_info['value'])
             // 100218 ALNAUA New building mechanism in order, mail and invoice End
          );
          
          
//          $ORDER_PNAME[] = $product['name'] . ' (' . $product['model'] . ')';
//          $ORDER_PCODE[] = $product['product_id'];
//          $ORDER_PINFO[] = $options_text;
//          $ORDER_PRICE[] = $product['price'];
//          $ORDER_QTY[] = $product['quantity'];
//          $ORDER_VAT[] = 0;
//
//          if ($product['sborka']) {
//           $ORDER_PNAME[] = $this->language->get('text_sborka') . ' ' . $product['name'] . ' (' . $product['model'] . ')';
//           $ORDER_PCODE[] = $product['product_id'].'sborka';
//           $ORDER_PINFO[] = '';
//           $ORDER_PRICE[] = $product['sborka_cost'];
//           $ORDER_QTY[] = $product['quantity'];
//           $ORDER_VAT[] = 0;
//          }
        }
   //130424 ET-130424 Begin
//   $first_name_array = explode(' ', $order_info['firstname']);
//
//   $shipment_sort_order = $this->config->get('shipment_sort_order');
//   $order_shipment = $this->model_account_order->getOrderShipment($this->request->get['order_id'], $shipment_sort_order);
//
//   $forSend = array (
//         'ORDER_REF' => (int)$order_id, # Ордер. Если не указывать - создастся автоматически
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
//
//   $pay = PayU::getInst()->setOptions( $payu_option )->setData( $forSend )->LU();
//
//   $this->data['pay'] = $pay; # вывод формы
   // 130424 ET-130424 End

   $this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
   
   $this->data['comment'] = $order_info['comment'];
        
   $this->data['historys'] = array();

   $results = $this->model_account_order->getOrderHistorys($this->request->get['order_id']);

   foreach ($results as $result) {
     $this->data['historys'][] = array(
        'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        'status'     => $result['status'],
        'comment'    => nl2br($result['comment'])
     );
   }

   //$this->data['continue'] = $this->url->https('account/history');
   $this->data['continue'] = $this->url->http('common/home');

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/invoice_nds.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/account/invoice_nds.tpl';
   } else {
    $this->template = 'default/template/account/invoice_nds.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );  
   
   $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
  } else {
   $this->data['heading_title'] = $this->language->get('heading_title');

   $this->data['text_error'] = $this->language->get('text_error');

   $this->data['button_continue'] = $this->language->get('back_to_shop');

   $this->data['continue'] = $this->url->http('common/home');
         
   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
   } else {
    $this->template = 'default/template/error/not_found.tpl';
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
}
?>
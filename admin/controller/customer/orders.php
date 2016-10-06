<?php
class ControllerCustomerOrder extends Controller {
 private $error = array();
 
 public function index() {
 $this->load->language('customer/order');

  $this->data['title'] = $this->language->get('heading_title_invoice') . ' #' . sprintf("Т%06s", $this->request->get['order_id']);

  if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
   $this->data['base'] = HTTPS_SERVER;
  } else {
   $this->data['base'] = HTTP_SERVER;
  }

  $this->data['direction'] = $this->language->get('direction');
  $this->data['language'] = $this->language->get('code');

  $this->data['text_invoice'] = $this->language->get('text_invoice');
//     $this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
//  $this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
//  $this->data['text_telephone'] = $this->language->get('text_telephone');
//  $this->data['text_fax'] = $this->language->get('text_fax');
//  $this->data['text_to'] = $this->language->get('text_to');
//  $this->data['text_ship_to'] = $this->language->get('text_ship_to');

  $this->data['column_product'] = $this->language->get('column_product');
     $this->data['column_model'] = $this->language->get('column_model');
     $this->data['column_quantity'] = $this->language->get('column_quantity');
     $this->data['column_price'] = $this->language->get('column_price');
        
     $this->data['column_total'] = $this->language->get('column_total');

        $this->data['text_supplier'] = $this->language->get('text_supplier');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_invoice_new'] = $this->language->get('text_invoice_new');
        $this->data['text_from_date'] = $this->language->get('text_from_date');
        $this->data['text_adv'] = $this->language->get('text_adv');
        $this->data['column_unit_meas'] = $this->language->get('column_unit_meas');
        $this->data['text_unit_meas'] = $this->language->get('text_unit_meas');

        $this->data['text_total_without_tax'] = $this->language->get('text_total_without_tax');
        $this->data['text_total_tax'] = $this->language->get('text_total_tax');
        $this->data['text_total_with_tax'] = $this->language->get('text_total_with_tax');
        // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
        $this->data['text_sborka'] = $this->language->get('text_sborka');
        $this->data['text_sborka_unit_meas'] = $this->language->get('text_sborka_unit_meas');
        // 100218 ALNAUA New building mechanism in order, mail and invoice End

        // ET-20150113 Begin
        $this->data['text_warning_reserve'] = $this->language->get('text_warning_reserve');
        // ET-20150113 End

        //$this->data['supplier_address'] = $this->config->get('config_invoice_data');
        $this->data['supplier_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim($this->config->get('config_invoice_data'))));

  $this->load->model('customer/order');

     $order_info = $this->model_customer_order->getOrder($this->request->get['order_id']);

//  $this->data['order_id'] = $order_info['order_id'];
        $this->data['order_id'] = sprintf("Т%06s",$order_info['order_id']); // zero-padding works on strings too

  $this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
        $this->data['column_currency'] = $order_info['currency'];

//  $this->data['store'] = $this->config->get('config_store');
//  $this->data['address'] = nl2br($this->config->get('config_address'));
//  $this->data['telephone'] = $this->config->get('config_telephone');
//  $this->data['fax'] = $this->config->get('config_fax');
//  $this->data['email'] = $this->config->get('config_email');
//  $this->data['website'] = trim(HTTP_CATALOG, '/');

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

  $this->data['products'] = array();

        // (+) ALNAUA 091114 (START)
        $this->load->model('catalog/color');
        // (+) ALNAUA 091114 (FINISH)

  $products = $this->model_customer_order->getOrderProducts($this->request->get['order_id']);

     foreach ($products as $product) {
   $option_data = array();

   $options = $this->model_customer_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

        foreach ($options as $option) {
          $option_data[] = array(
             'name'  => $option['name'],
             'value' => $option['value']
          );
        }
        $this->load->model('catalog/product');
        $paras = $this->model_catalog_product->getProduct($product['product_id']);
        $nine = $paras['nds'];

            // (+) ALNAUA 091114 (START)
            // 100223 ALNAUA Site redesign Begin
            // for capability older orders
            if ($this->request->get['order_id'] < 207) {
            // 100223 ALNAUA Site redesign End
              $color = $this->model_catalog_color->getColorDescCurrLang($product['color_id']);
              $option_data[] = array(
                      'name'  => $this->language->get('text_color'),
                      'value' => $color['name'],
                  );
            // 100223 ALNAUA Site redesign Begin
            }
            // 100223 ALNAUA Site redesign End
            // (+) ALNAUA 091114 (FINISH)
        if ($nine['nds']  == 1) {
         $this->data['products'][] = array(
            'name'     => $product['name'],
            'model'    => $product['model'],
            'option'   => $option_data,
            'quantity' => number_format(round($product['quantity'], 4), 4, '.', ''),
            'price'    => $this->currency->format($product['price'], $order_info['currency'], $order_info['value'], false),
            'total'    => $this->currency->format($product['total'], $order_info['currency'], $order_info['value'], false),
                // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
            'sborka' => $product['sborka'],
            'sborka_qty' => number_format(round($product['quantity']*$product['sborka_cost']/$this->config->get('config_sborka_cost_per_hour'), 4), 4, '.', ''),
            'sborka_cost' => $this->currency->format($this->config->get('config_sborka_cost_per_hour')/1.2, $order_info['currency'], $order_info['value'], false),
            'sborka_cost_total' => $this->currency->format($product['quantity']*$product['sborka_cost']/1.2, $order_info['currency'], $order_info['value'], false)
                // 100218 ALNAUA New building mechanism in order, mail and invoice End
         );
        }
     }

     $this->data['totals'] = $this->model_customer_order->getOrderTotals($this->request->get['order_id']);

  $this->template = 'customer/new_order_nds_invoice.tpl';

   $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));    
 }
 public function newprepaymentinvoices() {
  $this->load->language('customer/order');

  $this->data['title'] = $this->language->get('heading_title_invoice') . ' #' . sprintf("Т%06s", $this->request->get['order_id']);

  if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
   $this->data['base'] = HTTPS_SERVER;
  } else {
   $this->data['base'] = HTTP_SERVER;
  }

  $this->data['direction'] = $this->language->get('direction');
  $this->data['language'] = $this->language->get('code');

  $this->data['text_invoice'] = $this->language->get('text_invoice');

  $this->data['column_product'] = $this->language->get('column_product');
     $this->data['column_model'] = $this->language->get('column_model');
     $this->data['column_quantity'] = $this->language->get('column_quantity');
     $this->data['column_price'] = $this->language->get('column_price');

     $this->data['column_total'] = $this->language->get('column_total');

        $this->data['text_supplier'] = $this->language->get('text_supplier');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_invoice_new'] = $this->language->get('text_invoice_new');
        $this->data['text_from_date'] = $this->language->get('text_from_date');
        $this->data['text_adv'] = $this->language->get('text_adv');
        $this->data['column_unit_meas'] = $this->language->get('column_unit_meas');
        $this->data['text_unit_meas'] = $this->language->get('text_unit_meas');

        $this->data['text_total_without_tax'] = $this->language->get('text_total_without_tax');
        $this->data['text_total_tax'] = $this->language->get('text_total_tax');
        $this->data['text_total_with_tax'] = $this->language->get('text_total_with_tax');
        $this->data['text_sborka'] = $this->language->get('text_sborka');
        $this->data['text_sborka_unit_meas'] = $this->language->get('text_sborka_unit_meas');
        $this->data['text_prepayment_50'] = $this->language->get('text_prepayment_50');

        // 100611 ALNAUA Add Discount System Begin
        $this->data['text_total_discount'] = $this->language->get('text_total_discount');
        $this->data['text_total_to_pay'] = $this->language->get('text_total_to_pay');
        // 100611 ALNAUA ALNAUA Add Discount System End

        // ET-20150113 Begin
        $this->data['text_warning_reserve'] = $this->language->get('text_warning_reserve');
        // ET-20150113 End

        $this->data['supplier_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim($this->config->get('config_invoice_data'))));

  $this->load->model('customer/order');

     $order_info = $this->model_customer_order->getOrder($this->request->get['order_id']);

        $this->data['order_id'] = sprintf("Т%06sP",$order_info['order_id']); // zero-padding works on strings too

  $this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
        $this->data['column_currency'] = $order_info['currency'];

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

  $this->data['products'] = array();

        $this->load->model('catalog/color');

  $products = $this->model_customer_order->getOrderProducts($this->request->get['order_id']);

        $this->load->model('catalog/product');
        $total_without_tax = 0;
        $total_product_prepayment = 0;
        $total_product = 0;

     foreach ($products as $product) {
   $option_data = array();

   $options = $this->model_customer_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

        foreach ($options as $option) {
          $option_data[] = array(
             'name'  => $option['name'],
             'value' => $option['value']
          );
        }

            // for capability older orders
            if ($this->request->get['order_id'] < 207) {
              $color = $this->model_catalog_color->getColorDescCurrLang($product['color_id']);
              $option_data[] = array(
                      'name'  => $this->language->get('text_color'),
                      'value' => $color['name'],
                  );
            }

            // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
            //$product_info = $this->model_catalog_product->getProduct($product['product_id']);
            //$product_prepayment = $product_info['prepayment']/100;
            $product_prepayment = $product['prepayment']/100;
            // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
            $product_price = $product['price']*$product_prepayment;
            $product_total = $product['total']*$product_prepayment;

            $sborka_qty = round($product['quantity']*$product['sborka_cost']/$this->config->get('config_sborka_cost_per_hour')*$product_prepayment, 4);
            $sborka_cost = ($this->config->get('config_sborka_cost_per_hour')/1.2);
            $sborka_cost_total = ($product['sborka'] ? $product['quantity']*$product['sborka_cost']/1.2*$product_prepayment : 0.00);
            $search = $this->model_catalog_product->getProduct($product['product_id']);
            $nds = $search['nds'];
            
        if($nds['nds'] == 1) {  
         $this->data['products'][] = array(
            'name'     => $product['name'],
            'model'    => $product['model'],
            'option'   => $option_data,
            'prepayment' => $product_prepayment,
            'quantity' => number_format(round($product['quantity'], 4), 4, '.', ''),
            'price'    => $this->currency->format($product_price, $order_info['currency'], $order_info['value'], false),
            'total'    => $this->currency->format($product_total, $order_info['currency'], $order_info['value'], false),
            'sborka' => $product['sborka'],
            'sborka_qty' => number_format($sborka_qty, 4, '.', ''),
            'sborka_cost' => $this->currency->format($sborka_cost, $order_info['currency'], $order_info['value'], false),
            'sborka_cost_total' => $this->currency->format($sborka_cost_total, $order_info['currency'], $order_info['value'], false)
         );
            
            $total_without_tax = $total_without_tax + $product_total + $sborka_cost_total;
            // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
            if ($product['use_in_order_discount']) {
            // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
                $total_product_prepayment = $total_product_prepayment + $product['total']*$product_prepayment;
                $total_product = $total_product + $product['total'];
            // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
            }
            // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
        }
     }

        $discount = 0;

        $order_discount = array( array($this->config->get('order_discount_sum1'), $this->config->get('order_discount_percent1')),
                                 array($this->config->get('order_discount_sum2'), $this->config->get('order_discount_percent2')),
                                 array($this->config->get('order_discount_sum3'), $this->config->get('order_discount_percent3')),
                                 array($this->config->get('order_discount_sum4'), $this->config->get('order_discount_percent4')),
                                 array($this->config->get('order_discount_sum5'), $this->config->get('order_discount_percent5'))
                                );

        array_multisort($order_discount, SORT_NUMERIC, $order_discount);

        for ($i = 0; $i < sizeof($order_discount); $i++) {
          if ($total_product > (float)$order_discount[$i][0]) {
            $discount = (float)$order_discount[$i][1];
          }
        }

     //$this->data['totals'] = $this->model_customer_order->getOrderTotals($this->request->get['order_id']);
        
        $this->data['total_without_tax'] = round($total_without_tax, 2);
        $this->data['total_tax'] = round($total_without_tax * 1.2 - $total_without_tax, 2);
        $this->data['total_with_tax'] = round($total_without_tax*1.2, 2);

        $this->data['total_discount'] = round($total_product_prepayment * ($discount/100), 2);
        $this->data['total_to_pay'] = $this->data['total_without_tax'] - $this->data['total_discount'];

   $this->template = 'customer/new_order_prepayment_nds_invoice.tpl';

   $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }
}



<?php
class ControllerCheckoutCart extends Controller {
 private $error = array();

 public function index() {
   $this->language->load('checkout/cart');

   $this->data['active_tab'] = '#tab_fizlico';

   if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    $this->data['active_tab'] = '#tab_fizlico';
    if ($this->request->post['form_name'] == 'cart') {
     if (isset($this->request->post['quantity'])) {
      if (!is_array($this->request->post['quantity'])) {
       if (isset($this->request->post['option'])) {
        $option = $this->request->post['option'];
       } else {
        $option = array();
       }

       $this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
      } else {
       foreach ($this->request->post['quantity'] as $key => $value) {
        $this->cart->update($key, $value);
       }
      }

      unset($this->session->data['shipping_methods']);
      unset($this->session->data['shipping_method']);
      unset($this->session->data['payment_methods']);
      unset($this->session->data['payment_method']);
     }

 if (isset($this->request->post['redirect'])) {
  $this->session->data['redirect'] = $this->request->post['redirect'];
 }

 if (isset($this->request->post['quantity']) || isset($this->request->post['remove'])) {
  unset($this->session->data['shipping_methods']);
  unset($this->session->data['shipping_method']);
  unset($this->session->data['payment_methods']);
  unset($this->session->data['payment_method']);

  $this->redirect($this->url->https('checkout/cart'));
 }

        }

        if ($this->request->post['form_name'] == 'fizlico') {
          $this->data['active_tab'] = '#tab_fizlico';
          if ($this->validate_order_fizlico()) {

            $this->session->data['guest']['firstname'] = $this->request->post['fio'];
//              $this->session->data['guest']['lastname'] = $this->request->post['lastname'];
            $this->session->data['guest']['lastname'] = '';
            $this->session->data['guest']['email'] = $this->request->post['email'];
            $this->session->data['guest']['telephone'] = $this->request->post['telephone'];
//              $this->session->data['guest']['fax'] = $this->request->post['fax'];
            $this->session->data['guest']['fax'] = '';
//              $this->session->data['guest']['company'] = $this->request->post['company'];
            $this->session->data['guest']['company'] = '';
            // 140606 ET-140606 Begin
            //$this->session->data['guest']['address_1'] = $this->request->post['address_1'];
            $this->session->data['guest']['address_1'] = (!isset($this->request->post['door_delivery']) && $this->request->post['address_1']==$this->language->get('text_address_1')? '' : $this->request->post['address_1']) ;
            // 140606 ET-140606 End
//              $this->session->data['guest']['address_2'] = $this->request->post['address_2'];
//              $this->session->data['guest']['postcode'] = $this->request->post['postcode'];
//              $this->session->data['guest']['city'] = $this->request->post['city'];
            $this->session->data['guest']['address_2'] = '';
            $this->session->data['guest']['postcode'] = '';
            $this->session->data['guest']['city'] = '';
            $this->session->data['guest']['country_id'] = $this->request->post['country_id'];
            $this->session->data['guest']['zone_id'] = $this->request->post['zone_id'];
            // $this->session->data['guest']['shipment_cost'] = $this->request->post['shipment_cost'];
            // 140606 ET-140606 Begin
            $this->session->data['guest']['door_delivery'] = (isset($this->request->post['door_delivery']) ? $this->request->post['door_delivery'] : 0);
            // 140606 ET-140606 End

            if ($this->cart->hasShipping()) {
                $this->tax->setZone($this->request->post['country_id'], $this->request->post['zone_id']);
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {
                $this->session->data['guest']['country'] = $country_info['name'];
                $this->session->data['guest']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['address_format'] = $country_info['address_format'];
            } else {
                $this->session->data['guest']['country'] = '';
                $this->session->data['guest']['iso_code_2'] = '';
                $this->session->data['guest']['iso_code_3'] = '';
                $this->session->data['guest']['address_format'] = '';
            }

            $this->load->model('localisation/zone');

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {
                $this->session->data['guest']['zone'] = $zone_info['name'];
                $this->session->data['guest']['zone_code'] = $zone_info['code'];
            } else {
                $this->session->data['guest']['zone'] = '';
                $this->session->data['guest']['zone_code'] = '';
            }

//              if (isset($this->request->post['shipping_method'])) {
//                  $shipping = explode('.', $this->request->post['shipping_method']);
//
//                  $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
//              }
            $this->session->data['shipping_method'] = $this->request->post['shipping_method'];

//              $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
            $this->session->data['payment_method'] = $this->request->post['payment_method'];

//              $this->session->data['comment'] = $this->request->post['comment'];
            $this->session->data['comment'] = '';

            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('checkout/extension');

            $sort_order = array();

            $results = $this->model_checkout_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                $this->load->model('total/' . $result['key']);
                $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
            }

            $sort_order = array();

            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data);

            $price_nds = $this->cart->getNdsTotal();
            $price_no_nds = $this->cart->getNoNdsTotal();
            $order_discount = $this->cart->getOrderDiscount();
            $sub_total = $this->cart->getTotal();
            $this->load->model('checkout/shipment');

   $shipment_data = array();
   $shipments = $this->model_checkout_shipment->getShipments($shipment_data);

   if (isset($this->request->post['shipment_id'])) {
    $this->data['shipment_id'] = $this->request->post['shipment_id'];
   } elseif (isset($this->session->data['shipment_id'])) {
    $this->data['shipment_id'] = $this->session->data['shipment_id'];
   } elseif (isset($shipments[0])) {
    $this->data['shipment_id'] = $shipments[0]['shipment_id'];
   } else {
    $this->data['shipment_id'] = 0;
   }
   $shipment_id = $this->data['shipment_id'];

   if(!isset($this->session->data['shipment_id'])) {
     $this->session->data['shipment_id'] = $shipment_id;
   } elseif($this->session->data['shipment_id'] == 0) {
     $this->session->data['shipment_id'] = $shipment_id;
   }
   // 140323 ET-140323 End

   // 140606 ET-140606 Begin
   $shipment_details = $this->model_checkout_shipment->getShipmentDetails($shipment_id);

    if (isset($this->request->post['shipment_detail_id'])) {
    $this->data['shipment_detail_id'] = $this->request->post['shipment_detail_id'];
    } elseif (isset($this->session->data['shipment_detail_id'])) {
    $this->data['shipment_detail_id'] = $this->session->data['shipment_detail_id'];
    } elseif (isset($shipment_details[0])) {
    $this->data['shipment_detail_id'] = $shipment_details[0]['shipment_detail_id'];
    } else {
    $this->data['shipment_detail_id'] = 0;
    }

    $shipment_detail_id = $this->data['shipment_detail_id'];

    if(!isset($this->session->data['shipment_detail_id'])) {
     $this->session->data['shipment_detail_id'] = $shipment_detail_id;
    } elseif($this->session->data['shipment_detail_id'] == 0) {
     $this->session->data['shipment_detail_id'] = $shipment_detail_id;
    }
     if ($shipment_id > 0) {
   foreach ($shipments as $shipment) {

    $shipment_cost = $this->getShipmentCostByRate($shipment['rates'], $sub_total);

    $this->data['shipments'][] = array(
        'shipment_id' => $shipment['shipment_id'],
        'name' => $shipment['name'],
        // 140606 ET-140606 Begin
        //'cost' => $this->currency->format($shipment_cost)
        'cost' => $this->currency->format($shipment_cost),
        'door_delivery' => $shipment['door_delivery'],
        'cash_on_delivery' => $shipment['cash_on_delivery']
        // 140606 ET-140606 End
    );
    if($shipment['shipment_id'] == $shipment_id) {
     $this->data['shipment_cost'] = $this->currency->format($shipment_cost);
     $this->data['text_shipment'] = $this->language->get('text_shipment').' - '.$shipment['name'].':';
     $selected_shipment_cost = $shipment_cost;
    }
    // 140606 ET-140606 Begin
    $this->data['shipment_details'] = $shipment_details;
    // 140606 ET-140606 End
   }
  } else {
   foreach ($shipments as $shipment) {

    $shipment_cost = $this->getShipmentCostByRate($shipment['rates'], $sub_total);
    $cost = $shipment_cost;


    $this->data['shipments'][] = array(
        'shipment_id' => $shipment['shipment_id'],
        'name' => $shipment['name'],
        // 140606 ET-140606 Begin
        //'cost' => $this->currency->format($shipment_cost)
        'cost' => $this->currency->format($shipment_cost),
        'door_delivery' => $shipment['door_delivery'],
        'cash_on_delivery' => $shipment['cash_on_delivery']
        // 140606 ET-140606 End

    );
   }
   $selected_shipment_cost = 0;
  }

            $this->language->load('checkout/confirm');

            $this->document->title = $this->language->get('heading_title');

            $data = array();

            $data['customer_id'] = 0;
            $data['firstname'] = $this->session->data['guest']['firstname'];
            $data['lastname'] = $this->session->data['guest']['lastname'];
            $data['email'] = $this->session->data['guest']['email'];
            $data['telephone'] = $this->session->data['guest']['telephone'];
           // var_dump($this->session->data['guest']['telephone']);
            $data['fax'] = $this->session->data['guest']['fax'];

            if ($this->cart->hasShipping()) {
                $data['shipping_firstname'] = $this->session->data['guest']['firstname'];
                $data['shipping_lastname'] = $this->session->data['guest']['lastname'];
                $data['shipping_company'] = $this->session->data['guest']['company'];
                $data['shipping_address_1'] = $this->session->data['guest']['address_1'];
                $data['shipping_address_2'] = $this->session->data['guest']['address_2'];
                $data['shipping_city'] = $this->session->data['guest']['city'];
                $data['shipping_postcode'] = $this->session->data['guest']['postcode'];
                $data['shipping_zone'] = $this->session->data['guest']['zone'];
                $data['shipping_zone_id'] = $this->session->data['guest']['zone_id'];
                $data['shipping_country'] = $this->session->data['guest']['country'];
                $data['shipping_country_id'] = $this->session->data['guest']['country_id'];
                $data['shipping_address_format'] = $this->session->data['guest']['address_format'];
                $data['shipping_cost'] = $this->session->data['shipment_cost'];;

                if (isset($this->session->data['shipping_method']['title'])) {
                    $data['shipping_method'] = $this->session->data['shipping_method']['title'];
                } else {
                    $data['shipping_method'] = '';
                }
            } else {
                $data['shipping_firstname'] = '';
                $data['shipping_lastname'] = '';
                $data['shipping_company'] = '';
                $data['shipping_address_1'] = '';
                $data['shipping_address_2'] = '';
                $data['shipping_city'] = '';
                $data['shipping_postcode'] = '';
                $data['shipping_zone'] = '';
                $data['shipping_zone_id'] = '';
                $data['shipping_country'] = '';
                $data['shipping_country_id'] = '';
                $data['shipping_address_format'] = '';
                $data['shipping_method'] = '';
            }

            $data['payment_firstname'] = $this->session->data['guest']['firstname'];
            $data['payment_lastname'] = $this->session->data['guest']['lastname'];
            $data['payment_company'] = $this->session->data['guest']['company'];
            $data['payment_address_1'] = $this->session->data['guest']['address_1'];
            $data['payment_address_2'] = $this->session->data['guest']['address_2'];
            $data['payment_city'] = $this->session->data['guest']['city'];
            $data['payment_postcode'] = $this->session->data['guest']['postcode'];
            $data['payment_zone'] = $this->session->data['guest']['zone'];
            $data['payment_zone_id'] = $this->session->data['guest']['zone_id'];
            $data['payment_country'] = $this->session->data['guest']['country'];
            $data['payment_country_id'] = $this->session->data['guest']['country_id'];
            $data['payment_address_format'] = $this->session->data['guest']['address_format'];

            if (isset($this->session->data['payment_method']['title'])) {
                $data['payment_method'] = $this->session->data['payment_method']['title'];
            // 140606 ET-140606 Begin
            } elseif (isset($this->request->post['cash_on_delivery'])) {
             if($this->request->post['cash_on_delivery'] == 1) {
              $data['payment_method'] = $this->language->get('text_cash_on_delivery');;
             }
            // 140606 ET-140606 End
            } else {
                $data['payment_method'] = '';
            }

            $product_data = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();
                //var_dump($product);

                foreach ($product['option'] as $option) {
                    $option_data[] = array(
                        'product_option_value_id' => $option['product_option_value_id'],
                        'name'                    => $option['name'],
                        'value'                   => $option['value'],
                        'prefix'                  => $option['prefix']
                    );
                }

                $product_data[] = array(
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'download'   => $product['download'],
                    'quantity'   => $product['quantity'],
                    'price'      => $product['price'],
                    'total'      => $product['total'],
                    'tax'        => $this->tax->getRate($product['tax_class_id']),
                    'nds'        => $product['nds'],
                    // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                    'sborka'    => $product['sborka'],
                    'sborka_cost'    => $product['sborka_cost'],
                    // 100218 ALNAUA New building mechanism in order, mail and invoice End
                    // 100223 ALNAUA Site redesign Begin
                    'serial_no'        => $product['serial_no']
                    // 100223 ALNAUA Site redesign End
                    // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
                    , 'prepayment'       => $product['prepayment']
                    , 'use_in_order_discount' => $product['use_in_order_discount']
                    // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
                    // 20120204 ALNAUA ET-111227 Begin
                    , 'credit_id'       => $product['credit_id']
                    , 'credit_name'     => $product['credit_name']
                    // 20120204 ALNAUA ET-111227 End
                    // ET-150223 Begin
                    , 'min_order_qty' => $product['min_order_qty']
                    // ET-150223 End
                );
            }

              if ($price_nds > 0 && $price_no_nds > 0) {
                  $one = $price_nds - $order_discount + $selected_shipment_cost;
                  $two = $price_no_nds - $order_discount;
              }
              elseif ($price_nds > 0) {
                  $one = $price_nds - $order_discount + $selected_shipment_cost;
              }
              elseif ($price_nds = 0) {
                  $one = $price_nds;
              }
              elseif ($price_no_nds > 0) {
                  $two = $price_no_nds - $order_discount + $selected_shipment_cost;
              }
              elseif ($price_no_nds = 0) {
                  $two = $price_no_nds;
              }

//              if ($price_nds > 0) {
//                  $one = $price_nds - $order_discount + $selected_shipment_cost;
//              } else {
//                  $one = $price_nds;
//              }
//              if($price_no_nds > 0) {
//                  $two = $price_no_nds - $order_discount + $selected_shipment_cost;
//              } else {
//                  $two = $price_no_nds;
//              }

            $data['products'] = $product_data;
            $data['nds'] = $product['nds'];
            $data['totals'] = $total_data;
            $data['tot_no_nds'] = $price_no_nds;
            $data['tot_nds'] = $price_nds;
            $data['comment'] = $this->session->data['comment'];
            $data['total'] = $total;
            $data['language_id'] = $this->language->getId();
            $data['currency_id'] = $this->currency->getId();
            $data['currency'] = $this->currency->getCode();
            $data['value'] = $this->currency->getValue($this->currency->getCode());
            if(isset($one)){
            $data['one_nds'] = $one;
          } else {
            $data['one_nds'] = 0;
          }
            if(isset($two)){
            $data['one_no_nds'] = $two;
          } else {
            $data['one_no_nds'] = 0;
          }


            if (isset($this->session->data['coupon'])) {
                $this->load->model('checkout/coupon');

                $coupon = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);

                if ($coupon) {
                    $data['coupon_id'] = $coupon['coupon_id'];
                } else {
                    $data['coupon_id'] = 0;
                }
            } else {
                $data['coupon_id'] = 0;
            }

            $data['ip'] = $this->request->server['REMOTE_ADDR'];

            $data['secret_code'] = substr(sha1(mt_rand()), 17, 6);
            $this->session->data['secret_code'] = $data['secret_code'];

            // 20120204 ALNAUA ET-111227 Begin
            if (isset($this->request->post['buy_credit'])) {
             $this->data['buy_credit'] = $this->request->post['buy_credit'];
             $data['credit_id'] = $this->cart->getCreditIdForOrder();
            } else {
             $data['credit_id'] = 0;
            }
            // 20120204 ALNAUA ET-111227 End

            $this->load->model('checkout/order');
            $this->session->data['order_id'] = $this->model_checkout_order->create($data);
            $this->model_checkout_order->confirm_width_nds($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
            //var_dump($data['nds']);
            // $c = 0;
           // foreach ($data['products'] as $result){
               // $c++;
             //   var_dump($result);
                //var_dump($result['nds']);
                //if(!empty($result['nds'])){
              //  if($result['nds'] == 1){
                //$this->session->data['order_id'] = $this->model_checkout_order->create($data);
                //$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
                              //  if($c == 1){break;}
             //   }
              //  if($result['nds'] == 0){
              //  $this->session->data['order_id'] = $this->model_checkout_order->create($data);
              //  $this->model_checkout_order->confirms($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
                            //    if($c == 1){break;}
              //  }
                //break;
              //}
        //    }

            // 141208 ET-141208 Begin
            $this->load->model('account/customer');

            $total = $this->model_account_customer->getTotalCustomersByEmail($data['email']);

            if ($total == 0) {
              $data['password'] = '';
              $data['newsletter'] = 1;
              $data['company'] = $data['payment_company'];
              $data['address_1'] = $data['payment_address_1'];
              $data['address_2'] = $data['payment_address_2'];
              $data['city'] = $data['payment_city'];
              $data['postcode'] = $data['payment_postcode'];
              $data['country_id'] = $data['payment_country_id'];
              $data['zone_id'] = $data['payment_zone_id'];

              $this->model_account_customer->addCustomer($data);

            }
            // 141208 ET-141208 End
            $this->redirect($this->url->https('checkout/success'));
          }
        }
        if ($this->request->post['form_name'] == 'urlico') {
          $this->data['active_tab'] = '#tab_urlico';
          if ($this->validate_order_urlico()) {

//              $this->session->data['guest']['firstname'] = $this->request->post['fio'];
              $this->session->data['guest']['firstname'] = '';
//              $this->session->data['guest']['lastname'] = $this->request->post['lastname'];
              $this->session->data['guest']['lastname'] = '';
              $this->session->data['guest']['email'] = $this->request->post['email'];
              $this->session->data['guest']['telephone'] = $this->request->post['telephone'];
//              $this->session->data['guest']['fax'] = $this->request->post['fax'];
              $this->session->data['guest']['fax'] = '';
//              $this->session->data['guest']['company'] = $this->request->post['company'];
              $this->session->data['guest']['company'] = $this->request->post['company'];
              // 140606 ET-140606 Begin
              //$this->session->data['guest']['address_1'] = $this->request->post['address_1'];
              $this->session->data['guest']['address_1'] = (!isset($this->request->post['door_delivery']) && $this->request->post['address_1'] == $this->language->get('text_address_1') ? '' : $this->request->post['address_1']);
              // 140606 ET-140606 End
              $this->session->data['guest']['address_2'] = $this->request->post['address_2'];
              $this->session->data['guest']['postcode'] = $this->request->post['postcode'];
//              $this->session->data['guest']['city'] = $this->request->post['city'];
              $this->session->data['guest']['city'] = '';
              $this->session->data['guest']['country_id'] = $this->request->post['country_id'];
              $this->session->data['guest']['zone_id'] = $this - $this->request->post['telephone'];
              $this->session->data['guest']['shipment_cost'] = $this->request->post['shipment_cost'];
              // 140606 ET-140606 Begin
              $this->session->data['guest']['door_delivery'] = (isset($this->request->post['door_delivery']) ? $this->request->post['door_delivery'] : 0);
              // 140606 ET-140606 End

              if ($this->cart->hasShipping()) {
                  $this->tax->setZone($this->request->post['country_id'], $this->request->post['zone_id']);
              }

              $this->load->model('localisation/country');

              $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

              if ($country_info) {
                  $this->session->data['guest']['country'] = $country_info['name'];
                  $this->session->data['guest']['iso_code_2'] = $country_info['iso_code_2'];
                  $this->session->data['guest']['iso_code_3'] = $country_info['iso_code_3'];
                  $this->session->data['guest']['address_format'] = $country_info['address_format'];
              } else {
                  $this->session->data['guest']['country'] = '';
                  $this->session->data['guest']['iso_code_2'] = '';
                  $this->session->data['guest']['iso_code_3'] = '';
                  $this->session->data['guest']['address_format'] = '';
              }

              $this->load->model('localisation/zone');

              $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

              if ($zone_info) {
                  $this->session->data['guest']['zone'] = $zone_info['name'];
                  $this->session->data['guest']['zone_code'] = $zone_info['code'];
              } else {
                  $this->session->data['guest']['zone'] = '';
                  $this->session->data['guest']['zone_code'] = '';
              }

//              if (isset($this->request->post['shipping_method'])) {
//                  $shipping = explode('.', $this->request->post['shipping_method']);
//
//                  $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
//              }
              $this->session->data['shipping_method'] = $this->request->post['shipping_method'];

//              $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
              $this->session->data['payment_method'] = $this->request->post['payment_method'];

//              $this->session->data['comment'] = $this->request->post['comment'];
              $this->session->data['comment'] = '';

              $total_data = array();
              $total = 0;
              $taxes = $this->cart->getTaxes();

              $this->load->model('checkout/extension');

              $sort_order = array();

              $results = $this->model_checkout_extension->getExtensions('total');

              foreach ($results as $key => $value) {
                  $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
              }

              array_multisort($sort_order, SORT_ASC, $results);

              foreach ($results as $result) {
                  $this->load->model('total/' . $result['key']);

                  $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
              }

              $sort_order = array();

              foreach ($total_data as $key => $value) {
                  $sort_order[$key] = $value['sort_order'];
              }

              array_multisort($sort_order, SORT_ASC, $total_data);

              $price_nds = $this->cart->getNdsTotal();
              $price_no_nds = $this->cart->getNoNdsTotal();
              $order_discount = $this->cart->getOrderDiscount();
              $selected_shipment_cost = 0;

              $this->language->load('checkout/confirm');

              $this->document->title = $this->language->get('heading_title');

              $data = array();

              $data['customer_id'] = 0;
              $data['firstname'] = $this->session->data['guest']['firstname'];
              $data['lastname'] = $this->session->data['guest']['lastname'];
              $data['email'] = $this->session->data['guest']['email'];
              $data['telephone'] = $this->session->data['guest']['telephone'];
              //var_dump($this->session->data['guest']['telephone']);
              $data['fax'] = $this->session->data['guest']['fax'];

              if ($this->cart->hasShipping()) {
                  $data['shipping_firstname'] = $this->session->data['guest']['firstname'];
                  $data['shipping_lastname'] = $this->session->data['guest']['lastname'];
                  $data['shipping_company'] = $this->session->data['guest']['company'];
                  $data['shipping_address_1'] = $this->session->data['guest']['address_1'];
                  $data['shipping_address_2'] = $this->session->data['guest']['address_2'];
                  $data['shipping_city'] = $this->session->data['guest']['city'];
                  $data['shipping_postcode'] = $this->session->data['guest']['postcode'];
                  $data['shipping_zone'] = $this->session->data['guest']['zone'];
                  $data['shipping_zone_id'] = $this->session->data['guest']['zone_id'];
                  $data['shipping_country'] = $this->session->data['guest']['country'];
                  $data['shipping_country_id'] = $this->session->data['guest']['country_id'];
                  $data['shipping_address_format'] = $this->session->data['guest']['address_format'];
                  $data['shipment_cost'] = $this->request->post['shipment_cost'];

                  if (isset($this->session->data['shipping_method']['title'])) {
                      $data['shipping_method'] = $this->session->data['shipping_method']['title'];
                  } else {
                      $data['shipping_method'] = '';
                  }
              } else {
                  $data['shipping_firstname'] = '';
                  $data['shipping_lastname'] = '';
                  $data['shipping_company'] = '';
                  $data['shipping_address_1'] = '';
                  $data['shipping_address_2'] = '';
                  $data['shipping_city'] = '';
                  $data['shipping_postcode'] = '';
                  $data['shipping_zone'] = '';
                  $data['shipping_zone_id'] = '';
                  $data['shipping_country'] = '';
                  $data['shipping_country_id'] = '';
                  $data['shipping_address_format'] = '';
                  $data['shipping_method'] = '';
              }

              $data['payment_firstname'] = $this->session->data['guest']['firstname'];
              $data['payment_lastname'] = $this->session->data['guest']['lastname'];
              $data['payment_company'] = $this->session->data['guest']['company'];
              $data['payment_address_1'] = $this->session->data['guest']['address_2'];
              $data['payment_address_2'] = $this->session->data['guest']['address_1'];
              $data['payment_city'] = $this->session->data['guest']['city'];
              $data['payment_postcode'] = $this->session->data['guest']['postcode'];
              $data['payment_zone'] = $this->session->data['guest']['zone'];
              $data['payment_zone_id'] = $this->session->data['guest']['zone_id'];
              $data['payment_country'] = $this->session->data['guest']['country'];
              $data['payment_country_id'] = $this->session->data['guest']['country_id'];
              $data['payment_address_format'] = $this->session->data['guest']['address_format'];

              if (isset($this->session->data['payment_method']['title'])) {
                  $data['payment_method'] = $this->session->data['payment_method']['title'];
                  // 140606 ET-140606 Begin
              } elseif (isset($this->request->post['cash_on_delivery'])) {
                  if ($this->request->post['cash_on_delivery'] == 1) {
                      $data['payment_method'] = $this->language->get('text_cash_on_delivery');;
                  }
                  // 140606 ET-140606 End
              } else {
                  $data['payment_method'] = '';
              }

              $product_data = array();

              foreach ($this->cart->getProducts() as $product) {
                  $option_data = array();
                  //var_dump($product);

                  foreach ($product['option'] as $option) {
                      $option_data[] = array(
                          'product_option_value_id' => $option['product_option_value_id'],
                          'name' => $option['name'],
                          'value' => $option['value'],
                          'prefix' => $option['prefix']
                      );
                  }
                  $product_data[] = array(
                      'product_id' => $product['product_id'],
                      'name' => $product['name'],
                      'model' => $product['model'],
                      'option' => $option_data,
                      'download' => $product['download'],
                      'quantity' => $product['quantity'],
                      'price' => $product['price'],
                      'total' => $product['total'],
                      'nds' => $product['nds'],
                      'tax' => $this->tax->getRate($product['tax_class_id'])
                      // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                  , 'sborka' => $product['sborka'],
                      'sborka_cost' => $product['sborka_cost'],
                      // 100218 ALNAUA New building mechanism in order, mail and invoice End
                      // 100223 ALNAUA Site redesign Begin
                      'serial_no' => $product['serial_no']
                      // 100223 ALNAUA Site redesign End
                      // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
                  , 'prepayment' => $product['prepayment']
                  , 'use_in_order_discount' => $product['use_in_order_discount']
                      // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
                      // 20120204 ALNAUA ET-111227 Begin
                  , 'credit_id' => $product['credit_id']
                  , 'credit_name' => $product['credit_name']
                      // 20120204 ALNAUA ET-111227 End
                      // ET-150223 Begin
                  , 'min_order_qty' => $product['min_order_qty']
                      // ET-150223 End
                  );
              }

              if ($price_nds > 0 && $price_no_nds > 0) {
                  $one = $price_nds - $order_discount + $selected_shipment_cost;
                  $two = $price_no_nds - $order_discount;
              }
              elseif ($price_nds > 0) {
                  $one = $price_nds - $order_discount + $selected_shipment_cost;
              }
              elseif ($price_nds = 0) {
                  $one = $price_nds;
              }
              elseif ($price_no_nds > 0) {
                  $two = $price_no_nds - $order_discount + $selected_shipment_cost;
              }
              elseif ($price_no_nds = 0) {
                  $two = $price_no_nds;
              }

//              if ($price_nds > 0) {
//                  $one = $price_nds - $order_discount + $selected_shipment_cost;
//              } else {
//                  $one = $price_nds;
//              }
//              if($price_no_nds > 0) {
//                  $two = $price_no_nds - $order_discount + $selected_shipment_cost;
//              } else {
//                  $two = $price_no_nds;
//              }


            $data['products'] = $product_data;
            $data['totals'] = $total_data;
            $data['tot_no_nds'] = $price_no_nds;
            $data['tot_nds'] = $price_nds;
            $data['comment'] = $this->session->data['comment'];
            $data['total'] = $total;
            $data['language_id'] = $this->language->getId();
            $data['currency_id'] = $this->currency->getId();
            $data['currency'] = $this->currency->getCode();
            $data['value'] = $this->currency->getValue($this->currency->getCode());
            $data['one_nds'] = $one;
            $data['one_no_nds'] = $two;

            if (isset($this->session->data['coupon'])) {
                $this->load->model('checkout/coupon');

                $coupon = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);

                if ($coupon) {
                    $data['coupon_id'] = $coupon['coupon_id'];
                } else {
                    $data['coupon_id'] = 0;
                }
            } else {
                $data['coupon_id'] = 0;
            }

            $data['ip'] = $this->request->server['REMOTE_ADDR'];

            $data['secret_code'] = substr(sha1(mt_rand()), 17, 6);
            $this->session->data['secret_code'] = $data['secret_code'];

            // 20120204 ALNAUA ET-111227 Begin
            $data['credit_id'] = 0;
            // 20120204 ALNAUA ET-111227 End

            $this->load->model('checkout/order');
            $this->session->data['order_id'] = $this->model_checkout_order->create($data);
            $this->model_checkout_order->confirm_width_nds($this->session->data['order_id'], $this->config->get('cod_order_status_id'));

            // 141208 ET-141208 Begin
            $this->load->model('account/customer');

            $total = $this->model_account_customer->getTotalCustomersByEmail($data['email']);

            if ($total == 0) {
              $data['password'] = '';
              $data['newsletter'] = 1;
              $data['company'] = $data['payment_company'];
              $data['address_1'] = $data['payment_address_1'];
              $data['address_2'] = $data['payment_address_2'];
              $data['city'] = $data['payment_city'];
              $data['postcode'] = $data['payment_postcode'];
              $data['country_id'] = $data['payment_country_id'];
              $data['zone_id'] = $data['payment_zone_id'];

              $this->model_account_customer->addCustomer($data);
            }
            // 141208 ET-141208 End

            $this->redirect($this->url->https('checkout/success'));
          }
        }
   }

   $this->document->title = $this->language->get('heading_title');

   $this->document->breadcrumbs = array();

   $this->document->breadcrumbs[] = array(
     'href'      => $this->url->http('common/home'),
     'text'      => $this->language->get('text_home'),
     'separator' => FALSE
   );

   $this->document->breadcrumbs[] = array(
     'href'      => $this->url->http('checkout/cart'),
     'text'      => $this->language->get('text_basket'),
     'separator' => $this->language->get('text_separator')
   );
   // 20120204 ALNAUA ET-111227 Begin
   $this->data['text_buy_credit'] = $this->language->get('text_buy_credit');
   // 20120204 ALNAUA ET-111227 End



   if ($this->cart->hasProducts()) {
    $this->data['heading_title'] = $this->language->get('heading_title');

    $this->data['offer_nds'] = $this->language->get('offer_nds');
    $this->data['offer_no_nds'] = $this->language->get('offer_no_nds');

    $this->data['text_select'] = $this->language->get('text_select');
    // 140606 ET-140606 Begin
    $this->data['text_sborka_only'] = $this->language->get('text_sborka_only');
    // 140606 ET-140606 End
    $this->data['text_sub_total'] = $this->language->get('text_sub_total');
    $this->data['text_total_nds'] = $this->language->get('text_total_nds');
    $this->data['text_sborka'] = $this->language->get('text_sborka');
    $this->data['text_delete'] = $this->language->get('text_delete');
    $this->data['tab_fizlico'] = $this->language->get('tab_fizlico');
    $this->data['tab_urlico'] = $this->language->get('tab_urlico');
    $this->data['text_email'] = $this->language->get('text_email');
    $this->data['text_fio'] = $this->language->get('text_fio');
    $this->data['text_telephone'] = $this->language->get('text_telephone');
    $this->data['text_address_1'] = $this->language->get('text_address_1');
    // 130623 ET-130617-6 Begin
    //$this->data['text_captcha'] = $this->language->get('text_captcha');
    // 130623 ET-130617-6 End
    $this->data['text_mandatory'] = $this->language->get('text_mandatory');

    $this->data['text_company'] = $this->language->get('text_company');
    $this->data['text_postcode'] = $this->language->get('text_postcode');
    $this->data['text_address_2'] = $this->language->get('text_address_2');

    $this->data['text_order_discount'] = $this->language->get('text_order_discount');
    $this->data['text_total'] = $this->language->get('text_total');
    // 20120204 ALNAUA ET-111227 Begin
    $this->data['text_credit'] = $this->language->get('text_credit');
    // 20120204 ALNAUA ET-111227 End
    // 140606 ET-140606 Begin
    $this->data['text_cash_on_delivery'] = $this->language->get('text_cash_on_delivery');
    $this->data['text_door_delivery'] = $this->language->get('text_door_delivery');
    // 140606 ET-140606 End
    // ET-150223 Begin
    $this->data['text_min_order_qty_error'] = $this->language->get('text_min_order_qty_error');
    $this->data['text_good'] = $this->language->get('text_good');
    $this->data['text_min_order_qty'] = $this->language->get('text_min_order_qty');
    // ET-150223 End

//   $this->data['text_discount'] = $this->language->get('text_discount');
//   $this->data['text_coupon'] = $this->language->get('text_coupon');

//       $this->data['column_remove'] = $this->language->get('column_remove');
//        $this->data['column_image'] = $this->language->get('column_image');
//        $this->data['column_name'] = $this->language->get('column_name');
//        $this->data['column_model'] = $this->language->get('column_model');
//        $this->data['column_quantity'] = $this->language->get('column_quantity');
//   $this->data['column_price'] = $this->language->get('column_price');
//        $this->data['column_total'] = $this->language->get('column_total');
//
//   $this->data['entry_coupon'] = $this->language->get('entry_coupon');

   $this->data['button_update'] = $this->language->get('button_update');
//        $this->data['button_shopping'] = $this->language->get('button_shopping');
   $this->data['button_checkout'] = $this->language->get('button_checkout');
//   $this->data['button_coupon'] = $this->language->get('button_coupon');
   $this->data['text_quantity'] = $this->language->get('text_quantity');
   // 140323 ET-140323 Begin
   $this->data['entry_shipment'] = $this->language->get('entry_shipment');
   // 140323 ET-140323 End
   // 140323 ET-140323-2 Begin
   $this->data['entry_agreement'] = $this->language->get('entry_agreement');
   // 140323 ET-140323-2 End
   // 140606 ET-140606 Begin
   $this->data['entry_shipment_detail'] = $this->language->get('entry_shipment_detail');
   // 140606 ET-140606 End

   if (isset($this->error['warning'])) {
    $this->data['error_warning'] = $this->error['warning'];
   } elseif (!$this->cart->hasStock() && $this->config->get('config_stock_check')) {
         $this->data['error_warning'] = $this->language->get('error_stock');
   } else {
    $this->data['error_warning'] = '';
   }

   if (isset($this->session->data['success'])) {
    $this->data['success'] = $this->session->data['success'];

    unset($this->session->data['success']);
   } else {
    $this->data['success'] = '';
   }

   // (+) ALNAUA 091114 (START)
   if (isset($this->error['fio'])) {
       $this->data['error_fio'] = $this->error['fio'];
   } else {
       $this->data['error_fio'] = '';
   }

   if (isset($this->error['email_fiz'])) {
       $this->data['error_email_fiz'] = $this->error['email_fiz'];
   } else {
       $this->data['error_email_fiz'] = '';
   }

   if (isset($this->error['email_ur'])) {
       $this->data['error_email_ur'] = $this->error['email_ur'];
   } else {
       $this->data['error_email_ur'] = '';
   }

   if (isset($this->error['telephone_fiz'])) {
       $this->data['error_telephone_fiz'] = $this->error['telephone_fiz'];
   } else {
       $this->data['error_telephone_fiz'] = '';
   }

   if (isset($this->error['telephone_ur'])) {
       $this->data['error_telephone_ur'] = $this->error['telephone_ur'];
   } else {
       $this->data['error_telephone_ur'] = '';
   }

   if (isset($this->error['address_1_fiz'])) {
       $this->data['error_address_1_fiz'] = $this->error['address_1_fiz'];
   } else {
       $this->data['error_address_1_fiz'] = '';
   }

   if (isset($this->error['address_1_ur'])) {
       $this->data['error_address_1_ur'] = $this->error['address_1_ur'];
   } else {
       $this->data['error_address_1_ur'] = '';
   }

   // 130623 ET-130617-6 Begin
   //if (isset($this->error['captcha_fiz'])) {
   //    $this->data['error_captcha_fiz'] = $this->error['captcha_fiz'];
   //} else {
   //    $this->data['error_captcha_fiz'] = '';
   //}

   //if (isset($this->error['captcha_ur'])) {
   //    $this->data['error_captcha_ur'] = $this->error['captcha_ur'];
   //} else {
   //    $this->data['error_captcha_ur'] = '';
   //}
   // 130623 ET-130617-6 End

   if (isset($this->error['company'])) {
       $this->data['error_company'] = $this->error['company'];
   } else {
       $this->data['error_company'] = '';
   }

   if (isset($this->error['address_2'])) {
       $this->data['error_address_2'] = $this->error['address_2'];
   } else {
       $this->data['error_address_2'] = '';
   }

   if (isset($this->error['postcode'])) {
       $this->data['error_postcode'] = $this->error['postcode'];
   } else {
       $this->data['error_postcode'] = '';
   }
   // (+) ALNAUA 091114 (FINISH)
   // 20120204 ALNAUA ET-111227 Begin
   if (isset($this->error['buy_credit'])) {
       $this->data['error_buy_credit'] = $this->error['buy_credit'];
   } else {
       $this->data['error_buy_credit'] = '';
   }
   // 20120204 ALNAUA ET-111227 End

   // 140323 ET-140323-2 Begin
   if (isset($this->error['agreement'])) {
       $this->data['error_agreement'] = $this->error['agreement'];
   } else {
       $this->data['error_agreement'] = '';
   }
   // 140323 ET-140323-2 End

   $this->data['action'] = $this->url->http('checkout/cart');

   if (isset($this->request->post['fio'])) {
       $this->data['fio'] = $this->request->post['fio'];
   } elseif (isset($this->session->data['guest']['firstname'])) {
       $this->data['fio'] = $this->session->data['guest']['firstname'];
   } else {
       $this->data['fio'] = $this->data['text_fio'];
   }

   if (isset($this->request->post['email'])) {
       $this->data['email'] = $this->request->post['email'];
   } elseif (isset($this->session->data['guest']['email'])) {
       $this->data['email'] = $this->session->data['guest']['email'];
   } else {
       $this->data['email'] = $this->data['text_email'];
   }

   if (isset($this->request->post['telephone'])) {
       $this->data['telephone'] = $this->request->post['telephone'];
   } elseif (isset($this->session->data['guest']['telephone'])) {
       $this->data['telephone'] = $this->session->data['guest']['telephone'];
   } else {
       $this->data['telephone'] = $this->data['text_telephone'];
       //   var_dump($this->data['telephone']);
   }

   // 140606 ET-140606 Begin
   if (isset($this->request->post['cash_on_delivery'])) {
       $this->data['cash_on_delivery'] = $this->request->post['cash_on_delivery'];
   } elseif (isset($this->session->data['guest']['cash_on_delivery'])) {
       $this->data['cash_on_delivery'] = $this->session->data['guest']['cash_on_delivery'];
   } else {
       $this->data['cash_on_delivery'] = 0;
   }
   if (isset($this->request->post['door_delivery'])) {
       $this->data['door_delivery'] = $this->request->post['door_delivery'];
   } elseif (isset($this->session->data['guest']['door_delivery'])) {
       $this->data['door_delivery'] = $this->session->data['guest']['door_delivery'];
   } else {
       $this->data['door_delivery'] = 0;
   }
   // 140606 ET-140606 End

   if (isset($this->request->post['address_1'])) {
       $this->data['address_1'] = $this->request->post['address_1'];
   } elseif (isset($this->session->data['guest']['address_1'])) {
       $this->data['address_1'] = $this->session->data['guest']['address_1'];
   } else {
       $this->data['address_1'] = $this->data['text_address_1'];
   }

   if (isset($this->request->post['company'])) {
       $this->data['company'] = $this->request->post['company'];
   } elseif (isset($this->session->data['guest']['company'])) {
       $this->data['company'] = $this->session->data['guest']['company'];
   } else {
       $this->data['company'] = $this->data['text_company'];
   }

   if (isset($this->request->post['postcode'])) {
       $this->data['postcode'] = $this->request->post['postcode'];
   } elseif (isset($this->session->data['guest']['postcode'])) {
       $this->data['postcode'] = $this->session->data['guest']['postcode'];
   } else {
       $this->data['postcode'] = $this->data['text_postcode'];
   }

   if (isset($this->request->post['address_2'])) {
       $this->data['address_2'] = $this->request->post['address_2'];
   } elseif (isset($this->session->data['guest']['address_2'])) {
       $this->data['address_2'] = $this->session->data['guest']['address_2'];
   } else {
       $this->data['address_2'] = $this->data['text_address_2'];
   }

   // 20120204 ALNAUA ET-111227 Begin
   if (isset($this->request->post['buy_credit'])) {
    $this->data['buy_credit'] = $this->request->post['buy_credit'];
   } else {
    $this->data['buy_credit'] = 0;
   }
   // 20120204 ALNAUA ET-111227 End

   // 140323 ET-140323-2 Begin
   if (isset($this->request->post['agreement'])) {
    $this->data['agreement'] = $this->request->post['agreement'];
   } elseif (isset($this->error['agreement'])) {
    $this->data['agreement'] = 0;
   } else {
    $this->data['agreement'] = 1;
   }
   // 140323 ET-140323-2 End

   // 140323 ET-140323 Begin
   $this->load->model('checkout/shipment');

   $shipment_data = array();
   $shipments = $this->model_checkout_shipment->getShipments($shipment_data);

   if (isset($this->request->post['shipment_id'])) {
    $this->data['shipment_id'] = $this->request->post['shipment_id'];
   } elseif (isset($this->session->data['shipment_id'])) {
    $this->data['shipment_id'] = $this->session->data['shipment_id'];
   } elseif (isset($shipments[0])) {
    $this->data['shipment_id'] = $shipments[0]['shipment_id'];
   } else {
    $this->data['shipment_id'] = 0;
   }
   $shipment_id = $this->data['shipment_id'];

   if(!isset($this->session->data['shipment_id'])) {
     $this->session->data['shipment_id'] = $shipment_id;
   } elseif($this->session->data['shipment_id'] == 0) {
     $this->session->data['shipment_id'] = $shipment_id;
   }
   // 140323 ET-140323 End

   // 140606 ET-140606 Begin
   $shipment_details = $this->model_checkout_shipment->getShipmentDetails($shipment_id);

    if (isset($this->request->post['shipment_detail_id'])) {
    $this->data['shipment_detail_id'] = $this->request->post['shipment_detail_id'];
    } elseif (isset($this->session->data['shipment_detail_id'])) {
    $this->data['shipment_detail_id'] = $this->session->data['shipment_detail_id'];
    } elseif (isset($shipment_details[0])) {
    $this->data['shipment_detail_id'] = $shipment_details[0]['shipment_detail_id'];
    } else {
    $this->data['shipment_detail_id'] = 0;
    }

    $shipment_detail_id = $this->data['shipment_detail_id'];

    if(!isset($this->session->data['shipment_detail_id'])) {
     $this->session->data['shipment_detail_id'] = $shipment_detail_id;
    } elseif($this->session->data['shipment_detail_id'] == 0) {
     $this->session->data['shipment_detail_id'] = $shipment_detail_id;
    }

   // 140606 ET-140606 End

    $this->load->model('tool/seo_url');
    $this->load->helper('image');

    // $this->load->model('catalog/product');
    // $perecenka = $this->model_catalog_product->getProduct('price');
    // var_dump($perecenka);

    $this->data['products'] = array();
    //var_dump($this->data['products']);

    $this->data['products_count'] = $this->cart->countProducts();

    foreach ($this->cart->getProducts() as $result) {
     $option_data = array();


     foreach ($result['option'] as $option) {
        $option_data[] = array(
          'name'  => $option['name'],
          'value' => $option['value']
        );
     }

    if ($result['image']) {
     $image = $result['image'];
    } else {
     $image = 'no_image.jpg';
    }

    $this->data['products'][] = array(
       'key'      => $result['key'],
       'name'     => $result['name'],
       'model'    => $result['model'],
       'thumb'    => image_resize($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')),
       'option'   => $option_data,
       'quantity' => $result['quantity'],
       'stock'    => $result['stock'],
       'nds'      => $result['nds'],
       // 140606 ET-140606 Begin
       //'price'    => $this->currency->format($this->tax->calculate($result['price'] + ($result['sborka'] == 1 ? $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))),
       //'total'    => $this->currency->format($this->tax->calculate($result['total'] + ($result['sborka'] == 1 ? $result['quantity'] * $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))),
       //'price'    => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
       //'total'    => $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))),
       'price'    => $result['price'],
       'total'    => $result['total'],
       // 140606 ET-140606 End
       'href'     => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
       // (+) ALNAUA 091114 (START)
       , 'sborka'       => $result['sborka']
       // (+) ALNAUA 091114 (FINISH)
       // 20120204 ALNAUA ET-111227 Begin
       , 'credit_id'       => $result['credit_id']
       , 'credit_name'     => $result['credit_name']
       // 20120204 ALNAUA ET-111227 End
       // ET-150223 Begin
       , 'min_order_qty' => $result['min_order_qty']
       // ET-150223 End
    );
  }
  // 140606 ET-140606 Begin
  $sborka_only = $this->cart->getSborka();
  $sborka_two = $this->cart->getSborkaTwo();
  // 140606 ET-140606 End
  $sub_total = $this->cart->getTotal();

  $price_nds = $this->cart->getNdsTotal();

  $price_no_nds = $this->cart->getNoNdsTotal();

  $order_discount = $this->cart->getOrderDiscount();

  // 140323 ET-140323 Begin
  $this->data['shipments'] = array();
  // 140606 ET-140606 Begin
  $this->data['shipment_details'] = array();
  // 140606 ET-140606 End

  if ($shipment_id > 0) {
   foreach ($shipments as $shipment) {

    $shipment_cost = $this->getShipmentCostByRate($shipment['rates'], $sub_total);

    $this->data['shipments'][] = array(
        'shipment_id' => $shipment['shipment_id'],
        'name' => $shipment['name'],
        // 140606 ET-140606 Begin
        //'cost' => $this->currency->format($shipment_cost)
        'cost' => $this->currency->format($shipment_cost),
        'door_delivery' => $shipment['door_delivery'],
        'cash_on_delivery' => $shipment['cash_on_delivery']
        // 140606 ET-140606 End
    );
    if($shipment['shipment_id'] == $shipment_id) {
     $this->data['shipment_cost'] = $this->currency->format($shipment_cost);
     $this->data['text_shipment'] = $this->language->get('text_shipment').' - '.$shipment['name'].':';
     $selected_shipment_cost = $shipment_cost;
    }
    // 140606 ET-140606 Begin
    $this->data['shipment_details'] = $shipment_details;
    // 140606 ET-140606 End
   }
  } else {
   foreach ($shipments as $shipment) {

    $shipment_cost = $this->getShipmentCostByRate($shipment['rates'], $sub_total);

    $this->data['shipments'][] = array(
        'shipment_id' => $shipment['shipment_id'],
        'name' => $shipment['name'],
        // 140606 ET-140606 Begin
        //'cost' => $this->currency->format($shipment_cost)
        'cost' => $this->currency->format($shipment_cost),
        'door_delivery' => $shipment['door_delivery'],
        'cash_on_delivery' => $shipment['cash_on_delivery']
        // 140606 ET-140606 End

    );
   }
   $this->data['text_shipment'] = $this->language->get('text_shipment').':';
   $this->data['shipment_cost'] = $this->currency->format(0);
   $selected_shipment_cost = 0;

   // 140606 ET-140606 Begin
   $this->data['shipment_details'] = $shipment_details;
   // 140606 ET-140606 End
  }
  // 140323 ET-140323 End

  // 140606 ET-140606 Begin
  $this->data['sborka_only'] = $this->currency->format($sborka_only);
  $this->data['sborka_two'] = $this->currency->format($sborka_two);
  // 140606 ET-140606 End
  $this->data['sub_total'] = $this->currency->format($sub_total);
  // NDS for cart
  $this->data['nds'] = $this->currency->format($price_nds*0.2);

  $this->data['nds_sub_total'] = $this->currency->format($price_nds);

  $this->data['totsal'] = $this->currency->format($price_no_nds);

  //$this->data['switch'] = $result['nds'];
  //$this->data['nds'] = $this->currency->format($sub_total*0.2);

  $this->data['order_discount'] = $this->currency->format($order_discount);
  // 140323 ET-140323 Begin
  //$this->data['total'] =  $this->currency->format($sub_total - $order_discount);
  $this->data['total'] =  $this->currency->format($sub_total - $order_discount + $selected_shipment_cost);

  $this->data['nds_total'] = $this->currency->format($price_nds - $order_discount + $selected_shipment_cost);
  $this->data['no_nds_total'] = $this->currency->format($price_no_nds - $order_discount + $selected_shipment_cost);
  // 140323 ET-140323 End

//   if (isset($this->request->post['coupon'])) {
//    $this->data['coupon'] = $this->request->post['coupon'];
//   } elseif (isset($this->session->data['coupon'])) {
//    $this->data['coupon'] = $this->session->data['coupon'];
//   } else {
//    $this->data['coupon'] = '';
//   }

   if (isset($this->session->data['redirect'])) {
    $this->data['continue'] = $this->session->data['redirect'];

    unset($this->session->data['redirect']);
   } else {
    $this->data['continue'] = $this->url->http('common/home');
   }

   $this->data['checkout'] = $this->url->http('checkout/shipping');

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/checkout/cart.tpl';
   } else {
    $this->template = 'default/template/checkout/cart.tpl';
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

    $this->data['button_continue'] = $this->language->get('button_continue');

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

private function validate() {
  $this->load->model('checkout/coupon');

  $coupon = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);

  if (!$coupon) {
   $this->error['warning'] = $this->language->get('error_coupon');
  }

  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

// (+) ALNAUA 091114 (START)
public function remove_refresh($buy_credit = FALSE) {
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        if (isset($this->request->post['product_key'])) {
            $this->cart->remove($this->request->post['product_key']);
        }
    if (isset($this->request->post['buy_credit'])) {
        $buy_credit = $this->request->post['buy_credit'];
        }
    }

    $this->language->load('checkout/cart');

    if ($this->cart->hasProducts()) {

    $this->load->model('tool/seo_url');
    $this->load->helper('image');

    $output = '<div id="cart_contents">';
    $output = '<input type="hidden" value="cart" name="form_name" />';
    foreach ($this->cart->getProducts() as $result) {
     $option_data = array();
     if ($result['nds'] == 1){

     foreach ($result['option'] as $option) {
        $option_data[] = array(
          'name'  => $option['name'],
          'value' => $option['value']
        );
     }
    if ($result['image']) {
     $image = $result['image'];
    } else {
     $image = 'no_image.jpg';
    }

    $output .= '<div class="cartrow" id='.$result['key'].'><table class="carttable"><tr>';
    if ($result['sborka']==1) {
      $output .= '<td class="sborka" align="center" title="'.$this->language->get('text_sborka').'"><input onclick=\'update_sborka(this,"'. $result['key'] .'");\' class="sborkachkbox" type="checkbox" name="sborka[' . $result['key'] . ']" checked /></td>';
    } else {
      $output .= '<td class="sborka" align="center" title="'.$this->language->get('text_sborka').'"><input onclick=\'update_sborka(this,"'. $result['key'] .'");\' class="sborkachkbox" type="checkbox" name="sborka[' . $result['key'] . ']" /></td>';
    }
    $output .= '<td width="75px"><a href="'.$this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id'])). '"><img src="'.image_resize($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')).'" alt="'.$result['name'].'" /></a></td>';
    $output .= '<td width="47%>';
    $output .= '<a href="'.$this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id'])).'"><b>'.$result['name'].'</b></a> ';
    $output .= '<span style="font-size: x-small;">'.$result['model'].'</span>';
    $output .= '<div>';
    if ($buy_credit && $result['credit_id'] > 0) {
    $output .= '- <small><span style="color: black;"><b>' . $this->language->get('text_credit') . '</b></span> ' . $result['credit_name']. '</small><br />';
    }
    foreach ($option_data as $option) {
      $output .= '- <small><span style="color: black;"><b>'.$option['name'].':</b></span> '.html_entity_decode($option['value'], ENT_NOQUOTES, 'UTF-8').'</small><br />';
    }
    $output .= '</div></td>';
    $output .= '<td align="center"><input class="quantity" type="text" name="quantity['.$result['key'].']" value="'.$result['quantity'].'" size="3" /><br /><small>'.$this->language->get('text_quantity').'</small></td>';
    // 140606 ET-140606 Begin
    $output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['price'] + ($result['sborka'] == 1 ? $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
    $output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['total'] + ($result['sborka'] == 1 ? $result['quantity'] * $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
    //$output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
    //$output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
    // 140606 ET-140606 End
    $output .= '<td class="delete" title="'.$this->language->get('text_delete').'"><div class="cartdelete" onclick=\'remove_product("'.$result['key'].'");\'>&nbsp;</div></td>';
    $output .= '</tr>';
    $output .= '</table>';
    $output .= '</div>';

    // 140606 ET-140606 Begin
    $sborka_only = $this->cart->getSborka();
    // 140606 ET-140606 End
          }
    }

    // 140323 ET-140323 Begin
    $this->load->model('checkout/shipment');
    $sub_total = $this->cart->getTotal();

    $price_nds = $this->cart->getNdsTotal();

    if (isset($this->session->data['shipment_id'])) {
    if ($this->session->data['shipment_id'] > 0) {
    $shipment_info = $this->model_checkout_shipment->getShipment($this->session->data['shipment_id']);
    $shipment_cost = $this->getShipmentCostByRate($shipment_info['rates'], $sub_total);
     $text_shipment = $this->language->get('text_shipment').' - '.$shipment_info['name'].':';
    } else {
     $text_shipment = $this->language->get('text_shipment').':';
     $shipment_cost = 0;
     }
    }
    // 140606 ET-140606 Begin
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_sborka_only').'</b> '.$this->currency->format($sborka_only).'</div>';
    // 140606 ET-140606 End
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_sub_total').'</b> '.$this->currency->format($price_nds).'</div>';
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_total_nds').'</b>'.$this->currency->format($price_nds*0.2).'</div>';
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_order_discount').'</b> '.$this->currency->format($this->cart->getOrderDiscount()).'</div>';
    // 140323 ET-140323 Begin
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$text_shipment.'</b> '.$this->currency->format($shipment_cost).'</div>';
    //$output .= '<div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b>'.$this->language->get('text_total').'</b> '.$this->currency->format($sub_total - $this->cart->getOrderDiscount().'</div>';
    $output .= '<div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b>'.$this->language->get('text_total').'</b> '.$this->currency->format($price_nds - $this->cart->getOrderDiscount() + $shipment_cost).'</div>';
    // 140323 ET-140323 End
    $output .= '<table width="100%"><tr>';
    $output .= '<td align="right"><a onclick="$(\'#cart\').submit();" class="button"><span>'.$this->language->get('button_update').'</span></a></td>';
    $output .= '</tr></table>';
    $output .= '</div>';
    } else {
    $output  = '<div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">'.$this->language->get('text_error').'</div>';
    $output .= '<div class="buttons"><table><tr>';
    $output .= '<td align="right"><a onclick="location=\''.$this->url->http('common/home').'\'" class="button"><span>'.$this->language->get('button_continue').'</span></a></td>';
    $output .= '</tr></table>';
    $output .= '</div>';
    }

    $this->response->setOutput($output, $this->config->get('config_compression'));
}

public function remove_refresh_second_order($buy_credit = FALSE) {
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        if (isset($this->request->post['product_key'])) {
            $this->cart->remove($this->request->post['product_key']);
        }
    if (isset($this->request->post['buy_credit'])) {
        $buy_credit = $this->request->post['buy_credit'];
        }
    }

    $this->language->load('checkout/cart');

    if ($this->cart->hasProducts()) {

        $this->load->model('tool/seo_url');
        $this->load->helper('image');

        $output = '<div id="cart_contentss">';
        $output = '<input type="hidden" value="cart" name="form_name" />';
        foreach ($this->cart->getProducts() as $result) {
            $option_data = array();
            if ($result['nds'] == 0) {

                foreach ($result['option'] as $option) {
                    $option_data[] = array(
                        'name' => $option['name'],
                        'value' => $option['value']
                    );
                }
                if ($result['image']) {
                    $image = $result['image'];
                } else {
                    $image = 'no_image.jpg';
                }

                $output .= '<div class="cartrows" id=' . $result['key'] . '><table class="carttable"><tr>';
                if ($result['sborka'] == 1) {
                    $output .= '<td class="sborka" align="center" title="' . $this->language->get('text_sborka') . '"><input onclick=\'update_sborkas(this,"' . $result['key'] . '");\' class="sborkachkbox" type="checkbox" name="sborka[' . $result['key'] . ']" checked /></td>';
                } else {
                    $output .= '<td class="sborka" align="center" title="' . $this->language->get('text_sborka') . '"><input onclick=\'update_sborkas(this,"' . $result['key'] . '");\' class="sborkachkbox" type="checkbox" name="sborka[' . $result['key'] . ']" /></td>';
                }
                $output .= '<td width="75px"><a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id'])) . '"><img src="' . image_resize($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')) . '" alt="' . $result['name'] . '" /></a></td>';
                $output .= '<td width="47%>';
                $output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id'])) . '"><b>' . $result['name'] . '</b></a> ';
                $output .= '<span style="font-size: x-small;">' . $result['model'] . '</span>';
                $output .= '<div>';
                if ($buy_credit && $result['credit_id'] > 0) {
                    $output .= '- <small><span style="color: black;"><b>' . $this->language->get('text_credit') . '</b></span> ' . $result['credit_name'] . '</small><br />';
                }
                foreach ($option_data as $option) {
                    $output .= '- <small><span style="color: black;"><b>' . $option['name'] . ':</b></span> ' . html_entity_decode($option['value'], ENT_NOQUOTES, 'UTF-8') . '</small><br />';
                }
                $output .= '</div></td>';
                $output .= '<td align="center"><input class="quantity" type="text" name="quantity[' . $result['key'] . ']" value="' . $result['quantity'] . '" size="3" /><br /><small>' . $this->language->get('text_quantity') . '</small></td>';
                // 140606 ET-140606 Begin
                $output .= '<td align="right">' . $this->currency->format($this->tax->calculate($result['price'] + ($result['sborka'] == 1 ? $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))) . '</td>';
                $output .= '<td align="right">' . $this->currency->format($this->tax->calculate($result['total'] + ($result['sborka'] == 1 ? $result['quantity'] * $result['sborka_cost'] : 0), $result['tax_class_id'], $this->config->get('config_tax'))) . '</td>';
                //$output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
                //$output .= '<td align="right">'.$this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))).'</td>';
                // 140606 ET-140606 End
                $output .= '<td class="delete" title="' . $this->language->get('text_delete') . '"><div class="cartdelete" onclick=\'remove_products("' . $result['key'] . '");\'>&nbsp;</div></td>';
                $output .= '</tr>';
                $output .= '</table>';
                $output .= '</div>';

                // 140606 ET-140606 Begin
                $sborka_only = $this->cart->getSborkaTwo();
            }
            // 140606 ET-140606 End
            if ($result['nds'] == 1) {
                $no_ship = TRUE;
            }
        }
        // 140323 ET-140323 Begin
        $this->load->model('checkout/shipment');
        $sub_total = $this->cart->getTotal();
        $price_no_nds = $this->cart->getNoNdsTotal();

        if ($no_ship == TRUE){
            $text_shipment = $this->language->get('text_shipment') . ':';
            $shipment_cost = 0;
        }
        else {
            if (isset($this->session->data['shipment_id'])) {
                if ($this->session->data['shipment_id'] > 0) {
                    $shipment_info = $this->model_checkout_shipment->getShipment($this->session->data['shipment_id']);
                    $shipment_cost = $this->getShipmentCostByRate($shipment_info['rates'], $sub_total);
                    $text_shipment = $this->language->get('text_shipment') . ' - ' . $shipment_info['name'] . ':';
                } else {
                    $text_shipment = $this->language->get('text_shipment') . ':';
                    $shipment_cost = 0;
                }
            }
        }
    // 140606 ET-140606 Begin
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_sborka_only').'</b> '.$this->currency->format($sborka_only).'</div>';
    // 140606 ET-140606 End
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_sub_total').'</b> '.$this->currency->format($price_no_nds).'</div>';
    //$output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_total_nds').'</b>'.$this->currency->format($sub_total*0.2).'</div>';
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$this->language->get('text_order_discount').'</b> '.$this->currency->format($this->cart->getOrderDiscount()).'</div>';
    // 140323 ET-140323 Begin
    $output .= '<div style="margin-right: 24px;" align="right"><b>'.$text_shipment.'</b> '.$this->currency->format($shipment_cost).'</div>';
    //$output .= '<div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b>'.$this->language->get('text_total').'</b> '.$this->currency->format($sub_total - $this->cart->getOrderDiscount().'</div>';
    $output .= '<div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b>'.$this->language->get('text_total').'</b> '.$this->currency->format($price_no_nds - $this->cart->getOrderDiscount() + $shipment_cost).'</div>';
    // 140323 ET-140323 End
    $output .= '<table width="100%"><tr>';
    $output .= '<td align="right"><a onclick="$(\'#cart\').submit();" class="button"><span>'.$this->language->get('button_updates').'</span></a></td>';
    $output .= '</tr></table>';
    $output .= '</div>';
    } else {
    $output  = '<div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">'.$this->language->get('text_error').'</div>';
    $output .= '<div class="buttons"><table><tr>';
    $output .= '<td align="right"><a onclick="location=\''.$this->url->http('common/home').'\'" class="button"><span>'.$this->language->get('button_continue').'</span></a></td>';
    $output .= '</tr></table>';
    $output .= '</div>';
    }

    $this->response->setOutput($output, $this->config->get('config_compression'));
}

    public function update_sborka() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
       if (isset($this->request->get['product_key'])) {
         $this->cart->update_sborka($this->request->get['product_key'], $this->request->get['checked']);

         $this->remove_refresh($this->request->get['buy_credit'] == 'true');
       }
     }
}


    public function update_sborka_second_order() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
       if (isset($this->request->get['product_key'])) {
         $this->cart->update_sborka($this->request->get['product_key'], $this->request->get['checked']);

         $this->remove_refresh_second_order($this->request->get['buy_credit'] == 'true');
       }
     }
}

 public function clear() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
         $this->cart->clear();

         $this->remove_refresh($this->request->get['buy_credit'] == 'true');
     }
 }

 public function check_sborka() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
         $this->cart->check_sborka();

         $this->remove_refresh($this->request->get['buy_credit'] == 'true');
     }
 }

 public function check_sborka_second_order() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
         $this->cart->check_sborka_two();

         $this->remove_refresh_second_order($this->request->get['buy_credit'] == 'true');
     }
 }

 // 20120204 ALNAUA ET-111227 Begin
    public function update_credit() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
        $this->remove_refresh($this->request->get['buy_credit'] == 'true');
     }
    }

    public function update_credit_second() {
     if ($this->request->server['REQUEST_METHOD'] == 'GET') {
        $this->remove_refresh_second_order($this->request->get['buy_credit'] == 'true');
     }
    }


    private function validate_order_fizlico() {
     $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9_]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))*(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';

     if ($this->request->post['email'] == $this->language->get('text_email')) {
       $this->error['email_fiz'] = $this->language->get('error_email_input');
     } elseif (!preg_match($pattern, $this->request->post['email'])) {
         $this->error['email_fiz'] = $this->language->get('error_email');
     }

     if ($this->request->post['telephone'] == $this->language->get('text_telephone')) {
       $this->error['telephone_fiz'] = $this->language->get('error_telephone_input');
     } elseif ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
         $this->error['telephone_fiz'] = $this->language->get('error_telephone');
     }

     // 140606 ET-140606 Begin
     //if ($this->request->post['address_1'] == $this->language->get('text_address_1')) {
     if ($this->request->post['address_1'] == $this->language->get('text_address_1') && isset($this->request->post['door_delivery'])) {
     // 140606 ET-140606 End
       $this->error['address_1_fiz'] = $this->language->get('error_address_1_input');
     // 140606 ET-140606 Begin
     //} elseif ((strlen(utf8_decode($this->request->post['address_1'])) < 3) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) {
     } elseif (((strlen(utf8_decode($this->request->post['address_1'])) < 3) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) && isset($this->request->post['door_delivery'])) {
     // 140606 ET-140606 End
       $this->error['address_1_fiz'] = $this->language->get('error_address_1');
     }

     if ($this->request->post['fio'] == $this->language->get('text_fio')) {
       $this->error['fio'] = $this->language->get('error_fio_input');
     } elseif ((strlen(utf8_decode($this->request->post['fio'])) < 3) || (strlen(utf8_decode($this->request->post['fio'])) > 255)) {
         $this->error['fio'] = $this->language->get('error_fio');
     }

     // 130623 ET-130617-6 Begin
     //if ($this->session->data['captcha_fizlico'] != $this->request->post['captcha']) {
     //   $this->error['captcha_fiz'] = $this->language->get('error_captcha');
     //}
     // 130623 ET-130617-6 End

     // 20120204 ALNAUA ET-111227 Begin
     if (isset($this->request->post['buy_credit']) && $this->cart->getHasDifferentCreditPrograms()) {
      $this->error['buy_credit'] = $this->language->get('error_buy_credit');
     }
     // 20120204 ALNAUA ET-111227 End

     // 140323 ET-140323-2 Begin
     if (!isset($this->request->post['agreement'])) {
      $this->error['agreement'] = $this->language->get('error_agreement');
     }
     // 140323 ET-140323-2 End

     if (!$this->error) {
        return TRUE;
     } else {
        return FALSE;
     }
    }

    private function validate_order_urlico() {
        $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9_]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))*(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';

        if ($this->request->post['email'] == $this->language->get('text_email')) {
          $this->error['email_ur'] = $this->language->get('error_email_input');
        } elseif (!preg_match($pattern, $this->request->post['email'])) {
            $this->error['email_ur'] = $this->language->get('error_email');
        }

        if ($this->request->post['telephone'] == $this->language->get('text_telephone')) {
          $this->error['telephone_ur'] = $this->language->get('error_telephone_input');
        } elseif ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
            $this->error['telephone_ur'] = $this->language->get('error_telephone');
        }

        // 140606 ET-140606 Begin
        //if ($this->request->post['address_1'] == $this->language->get('text_address_1')) {
        if ($this->request->post['address_1'] == $this->language->get('text_address_1') && isset($this->request->post['door_delivery'])) {
        // 140606 ET-140606 End
          $this->error['address_1_ur'] = $this->language->get('error_address_1_input');
        // 140606 ET-140606 Begin
        //} elseif ((strlen(utf8_decode($this->request->post['address_1'])) < 3) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) {
        } elseif (((strlen(utf8_decode($this->request->post['address_1'])) < 3) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) && isset($this->request->post['door_delivery'])) {
        // 140606 ET-140606 End
          $this->error['address_1_ur'] = $this->language->get('error_address_1');
        }

        if ($this->request->post['company'] == $this->language->get('text_company')) {
          $this->error['company'] = $this->language->get('error_company_input');
        } elseif ((strlen(utf8_decode($this->request->post['company'])) < 3) || (strlen(utf8_decode($this->request->post['company'])) > 255)) {
            $this->error['company'] = $this->language->get('error_company');
        }

        if ($this->request->post['address_2'] == $this->language->get('text_address_2')) {
          $this->error['address_2'] = $this->language->get('error_address_2_input');
        } elseif ((strlen(utf8_decode($this->request->post['address_2'])) < 3) || (strlen(utf8_decode($this->request->post['address_2'])) > 128)) {
          $this->error['address_2'] = $this->language->get('error_address_2');
        }

        if ($this->request->post['postcode'] == $this->language->get('text_postcode')) {
          $this->error['postcode'] = $this->language->get('error_postcode_input');
        } elseif ((strlen(utf8_decode($this->request->post['postcode'])) < 3) || (strlen(utf8_decode($this->request->post['postcode'])) > 255)) {
            $this->error['postcode'] = $this->language->get('error_postcode');
        }

        // 130623 ET-130617-6 Begin
        //if ($this->session->data['captcha_urlico'] != $this->request->post['captcha']) {
        //   $this->error['captcha_ur'] = $this->language->get('error_captcha');
        //}
        // 130623 ET-130617-6 End

        // 140323 ET-140323-2 Begin
        if (!isset($this->request->post['agreement'])) {
         $this->error['agreement'] = $this->language->get('error_agreement');
        }
        // 140323 ET-140323-2 End

        if (!$this->error) {
           return TRUE;
        } else {
           return FALSE;
        }
       }
       // (+) ALNAUA 091114 (FINISH)
// 140323 ET-140323 Begin
 private function getShipmentCostByRate($shipment_rates, $cart_total) {

  $shipment_cost = 0;

  if (isset($shipment_rates) && isset($cart_total)) {
   $rates = explode(',', $shipment_rates);

   foreach ($rates as $rate) {
    $data = explode(':', $rate);
    if ($data[0] >= $cart_total) {
     if (isset($data[1])) {
      $shipment_cost = $data[1];
     }
     break;
    }
   }
  }
  return $shipment_cost;
 }

 public function update_shipment() {
  if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   if(isset($this->request->get['shipment_id'])) {
    $this->session->data['shipment_id'] = $this->request->get['shipment_id'];
   } else {
    $this->session->data['shipment_id'] = 0;
   }
   $this->remove_refresh($this->request->get['buy_credit'] == 'true');
  }
 }

  public function update_shipment_second() {
  if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   if(isset($this->request->get['shipment_id'])) {
    $this->session->data['shipment_id'] = $this->request->get['shipment_id'];
   } else {
    $this->session->data['shipment_id'] = 0;
   }
   $this->remove_refresh_second_order($this->request->get['buy_credit'] == 'true');
  }
 }

 public function update_shipment_combo() {
  $output = '';

  if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   if(isset($this->session->data['shipment_id'])) {
    $shipment_id = $this->session->data['shipment_id'];
   } else {
    $shipment_id = 0;
   }

   $this->load->model('checkout/shipment');
   $shipment_data = array();
   $shipments = $this->model_checkout_shipment->getShipments($shipment_data);

   $sub_total = $this->cart->getTotal();

   foreach ($shipments as $shipment) {
    $shipment_cost = $this->getShipmentCostByRate($shipment['rates'], $sub_total);
    // 140606 ET-140606 Begin
    //$output .= '<option value="'.$shipment['shipment_id'].'"'.($shipment_id == $shipment['shipment_id'] ? ' selected="selected"' :'').'>';
    $output .= '<option value="'.$shipment['shipment_id'].'"'.($shipment_id == $shipment['shipment_id'] ? ' selected="selected"' :'').' door_delivery="'.$shipment['door_delivery'].'" cash_on_delivery="'.$shipment['cash_on_delivery'].'">';
    // 140606 ET-140606 End
    $output .= $shipment['name'];
    $output .= ' ('.$this->currency->format($shipment_cost).')';
    $output .= '</option>';
   }
  }
  $this->response->setOutput($output, $this->config->get('config_compression'));
 }
// 140323 ET-140323 End
// 140606 ET-140606 Begin
  public function update_shipment_detail() {
  if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   if(isset($this->request->get['shipment_detail_id'])) {
    $this->session->data['shipment_detail_id'] = $this->request->get['shipment_detail_id'];
   } else {
    $this->session->data['shipment_detail_id'] = 0;
   }
  }
 }
 public function update_shipment_detail_combo() {
  $output = '';

  if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   if(isset($this->session->data['shipment_id'])) {
    $shipment_id = $this->session->data['shipment_id'];
   } else {
    $shipment_id = 0;
   }
   $this->load->model('checkout/shipment');
   $shipment_details = $this->model_checkout_shipment->getShipmentDetails($shipment_id);

   if(isset($this->session->data['shipment_detail_id'])) {
    $shipment_detail_id = $this->session->data['shipment_detail_id'];
    if ($this->session->data['shipment_detail_id'] === 0 && count($shipment_details) > 0) {
     $default_shipment_detail = $this->model_checkout_shipment->getDefaultShipmentDetail($shipment_id);
     $shipment_detail_id = $default_shipment_detail['shipment_detail_id'];
    }
   } else {
    $shipment_detail_id = 0;
   }

   foreach ($shipment_details as $shipment_detail) {
    $output .= '<option value="'.$shipment_detail['shipment_detail_id'].'"'.($shipment_detail_id == $shipment_detail['shipment_detail_id'] ? ' selected="selected"' :'').'>';
    $output .= ($shipment_detail['region'].', '.$shipment_detail['city'].': '.$shipment_detail['address'].($shipment_detail['phone'] ? ', '.$shipment_detail['phone'] : ''));
    $output .= '</option>';
   }
  }
  $this->response->setOutput($output, $this->config->get('config_compression'));
 }
// 140606 ET-140606 End
}

?>

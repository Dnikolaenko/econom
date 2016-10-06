<?php
final class Cart {
 public function __construct() {
  $this->config = Registry::get('config');
  $this->customer = Registry::get('customer');
  $this->session = Registry::get('session');
  $this->db = Registry::get('db');
  $this->language = Registry::get('language');
  $this->tax = Registry::get('tax');
  $this->weight = Registry::get('weight');

  if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
        $this->session->data['cart'] = array();
     }
 }
       
 public function getProducts() {
  $product_data = array();
  
     foreach ($this->session->data['cart'] as $key => $value) {
        $array = explode(':', $key);
        $product_id = $array[0];

        $quantity = $value[0];
        $sborka = count($value) > 1 ? $value[1] : 0;

        $stock = TRUE;

        if (isset($array[1])) {
          $options = explode('.', $array[1]);
        } else {
          $options = array();
        } 
  
        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->language->getId() . "' AND p.date_available <= NOW() AND p.status = '1'");
          
   if ($product_query->num_rows) {
    $option_price = 0;

    $option_data = array();
      
    foreach ($options as $product_option_value_id) {
       $option_value_query = $this->db->query("SELECT pov.product_option_id, povd.name, pov.price, pov.quantity, pov.subtract, pov.prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product_option_value_description povd ON (pov.product_option_value_id = povd.product_option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_id = '" . (int)$product_id . "' AND povd.language_id = '" . (int)$this->language->getId() . "' ORDER BY pov.sort_order");
     
     if ($option_value_query->num_rows) {
      $option_query = $this->db->query("SELECT pod.name FROM " . DB_PREFIX . "product_option po LEFT JOIN " . DB_PREFIX . "product_option_description pod ON (po.product_option_id = pod.product_option_id) WHERE po.product_option_id = '" . (int)$option_value_query->row['product_option_id'] . "' AND po.product_id = '" . (int)$product_id . "' AND pod.language_id = '" . (int)$this->language->getId() . "' ORDER BY po.sort_order");
      
       if ($option_value_query->row['prefix'] == '+') {
          $option_price = $option_price + $option_value_query->row['price'];
       } elseif ($option_value_query->row['prefix'] == '-') {
          $option_price = $option_price - $option_value_query->row['price'];
       }

       $option_data[] = array(
          'product_option_value_id' => $product_option_value_id,
          'name'                    => $option_query->row['name'],
          'value'                   => $option_value_query->row['name'],
          'prefix'                  => $option_value_query->row['prefix'],
          'price'                   => $option_value_query->row['price']
       );
      
      if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
       $stock = FALSE;
      }
     }
    } 
   
    if ($this->customer->isLogged()) {
     $customer_group_id = $this->customer->getCustomerGroupId();
    } else {
     $customer_group_id = $this->config->get('config_customer_group_id');
    }

    $perecenka = $product_query->row['nds'];
    $akcia = $product_query->row['power'];

    if ($perecenka == 1) {
      $on = TRUE;
    } 
    else if ($perecenka == 0) {
      $on = FALSE;
    }
    if ($akcia == 1) {
        $power = TRUE;
    }
    else if ($akcia == 0) {
        $power = FALSE;
    }
       //var_dump($product_query->row['special']);
    
    //$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
    
//    if ($product_discount_query->num_rows) {
//      $price = $product_discount_query->row['price'];
//        var_dump($price);
//    } else {
      if ($power == TRUE) {
          if ($on == TRUE) {
              //$nds = $product_query->row['price'] * 0.2;
              $price_nds = $product_query->row['special'];

              $price = $price_nds;

              //  $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

              //  if ($product_special_query->num_rows) {
              //  $price = $product_special_query->row['price'];
              //  } else {
              //  $price = $product_query->row['price'];
              // }
          } else if ($on == FALSE) {
              $price = $product_query->row['special'];
          }
      }
      else if ($power == FALSE) {
          if ($on == TRUE) {
              //$nds = $product_query->row['price'] * 0.2;
              $price_nds = $product_query->row['price'];

              $price = $price_nds;

              //  $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

              //  if ($product_special_query->num_rows) {
              //  $price = $product_special_query->row['price'];
              //  } else {
              //  $price = $product_query->row['price'];
              // }
          } else if ($on == FALSE) {
              $price = $product_query->row['price'];
          }
      }
//    }
//      $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
//
//      if ($product_special_query->num_rows) {
//        if ($on == TRUE){
//      //$nds = $product_special_query->row['price']*0.2;
//      $price_nds = $product_special_query->row['price'];
//      $price = $price_nds;
//      } else if ($on == FALSE) {
//        $price = $product_special_query->row['price'];
//      }
//    }

    
    $download_data = array();       
    
    $download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "' AND dd.language_id = '" . (int)$this->language->getId() . "'");
   
    foreach ($download_query->rows as $download) {
      $download_data[] = array(
         'download_id' => $download['download_id'],
         'name'        => $download['name'],
         'filename'    => $download['filename'],
         'mask'        => $download['mask'],
         'remaining'   => $download['remaining']
        );
    }
    
    if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
     $stock = FALSE;
    }
    
    $credit_id = $product_query->row['credit_id'];
    
    if ($credit_id > 0) {

     $credit_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE c.credit_id = '" . (int)$credit_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "'");

     $credit_id = ($credit_query->row['status'] ? $credit_id : 0);

     $credit_name = $credit_query->row['name'];
    } else {
     $credit_name = '';
    }

                $product_data[$key] = array(
                    'key'             => $key,
                    'product_id'      => $product_query->row['product_id'],
                    'name'            => $product_query->row['name'],
                    'model'           => $product_query->row['model'],
                    'shipping'        => $product_query->row['shipping'],
                    'image'           => $product_query->row['image'],
                    'option'          => $option_data,
                    'download'        => $download_data,
                    'quantity'        => $quantity,
                    'stock'           => $stock,
                    // (+) ALNAUA 091114 (START)
                    //'price'           => ($price + $option_price),
                    //'total'           => ($price + $option_price) * $quantity,
                    // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                    //'price'           => ($price + $option_price + ($sborka == 1 ? $product_query->row['sborka'] : 0)),
                    //'total'           => ($price + $option_price + ($sborka == 1 ? $product_query->row['sborka'] : 0)) * $quantity,
                    'price'           => ($price + $option_price),
                    'total'           => ($price + $option_price) * $quantity,
                    // 100218 ALNAUA New building mechanism in order, mail and invoice End
                    // (+) ALNAUA 091114 (FINISH)
                    'tax_class_id'    => $product_query->row['tax_class_id'],
                    'weight'          => $product_query->row['weight'],
                    'weight_class_id' => $product_query->row['weight_class_id'],
                    'length'          => $product_query->row['length'],
                    'width'           => $product_query->row['width'],
                    'height'          => $product_query->row['height'],
                    'nds'             => $product_query->row['nds'],
                    'measurement_id'  => $product_query->row['measurement_class_id']
                    // (+) ALNAUA 091114 (START)
                    , 'sborka'           => $sborka
                    // (+) ALNAUA 091114 (FINISH)
                    // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                    , 'sborka_cost'      => $product_query->row['sborka']
                    // 100218 ALNAUA New building mechanism in order, mail and invoice End
                    // 100223 ALNAUA Site redesign Begin
                    , 'serial_no'        => $product_query->row['serial_no']
                    // 100223 ALNAUA Site redesign End
                    // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
                    , 'prepayment'       => $product_query->row['prepayment']
                    , 'use_in_order_discount' => $product_query->row['use_in_order_discount']
                    // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
                    // 20120204 ALNAUA ET-111227 Begin
                    , 'credit_id'       => $credit_id
                    , 'credit_name'     => $credit_name
                    // 20120204 ALNAUA ET-111227 End
                    // ET-150223 Begin
                    , 'min_order_qty' => $product_query->row['min_order_qty']

                    // ET-150223 End
                );
   } else {
    $this->remove($key);
   }
     }
  
  return $product_data;
   }
 
   public function add($product_id, $qty = 1, $options = array()) {
     if (!$options) {
            $key = $product_id;
     } else {
            $key = $product_id . ':' . implode('.', $options);
     }
     
  if ((int)$qty && ((int)$qty > 0)) {
      if (!isset($this->session->data['cart'][$key])) {
         //$this->session->data['cart'][$key] = (int)$qty;
                $this->session->data['cart'][$key] = array((int)$qty, 0);
      } else {
                // (+) ALNAUA 091114 (START)
         //$this->session->data['cart'][$key] += (int)$qty;
                $this->session->data['cart'][$key][0] += (int)$qty;
                // (+) ALNAUA 091114 (FINISH)
      }
  }
   }

   public function update($key, $qty) {
     if ((int)$qty && ((int)$qty > 0)) {
        // (+) ALNAUA 091114 (START)
            //$this->session->data['cart'][$key] += (int)$qty;
            $this->session->data['cart'][$key][0] = (int)$qty;
            // (+) ALNAUA 091114 (FINISH)
     } else {
     $this->remove($key);
  }
   }

    // (+) ALNAUA 091114 (START)
    public function update_sborka($key, $sborka = 'false') {
        $this->session->data['cart'][$key][1] = ($sborka=='true' ? 1 : 0);
   }

    public function check_sborka() {
        foreach ($this->getProducts() as $product) {
            if ($product['nds']==1){
          $this->session->data['cart'][$product['key']][1] = 1;
            }
        }
    }
   
    public function check_sborka_two() {
        foreach ($this->getProducts() as $product) {
            if ($product['nds']==0){
          $this->session->data['cart'][$product['key']][1] = 1;
            }
        }
    }
    // (+) ALNAUA 091114 (FINISH)


   public function remove($key) {
  if (isset($this->session->data['cart'][$key])) {
       unset($this->session->data['cart'][$key]);
    }
 }

   public function clear() {
       //var_dump($this->session->data['cart']);
  $this->session->data['cart'] = array();
   }
   
   public function getWeight() {
  $weight = 0;
 
     foreach ($this->getProducts() as $product) {
        $weight += $this->weight->convert($product['weight'] * $product['quantity'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
     }
 
  return $weight;
 }

   public function getSubTotal() {
  $total = 0;
  
  foreach ($this->getProducts() as $product) {
   // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
            //$total += $product['total'];
            $total += $product['total'] + ($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0);
            //$total += $product['total'];
            // 100218 ALNAUA New building mechanism in order, mail and invoice End

  }

  return $total;
   }
 
 public function getTaxes() {
  $taxes = array();
  
  foreach ($this->getProducts() as $product) {
   if ($product['tax_class_id']) {
    if (!isset($taxes[$product['tax_class_id']])) {
     $taxes[$product['tax_class_id']] = $product['total'] / 100 * $this->tax->getRate($product['tax_class_id']);
    } else {
     $taxes[$product['tax_class_id']] += $product['total'] / 100 * $this->tax->getRate($product['tax_class_id']);
    }
   }
  }
  
  return $taxes;
   }

 // 140606 ET-140606 Begin
  public function getSborka() {
  $sborka = 0;
  foreach ($this->getProducts() as $product) {
      if($product['nds']==1){
   $sborka += $this->tax->calculate(($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0), $product['tax_class_id'], $this->config->get('config_tax'));
      }
  }

  return $sborka;
 }
 
  public function getSborkaTwo() {
  $sborkatwo = 0;
  foreach ($this->getProducts() as $product) {
      if($product['nds']==0){
   $sborkatwo += $this->tax->calculate(($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0), $product['tax_class_id'], $this->config->get('config_tax'));
      }
  }

  return $sborkatwo;
 }
 // 140606 ET-140606 End

 public function getTotal() {
  $total = 0;
  
  foreach ($this->getProducts() as $product) {
   // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
            //$total += $this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'));
            $total += $this->tax->calculate($product['total'] + ($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0), $product['tax_class_id'], $this->config->get('config_tax'));
            //$total += $this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'));
            // 100218 ALNAUA New building mechanism in order, mail and invoice End
            //var_dump($product['total']);
  }

  return $total;
 }

  public function getNdsTotal() {
    $ndstotal = 0;
    foreach ($this->getProducts() as $product) {
      if ($product['nds'] == 1) {
        $ndstotal += $this->tax->calculate($product['total'] + ($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0), $product['tax_class_id'], $this->config->get('config_tax'));
        //var_dump($product['total']);
      }
    }
  return $ndstotal;  
  }
  public function getNoNdsTotal() {
    $totsal = 0;
    foreach ($this->getProducts() as $product) {
      if ($product['nds'] == 0) {
        $totsal += $this->tax->calculate($product['total'] + ($product['sborka'] == 1 ? $product['quantity'] * $product['sborka_cost'] : 0), $product['tax_class_id'], $this->config->get('config_tax'));
      }
    }
    return $totsal;
  }

    public function getOrderDiscount() {
  $total = 0;
        $discount = 0;

        $order_discount = array( array($this->config->get('order_discount_sum1'), $this->config->get('order_discount_percent1')),
                                 array($this->config->get('order_discount_sum2'), $this->config->get('order_discount_percent2')),
                                 array($this->config->get('order_discount_sum3'), $this->config->get('order_discount_percent3')),
                                 array($this->config->get('order_discount_sum4'), $this->config->get('order_discount_percent4')),
                                 array($this->config->get('order_discount_sum5'), $this->config->get('order_discount_percent5'))
                                );

        array_multisort($order_discount, SORT_NUMERIC, $order_discount);

  foreach ($this->getProducts() as $product) {
            if ($product['use_in_order_discount']) {
                $total += $product['total'];
            }
  }

        for ($i = 0; $i < sizeof($order_discount); $i++) {
          if ($total > (float)$order_discount[$i][0]) {
            $discount = (float)$order_discount[$i][1];
          }
        }

//        if ($total > (float)$this->config->get('order_discount_sum1')) {
//          $discount
//        }

  return ($total * ($discount/100));
   }
   
   public function countProducts() {
  $total = 0;
  
  foreach ($this->session->data['cart'] as $value) {
   // (+) ALNAUA 091114 (START)
            //$total += $value;
            $total += $value[0];
            // (+) ALNAUA 091114 (FINISH)
  }
  
     return $total;
   }
   
   public function hasProducts() {
     return count($this->session->data['cart']);
   }
  
   public function hasStock() {
  $stock = TRUE;
  
  foreach ($this->getProducts() as $product) {
   if (!$product['stock']) {
       $stock = FALSE;
   }
  }
  
     return $stock;
   }
  
   public function hasShipping() {
  $shipping = FALSE;
  
  foreach ($this->getProducts() as $product) {
     if ($product['shipping']) {
       $shipping = TRUE;
    
    break;
     }  
  }
  
  return $shipping;
 }
 
   public function hasDownload() {
  $download = FALSE;
  
  foreach ($this->getProducts() as $product) {
     if ($product['download']) {
       $download = TRUE;
    
    break;
     }  
  }
  
  return $download;
 }
 public function getHasDifferentCreditPrograms() {
  $result = FALSE;
  $product_ids = array();
  
  foreach ($this->session->data['cart'] as $key => $value) {
     $array = explode(':', $key);
     $product_ids[] = $array[0];
  }
  
  $product_query = $this->db->query("SELECT COUNT(DISTINCT CASE WHEN c.status THEN p.credit_id ELSE 0 END) cnt from " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "credit c ON (p.credit_id = c.credit_id) WHERE p.product_id IN (" . implode(',', $product_ids) . ") AND p.date_available <= NOW() AND p.status = '1'");
          
   if (isset($product_query->row['cnt']) && $product_query->row['cnt'] > 1) {
    $result = TRUE;
   }
   //echo $product_query->row['cnt'];
   return $result;
 }
 
 public function getCreditIdForOrder() {
  $result = 0;
  
  $product_ids = array();
  
  foreach ($this->session->data['cart'] as $key => $value) {
     $array = explode(':', $key);
     $product_ids[] = $array[0];
  }
  
  $product_query = $this->db->query("SELECT DISTINCT CASE WHEN c.status THEN p.credit_id ELSE 0 END credit_id from " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "credit c ON (p.credit_id = c.credit_id) WHERE p.product_id IN (" . implode(',', $product_ids) . ") AND p.date_available <= NOW() AND p.status = '1'");
          
   if (isset($product_query->row['credit_id']) && $product_query->row['credit_id'] > 0) {
    $result = $product_query->row['credit_id'];
   }
   return $result;
 }
 
 public function getShipmentCost($shipment_id, $cart_total) {
  
  $shipment_cost = 0;
  
  if (isset($shipment_id) && isset($cart_total)) {
   $shipment_data = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shipment WHERE shipment_id = '" . (int)$shipment_id . "' AND status = '1'");

   $rates = explode(',', $shipment_data->row['rates']);

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
}
?>
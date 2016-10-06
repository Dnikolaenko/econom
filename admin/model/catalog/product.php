<?php
class ModelCatalogProduct extends Model {
 public function addProduct($data) {
  // (+) ALNAUA 091114 (START)
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_added = NOW()");
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_added = NOW()");
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_added = NOW()");
  // 100128 ALNAUA Product Banner Flag Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_added = NOW()");
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', date_added = NOW()");
  // 100223 ALNAUA Site redesign Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
  // 100426 Prepayment Invoice Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', date_added = NOW()");
  // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', date_added = NOW()");
  // 101115 Add icon layers to products images Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', date_added = NOW()");
  // 20120204 ALNAUA ET-111227 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', date_added = NOW()");
  // 20120424  ALNAUA ET-120419 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', date_added = NOW()");
  // 130829 ET-130808 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_added = NOW()");
  // 130829 ET-130815 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_added = NOW()");
  // ET-150223 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', is_5_days_delivery = '" . (int)$data['is_5_days_delivery'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_added = NOW()");
  $this->db->query("INSERT INTO " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', special = '" . (float)$data['special']. "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', nds = '" . $data['nds'] ."', power = '" .$data['power']. "' , tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', is_5_days_delivery = '" . (int)$data['is_5_days_delivery'] . "', min_order_qty = '" . (int)$data['min_order_qty'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_added = NOW()");
  // ET-150223 End
  // 130829 ET-130815 End
  // 130829 ET-130808 End
  // 20120424  ALNAUA ET-120419 End
  // 20120204 ALNAUA ET-111227 End
  // 101115 Add icon layers to products images End
  // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
  // 100426 Prepayment Invoice End
  // 100223 ALNAUA Site redesign End
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  // 100128 ALNAUA Product Banner Flag End
  // (+) ALNAUA 091114 (FINISH)
  
  $product_id = $this->db->getLastId();
  
  if (isset($data['image'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
  }
  
  foreach ($data['product_description'] as $language_id => $value) {
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
   // (-/+) ALNAUA 100112 Tags (START)
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "'");
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 100223 ALNAUA Site redesign Begin
   $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "', advanced_description = '" . $this->db->escape($value['advanced_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 100223 ALNAUA Site redesign End
   // (-/+) ALNAUA 100112 Tags (FINISH)
  }
  
  if (isset($data['product_option'])) {
   foreach ($data['product_option'] as $product_option) {
    // 100223 ALNAUA Site redesign Begin
    //$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', sort_order = '" . (int)$product_option['sort_order'] . "'");
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', color_option = '" . (int)$product_option['color_option'] . "', sort_order = '" . (int)$product_option['sort_order'] . "'");
    // 100223 ALNAUA Site redesign End
    
    $product_option_id = $this->db->getLastId();
    
    foreach ($product_option['language'] as $language_id => $language) {
     $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_description SET product_option_id = '" . (int)$product_option_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
    }    
    
    if (isset($product_option['product_option_value'])) {
     foreach ($product_option['product_option_value'] as $product_option_value) {
      // 100223 ALNAUA Site redesign Begin
      //$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "'");
      $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', color_id = '" . (int)$product_option_value['color_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "'");
      // 100223 ALNAUA Site redesign End
    
      $product_option_value_id = $this->db->getLastId();
    
      foreach ($product_option_value['language'] as $language_id => $language) {
        // 100713 ALNAUA Color Description fix Begin
        if ($product_option['color_option']) {
            $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '" . (int)$language_id . "'");

            if (count($query->rows)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "'");
            } else {
                $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '2'");

                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "'");
            }
        } else {
        // 100713 ALNAUA Color Description fix End
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
        // 100713 ALNAUA Color Description fix Begin
        }
        // 100713 ALNAUA Color Description fix End
      } 
     }
    }
   }
  }
  
  if (isset($data['product_discount'])) {
   foreach ($data['product_discount'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', quantity = '" . (int)$value['quantity'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
   }
  }

  if (isset($data['product_special'])) {
   foreach ($data['product_special'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
   }
  }
  
  if (isset($data['product_image'])) {
   foreach ($data['product_image'] as $image) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($image) . "'");
   }
  }
  
  if (isset($data['product_download'])) {
   foreach ($data['product_download'] as $download_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
   }
  }
  
  if (isset($data['product_category'])) {
   foreach ($data['product_category'] as $category_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
   }
  }
  
  if (isset($data['product_related'])) {
   foreach ($data['product_related'] as $related_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
   }
  }

  // (+) ALNAUA 091114 (START)
  if (isset($data['product_techparam'])) {
   foreach ($data['product_techparam'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_techparam_value SET product_id = '" . (int)$product_id . "', techparam_id = '" . (int)$value['techparam_id'] . "', measurement_class_id = '" . (int)$value['measurement_class_id'] . "', value = '" . $this->db->escape($value['value']) . "'");
   }
  }
  // (+) ALNAUA 091114 (FINISH)
  
  // 130415 ET-130411 Begin
  if (isset($data['product_video'])) {
   foreach ($data['product_video'] as $video_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_video SET product_id = '" . (int)$product_id . "', video_id = '" . (int)$video_id . "'");
   }
  }
  // 130415 ET-130411 End

  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }
  // ET-150725 Begin
     /*$this->db->query("UPDATE " . DB_PREFIX . "product p
                           JOIN " . DB_PREFIX . "product_installation_v piv
                             ON p.product_id = piv.product_id
                       SET p.sborka = piv.new_sborka
                     WHERE p.sborka != piv.new_sborka
                       AND p.product_id = '" . (int)$product_id . "'");*/
     if((float)$data['sborka'] != 0.0) {
         $this->db->query("UPDATE " . DB_PREFIX . "product p
                         JOIN " . DB_PREFIX . "product_installation_v piv
                           ON p.product_id = piv.product_id
                       SET p.sborka = piv.new_sborka
                     WHERE p.sborka != piv.new_sborka
                       AND p.product_id = '" . (int)$product_id . "'");
     }
  // ET-150725 End
  
  $this->cache->delete('product');
 }
 
 public function editProduct($product_id, $data) {
  // (+) ALNAUA 091114 (START)
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 100128 ALNAUA Product Banner Flag Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 100223 ALNAUA Site redesign Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 100426 Prepayment Invoice Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 101115 Add icon layers to products images Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 20120204 ALNAUA ET-111227 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 20120424  ALNAUA ET-120419 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 130829 ET-130808 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // 130829 ET-130815 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // ET-150223 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', is_5_days_delivery = '" . (int)$data['is_5_days_delivery'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  //var_dump($data);
  $this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', special = '" .(float)$data['special']. "', sborka = '" . (float)$data['sborka'] . "', status = '" . (int)$data['status'] . "', nds = '" . $data['nds'] . "' , power = '" .$data['power']. "' , tax_class_id = '" . (int)$data['tax_class_id'] . "', random_display = '" . (int)$data['random_display'] . "', sort_order = '" . (int)$data['sort_order'] . "', serial_no = '" . $this->db->escape($data['serial_no']) . "', prepayment = '" . (float)$data['prepayment'] . "', use_in_order_discount = '" . (int)$data['use_in_order_discount'] . "', is_24_hour_delivery = '" . (int)$data['is_24_hour_delivery'] . "', is_new_item = '" . (int)$data['is_new_item'] . "', credit_id = '" . (int)$data['credit_id'] . "', show_min_price_warranty = '" . (int)$data['show_min_price_warranty'] . "', is_5_days_delivery = '" . (int)$data['is_5_days_delivery'] . "', min_order_qty = '" . (int)$data['min_order_qty'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
  // ET-150223 End
  // 130829 ET-130815 End
  // 130829 ET-130808 End
  // 20120424  ALNAUA ET-120419 End
  // 20120204 ALNAUA ET-111227 End
  // 101115 Add icon layers to products images End
  // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
  // 100426 Prepayment Invoice End
  // 100223 ALNAUA Site redesign End
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  // 100128 ALNAUA Product Banner Flag End
  // (+) ALNAUA 091114 (FINISH)

  if (isset($data['image'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($data['product_description'] as $language_id => $value) {
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
   // (-/+) ALNAUA 100112 Tags (START)
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "'");
   //$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 100223 ALNAUA Site redesign Begin
   $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', model = '" . $this->db->escape($value['model']) . "', description = '" . $this->db->escape($value['description']) . "', advanced_description = '" . $this->db->escape($value['advanced_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 100223 ALNAUA Site redesign End
   // (-/+) ALNAUA 100112 Tags (FINISH)
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_description WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_option'])) {
   foreach ($data['product_option'] as $product_option) {
    // 100223 ALNAUA Site redesign Begin
    //$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', sort_order = '" . (int)$product_option['sort_order'] . "'");
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', color_option = '" . (int)$product_option['color_option'] . "', sort_order = '" . (int)$product_option['sort_order'] . "'");
    // 100223 ALNAUA Site redesign End
    
    $product_option_id = $this->db->getLastId();
    
    foreach ($product_option['language'] as $language_id => $language) {
     $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_description SET product_option_id = '" . (int)$product_option_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
    }    
    
    if (isset($product_option['product_option_value'])) {
     foreach ($product_option['product_option_value'] as $product_option_value) {
      // 100223 ALNAUA Site redesign Begin
      //$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', color_id = '" . (int)$product_option_value['color_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "'");
                        // 100223 ALNAUA Site redesign End
    
      $product_option_value_id = $this->db->getLastId();
    
      foreach ($product_option_value['language'] as $language_id => $language) {
       // 100713 ALNAUA Color Description fix Begin
       if ($product_option['color_option']) {
           $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '" . (int)$language_id . "'");

           if (count($query->rows)) {
               $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "'");
           } else {
               $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '2'");

               $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "'");
           }
       } else {
       // 100713 ALNAUA Color Description fix End
         $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
       // 100713 ALNAUA Color Description fix Begin
       }
       // 100713 ALNAUA Color Description fix End
      }     
     }
    }
   }
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

  if (isset($data['product_discount'])) {
   foreach ($data['product_discount'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', quantity = '" . (int)$value['quantity'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
   }
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_special'])) {
   foreach ($data['product_special'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
   }
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_image'])) {
   foreach ($data['product_image'] as $image) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($image) . "'");
   }
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_download'])) {
   foreach ($data['product_download'] as $download_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
   }
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_category'])) {
   foreach ($data['product_category'] as $category_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
   }  
  }

  $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

  if (isset($data['product_related'])) {
   foreach ($data['product_related'] as $related_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
   }
  }

  // (+) ALNAUA 091114 (START)
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_techparam_value WHERE product_id = '" . (int)$product_id . "'");

  if (isset($data['product_techparam'])) {
   foreach ($data['product_techparam'] as $value) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_techparam_value SET product_id = '" . (int)$product_id . "', techparam_id = '" . (int)$value['techparam_id'] . "', measurement_class_id = '" . (int)$value['measurement_class_id'] . "', value = '" . $this->db->escape($value['value']). "'");
   }
  }
  // (+) ALNAUA 091114 (FINISH)
  
  // 130415 ET-130411 Begin
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_video WHERE product_id = '" . (int)$product_id . "'");
  
  if (isset($data['product_video'])) {
   foreach ($data['product_video'] as $video_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_video SET product_id = '" . (int)$product_id . "', video_id = '" . (int)$video_id . "'");
   }
  }
  // 130415 ET-130411 End
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
  
  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }

     // ET-150725 Begin
     /*$this->db->query("UPDATE " . DB_PREFIX . "product p
                           JOIN " . DB_PREFIX . "product_installation_v piv
                             ON p.product_id = piv.product_id
                       SET p.sborka = piv.new_sborka
                     WHERE p.sborka != piv.new_sborka
                       AND p.product_id = '" . (int)$product_id . "'");*/
     // if((float)$data['sborka'] != 0.0) {
     //     $this->db->query("UPDATE " . DB_PREFIX . "product p
     //                         JOIN " . DB_PREFIX . "product_installation_v piv
     //                           ON p.product_id = piv.product_id
     //                   SET p.sborka = piv.new_sborka
     //                 WHERE p.sborka != piv.new_sborka
     //                   AND p.product_id = '" . (int)$product_id . "'");
     // }
     // ET-150725 End
  
  $this->cache->delete('product');

  // 101115 Add icon layers to products images Begin
  $product = $this->getProduct($product_id);
  //

  foreach (glob(DIR_IMAGE . 'cache/' . substr($product['image'], 0, strrpos($product['image'], '.')) . '*.png') as $filename) {
        //foreach (glob(DIR_IMAGE . 'cache/*') as $filename) {
          //echo "$filename: " . $filename . "\n";
          //if (strrpos($filename, '.')) {
          @unlink($filename);
          //}
        }
        //exit;
        // 101115 Add icon layers to products images End

 }

 public function deleteProduct($product_id) {
        // (+) ALNAUA 091114 (START)
// Commented because duplicate function added.
//        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
//        foreach ($query->rows as $result) {
//            if (file_exists(DIR_IMAGE . $result['image'])) {
//             @unlink(DIR_IMAGE . $result['image']);
//            }
//  }
//        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
//        foreach ($query->rows as $result) {
//            if (file_exists(DIR_IMAGE . $result['image'])) {
//              @unlink(DIR_IMAGE . $result['image']);
//            }
//  }
        // (+) ALNAUA 091114 (FINISH)
  $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_description WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
  // (+) ALNAUA 091114 (START)
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_color WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_techparam_value WHERE product_id = '" . (int)$product_id . "'");
  // (+) ALNAUA 091114 (FINISH)
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
  
  $this->cache->delete('product');
 }
 
 public function getProduct($product_id) {
  $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->language->getId() . "'");
    
  return $query->row;
 }
 
 public function getProducts($data = array()) {
  if ($data) {
            // 101030 ALNAUA Add Category Filter To Product List Begin
   //$sql = "SELECT *, (SELECT c.sort_order FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = ptc.category_id) WHERE ptc.product_id = p.product_id LIMIT 0 , 1) as category_sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "'";
            $sql = "SELECT p.*, pd.*, c.category_id, c.sort_order as category_sort_order, (SELECT pc.sort_order FROM category pc WHERE pc.category_id = c.parent_id) as parent_category_sort_order
                    FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                                    LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON (ptc.product_id = p.product_id)
                                                    LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = ptc.category_id)
                    WHERE pd.language_id = '" . (int)$this->language->getId() . "'";
            // 101030 ALNAUA Add Category Filter To Product List End
  
   if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
    $sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
   }

   if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
    $sql .= " AND pd.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
   }
   
   if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
    $sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
   }
   
   if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
    $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
   }

   if (isset($data['filter_nds']) && !is_null($data['filter_nds'])) {
    $sql .= " AND p.nds = '" . (int)$data['filter_nds'] . "'";
   }

            // 101030 ALNAUA Add Category Filter To Product List Begin
            if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
    $sql .= " AND c.category_id = '" . (int)$data['filter_category'] . "'";
   }
            // 101030 ALNAUA Add Category Filter To Product List End

   $sort_data = array(
    'pd.name',
    'pd.model',
    'p.quantity',
    'p.status',
    'p.nds',
    'p.sort_order'
   ); 
   
   if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
    $sql .= " ORDER BY " . $data['sort']; 
   } else {
                // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
    //$sql .= " ORDER BY pd.name";
                $sql .= " ORDER BY parent_category_sort_order, category_sort_order, p.sort_order, pd.name";
                // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
   }
   
   if (isset($data['order']) && ($data['order'] == 'DESC')) {
    $sql .= " DESC";
   } else {
    $sql .= " ASC";
   }
  
   if (isset($data['start']) || isset($data['limit'])) {
    if ($data['start'] < 0) {
     $data['start'] = 0;
    }    

    if ($data['limit'] < 1) {
     $data['limit'] = 30;
    } 
   
    $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
   } 
   
   $query = $this->db->query($sql);
  
   return $query->rows;
  } else {
   $product_data = $this->cache->get('product.' . $this->language->getId());

   if (!$product_data) {
                // 101030 ALNAUA Add Category Filter To Product List Begin
    $query = $this->db->query("SELECT *, (SELECT c.sort_order FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = ptc.category_id) WHERE ptc.product_id = p.product_id LIMIT 0 , 1) as category_sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "' ORDER BY category_sort_order, p.sort_order, pd.name ASC");
                //$query = $this->db->query("SELECT p.*, pd.*, c.category_id, c.sort_order as category_sort_order
                //                             FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                //                                                             LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON (ptc.product_id = p.product_id)
                //                                                             LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = ptc.category_id)
                //                             WHERE pd.language_id = '" . (int)$this->language->getId() . "'
                //                             ORDER BY category_sort_order, p.sort_order, pd.name ASC");
                // 101030 ALNAUA Add Category Filter To Product List End
 
    $product_data = $query->rows;
   
    $this->cache->set('product.' . $this->language->getId(), $product_data);
   } 
 
   return $product_data;
  }
 }
 public function getProductsByCategoryId($category_id) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
          
  return $query->rows;
 } 
 
 public function getProductDescriptions($product_id) {
  $product_description_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($query->rows as $result) {
   $product_description_data[$result['language_id']] = array(
    'name'             => $result['name'],
    'meta_description' => $result['meta_description'],
                // (+) ALNAUA 091114 (START)
                'model'            => $result['model'],
                // (+) ALNAUA 091114 (FINISH)
    'description'      => $result['description'],
                // 100223 ALNAUA Site redesign Begin
                'advanced_description'      => $result['advanced_description'],
                // 100223 ALNAUA Site redesign End
                // (+) ALNAUA 100112 Tags (START)
                'page_title' => $result['page_title'],
                'meta_keywords' => $result['meta_keywords']
                // (+) ALNAUA 100112 Tags (FINISH)
   );
  }
  
  return $product_description_data;
 }
 
 public function getProductOptions($product_id) {
  $product_option_data = array();
  
  $product_option = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
  
  foreach ($product_option->rows as $product_option) {
   $product_option_value_data = array();

            // 100223 ALNAUA Site redesign Begin
            if ($product_option['color_option']) {
              $product_option_value = $this->db->query("SELECT pov.* FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "color c ON (pov.color_id = c.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY cc.sort_order, pov.sort_order");
            } else {
            // 100223 ALNAUA Site redesign End
              $product_option_value = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");
            // 100223 ALNAUA Site redesign Begin
            }
            // 100223 ALNAUA Site redesign End

   foreach ($product_option_value->rows as $product_option_value) {
    $product_option_value_description_data = array();
    
    $product_option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");

    foreach ($product_option_value_description->rows as $result) {
     $product_option_value_description_data[$result['language_id']] = array('name' => $result['name']);
    }
   
    $product_option_value_data[] = array(
     'product_option_value_id' => $product_option_value['product_option_value_id'],
     'language'                => $product_option_value_description_data,
                    // 100223 ALNAUA Site redesign Begin
                    'color_id'                => $product_option_value['color_id'],
                    // 100223 ALNAUA Site redesign End
            'quantity'                => $product_option_value['quantity'],
     'subtract'                => $product_option_value['subtract'],
     'price'                   => $product_option_value['price'],
            'prefix'                  => $product_option_value['prefix'],
     'sort_order'              => $product_option_value['sort_order']
    );
   }
   
   $product_option_description_data = array();
   
   $product_option_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

   foreach ($product_option_description->rows as $result) {
    $product_option_description_data[$result['language_id']] = array('name' => $result['name']);
   }
  
         $product_option_data[] = array(
          'product_option_id'    => $product_option['product_option_id'],
    'language'             => $product_option_description_data,
    'product_option_value' => $product_option_value_data,
                // 100223 ALNAUA Site redesign Begin
                'color_option'         => $product_option['color_option'],
                // 100223 ALNAUA Site redesign End
    'sort_order'           => $product_option['sort_order']
         );
       } 
  
  return $product_option_data;
 }
 
 public function getProductImages($product_id) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
  
  return $query->rows;
 }
 
 public function getProductDiscounts($product_id) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
  
  return $query->rows;
 }
 
 public function getProductSpecials($product_id) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
  
  return $query->rows;
 }
 
 public function getProductDownloads($product_id) {
  $product_download_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($query->rows as $result) {
   $product_download_data[] = $result['download_id'];
  }
  
  return $product_download_data;
 }

 public function getProductCategories($product_id) {
  $product_category_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($query->rows as $result) {
   $product_category_data[] = $result['category_id'];
  }

  return $product_category_data;
 }

 public function getProductRelated($product_id) {
  $product_related_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($query->rows as $result) {
   $product_related_data[] = $result['related_id'];
  }
  
  return $product_related_data;
 }

    // (+) ALNAUA 091114 (START)
 public function getProductTechParams($product_id) {
  $product_techparam_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_techparam_value ptv LEFT JOIN " . DB_PREFIX . "techparam t ON (ptv.techparam_id = t.techparam_id)  WHERE ptv.product_id = '" . (int)$product_id . "' ORDER BY t.sort_order");

        return $query->rows;
 }
    // (+) ALNAUA 091114 (FINISH)
 
 public function getTotalProducts($data = array()) {
  // 101030 ALNAUA Add Category Filter To Product List Begin
        //$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->language->getId() . "'";
        $sql = "SELECT COUNT(*) AS total
                FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                                LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON (ptc.product_id = p.product_id)
                                                LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = ptc.category_id)
                WHERE pd.language_id = '" . (int)$this->language->getId() . "'";
  
  if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
   $sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
  }

  if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
   $sql .= " AND pd.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
  }
  
  if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
   $sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
  }
  
  if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
   $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
   $sql .= " AND c.category_id = '" . (int)$data['filter_category'] . "'";
  }
        // 101030 ALNAUA Add Category Filter To Product List End

  $query = $this->db->query($sql);
  
  return $query->row['total'];
 } 
 
 public function getTotalProductsByStockStatusId($stock_status_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

  return $query->row['total'];
 }
 
 public function getTotalProductsByImageId($image_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE image_id = '" . (int)$image_id . "'");

  return $query->row['total'];
 }
 
 public function getTotalProductsByTaxClassId($tax_class_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

  return $query->row['total'];
 }
 
 public function getTotalProductsByWeightClassId($weight_class_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

  return $query->row['total'];
 }
 
 public function getTotalProductsByMeasurementClassId($measurement_class_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE measurement_class_id = '" . (int)$measurement_class_id . "'");

  return $query->row['total'];
 }
 
 public function getTotalProductsByOptionId($option_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_option WHERE option_id = '" . (int)$option_id . "'");

  return $query->row['total'];
 }

 public function getTotalProductsByDownloadId($download_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
  
  return $query->row['total'];
 }
 
 public function getTotalProductsByManufacturerId($manufacturer_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

  return $query->row['total'];
 }
 
 // 20120204 ALNAUA ET-111227 Begin
 public function getTotalProductsByCreditId($credit_id) {
      $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE credit_id = '" . (int)$credit_id . "'");

  return $query->row['total'];
 }
 // 20120204 ALNAUA ET-111227 End

    // 100713 ALNAUA Color Description fix Begin
    public function updAllProdColorOptValDesc() {
       $products = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product ORDER BY product_id");

        foreach ($products->rows as $product) {
   $product_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product['product_id'] . "' ORDER BY sort_order");

            foreach ($product_options->rows as $product_option) {
                if ($product_option['color_option']) {
                    $product_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");

                    foreach ($product_option_values->rows as $product_option_value) {

                      $product_option_value_descriptions = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");

                      foreach ($product_option_value_descriptions->rows as $product_option_value_description) {
                          $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '" . (int)$product_option_value_description['language_id'] . "'");

                          if (count($query->rows)) {
                              $this->db->query("UPDATE " . DB_PREFIX . "product_option_value_description SET name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "' WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND language_id = '" . (int)$product_option_value_description['language_id'] . "' AND product_id = '" . (int)$product['product_id'] . "'");
                          } else {
                              $query = $this->db->query("SELECT DISTINCT cd.name, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$product_option_value['color_id'] ."' AND cd.language_id = '2'");

                              $this->db->query("UPDATE " . DB_PREFIX . "product_option_value_description SET name = '" . $this->db->escape(($query->row['category_name'] != '' ? $query->row['category_name']. ' -> ' : '') . $query->row['name']) . "' WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND language_id = '" . (int)$product_option_value_description['language_id'] . "' AND product_id = '" . (int)$product['product_id'] . "'");
                          }
                      }

                    }
                }
            }
  }
 }
 // 100713 ALNAUA Color Description fix End
 
 // 130415 ET-130411 Begin
 public function getProductVideos($product_id) {
  $product_video_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_video WHERE product_id = '" . (int)$product_id . "'");
  
  foreach ($query->rows as $result) {
   $product_video_data[] = $result['video_id'];
  }

  return $product_video_data;
 }
  // 130415 ET-130411 End
}
?>
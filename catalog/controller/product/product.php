<?php
class ControllerProductProduct extends Controller {
 private $error = array();

 public function index() {
  $this->language->load('product/product');

  // (+) ALNAUA 091114 (START)
  $this->document->active = '';
  // (+) ALNAUA 091114 (FINISH)

  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
    'href'      => $this->url->http('common/home'),
    'text'      => $this->language->get('text_home'),
    'separator' => FALSE
  );

  $this->load->model('tool/seo_url');

  $this->load->model('catalog/category');

  if (isset($this->request->get['path'])) {
   $path = '';

   foreach (explode('_', $this->request->get['path']) as $path_id) {
    $category_info = $this->model_catalog_category->getCategory($path_id);

    if (!$path) {
     $path = $path_id;
    } else {
     $path .= '_' . $path_id;
    }

    if ($category_info) {
      $this->document->breadcrumbs[] = array(
          'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $path)),
          'text'      => $category_info['name'],
          'separator' => $this->language->get('text_separator')
      );
    }
    }
   }

  $this->load->model('catalog/manufacturer');

  if (isset($this->request->get['manufacturer_id'])) {
   $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

   if ($manufacturer_info) {
    $this->document->breadcrumbs[] = array(
      'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $this->request->get['manufacturer_id'])),
      'text'      => $manufacturer_info['name'],
      'separator' => $this->language->get('text_separator')
    );
   }
  }

  if (isset($this->request->get['keyword'])) {
   $url = '';

   if (isset($this->request->get['description'])) {
    $url .= '&description=' . $this->request->get['description'];
   }

   $this->document->breadcrumbs[] = array(
     'href'      => $this->url->http('product/search&keyword=' . $this->request->get['keyword'] . $url),
     'text'      => $this->language->get('text_search'),
     'separator' => $this->language->get('text_separator')
   );
  }

  $this->load->model('catalog/product');

  if (isset($this->request->get['product_id'])) {
   $product_id = $this->request->get['product_id'];
  } else {
   $product_id = 0;
  }

  $product_info = $this->model_catalog_product->getProduct($product_id);
  //var_dump($product_info);

  if ($product_info) {
   $url = '';

   if (isset($this->request->get['path'])) {
    $url .= '&path=' . $this->request->get['path'];
   }

   if (isset($this->request->get['manufacturer_id'])) {
    $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
   }

   if (isset($this->request->get['keyword'])) {
    $url .= '&keyword=' . $this->request->get['keyword'];
   }

   if (isset($this->request->get['description'])) {
    $url .= '&description=' . $this->request->get['description'];
   }

   $this->document->breadcrumbs[] = array(
     'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/product' . $url . '&product_id=' . $this->request->get['product_id'])),
     'text'      => $product_info['name'],
     'separator' => $this->language->get('text_separator')
   );

   // (-/+) ALNAUA 100112 Tags (START)
   //$this->document->title = $product_info['name'];
   // 1500609 ET-150609 Begin
   //$this->document->title = ($product_info['page_title'] != '' ? $product_info['page_title'] : $product_info['name']);
   $this->document->title = ($product_info['page_title'] != '' ? $product_info['page_title'] : $product_info['name'].$this->language->get('text_page_title_suffix'));
   // 1500609 ET-150609 End
   // (-/+) ALNAUA 100112 Tags (FINISH)

   // 1500609 ET-150609 Begin
   //$this->document->description = $product_info['meta_description'];
   $this->document->description = ($product_info['meta_description'] != '' ? $product_info['meta_description'] : $product_info['name'].$this->language->get('text_meta_description_suffix'));
   // 1500609 ET-150609 End
   // (+) ALNAUA 100112 Tags (START)
   $this->document->keywords = $product_info['meta_keywords'];
   // (+) ALNAUA 100112 Tags (FINISH)

   $this->data['heading_title'] = $product_info['name'];

   $this->data['text_enlarge'] = $this->language->get('text_enlarge');
   $this->data['text_discount'] = $this->language->get('text_discount');
   // (+) ALNAUA 091114 (START)
   $this->data['text_back'] = $this->language->get('text_back');
   $this->data['text_loading'] = $this->language->get('text_loading');
   $this->data['text_sending'] = $this->language->get('text_sending');
   $this->data['text_click_thanks'] = $this->language->get('text_click_thanks');
   $this->data['text_click_bye'] = $this->language->get('text_click_bye');

   $this->data['text_unit_meas'] = $this->language->get('text_unit_meas');
   $this->data['text_related'] = sprintf($this->language->get('text_related'),$product_info['name']);
   $this->data['text_how_to_buy'] = $this->language->get('text_how_to_buy');
   $this->data['text_techparam'] = $this->language->get('text_techparam');
   $this->data['text_color_info'] = $this->language->get('text_color_info');
   // (+) ALNAUA 091114 (FINISH)
   $this->data['text_options'] = $this->language->get('text_options');
   $this->data['text_price'] = $this->language->get('text_price');
   $this->data['text_availability'] = $this->language->get('text_availability');
   $this->data['text_model'] = $this->language->get('text_model');
   $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
   $this->data['text_order_quantity'] = $this->language->get('text_order_quantity');
   $this->data['text_price_per_item'] = $this->language->get('text_price_per_item');
   $this->data['text_qty'] = $this->language->get('text_qty');
   $this->data['text_write'] = $this->language->get('text_write');
   $this->data['text_average'] = $this->language->get('text_average');
   $this->data['text_no_rating'] = $this->language->get('text_no_rating');
   $this->data['text_note'] = $this->language->get('text_note');
   $this->data['text_no_images'] = $this->language->get('text_no_images');
   $this->data['text_no_related'] = $this->language->get('text_no_related');
   $this->data['text_wait'] = $this->language->get('text_wait');
   $this->data['text_one_click'] = $this->language->get('text_one_click');
   // 20120204 ALNAUA ET-111227 Begin
   $this->data['text_credit'] = $this->language->get('text_credit');
   // 20120204 ALNAUA ET-111227 End
   // 130829 ET-130808 Begin
   $this->data['text_min_price_warranty'] = $this->language->get('text_min_price_warranty');
   // 130829 ET-130808 End
   // 140412 ET-140412 Begin
   $this->data['text_special'] = $this->language->get('text_special');
   // 140412 ET-140412 End
   // ET-150223 Begin
   $this->data['text_min_order_qty'] = $this->language->get('text_min_order_qty');
   // ET-150223 End

   $this->data['entry_name'] = $this->language->get('entry_name');
   $this->data['entry_review'] = $this->language->get('entry_review');
   $this->data['entry_rating'] = $this->language->get('entry_rating');
   $this->data['entry_good'] = $this->language->get('entry_good');
   $this->data['entry_bad'] = $this->language->get('entry_bad');
   $this->data['entry_captcha'] = $this->language->get('entry_captcha');


   $this->data['button_continue'] = $this->language->get('button_continue');

   $this->load->model('catalog/review');

   $this->data['tab_description'] = $this->language->get('tab_description');
   $this->data['tab_image'] = $this->language->get('tab_image');
   $this->data['tab_review'] = sprintf($this->language->get('tab_review'), $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']));
   $this->data['tab_related'] = $this->language->get('tab_related');

   $average = $this->model_catalog_review->getAverageRating($this->request->get['product_id']);

   $this->data['text_stars'] = sprintf($this->language->get('text_stars'), $average);
   $this->data['text_latest'] = $this->language->get('text_latest');

   $this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

   $this->data['action'] = $this->url->http('checkout/cart');

   // (+) ALNAUA 091114 (START)
   if (isset($this->request->get['path'])) {
     $this->data['back'] = $this->url->http('product/category&path='.$this->request->get['path']);
   } else {
     $this->data['back'] = 'javascript: history.go(-1)';
   }
   // (+) ALNAUA 091114 (FINISH)

   $this->data['redirect'] = $this->url->http('product/product' . $url . '&product_id=' . $this->request->get['product_id']);
   //var_dump($this->request->get['product_id']);

   if ($this->request->get['product_id'] == 1718 || $this->request->get['product_id'] == 4595 || $this->request->get['product_id'] == 4601){
    $ga = TRUE;
    $this->data['ga'] = $ga;
   }
   else {
    $ga = FALSE;
    $this->data['ga'] = $ga;
   }

   //var_dump($this->request);

   //var_dump($_SERVER);

   $this->load->helper('image');

   if ($product_info['image']) {
    $image = $product_info['image'];
   } else {
    $image = 'no_image.jpg';
   }

   // 101115 Add icon layers to products images Begin
   $resize_options = array('image_name_only' => true);

   $config_icon_24 = ($this->config->get('config_icon_24') && $product_info['is_24_hour_delivery'] ? $this->config->get('config_icon_24') : '');
   $config_icon_new = ($this->config->get('config_icon_new') && $product_info['is_new_item'] ? $this->config->get('config_icon_new') : '');
   // 130829 ET-130815 Begin
   $config_icon_5 = ($this->config->get('config_icon_5') && $product_info['is_5_days_delivery'] ? $this->config->get('config_icon_5') : '');
   // 130829 ET-130815 End

   if ($config_icon_24) {
     $config_icon_24 = image_resize($config_icon_24, $this->config->get('config_icon_24_width'), $this->config->get('config_icon_24_height'), $resize_options);
   }

   if ($config_icon_new) {
     $config_icon_new = image_resize($config_icon_new, $this->config->get('config_icon_new_width'), $this->config->get('config_icon_new_width'), $resize_options);
   }

   // 130829 ET-130815 Begin
   if ($config_icon_5) {
     $config_icon_5 = image_resize($config_icon_5, $this->config->get('config_icon_5_width'), $this->config->get('config_icon_5_height'), $resize_options);
   }
   // 130829 ET-130815 End

   $resize_options = array( 'icon_24'  => array('image'     => $config_icon_24,
                                                'postition' => $this->config->get('config_icon_24_pos'),
                                                'offset'    => array('top'    => $this->config->get('config_icon_24_top_offset'),
                                                                     'right'  => $this->config->get('config_icon_24_right_offset'),
                                                                     'bottom' => $this->config->get('config_icon_24_bottom_offset'),
                                                                     'left'   => $this->config->get('config_icon_24_left_offset'))),
                            'icon_new' => array('image'     => $config_icon_new,
                                                'postition' => $this->config->get('config_icon_new_pos'),
                                                'offset'    => array('top'    => $this->config->get('config_icon_new_top_offset'),
                                                                     'right'  => $this->config->get('config_icon_new_right_offset'),
                                                                     'bottom' => $this->config->get('config_icon_new_bottom_offset'),
                                                                     'left'   => $this->config->get('config_icon_new_left_offset'))),
                            'icon_5'  => array('image'     => $config_icon_5,
                                               'postition' => $this->config->get('config_icon_5_pos'),
                                               'offset'    => array('top'    => $this->config->get('config_icon_5_top_offset'),
                                                                    'right'  => $this->config->get('config_icon_5_right_offset'),
                                                                    'bottom' => $this->config->get('config_icon_5_bottom_offset'),
                                                                    'left'   => $this->config->get('config_icon_5_left_offset')))
                        );
   //$this->data['popup'] = image_resize($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
   //$this->data['thumb'] = image_resize($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
   $this->data['popup'] = image_resize($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
   $this->data['thumb'] = image_resize($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'), $resize_options );
   // 101115 Add icon layers to products images End

   $discount = $this->model_catalog_product->getProductDiscount($this->request->get['product_id']);

   $perecenka = $this->model_catalog_product->getProduct($product_id);

    if ($perecenka["nds"] == 1) {
      $pereshet = TRUE;
    }
    else if ($perecenka["nds"] == 0) {
      $pereshet = FALSE;
    }

   if ($discount) {
    //var_dump($this->data['price']);
    $this->data['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));

    $this->data['special'] = FALSE;
   } else {
    //var_dump($product_info['price']);
    //$obmenka = $product_info['price']*0.2;
    $pererashet = $product_info['price'];
    //var_dump($pererashet);

    if($pereshet == TRUE){
    $this->data['price'] = $this->currency->format($this->tax->calculate($pererashet, $product_info['tax_class_id'], $this->config->get('config_tax')));
    }
    else if ($pereshet == FALSE){
    $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
    }
    $special = $this->model_catalog_product->getProductSpecial($this->request->get['product_id']);
    //var_dump($this->data['price']);

    if ($special) {
    //var_dump($special);
    //$obmenka = $special*0.2;
    //$pererashet = $special+$obmenka;
    //var_dump($pererashet);
     $this->data['special'] = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
    } else {
     $this->data['special'] = FALSE;
    }
   }
   //var_dump($special);
   //var_dump($discount);
   //var_dump($this->data['price']);
   $perecenka = $this->model_catalog_product->getProduct($product_id);

   if ($perecenka["power"] == 1) {
    $akcia = TRUE;
   } else if ($perecenka["power"] == 0) {
    $akcia = FALSE;
   }

   $this->data['akcia'] = $akcia;

   $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

   $this->data['discounts'] = array();

   foreach ($discounts as $discount) {
    $this->data['discounts'][] = array(
     'quantity' => $discount['quantity'],
     'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
    );
   }

   if ($product_info['quantity'] <= 0) {
    $this->data['stock'] = $product_info['stock'];
   } else {
    if ($this->config->get('config_stock_display')) {
     $this->data['stock'] = $product_info['quantity'];
    } else {
     $this->data['stock'] = $this->language->get('text_instock');
    }
   }

   $this->data['model'] = $product_info['model'];
   $this->data['manufacturer'] = $product_info['manufacturer'];
   $this->data['manufacturers'] = $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $product_info['manufacturer_id']));
   $this->data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
   // 100223 ALNAUA Site redesign Begin
   $this->data['advanced_description'] = html_entity_decode($product_info['advanced_description'], ENT_QUOTES, 'UTF-8');
   // 100223 ALNAUA Site redesign End
   $this->data['product_id'] = $this->request->get['product_id'];
   $this->data['average'] = $average;

   $this->data['options'] = array();

   $options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);

   $this->load->model('catalog/color');

   foreach ($options as $option) {
    $option_value_data = array();

    foreach ($option['option_value'] as $option_value) {
     // 100223 ALNAUA Site redesign Begin
     $color_info = array();

     if ($option['color_option']) {
       $color_info = $this->model_catalog_color->getColorAndCategory($option_value['color_id']);
     }
     // 100223 ALNAUA Site redesign End

     $option_value_data[] = array(
       'option_value_id' => $option_value['product_option_value_id'],
       // 100223 ALNAUA Site redesign Begin
       //'name'            => $option_value['name'],
       // 100223 ALNAUA Site redesign End
       'name'            => ($option['color_option'] ? (isset($color_info['category_name']) ? $color_info['category_name'] . ' -> ' . $color_info['name'] : $color_info['name']): $option_value['name']),
       'price'           => (int)$option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : FALSE,
       'prefix'          => $option_value['prefix']
       // 100223 ALNAUA Site redesign Begin
       , 'color_id'        => $option_value['color_id'],
       'color_image'     => ($option['color_option'] ? image_resize($color_info['image'] , 100, 100): ''),
       'color_thumb'     => ($option['color_option'] ? image_resize($color_info['image'] , 25, 25): '')
       // 100223 ALNAUA Site redesign End
       // 100611 ALNAUA Add Color Group Tips Begin
       , 'colorcategory_id' => ($option['color_option'] ? $color_info['colorcategory_id'] : ''),
       'colorcategory_tip'  => ($option['color_option'] ? html_entity_decode($color_info['tip'], ENT_QUOTES, 'UTF-8') : '')
       // 100611 ALNAUA Add Color Group Tips End
     );
    }
    //var_dump($option_value['price']);

    $this->data['options'][] = array(
             'option_id'    => $option['product_option_id'],
             'name'         => $option['name'],
             'option_value' => $option_value_data
             // 100223 ALNAUA Site redesign Begin
             , 'color_option' => $option['color_option']
             // 100223 ALNAUA Site redesign End
    );
   }
   //var_dump($this->data['options']);

   $this->data['images'] = array();

   $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

   foreach ($results as $result) {
     $this->data['images'][] = array(
        'popup' => image_resize($result['image'] , $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
        'thumb' => image_resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
     );
   }
   // (+) ALNAUA 091114 (START)
   // 140412 ET-140412 Begin
   if ($special) {
    $array = explode('.', $this->data['special']);
    //var_dump($array);
   } else {
   // 140412 ET-140412 End
    $array = explode('.', $this->data['price']);
   // 140412 ET-140412 Begin
    //var_dump($array);
   }
   // 140412 ET-140412 End
   $price_int = $array[0];
   $array = explode(' ', $array[1]);
   $price_dec = $array[0];
   $price_curr = $array[1];

   $this->data['price_int'] = $price_int;
    //var_dump($this->data['special']);
    //var_dump($this->data['price_int']);
   // $prices  = $price_int * 0.2;
   $this->data['price_dec'] = $price_dec;
   $this->data['price_curr'] = $price_curr;

   //var_dump($price_int);
   // (+) ALNAUA 091114 (FINISH)

   // 130415 ET-130411 Begin
   $this->data['product_videos'] = array();

   $product_videos = $this->model_catalog_product->getProductVideo($this->request->get['product_id']);

   $this->data['video_icon'] = image_resize('video_icon.png' , $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));

   foreach ($product_videos as $product_video) {
    $this->data['product_videos'][] = array(
        'video_id'   => $product_video['video_id'],
        'name'       => $product_video['name'],
        'video_code' => html_entity_decode($product_video['video_code'], ENT_QUOTES, 'UTF-8')
        );
   }

   // 130415 ET-130411 End

   $this->data['products'] = array();

   $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

   foreach ($results as $result) {
    if ($result['image']) {
     $image = $result['image'];
    } else {
     $image = 'no_image.jpg';
    }

    $rating = $this->model_catalog_review->getAverageRating($result['product_id']);

    $special = FALSE;

    if($result["power"] == 1) {
     $akcia = TRUE;
     $this->data['akcia'] = TRUE;
    } else if ($result["power"] == 0) {
     $akcia = FALSE;
     $this->data['akcia'] = FALSE;
    }

    $discount = $this->model_catalog_product->getProductDiscount($result['product_id']);

    if ($discount) {
     $price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
    } else {
     $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
     }
     $special = $this->model_catalog_product->getProductSpecial($result['product_id']);

     if ($special) {
      $special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
     } else {
      $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
     }

   $this->data['products'][] = array(
     'name'    => $result['name'],
     'model'   => $result['model'],
     'rating'  => $rating,
     'stars'   => sprintf($this->language->get('text_stars'), $rating),
     'thumb'   => image_resize($image, $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height')),
     'price'   => $price,
     'special' => $special,
     'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
    );
   }

   $this->data['bestseller_display_on_home'] = $this->config->get('bestseller_display_on_home');

   if ($this->data['bestseller_display_on_home']) {
    // ET-20150114 Begin
    $random_products = $this->model_catalog_product->getRandomProducts($this->config->get('bestseller_limit'));
    // ET-20150114 End

    foreach ($random_products as $result) {
     if ($result['image']) {
      $image = $result['image'];
     } else {
      $image = 'no_image.jpg';
     }

     $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
     $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));

     $this->data['productss'][] = array(
         'name'    => $result['name'],
         'model'   => $result['model'],
         'thumb'   => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
         'akcia'   => $akcia,
         'price'   => $price,
         'special' => $special,
         'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
     );
    }
   }

   if (!$this->config->get('config_customer_price')) {
    $this->data['display_price'] = TRUE;
   } elseif ($this->customer->isLogged()) {
    $this->data['display_price'] = TRUE;

   } else {
    $this->data['display_price'] = FALSE;
   }

   $this->model_catalog_product->updateViewed($this->request->get['product_id']);

   // (+) ALNAUA 091114 (START)
   $this->data['techparams'] = array();

   $techparams = $this->model_catalog_product->getProductTechParams($this->request->get['product_id']);

        foreach ($techparams as $techparam) {
               $this->data['techparams'][] = array(
                'name'      => $techparam['name'],
                'unit'      => $techparam['unit'],
                'value'     => $techparam['value']
               );
        }
   // (+) ALNAUA 091114 (FINISH)

   // 20120204 ALNAUA ET-111227 Begin
   $credit_id = $product_info['credit_id'];

   if ($credit_id) {

    $this->load->model('catalog/credit');

    $credit_info = $this->model_catalog_credit->getCredit($credit_id);

    $credit_id = ($credit_info['status'] ? $credit_id : 0);

    $this->data['credit_name'] = $credit_info['name'];
    if (isset($credit_info) && $credit_info['image'] && file_exists(DIR_IMAGE . $credit_info['image'])) {
     $this->data['credit_image'] = image_resize($credit_info['image'], 0, 0);
    } else {
     $this->data['credit_image'] = image_resize('no_image.jpg', 50, 50);
    }
    $this->data['credit_href'] = $this->model_tool_seo_url->rewrite($this->url->http('information/credit#credit_id=' . $credit_id));

   }
   $this->data['credit_id'] = $credit_id;
   // 20120204 ALNAUA ET-111227 End

   // 130829 ET-130808 Begin
   $this->data['show_min_price_warranty'] = $product_info['show_min_price_warranty'];
   $this->data['show_min_price_warranty_href'] = $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $this->config->get('config_min_price_warranty_page')));
   $this->load->model('catalog/information');
   $min_price_warranty_info = $this->model_catalog_information->getInformation($this->config->get('config_min_price_warranty_page'));
   if ($min_price_warranty_info) {
     $this->data['show_min_price_warranty_text'] = html_entity_decode($min_price_warranty_info['description'], ENT_QUOTES, 'UTF-8');
   }
   // 130829 ET-130808 End

   // ET-150223 Begin
   $this->data['min_order_qty'] = $product_info['min_order_qty'];
   // ET-150223 End

//   $products = $this->model_catalog_product->getInvalidImageProducts();
//
//   $output = 'Renamed files:<br />';
//
//   foreach ($products as $product) {
//    //$newfilename = str_replace(" ", "_", $product['image']);
//    $newfilename = strtolower(translite($product['image']));
//    rename(DIR_IMAGE . $product['image'], DIR_IMAGE . $newfilename);
//    $this->db->query("UPDATE " . DB_PREFIX . "product p SET p.image = '". $newfilename. "' WHERE p.product_id = '" . (int)$product['product_id'] . "'");
//
//    $output .= $product['product_id']. ' : ' . $product['image'] . " -> " . $newfilename . "<br />";
//   }
//   echo $output;

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/product/product.tpl';
   } else {
    $this->template = 'default/template/product/product.tpl';
   }

   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );

   $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     } else {
   $url = '';

   if (isset($this->request->get['path'])) {
    $url .= '&path=' . $this->request->get['path'];
   }

   if (isset($this->request->get['manufacturer_id'])) {
    $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
   }

   if (isset($this->request->get['keyword'])) {
    $url .= '&keyword=' . $this->request->get['keyword'];
   }

   if (isset($this->request->get['description'])) {
    $url .= '&description=' . $this->request->get['description'];
   }

        $this->document->breadcrumbs[] = array(
          'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/product' . $url . '&product_id=' . $product_id)),
          'text'      => $this->language->get('text_error'),
          'separator' => $this->language->get('text_separator')
        );

        $this->document->title = $this->language->get('text_error');

        $this->data['heading_title'] = $this->language->get('text_error');

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

 public function review() {
     $this->language->load('product/product');

  $this->load->model('catalog/review');

  $this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

  if (isset($this->request->get['page'])) {
   $page = $this->request->get['page'];
  } else {
   $page = 1;
  }

  $this->data['reviews'] = array();

  $results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

  foreach ($results as $result) {
         $this->data['reviews'][] = array(
          'author'     => $result['author'],
          'rating'     => $result['rating'],
          'text'       => strip_tags($result['text']),
          'stars'      => sprintf($this->language->get('text_stars'), $result['rating']),
          'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
         );
       }

  $review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

  $pagination = new Pagination();
  $pagination->total = $review_total;
  $pagination->page = $page;
  $pagination->limit = 5;
  $pagination->text = $this->language->get('text_pagination');
  $pagination->url = $this->url->http('product/product/review&product_id=' . $this->request->get['product_id'] . '&page=%s');

  $this->data['pagination'] = $pagination->render();

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/product/review.tpl';
  } else {
   $this->template = 'default/template/product/review.tpl';
  }

  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 public function write() {
     $this->language->load('product/product');

  $this->load->model('catalog/review');

  $json = array();

  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
   $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

   $json['success'] = $this->language->get('text_success');
  } else {
   $json['error'] = $this->error['message'];
  }

  $this->load->library('json');

  $this->response->setOutput(Json::encode($json));
 }

 public function captcha() {
  $this->load->library('captcha');

  $captcha = new Captcha();

  $this->session->data['captcha'] = $captcha->getCode();

  $captcha->showImage();
 }

   private function validate() {
     if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
        $this->error['message'] = $this->language->get('error_name');
     }

     if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text'])) > 1000)) {
        $this->error['message'] = $this->language->get('error_text');
     }

     if (!$this->request->post['rating']) {
        $this->error['message'] = $this->language->get('error_rating');
     }

     if ($this->session->data['captcha'] != $this->request->post['captcha']) {
        $this->error['message'] = $this->language->get('error_captcha');
     }

     if (!$this->error) {
        return TRUE;
     } else {
        return FALSE;
     }
 }

  // 100223 ALNAUA Site redesign Begin
  public function recalculateprice()
  {
   if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    if (isset($this->request->post['option'])) {
     $options = $this->request->post['option'];
    } else {
     $options = array();
    }

    if (isset($this->request->post['product_id'])) {
     $product_id = $this->request->post['product_id'];
    } else {
     return;
    }
   }

   $this->load->model('catalog/product');
   $product_query = $this->model_catalog_product->getProduct($product_id);

   $option_price = 0;

   foreach ($options as $product_option_value_id) {
    $option_value_query = $this->db->query("SELECT pov.product_option_id, povd.name, pov.price, pov.quantity, pov.subtract, pov.prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product_option_value_description povd ON (pov.product_option_value_id = povd.product_option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_id = '" . (int)$product_id . "' AND povd.language_id = '" . (int)$this->language->getId() . "' ORDER BY pov.sort_order");

    if ($option_value_query->num_rows) {
     if ($option_value_query->row['prefix'] == '+') {
      $option_price = $option_price + $option_value_query->row['price'];
     } elseif ($option_value_query->row['prefix'] == '-') {
      $option_price = $option_price - $option_value_query->row['price'];
     }
    }
   }

   // 140412 ET-140412 Begin
   $perecenka = $this->model_catalog_product->getProduct($product_id);

   if ($perecenka["nds"] == 1) {
    $pereshet = TRUE;
   } else if ($perecenka["nds"] == 0) {
    $pereshet = FALSE;
   }

   if ($perecenka["power"] == 1) {
    $akcia = TRUE;
    $this->data['akcia'] = TRUE;
   } else if ($perecenka["power"] == 0) {
    $akcia = FALSE;
    $this->data['akcia'] = FALSE;
   }

   //var_dump($perecenka);
   //var_dump($this->data['price']);
   //var_dump($pereshet);
   //var_dump($akcia);

   $discount = $this->model_catalog_product->getProductDiscount($product_id);
   $special = $this->model_catalog_product->getProductSpecial($product_id);
   $spec = $this->model_catalog_product->getProductAkcia($product_id);

   // if ($discount) {
   //   $price = $this->currency->format($this->tax->calculate($discount + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
   //$special = FALSE;
   //   } else {
   if ($pereshet == TRUE) {
    $price_nds = $product_query['price'];
    $price = $this->currency->format($this->tax->calculate($price_nds + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
    //var_dump($price);
   } else if ($pereshet == FALSE) {
    $price = $this->currency->format($this->tax->calculate($product_query['price'] + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
   }
   // }

   //var_dump($spec);

//    if ($special) {
   //var_dump($special);
   if ($akcia == TRUE) {
//   if ($pereshet == TRUE) {
//    //$nds = $product_query['price'] * 0.2;
//    $price_nds = $product_query['special'];
//    //$ndds = $special * 0.2;
//    //$special_nds = $special;
//    //var_dump($price_nds);
//    //var_dump($special_nds);
//    $price = $this->currency->format($this->tax->calculate($price_nds + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
//    //var_dump($price);
//    //$special = $this->currency->format($this->tax->calculate($spec + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
//    //var_dump($special);
//   } else if ($pereshet == FALSE) {
    $price = $this->currency->format($this->tax->calculate($product_query['special'] + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
    //var_dump($prices);
    //$special = $this->currency->format($this->tax->calculate($spec + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
  // }
//    } else {
//      $special = FALSE;
//    }
  }
   else if ($akcia == FALSE){
//    if ($pereshet == TRUE) {
//     //$nds = $product_query['price'] * 0.2;
//     $price_nds = $product_query['price'];
//     //$ndds = $special * 0.2;
//     //$special_nds = $special;
//     //var_dump($price_nds);
//     //var_dump($special_nds);
//     $price = $this->currency->format($this->tax->calculate($price_nds + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
//     //var_dump($price);
//     //$special = $this->currency->format($this->tax->calculate($spec + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
//     //var_dump($special);
//    } else if ($pereshet == FALSE) {
     $price = $this->currency->format($this->tax->calculate($product_query['price'] + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
     //var_dump($prices);
     //$special = $this->currency->format($this->tax->calculate($spec + $option_price, $product_query['tax_class_id'], $this->config->get('config_tax')));
   // }
   }
//    if ($special) {
//     $array = explode('.', $special);
//     //$array2 = explode(',', $array[0]);
//     // if(isset($array2[1])){
//      //$cena = $array2[0].$array2[1];
//     // }
//     //var_dump($array);
//     //$nds = $array[0] * 0.2;
//     //$price_nds = $array[0]+$nds;
//     //var_dump($price_nds);
//    } else {
     $array = explode('.', $price);
     //var_dump($array);
     //$nds = $array[0] * 0.2;
     //$price_nds = $array[0]+$nds;
     //var_dump($price_nds);
    //}
    //var_dump($array);

    // 140412 ET-140412 End
    $price_int = $array[0];
    $array = explode(' ', $array[1]);
    $price_dec = $array[0];
    $price_curr = $array[1];
    $output  = '<table><tbody><tr>';
    $output .= '<td><div class="price_int">'.$price_int.'</div></td>';
    $output .= '<td>';
    $output .= '<div class="price_dec">'.$price_dec.'</div>';
    $output .= '<div class="price_curr">'.$price_curr.'</div>';
    $output .= '</td>';
    $output .= '</tr></tbody></table>';

    $this->response->setOutput($output, $this->config->get('config_compression'));
   //}
  }
  // 100223 ALNAUA Site redesign End

 public function rename() {

  $this->load->model('catalog/product');

  $products = $this->model_catalog_product->getInvalidImageProducts();

  $output = 'Renamed files:<br />';

  foreach ($products as $product) {
   $newfilename = str_replace(" ", "_", $product['image']);
   $output .= $product['image'] . " -> " . $newfilename . "<br />";
  }
  echo $output;
  //$this->response->setOutput($output, $this->config->get('config_compression'));

 }
}
?>

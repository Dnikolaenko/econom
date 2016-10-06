<?php
class ControllerProductCategory extends Controller {
 public function index() {
  $this->language->load('product/category');

  $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
        'href'      => $this->url->http('common/home'),
        'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

  $this->load->model('catalog/category');
  $this->load->model('tool/seo_url');

  if (isset($this->request->get['path'])) {
   $path = '';

   $parts = explode('_', $this->request->get['path']);

   foreach ($parts as $path_id) {
    $category_info = $this->model_catalog_category->getCategory($path_id);

    if ($category_info) {
     if (!$path) {
      $path = $path_id;
     } else {
      $path .= '_' . $path_id;
     }

           $this->document->breadcrumbs[] = array(
            'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $path)),
            'text'      => $category_info['name'],
            'separator' => $this->language->get('text_separator')
           );
    }
   }

   $category_id = array_pop($parts);
  } else {
   $category_id = 0;
  }

  $category_info = $this->model_catalog_category->getCategory($category_id);

  $this->data['category_id'] = $category_id;

  if ($category_info) {
   // (-/+) ALNAUA 100112 Tags (START)
   //$this->document->title = $category_info['name'];
   // 1500609 ET-150609 Begin
   //$this->document->title = ($category_info['page_title'] != '' ? $category_info['page_title'] : $category_info['name']);
   $this->document->title = ($category_info['page_title'] != '' ? $category_info['page_title'] : $category_info['name'].$this->language->get('text_page_title_suffix'));
   // 1500609 ET-150609 End
   // (-/+) ALNAUA 100112 Tags (FINISH)

   // 1500609 ET-150609 Begin
   //$this->document->description = $category_info['meta_description'];
   $this->document->description = ($category_info['meta_description'] != '' ? $category_info['meta_description'] : $category_info['name'].$this->language->get('text_meta_description_suffix'));
   // 1500609 ET-150609 End
   // (+) ALNAUA 100112 Tags (START)
   $this->document->keywords = $category_info['meta_keywords'];
   // (+) ALNAUA 100112 Tags (FINISH)

   // 140125 ET-140125 Begin
   if ($category_id == 35) {
    $this->document->active = 'discount';
   } elseif ($category_id == 211) {
    $this->document->active = 'week_product';
   } elseif ($category_id == 317) {
    $this->document->active = 'no_enter';
   } else {
    $this->document->active = null;
   }
   // 140125 ET-140125 End

   $this->data['heading_title'] = $category_info['name'];
   //$this->data['heading_title'] = $this->language->get('text_choose_product');

   $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
   // 121210 SEO optimization Begin
   $this->data['bottom_description'] = html_entity_decode($category_info['bottom_description'], ENT_QUOTES, 'UTF-8');
   // 121210 SEO optimization End

   $this->data['text_sort'] = $this->language->get('text_sort');
   $this->data['text_latest'] = $this->language->get('text_latest');

   // (+) ALNAUA 091114 (START)
   $this->data['text_enlarge'] = $this->language->get('text_enlarge');
   // (+) ALNAUA 091114 (FINISH)

   if (isset($this->request->get['page'])) {
    $page = $this->request->get['page'];
    // 121210 SEO optimization Begin
    $this->data['page'] = $page;
    // 121210 SEO optimization End
   } else {
    $page = 1;
    // 121210 SEO optimization Begin
    $this->data['page'] = $page;
    // 121210 SEO optimization End
   }

   if (isset($this->request->get['sort'])) {
    $sort = $this->request->get['sort'];
   } else {
    // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
    //$sort = 'pd.name';
    $sort = 'p.sort_order, pd.name';
    // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
   }

   if (isset($this->request->get['order'])) {
    $order = $this->request->get['order'];
   } else {
    $order = 'ASC';
   }

   $url = '';

   if (isset($this->request->get['sort'])) {
    $url .= '&sort=' . $this->request->get['sort'];
   }

   if (isset($this->request->get['order'])) {
    $url .= '&order=' . $this->request->get['order'];
   }

   $this->load->model('catalog/product');

   $this->load->helper('image');

   $category_total = $this->model_catalog_category->getTotalCategoriesByCategoryId($category_id);
   $product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id);

   // 100223 ALNAUA Site redesign Begin
   $this->data['display_images'] = $category_info['display_images'];
   // 100223 ALNAUA Site redesign End

   // (+) ALNAUA 091114 (START)
   if ($category_info['image']) {
       $this->data['popup'] = HTTP_IMAGE . $category_info['image'];
       $this->data['thumb'] = image_resize($category_info['image'], $this->config->get('config_image_category_dops_width'), $this->config->get('config_image_category_dops_height'));
   } else {
       $this->data['thumb'] = '';
   }

   if ($category_info['image1']) {
       $this->data['popup1'] = HTTP_IMAGE . $category_info['image1'];
       $this->data['thumb1'] = image_resize($category_info['image1'], $this->config->get('config_image_category_dops_width'), $this->config->get('config_image_category_dops_height'));
   } else {
       $this->data['thumb1'] = '';
   }

   if ($category_info['image2']) {
       $this->data['popup2'] = HTTP_IMAGE . $category_info['image2'];
       $this->data['thumb2'] = image_resize($category_info['image2'], $this->config->get('config_image_category_dops_width'), $this->config->get('config_image_category_dops_height'));
   } else {
       $this->data['thumb2'] = '';
   }
   // (+) ALNAUA 091114 (FINISH)

   if ($category_total || $product_total) {
    $this->data['categories'] = array();

    $results = $this->model_catalog_category->getCategories($category_id);
    //$results = $this->model_catalog_category->getCategories(0);

    foreach ($results as $result) {
     if ($result['image']) {
      $image = $result['image'];
     } else {
      $image = 'no_image.jpg';
     }

     $this->data['categories'][] = array(
        //'category_id' => $result['category_id'],
       'name'  => $result['name'],
       // 140125 ET-140125 Begin
       //'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)),
       'href'  => (!$result['external'] ? $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)) : $result['external_link']),
       // 140125 ET-140125 End
       //'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result['category_id'] . $url)),
       'thumb' => image_resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'))
     );
   }

    $this->load->model('catalog/review');

    $this->data['products'] = array();

    $results = $this->model_catalog_product->getProductsByCategoryId($category_id, $sort, $order, ($page - 1) * 20, 20);

          foreach ($results as $result) {
          // var_dump($result);
    if ($result['image']) {
      $image = $result['image'];
     } else {
      $image = 'no_image.jpg';
     }

     $rating = $this->model_catalog_review->getAverageRating($result['product_id']);



    if (isset($this->request->get['path'] == '6_329')){
    $ga = 1;
    $this->data['ga'] = $ga;
    }
    else {
    $ga = 0;
    $this->data['ga'] = $ga;
    }

           $perecenka = $this->model_catalog_product->getProduct($result['product_id']);


    if ($perecenka["nds"] == 1) {
      $pereshet = TRUE;
    } else if ($perecenka["nds"] == 0) {
      $pereshet = FALSE;
    }


     if($result["power"] == 1) {
      $akcia = TRUE;
      $this->data['akcia'] = TRUE;
     } else if ($result["power"] == 0) {
      $akcia = FALSE;
      $this->data['akcia'] = FALSE;
     }

       $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
       $specials = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));

     // 101115 Add icon layers to products images Begin
     $resize_options = array('image_name_only' => true);

     $config_icon_24 = ($this->config->get('config_icon_24') && $result['is_24_hour_delivery'] ? $this->config->get('config_icon_24') : '');
     $config_icon_new = ($this->config->get('config_icon_new') && $result['is_new_item'] ? $this->config->get('config_icon_new') : '');
     $config_icon_5 = ($this->config->get('config_icon_5') && $result['is_5_days_delivery'] ? $this->config->get('config_icon_5') : '');

     if ($config_icon_24) {
       $config_icon_24 = image_resize($config_icon_24, $this->config->get('config_icon_24_cat_width'), $this->config->get('config_icon_24_cat_height'), $resize_options);
     }

     if ($config_icon_new) {
       $config_icon_new = image_resize($config_icon_new, $this->config->get('config_icon_new_cat_width'), $this->config->get('config_icon_new_cat_width'), $resize_options);
     }

     if ($config_icon_5) {
       $config_icon_5 = image_resize($config_icon_5, $this->config->get('config_icon_5_cat_width'), $this->config->get('config_icon_5_cat_height'), $resize_options);
     }

     $resize_options = array( 'icon_24'  => array('image'     => $config_icon_24,
                                                  'postition' => $this->config->get('config_icon_24_pos')),
                              'icon_new' => array('image'     => $config_icon_new,
                                                  'postition' => $this->config->get('config_icon_new_pos')),
                              'icon_5'  => array('image'     => $config_icon_5,
                                                 'postition' => $this->config->get('config_icon_5_pos')),
                 );
     // 101115 Add icon layers to products images End
     $this->data['products'][] = array(
         'name'    => $result['name'],
         'model'   => $result['model'],
         'rating'  => $rating,
         'stars'   => sprintf($this->language->get('text_stars'), $rating),
         'thumb'   => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'), $resize_options),
         'akcia'   => $akcia,
         'price'   => $price,
         'special' => $specials,
         'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&path=' . $this->request->get['path'] . '&product_id=' . $result['product_id']))
             );
          }
    $this->data['bestseller_display_on_home'] = $this->config->get('bestseller_display_on_home');

    if ($this->data['bestseller_display_on_home']) {
     // ET-20150114 Begin
     $random_products = $this->model_catalog_product->getRandomProducts($this->config->get('bestseller_limit'));
     //$random_products = $this->model_catalog_product->getBestSellerProducts();
     // ET-20150114 End



     foreach ($random_products as $result) {
      if ($result['image']) {
       $image = $result['image'];
      } else {
       $image = 'no_image.jpg';
      }

      if($result["power"] == 1) {
       $akcia = TRUE;
       $this->data['akcia'] = TRUE;
      } else if ($result["power"] == 0) {
       $akcia = FALSE;
       $this->data['akcia'] = FALSE;
      }
      //$rating = $this->model_catalog_review->getAverageRating($result['product_id']);

      $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
      $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));

      $this->data['productss'][] = array(
          'name'    => $result['name'],
          'model'   => $result['model'],
       //'rating'  => $rating,
       //'stars'   => sprintf($this->language->get('text_stars'), $rating),
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

    $url = '';

    if (isset($this->request->get['page'])) {
     $url .= '&page=' . $this->request->get['page'];
    }

    $this->data['sorts'] = array();

    $this->data['sorts'][] = array(
     'text'  => $this->language->get('text_name_asc'),
     'value' => 'pd.name-ASC',
     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC'))
    );

    $this->data['sorts'][] = array(
     'text'  => $this->language->get('text_name_desc'),
     'value' => 'pd.name-DESC',
     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC'))
    );

    $this->data['sorts'][] = array(
     'text'  => $this->language->get('text_price_asc'),
     'value' => 'p.price-ASC',
     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=p.price&order=ASC'))
    );

    $this->data['sorts'][] = array(
     'text'  => $this->language->get('text_price_desc'),
     'value' => 'p.price-DESC',
     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=p.price&order=DESC'))
    );

//    $this->data['sorts'][] = array(
//     'text'  => $this->language->get('text_rating_desc'),
//     'value' => 'rating-DESC',
//     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=rating&order=DESC'))
//    );
//
//    $this->data['sorts'][] = array(
//     'text'  => $this->language->get('text_rating_asc'),
//     'value' => 'rating-ASC',
//     'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . '&sort=rating&order=ASC'))
//    );

    $url = '';

    if (isset($this->request->get['sort'])) {
     $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
     $url .= '&order=' . $this->request->get['order'];
    }

    $pagination = new Pagination();
    $pagination->total = $product_total;
    $pagination->page = $page;
    $pagination->limit = 20;
    $pagination->text = $this->language->get('text_pagination');
                $pagination->text_first = $this->language->get('text_pagination_first');
                $pagination->text_last = $this->language->get('text_pagination_last');
                $pagination->text_next = $this->language->get('text_pagination_next');
                $pagination->text_prev = $this->language->get('text_pagination_prev');
    $pagination->url = $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . $url . '&page=%s'));

    $this->data['pagination'] = $pagination->render();

    $this->data['sort'] = $sort;
    $this->data['order'] = $order;

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
     $this->template = $this->config->get('config_template') . '/template/product/category.tpl';
    } else {
     $this->template = 'default/template/product/category.tpl';
    }

    $this->children = array(
     'common/header',
     'common/footer',
     'common/column_left',
     'common/column_right'
    );

    $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
        } else {
          $this->document->title = $category_info['name'];

    $this->document->description = $category_info['meta_description'];

          $this->data['heading_title'] = $category_info['name'];
//                $this->data['heading_title'] = $this->language->get('text_choose_product');

          $this->data['text_error'] = $this->language->get('text_empty');

          $this->data['button_continue'] = $this->language->get('button_back');

          $this->data['continue'] = 'javascript:history.go(-1);';

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
     } else {
   $url = '';

   if (isset($this->request->get['sort'])) {
    $url .= '&sort=' . $this->request->get['sort'];
   }

   if (isset($this->request->get['order'])) {
    $url .= '&order=' . $this->request->get['order'];
   }

   if (isset($this->request->get['page'])) {
    $url .= '&page=' . $this->request->get['page'];
   }

   if (isset($this->request->get['path'])) {
          $this->document->breadcrumbs[] = array(
           'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $this->request->get['path'] . $url)),
           'text'      => $this->language->get('text_error'),
           'separator' => $this->language->get('text_separator')
          );
   }

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
}
?>

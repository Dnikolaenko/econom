<?php
class ControllerCommonHome extends Controller {
 public function index() {
   if (isset($this->session->data['order_id'])) {
   // (+) ALNAUA 091114 (START)
   //$this->session->data['orders'][] = $this->session->data['order_id'];
   $current_order_id = (int)$this->session->data['order_id'];
   $secret_code = $this->session->data['secret_code'];
   // (+) ALNAUA 091114 (FINISH)

   $this->cart->clear();
   
   unset($this->session->data['shipping_method']);
   unset($this->session->data['shipping_methods']);
   unset($this->session->data['payment_method']);
   unset($this->session->data['payment_methods']);
   unset($this->session->data['guest']);
   unset($this->session->data['comment']);
   unset($this->session->data['order_id']);
   unset($this->session->data['coupon']);
   // (+) ALNAUA 091114 (START)
   unset($this->session->data['secret_code']);
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
  
  $this->language->load('common/home');
  
  $this->document->title = $this->config->get('config_title');
  $this->document->description = $this->config->get('config_meta_description');
  // (+) ALNAUA 100112 Tags (START)
  $this->document->keywords = $this->config->get('config_meta_keywords');
  // (+) ALNAUA 100112 Tags (FINISH)

  // (+) ALNAUA 091114 (START)
  $this->document->active = 'home';
  // (+) ALNAUA 091114 (FINISH)

  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
    'href'      => $this->url->http('common/home'),
    'text'      => $this->language->get('text_home'),
    'separator' => FALSE
  );
  
  $this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_store'));
  $this->data['welcome'] = html_entity_decode($this->config->get('config_welcome_' . $this->language->getId()));

   // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
   $this->data['config_left_top_banner_display'] = $this->config->get('config_left_top_banner_display');
   $this->data['config_left_top_banner'] = $this->config->get('config_left_top_banner');
   $this->data['config_left_top_banner_ext'] = substr($this->config->get('config_left_top_banner'), strlen($this->config->get('config_left_top_banner'))-3, 3);
   $this->data['config_left_top_banner_url'] = $this->config->get('config_left_top_banner_url');

   if ($this->config->get('config_left_top_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_left_top_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner');
   } else {
    $this->data['preview_left_top_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner');
   }
   }

   $this->data['config_right_top_banner_display'] = $this->config->get('config_right_top_banner_display');
   $this->data['config_right_top_banner'] = $this->config->get('config_right_top_banner');
   $this->data['config_right_top_banner_ext'] = substr($this->config->get('config_right_top_banner'), strlen($this->config->get('config_right_top_banner'))-3, 3);
   $this->data['config_right_top_banner_url'] = $this->config->get('config_right_top_banner_url');

  if ($this->config->get('config_right_top_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_right_top_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner');
   } else {
    $this->data['preview_right_top_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner');
   }
  }
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  
  // 130415 ET-130411 Begin
  $this->data['slideshow_display_on_home'] = $this->config->get('slideshow_display_on_home');
  
  if ($this->data['slideshow_display_on_home']) {
   
    $this->load->model('design/banner');
    $this->load->helper('image');
    
    // 140408 ET-140408 Begin
    //$banners = $this->model_design_banner->getEnabledBanners();
    $banners = $this->model_design_banner->getHomeSlideBanners();
    // 140408 ET-140408 End
    
    $this->data['slideshow'] = array();
    
    foreach ($banners as $banner) {
      $this->data['slideshow'][] = array(
          'title' => $banner['title'],
          'link'  => $banner['link'],
          'thumb' => image_resize($banner['image'], $this->config->get('config_slideshow_width'), $this->config->get('config_slideshow_height'))
          );
    }    
  }
  // 130415 ET-130411 End
  
  $this->data['text_latest'] = $this->language->get('text_latest');
  $this->data['text_choose_category'] = $this->language->get('text_choose_category');
  // 121210 SEO optimization Begin
  $this->data['text_news'] = $this->language->get('text_news');
  // 121210 SEO optimization End
  
  $this->load->model('catalog/product');
  //$this->load->model('catalog/review');
  $this->load->model('catalog/category');
  $this->load->model('tool/seo_url');
  // 121210 SEO optimization Begin
  $this->load->model('catalog/information');
  // 121210 SEO optimization End
  $this->load->helper('image');
  
  // 121210 SEO optimization Begin
  $this->data['news_display_on_home'] = $this->config->get('news_display_on_home');
  
  if ($this->data['news_display_on_home']) {
    
    $this->data['latest_news'] = array();
    
    $latest_news = $this->model_catalog_information->getLatestNews($this->config->get('news_limit'));
    
    foreach ($latest_news as $result) {
      $this->data['latest_news'][] = array(
            'title' => $result['title'],
            'anons' => $result['anons'],
            'date_added' => $result['date_added'],
            'href'  => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
          );
    }    
  }
  // 121210 SEO optimization End
  
  $this->data['products'] = array();

  $this->data['bestseller_display_on_home'] = $this->config->get('bestseller_display_on_home');

  if ($this->data['bestseller_display_on_home']) {
      // ET-20150114 Begin
      //$random_products = $this->model_catalog_product->getRandomBestSellerProducts($this->config->get('bestseller_limit'));
      $random_products = $this->model_catalog_product->getRandomProducts($this->config->get('bestseller_limit'));
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

        $this->data['products'][] = array(
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

    if (!$this->config->get('config_customer_price')) {
        $this->data['display_price'] = TRUE;
    } elseif ($this->customer->isLogged()) {
        $this->data['display_price'] = TRUE;
    } else {
        $this->data['display_price'] = FALSE;
    }
  }
  $this->data['categories'] = array();

  if ($this->config->get('category_display_on_home')) {
    foreach ($this->model_catalog_category->getCategories(0) as $result) {

        if ($result['image']) {
            $image = $result['image'];
        } else {
            $image = 'no_image.jpg';
        }
        $this->data['categories'][] = array(
            'name'               => $result['name'],
            'index_description'  => $result['index_description'],
            'thumb'   => "'".image_resize($image, 120, 80)."'",
            'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result['category_id']))
        );
    }
  }
    
  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/common/home.tpl';
  } else {
   $this->template = 'default/template/common/home.tpl';
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
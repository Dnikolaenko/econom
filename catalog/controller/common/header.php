<?php   
class ControllerCommonHeader extends Controller {
 protected function index() {
  $this->language->load('common/header');
  
  $this->data['title'] = $this->document->title;
  $this->data['description'] = $this->document->description;
  // (+) ALNAUA 100112 Tags (START)
  $this->data['keywords'] = $this->document->keywords;
  // (+) ALNAUA 100112 Tags (FINISH)

  if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
   $this->data['base'] = HTTPS_SERVER;
  } else {
   $this->data['base'] = HTTP_SERVER;
  }
  
  $this->data['charset'] = $this->language->get('charset');
  $this->data['lang'] = $this->language->get('code');
  $this->data['direction'] = $this->language->get('direction');
  $this->data['links'] = $this->document->links; 
  $this->data['styles'] = $this->document->styles;
  $this->data['scripts'] = $this->document->scripts;  
  $this->data['breadcrumbs'] = $this->document->breadcrumbs;
  $this->data['icon'] = $this->config->get('config_icon');
  
  $this->data['store'] = $this->config->get('config_store');
  
  if (isset($this->request->server['HTTPS']) && ($this->request->server['HTTPS'] == 'on')) {
   $this->data['logo'] = HTTPS_IMAGE . $this->config->get('config_logo');
  } else {
   $this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
  }
        
  // (+) ALNAUA 091114 (START)
  $this->data['active'] = $this->document->active;
  $this->data['text_subtotal'] = $this->language->get('text_subtotal');
  $this->data['text_empty'] = $this->language->get('text_empty');
  $this->data['text_cart'] = $this->language->get('text_cart');
  $this->data['count_products'] = $this->cart->countProducts();
  //$this->data['products'][] = $this->cart->getProducts();
  $this->data['subtotal'] = $this->currency->format($this->cart->getTotal());
  $this->data['ajax'] = $this->config->get('cart_ajax');
  $this->data['text_add_error'] = $this->language->get('text_add_error');
  // (+) ALNAUA 091114 (FINISH)
  // ET-150223 Begin
  $this->data['text_min_order_qty_error'] = $this->language->get('text_min_order_qty_error');
  // ET-150223 End

  $this->data['text_home'] = $this->language->get('text_home');
  // (+) ALNAUA 091114 (START)
  $this->data['text_news'] = $this->language->get('text_news');
  // (+) ALNAUA 091114 (FINISH)
//  $this->data['text_special'] = $this->language->get('text_special');
//     $this->data['text_account'] = $this->language->get('text_account');
//     $this->data['text_login'] = $this->language->get('text_login');
//     $this->data['text_logout'] = $this->language->get('text_logout');
//     $this->data['text_cart'] = $this->language->get('text_cart');
//     $this->data['text_checkout'] = $this->language->get('text_checkout');
  $this->data['text_freeshipping'] = $this->language->get('text_freeshipping');
  $this->data['text_advice'] = $this->language->get('text_advice');
  $this->data['text_payment'] = $this->language->get('text_payment');
  $this->data['text_ask'] = $this->language->get('text_ask');
  $this->data['text_contacts'] = $this->language->get('text_contacts');
  // 20120204 ALNAUA ET-111227 Begin
  $this->data['text_credit'] = $this->language->get('text_credit');
  // 20120204 ALNAUA ET-111227 End
  // 130619 ET-130619 Begin Begin
  $this->data['text_discount'] = $this->language->get('text_discount');
  // 130619 ET-130619 End
  // 140125 ET-140125 Begin
  $this->data['text_week_product'] = $this->language->get('text_week_product');
  // 140125 ET-140125 End
  // ET-150730 Begin
  $this->data['text_no_enter'] = $this->language->get('text_no_enter');
  // ET-150730 End


  // 100223 ALNAUA Site redesign Begin
  $this->data['text_loading'] = $this->language->get('text_loading');
  // 100223 ALNAUA Site redesign End
  
  $this->data['text_callback'] = $this->language->get('text_callback');
  $this->data['text_sending'] = $this->language->get('text_sending');
  $this->data['text_callback_thanks'] = $this->language->get('text_callback_thanks');
  $this->data['text_callback_bye'] = $this->language->get('text_callback_bye');
  $this->data['error_callback_name'] = $this->language->get('error_callback_name');
  $this->data['error_callback_phone'] = $this->language->get('error_callback_phone');
  $this->data['error_callback_phone_wrong'] = $this->language->get('error_callback_phone_wrong');
  $this->data['error_callback_message'] = $this->language->get('error_callback_message');
  
  $this->data['text_slogan'] = $this->language->get('text_slogan');
  
  $this->data['text_work_time'] = $this->language->get('text_work_time');
  

  $this->data['home'] = $this->url->http('common/home');
  // (+) ALNAUA 091114 (START)
  $this->data['news'] = $this->url->http('information/news');
  // (+) ALNAUA 091114 (FINISH)
//  $this->data['special'] = $this->url->http('product/special');
//  $this->data['account'] = $this->url->https('account/account');
//  $this->data['logged'] = $this->customer->isLogged();
//  $this->data['login'] = $this->url->https('account/login');
//  $this->data['logout'] = $this->url->http('account/logout');
    $this->data['cart'] = $this->url->http('checkout/cart');
//  $this->data['checkout'] = $this->url->https('checkout/shipping');
  $this->data['freeshipping'] = $this->url->http('information/freeshipping');
  $this->data['advice'] = $this->url->http('information/advice');
  $this->data['payment'] = $this->url->http('information/payment');
  $this->data['ask'] = $this->url->http('information/question');
  $this->data['contacts'] = $this->url->http('information/contact');
  // 20120204 ALNAUA ET-111227 Begin
  $this->data['credit'] = $this->url->http('information/credit');
  // 20120204 ALNAUA ET-111227 End
  // 130619 ET-130619 Begin
  // 140125 ET-140125 Begin
  //$this->data['discount'] = $this->url->http('information/payment#discount');
  $this->data['discount'] = $this->url->http('product/category&path=35');
  // 140125 ET-140125 End
  // 130619 ET-130619 End
  // 140125 ET-140125 Begin
  $this->data['week_product'] = $this->url->http('product/category&path=211');
  // 140125 ET-140125 End
  // ET-150730 Begin
  $this->data['no_enter'] = $this->url->http('product/category&path=211_317');
  // ET-150730 End

  // (+) ALNAUA 091114 (START)
  //$this->data['config_telephone_right'] = preg_replace('/\s{2}/i', '&nbsp;&nbsp;', preg_replace('/\s{3}/i', '&nbsp;&nbsp;&nbsp;', preg_replace('/,\s+/i', '<br />', $this->config->get('config_telephone_right'))));
  $this->data['config_telephone_right'] = html_entity_decode($this->config->get('config_telephone_right'), ENT_QUOTES, 'UTF-8');
  // (+) ALNAUA 091114 (FINISH)
  // 110805 ET-110805 Extra Telephone Field Begin
  //$this->data['config_telephone_left'] = preg_replace('/\s{2}/i', '&nbsp;&nbsp;', preg_replace('/\s{3}/i', '&nbsp;&nbsp;&nbsp;', preg_replace('/,\s+/i', '<br />', $this->config->get('config_telephone_left'))));
  $this->data['config_telephone_left'] = html_entity_decode($this->config->get('config_telephone_left'), ENT_QUOTES, 'UTF-8');
  // 110805 ET-110805 Extra Telephone Field End
  // ET-150303 Begin
  $this->data['config_slideshow_delay'] = $this->config->get('config_slideshow_delay');
  // ET-150303 End
  // 140408 ET-140408 Begin
  $this->load->model('design/banner');
  $this->load->helper('image');

  $banners = $this->model_design_banner->getTopBanners();

  $this->data['top_banners'] = array();

  foreach ($banners as $banner) {
    $this->data['top_banners'][] = $banner;
  }
  // 140408 ET-140408 End

  $this->id = 'header';
  
  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/common/header.tpl';
  } else {
   $this->template = 'default/template/common/header.tpl';
  }
  
  $this->children = array(
   'common/language',
   'common/search'
  );
  
     $this->render();
 } 
}
?>
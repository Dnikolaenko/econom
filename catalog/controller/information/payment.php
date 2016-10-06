<?php 
class ControllerInformationPayment extends Controller {
 public function index() {  
  $this->language->load('information/payment');
  
  $this->load->model('catalog/information');

  // (+) ALNAUA 091114 (START)
  $this->document->active = 'payment';
  // (+) ALNAUA 091114 (FINISH)
  
  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
    'href'      => $this->url->http('common/home'),
    'text'      => $this->language->get('text_home'),
    'separator' => FALSE
  );
  
  $payment_info = $this->model_catalog_information->getPayment();
     
  if ($payment_info) {

   // 100223 ALNAUA Site redesign Begin
   //$this->document->title = $this->language->get('text_payment');
   $this->document->title = ($payment_info['page_title'] != '' ? $payment_info['page_title'] : $this->language->get('text_payment'));
   $this->document->description = $payment_info['meta_description'];
   $this->document->keywords = $payment_info['meta_keywords'];
   // 100223 ALNAUA Site redesign End

   $this->document->breadcrumbs[] = array(
     'href'      => $this->url->http('information/payment'),
     'text'      => $this->language->get('text_payment'),
     'separator' => $this->language->get('text_separator')
   );

   $this->data['description'] =  html_entity_decode($payment_info['description'], ENT_QUOTES, 'UTF-8');

   $payment_items = $this->model_catalog_information->getItems($payment_info['information_id']);

   if ($payment_items) {
     $this->data['items'] = 'available';

     foreach ($payment_items as $result) {

       $this->data['payment_items'][] = array(
               'title'       => $result['title'],
               'href'        => $this->url->http('information/information&information_id=' . $result['information_id'])
           );
     }
   } else {
     $this->data['items'] = 'none';
   }
   $this->data['heading_title'] = $this->language->get('text_payment');
   
   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/payment.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/payment.tpl';
   } else {
    $this->template = 'default/template/information/payment.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );  
   
     $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     } else {
//        $this->document->breadcrumbs[] = array(
//          'href'      => $this->url->http('information/news'),
//          'text'      => $this->language->get('text_news'),
//          'separator' => $this->language->get('text_separator')
//        );
    
     $this->document->title = $this->language->get('text_payment');
   
        $this->data['heading_title'] = $this->language->get('text_payment');

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
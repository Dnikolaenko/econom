<?php 
class ControllerInformationCredit extends Controller {  
 public function index() { 
  $this->language->load('information/credit');
  
  $this->document->active = 'credit';

  $this->document->title = $this->language->get('heading_title');

  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
      'href'      => $this->url->http('common/home'),
      'text'      => $this->language->get('text_home'),
     'separator' => FALSE
  );

  $this->document->breadcrumbs[] = array(
      'href'      => $this->url->http('product/credit'),
      'text'      => $this->language->get('heading_title'),
      'separator' => $this->language->get('text_separator')
  );

  $this->data['heading_title'] = $this->language->get('heading_title');
   
 
  $this->load->model('catalog/credit');
   
  $credit_total = $this->model_catalog_credit->getTotalEnabledCredits();
      
  if ($credit_total) {
   $this->data['products'] = array();
    
   $results = $this->model_catalog_credit->getEnabledCredits();
   
   $this->load->model('tool/seo_url');
          
   foreach ($results as $result) {
    $this->data['credits'][] = array(
     'model'   => $result['credit_id'],
     'name'    => $result['name'],
     'description' => html_entity_decode($result['description']),
     'href'    => $this->model_tool_seo_url->rewrite($this->url->http('information/credit#credit_id=' . $result['credit_id'])),
     'anchor_name' => 'credit_id=' . $result['credit_id']
    );
   }

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/credit.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/credit.tpl';
   } else {
    $this->template = 'default/template/information/credit.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );
  
   $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));   
  } else {
        $this->data['text_error'] = $this->language->get('text_empty');

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
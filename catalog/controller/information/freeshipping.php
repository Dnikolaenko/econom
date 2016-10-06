<?php 
class ControllerInformationFreeShipping extends Controller {
 public function index() {  
  $this->language->load('information/freeshipping');
  
  $this->load->model('catalog/information');

  $this->document->active = 'freeshipping';
  
  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
    'href'      => $this->url->http('common/home'),
    'text'      => $this->language->get('text_home'),
    'separator' => FALSE
  );
  
  $freeshipping_info = $this->model_catalog_information->getFreeShipping();
     
  if ($freeshipping_info) {
    $this->document->title = ($freeshipping_info['page_title'] != '' ? $freeshipping_info['page_title'] : $this->language->get('text_freeshipping'));
    $this->document->description = $freeshipping_info['meta_description'];
    $this->document->keywords = $freeshipping_info['meta_keywords'];

    $this->document->breadcrumbs[] = array(
      'href'      => $this->url->http('information/freeshipping'),
      'text'      => $this->language->get('text_freeshipping'),
      'separator' => $this->language->get('text_separator')
    );

    $this->data['description'] =  html_entity_decode($freeshipping_info['description'], ENT_QUOTES, 'UTF-8');

    $freeshipping_items = $this->model_catalog_information->getItems($freeshipping_info['information_id']);

    if ($freeshipping_items) {
      $this->data['items'] = 'available';

      foreach ($freeshipping_items as $result) {

        $this->data['freeshipping_items'][] = array(
            'title'       => $result['title'],
            'href'        => $this->url->http('information/information&information_id=' . $result['information_id'])
        );
      }
    } else {
      $this->data['items'] = 'none';
    }
    $this->data['heading_title'] = $this->language->get('text_freeshipping');
        
   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/freeshipping.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/freeshipping.tpl';
   } else {
    $this->template = 'default/template/information/freeshipping.tpl';
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
    
    $this->document->title = $this->language->get('text_freeshipping');

    $this->data['heading_title'] = $this->language->get('text_freeshipping');

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
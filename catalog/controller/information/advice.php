<?php 
class ControllerInformationAdvice extends Controller {
 public function index() {  
     $this->language->load('information/advice');
  
  $this->load->model('catalog/advice');

        $this->document->active = 'advice';

        $this->document->breadcrumbs = array();

       $this->document->breadcrumbs[] = array(
         'href'      => $this->url->http('common/home'),
         'text'      => $this->language->get('text_home'),
         'separator' => FALSE
       );

        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/advice'),
          'text'      => $this->language->get('text_advice'),
          'separator' => $this->language->get('text_separator')
        );

        if (isset($this->request->get['advcategory_id'])) {
            $advcategory_id = $this->request->get['advcategory_id'];
        } else {
            $advcategory_id = 0;
        }

        $this->data['advcategory_id'] = $advcategory_id;

        $this->load->model('catalog/advcategory');
        $advcategories = $this->model_catalog_advcategory->getAdvCategories();

        if ($advcategories) {

            $this->data['catitems'] = 'available';

            foreach ($advcategories as $result) {
                $this->data['advcategories'][] = array(
                  'advcategory_id' => $result['advcategory_id'],
                  'name'        => $result['name'],
                  'href'        => $this->url->http('information/advice&advcategory_id=' . $result['advcategory_id'])
                  );

                if ($advcategory_id == $result['advcategory_id']) {
                  $this->document->breadcrumbs[] = array(
                      'href'      => $this->url->http('information/advice&advcategory_id=' . $advcategory_id),
                      'text'      => $result['name'],
                      'separator' => $this->language->get('text_separator')
                  );
                }
            }
        } else {
            $this->data['catitems'] = 'none';
        }
        
  $advices = $this->model_catalog_advice->getAdvices($advcategory_id);

        $this->data['text_info1'] = $this->language->get('text_info1');
        $this->data['text_info2'] = $this->language->get('text_info2');
     
  if ($advices) {
            $this->data['exists'] = 'available';

            $this->document->title = $this->language->get('text_advice');

            foreach ($advices as $result) {
            
            $this->data['advice'][] = array(
                    'name'        => $result['name'],
     'date_added'  => date('d.m.Y', strtotime($result['date_added'])),
     'href'        => $this->url->http('information/advice/info&advice_id=' . $result['advice_id'])
          );
            }
            $this->data['heading_title'] = $this->language->get('text_advice');
        
   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/advice.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/advice.tpl';
   } else {
    $this->template = 'default/template/information/advice.tpl';
   }
   
   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );  
   
     $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     } else {
        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/advice'),
          'text'      => $this->language->get('text_advice'),
          'separator' => $this->language->get('text_separator')
        );
   $this->data['exists'] = 'none';
            
     $this->document->title = $this->language->get('text_advice');
   
        $this->data['heading_title'] = $this->language->get('text_advice');

//        $this->data['text_error'] = $this->language->get('text_error');
//
//        $this->data['button_continue'] = $this->language->get('button_back');
//
//        $this->data['continue'] = 'javascript: history.go(-1)';

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/advice.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/advice.tpl';
   } else {
    $this->template = 'default/template/information/advice.tpl';
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

 public function info() {
     $this->language->load('information/advice');

  $this->load->model('catalog/advice');

        $this->document->active = 'advice';

        $this->document->breadcrumbs[] = array(
         'href'      => $this->url->http('common/home'),
         'text'      => $this->language->get('text_home'),
         'separator' => FALSE
       );

        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/advice'),
          'text'      => $this->language->get('text_advice'),
          'separator' => $this->language->get('text_separator')
        );

        if (isset($this->request->get['advice_id'])) {
            $advice_id = $this->request->get['advice_id'];
        } else {
            $advice_id = 0;
        }

        //$this->data['advice_id'] = $advcategory_id;

  $advice_info = $this->model_catalog_advice->getAdvice($advice_id);

  if ($advice_info) {

            $this->load->model('catalog/advcategory');

            if ($advice_info['advcategory_id']) {
              $advcategory = $this->model_catalog_advcategory->getAdvCategory($advice_info['advcategory_id']);

              $this->document->breadcrumbs[] = array(
                      'href'      => $this->url->http('information/advice&advcategory_id=' . $advice_info['advcategory_id']),
                      'text'      => $advcategory['name'],
                      'separator' => $this->language->get('text_separator')
              );
            }

            $this->document->breadcrumbs[] = array(
                    'href'      => $this->url->http('information/advice/info&advice_id=' . $advice_id),
                    'text'      => $advice_info['name'],
                    'separator' => $this->language->get('text_separator')
            );

     $this->document->title = $advice_info['name'];

            $this->document->description = $advice_info['meta_description'];

            $this->data['heading_title'] = $advice_info['name'];

            $this->data['description'] = html_entity_decode($advice_info['description']);

            $this->data['button_continue'] = $this->language->get('button_back');
            $this->data['continue'] = 'javascript: history.go(-1)';

   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/advice_info.tpl')) {
    $this->template = $this->config->get('config_template') . '/template/information/advice_info.tpl';
   } else {
    $this->template = 'default/template/information/advice_info.tpl';
   }

   $this->children = array(
    'common/header',
    'common/footer',
    'common/column_left',
    'common/column_right'
   );

     $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
     } else {
        $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/advice'),
          'text'      => $this->language->get('text_advice'),
          'separator' => $this->language->get('text_separator')
        );

     $this->document->title = $this->language->get('text_advice');

        $this->data['heading_title'] = $this->language->get('text_advice');

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
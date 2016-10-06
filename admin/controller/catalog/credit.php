<?php 
class ControllerCatalogCredit extends Controller {
 private $error = array();
 
 public function index() {
  $this->load->language('catalog/credit');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/credit');
   
  $this->getList();
 }

 public function insert() {
  $this->load->language('catalog/credit');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/credit');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();
   
   if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));
    
    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }
   } else {
    $data['image'] = '';
   }
   
   $this->model_catalog_credit->addCredit(array_merge($this->request->post, $data));

   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/credit'));
  }

  $this->getForm();
 }

 public function update() {
  $this->load->language('catalog/credit');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/credit');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();
   
   if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }
   }
   
   $this->model_catalog_credit->editCredit($this->request->get['credit_id'], array_merge($this->request->post, $data));
   
   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/credit'));
  }

  $this->getForm();
 }

 public function delete() {
  $this->load->language('catalog/credit');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/credit');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $credit_id) {
    $this->model_catalog_credit->deleteCredit($credit_id);
   }

   $this->session->data['success'] = $this->language->get('text_success');

   $this->redirect($this->url->https('catalog/credit'));
  }

  $this->getList();
 }

 private function getList() {
     $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('catalog/credit'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
         
  $this->data['insert'] = $this->url->https('catalog/credit/insert');
  $this->data['delete'] = $this->url->https('catalog/credit/delete');
  
  $this->data['credits'] = array();
  
  $results = $this->model_catalog_credit->getCredits();

  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('catalog/credit/update&credit_id=' . $result['credit_id'])
   );

     
   $this->data['credits'][] = array(
    'credit_id'   => $result['credit_id'],
    'name'        => $result['name'],
    'status'      => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
    'sort_order'  => $result['sort_order'],
    'selected'    => isset($this->request->post['selected']) && in_array($result['credit_id'], $this->request->post['selected']),
    'action'      => $action
   );
  }
  
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_no_results'] = $this->language->get('text_no_results');

  $this->data['column_name'] = $this->language->get('column_name');
  $this->data['column_status'] = $this->language->get('column_status');
  $this->data['column_sort_order'] = $this->language->get('column_sort_order');
  $this->data['column_action'] = $this->language->get('column_action');

  $this->data['button_insert'] = $this->language->get('button_insert');
  $this->data['button_delete'] = $this->language->get('button_delete');
 
   if (isset($this->error['warning'])) {
   $this->data['error_warning'] = $this->error['warning'];
  } else {
   $this->data['error_warning'] = '';
  }

  if (isset($this->session->data['success'])) {
   $this->data['success'] = $this->session->data['success'];
  
   unset($this->session->data['success']);
  } else {
   $this->data['success'] = '';
  }
  
  $this->template = 'catalog/credit_list.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function getForm() {
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_none'] = $this->language->get('text_none');
  $this->data['text_enabled'] = $this->language->get('text_enabled');
  $this->data['text_disabled'] = $this->language->get('text_disabled');
  
  $this->data['entry_name'] = $this->language->get('entry_name');
  $this->data['entry_status'] = $this->language->get('entry_status');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  $this->data['entry_image'] = $this->language->get('entry_image');
  $this->data['entry_description'] = $this->language->get('entry_description');
  
  //$this->data['entry_page_title'] = $this->language->get('entry_page_title');
  //$this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
  //$this->data['entry_keyword'] = $this->language->get('entry_keyword');

  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_general'] = $this->language->get('tab_general');
  $this->data['tab_data'] = $this->language->get('tab_data');

   if (isset($this->error['warning'])) {
   $this->data['error_warning'] = $this->error['warning'];
  } else {
   $this->data['error_warning'] = '';
  }
 
   if (isset($this->error['name'])) {
   $this->data['error_name'] = $this->error['name'];
  } else {
   $this->data['error_name'] = '';
  }

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
         'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('catalog/credit'),
         'text'      => $this->language->get('heading_title'),
         'separator' => ' :: '
     );
  
  if (!isset($this->request->get['credit_id'])) {
   $this->data['action'] = $this->url->https('catalog/credit/insert');
  } else {
   $this->data['action'] = $this->url->https('catalog/credit/update&credit_id=' . $this->request->get['credit_id']);
  }
  
  $this->data['cancel'] = $this->url->https('catalog/credit');

  if (isset($this->request->get['credit_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
   $credit_info = $this->model_catalog_credit->getCredit($this->request->get['credit_id']);
  }
  
  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();

  if (isset($this->request->post['credit_description'])) {
   $this->data['credit_description'] = $this->request->post['credit_description'];
  } elseif (isset($credit_info)) {
   $this->data['credit_description'] = $this->model_catalog_credit->getCreditDescriptions($this->request->get['credit_id']);
  } else {
   $this->data['credit_description'] = array();
  }
  
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (isset($credit_info)) {
   $this->data['sort_order'] = $credit_info['sort_order'];
  } else {
   $this->data['sort_order'] = 0;
  }
  
  if (isset($this->request->post['status'])) {
   $this->data['status'] = $this->request->post['status'];
  } else if (isset($credit_info)) {
   $this->data['status'] = $credit_info['status'];
  } else {
   $this->data['status'] = 1;
  }
  
  $this->load->helper('image');

  if (isset($credit_info) && $credit_info['image'] && file_exists(DIR_IMAGE . $credit_info['image'])) {
   $this->data['preview'] = image_resize($credit_info['image'], 0, 0);
  } else {
   $this->data['preview'] = image_resize('no_image.jpg', 100, 100);
  }
  
//  if (isset($this->request->post['keyword'])) {
//   $this->data['keyword'] = $this->request->post['keyword'];
//  } elseif (isset($credit_info)) {
//   $this->data['keyword'] = $credit_info['keyword'];
//  } else {
//   $this->data['keyword'] = '';
//  }
  
  $this->template = 'catalog/credit_form.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validateForm() {
  if (!$this->user->hasPermission('modify', 'catalog/credit')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  foreach ($this->request->post['credit_description'] as $language_id => $value) {
   if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 255)) {
    $this->error['name'][$language_id] = $this->language->get('error_name');
   }
  }
  
  if ($this->request->files['image']['name']) {
     if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
       'image/png',
       'image/x-png',
       'image/gif'
      );
    
   if (!in_array($this->request->files['image']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }
   
   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }
   
   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }
   
   if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) { 
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['image']['error']);
   }
  }
  
  if ($this->request->post['status'] == 0) {
   if (isset($this->request->get['credit_id']) && ($this->request->get['credit_id'] == $this->config->get('config_default_credit_id'))) {
    $this->error['warning'] = $this->language->get('error_default_credit');
   }
  }
   
  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

 private function validateDelete() {
  if (!$this->user->hasPermission('modify', 'catalog/credit')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  if (isset($this->request->post['selected'])) {
   $this->load->model('catalog/product');
   
   foreach ($this->request->post['selected'] as $credit_id) {
    if ($this->model_catalog_product->getTotalProductsByCreditId($credit_id) > 0){
     $this->error['warning'] = $this->language->get('error_assigned');
    }

    if ($credit_id == $this->config->get('config_default_credit_id')) {
     $this->error['warning'] = $this->language->get('error_delete_default_credit');
    }
   }
  }
 
  if (!$this->error) {
   return TRUE; 
  } else {
   return FALSE;
  }
 }
}
?>
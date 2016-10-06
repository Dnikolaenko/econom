<?php
class ControllerModuleCategory extends Controller {
 private $error = array(); 
 
 public function index() {   
  $this->load->language('module/category');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('setting/setting');
    
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
   // 140404 ET-140404 Begin
   $data = $this->request->post;
   
   $data['category_spliter_before'] = serialize($this->request->post['category_spliter_before']);
   
   //$this->model_setting_setting->editSetting('category', $this->request->post);  
   $this->model_setting_setting->editSetting('category', $data);
   // 140404 ET-140404 End
     
   $this->session->data['success'] = $this->language->get('text_success');
      
   $this->redirect($this->url->https('extension/module'));
  }
    
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_enabled'] = $this->language->get('text_enabled');
  $this->data['text_disabled'] = $this->language->get('text_disabled');
  $this->data['text_left'] = $this->language->get('text_left');
  $this->data['text_right'] = $this->language->get('text_right');
  
  $this->data['entry_position'] = $this->language->get('entry_position');
  $this->data['entry_status'] = $this->language->get('entry_status');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  // 100223 ALNAUA Site redesign Begin
  $this->data['entry_expand'] = $this->language->get('entry_expand');
  $this->data['entry_display_on_home'] = $this->language->get('entry_display_on_home');
  $this->data['text_yes'] = $this->language->get('text_yes');
  $this->data['text_no'] = $this->language->get('text_no');
  // 100223 ALNAUA Site redesign End
  
  // 140404 ET-140404 Begin
  $this->data['text_category_spliter_before'] = $this->language->get('text_category_spliter_before');
  
  $this->load->model('catalog/category');
  
  $this->data['categories'] = $this->model_catalog_category->getCategories(0);
  // 140404 ET-140404 End
  
  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_general'] = $this->language->get('tab_general');

   if (isset($this->error['warning'])) {
   $this->data['error_warning'] = $this->error['warning'];
  } else {
   $this->data['error_warning'] = '';
  }

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('extension/module'),
         'text'      => $this->language->get('text_module'),
        'separator' => ' :: '
     );
  
     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('module/category'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
  
  $this->data['action'] = $this->url->https('module/category');
  
  $this->data['cancel'] = $this->url->https('extension/module');

  if (isset($this->request->post['category_position'])) {
   $this->data['category_position'] = $this->request->post['category_position'];
  } else {
   $this->data['category_position'] = $this->config->get('category_position');
  }
  
  if (isset($this->request->post['category_status'])) {
   $this->data['category_status'] = $this->request->post['category_status'];
  } else {
   $this->data['category_status'] = $this->config->get('category_status');
  }
  
  if (isset($this->request->post['category_sort_order'])) {
   $this->data['category_sort_order'] = $this->request->post['category_sort_order'];
  } else {
   $this->data['category_sort_order'] = $this->config->get('category_sort_order');
  }

  // 100223 ALNAUA Site redesign Begin
  if (isset($this->request->post['category_expand'])) {
   $this->data['category_expand'] = $this->request->post['category_expand'];
  } else {
   $this->data['category_expand'] = $this->config->get('category_expand');
  }

  if (isset($this->request->post['category_display_on_home'])) {
   $this->data['category_display_on_home'] = $this->request->post['category_display_on_home'];
  } else {
   $this->data['category_display_on_home'] = $this->config->get('category_display_on_home');
  }
  // 100223 ALNAUA Site redesign End
  // 140404 ET-140404 Begin
  $category_spliter_before = unserialize($this->config->get('category_spliter_before'));
  
  if (isset($this->request->post['category_spliter_before'])) {
   $this->data['category_spliter_before'] = $this->request->post['category_spliter_before'];
  } elseif (isset($category_spliter_before)) {
   $this->data['category_spliter_before'] = $category_spliter_before;
  } else {
   $this->data['category_spliter_before'] = array();
  }
  // 140404 ET-140404 End
  
  $this->template = 'module/category.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }
 
 private function validate() {
  if (!$this->user->hasPermission('modify', 'module/category')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }
  
  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  } 
 }
}
?>
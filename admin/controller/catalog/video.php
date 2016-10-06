<?php 
class ControllerCatalogVideo extends Controller {
 private $error = array();
 
 public function index() {
  $this->load->language('catalog/video');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/video');
   
  $this->getList();
 }

 public function insert() {
  $this->load->language('catalog/video');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/video');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();
   
   $this->model_catalog_video->addVideo(array_merge($this->request->post, $data));

   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/video'));
  }

  $this->getForm();
 }

 public function update() {
  $this->load->language('catalog/video');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/video');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();

   $this->model_catalog_video->editVideo($this->request->get['video_id'], array_merge($this->request->post, $data));
   
   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/video'));
  }

  $this->getForm();
 }

 public function delete() {
  $this->load->language('catalog/video');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/video');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $video_id) {
    $this->model_catalog_video->deleteVideo($video_id);
   }

   $this->session->data['success'] = $this->language->get('text_success');

   $this->redirect($this->url->https('catalog/video'));
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
         'href'      => $this->url->https('catalog/video'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
         
  $this->data['insert'] = $this->url->https('catalog/video/insert');
  $this->data['delete'] = $this->url->https('catalog/video/delete');
  
  $this->data['videos'] = array();
  
  $results = $this->model_catalog_video->getVideos();

  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('catalog/video/update&video_id=' . $result['video_id'])
   );
     
   $this->data['videos'][] = array(
    'video_id' => $result['video_id'],
    'name'        => $result['name'],
    'sort_order'  => $result['sort_order'],
    'selected'    => isset($this->request->post['selected']) && in_array($result['video_id'], $this->request->post['selected']),
    'action'      => $action
   );
  }
  
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_no_results'] = $this->language->get('text_no_results');

  $this->data['column_name'] = $this->language->get('column_name');
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
  
  $this->template = 'catalog/video_list.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function getForm() {
  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_none'] = $this->language->get('text_none');
  
  $this->data['entry_name'] = $this->language->get('entry_name');
  $this->data['entry_video_code'] = $this->language->get('entry_video_code');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_general'] = $this->language->get('tab_general');

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
         'href'      => $this->url->https('catalog/video'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
  
  if (!isset($this->request->get['video_id'])) {
   $this->data['action'] = $this->url->https('catalog/video/insert');
  } else {
   $this->data['action'] = $this->url->https('catalog/video/update&video_id=' . $this->request->get['video_id']);
  }
  
  $this->data['cancel'] = $this->url->https('catalog/video');

  if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
        $video_info = $this->model_catalog_video->getVideo($this->request->get['video_id']);
     }
  
  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();

  if (isset($this->request->post['video_description'])) {
   $this->data['video_description'] = $this->request->post['video_description'];
  } elseif (isset($video_info)) {
   $this->data['video_description'] = $this->model_catalog_video->getVideoDescriptions($this->request->get['video_id']);
  } else {
   $this->data['video_description'] = array();
  }
  
  if (isset($this->request->post['video_code'])) {
   $this->data['video_code'] = $this->request->post['video_code'];
  } elseif (isset($video_info)) {
   $this->data['video_code'] = $video_info['video_code'];
  } else {
   $this->data['video_code'] = '';
  }
  
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (isset($video_info)) {
   $this->data['sort_order'] = $video_info['sort_order'];
  } else {
   $this->data['sort_order'] = 0;
  }
  
  $this->template = 'catalog/video_form.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validateForm() {
  if (!$this->user->hasPermission('modify', 'catalog/video')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  foreach ($this->request->post['video_description'] as $language_id => $value) {
   if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 255)) {
    $this->error['name'][$language_id] = $this->language->get('error_name');
   }
  }

  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

 private function validateDelete() {
  if (!$this->user->hasPermission('modify', 'catalog/video')) {
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
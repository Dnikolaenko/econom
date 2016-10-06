<?php 
class ControllerDesignBanner extends Controller {
 private $error = array();
 
 public function index() {
  $this->load->language('design/banner');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('design/banner');
  
  $this->getList();
 }

 public function insert() {
  $this->load->language('design/banner');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('design/banner');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $this->model_design_banner->addBanner($this->request->post);
   
   $this->session->data['success'] = $this->language->get('text_success');

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
   
   
   $this->redirect($this->url->https('design/banner' . $url));
  }

  $this->getForm();
 }

 public function update() {
  $this->load->language('design/banner');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('design/banner');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {   
   $this->model_design_banner->editBanner($this->request->get['banner_id'], $this->request->post);

   $this->session->data['success'] = $this->language->get('text_success');

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
     
   $this->redirect($this->url->https('design/banner' . $url));
  }

  $this->getForm();
 }
 
 public function delete() {
  $this->load->language('design/banner');
 
  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('design/banner');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $banner_id) {
    $this->model_design_banner->deleteBanner($banner_id);
   }
   
   $this->session->data['success'] = $this->language->get('text_success');

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

   $this->redirect($this->url->https('design/banner' . $url));
  }

  $this->getList();
 }

 private function getList() {
  if (isset($this->request->get['sort'])) {
   $sort = $this->request->get['sort'];
  } else {
   $sort = 'name';
  }
  
  if (isset($this->request->get['order'])) {
   $order = $this->request->get['order'];
  } else {
   $order = 'ASC';
  }
  
  if (isset($this->request->get['page'])) {
   $page = $this->request->get['page'];
  } else {
   $page = 1;
  }
   
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
    
    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'text'      => $this->language->get('text_home'),
         'href'      => $this->url->https('common/home'),
         'separator' => false
     );

     $this->document->breadcrumbs[] = array(
         'text'      => $this->language->get('heading_title'),
         'href'      => $this->url->https('design/banner' . $url),
         'separator' => ' :: '
     );
  
  $this->data['insert'] = $this->url->https('design/banner/insert' . $url);
  $this->data['delete'] = $this->url->https('design/banner/delete' . $url);
   
  $this->data['banners'] = array();

  $data = array(
   'sort'  => $sort,
   'order' => $order,
   'start' => ($page - 1) * $this->config->get('config_admin_limit'),
   'limit' => $this->config->get('config_admin_limit')
  );
  
  $banner_total = $this->model_design_banner->getTotalBanners();
  
  $results = $this->model_design_banner->getBanners($data);
  
  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('design/banner/update' . '&banner_id=' . $result['banner_id'] . $url)
   );

   $this->data['banners'][] = array(
    'banner_id' => $result['banner_id'],
    'name'      => $result['name'],
    'sort_order'=> $result['sort_order'],
    'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),    
    'selected'  => isset($this->request->post['selected']) && in_array($result['banner_id'], $this->request->post['selected']),    
    'action'    => $action
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

  $url = '';

  if ($order == 'ASC') {
   $url .= '&order=DESC';
  } else {
   $url .= '&order=ASC';
  }

  if (isset($this->request->get['page'])) {
   $url .= '&page=' . $this->request->get['page'];
  }
  
  $this->data['sort_name'] = $this->url->https('design/banner' . '&sort=name' . $url);
  $this->data['sort_status'] = $this->url->https('design/banner' . '&sort=status' . $url);
  $this->data['sort_order'] = $this->url->https('design/banner' . '&sort=sort_order' . $url);
  
  
  $url = '';

  if (isset($this->request->get['sort'])) {
   $url .= '&sort=' . $this->request->get['sort'];
  }
            
  if (isset($this->request->get['order'])) {
   $url .= '&order=' . $this->request->get['order'];
  }

  $pagination = new Pagination();
  $pagination->total = $banner_total;
  $pagination->page = $page;
  $pagination->limit = 30;
  $pagination->text = $this->language->get('text_pagination');
  $pagination->url = $this->url->https('design/banner' . $url . '&page=%s');

  $this->data['pagination'] = $pagination->render();
  
  $this->data['sort'] = $sort;
  $this->data['order'] = $order;

  $this->template = 'design/banner_list.tpl';
  $this->children = array(
   'common/header',
   'common/footer'
  );
    
  //$this->response->setOutput($this->render());
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function getForm() {
  $this->data['heading_title'] = $this->language->get('heading_title');
  
  $this->data['text_enabled'] = $this->language->get('text_enabled');
  $this->data['text_disabled'] = $this->language->get('text_disabled');
  $this->data['text_default'] = $this->language->get('text_default');
  $this->data['text_image_manager'] = $this->language->get('text_image_manager');
  $this->data['text_browse'] = $this->language->get('text_browse');
  $this->data['text_clear'] = $this->language->get('text_clear');
  // 140408 ET-140408 Begin
  $this->data['text_header'] = $this->language->get('text_header');
  $this->data['text_home'] = $this->language->get('text_home');
  $this->data['text_image'] = $this->language->get('text_image');
  $this->data['text_slideshow'] = $this->language->get('text_slideshow');
  // 140408 ET-140408 End
    
  $this->data['entry_name'] = $this->language->get('entry_name');
  $this->data['entry_title'] = $this->language->get('entry_title');
  $this->data['entry_link'] = $this->language->get('entry_link');
  $this->data['entry_image'] = $this->language->get('entry_image');  
  $this->data['entry_status'] = $this->language->get('entry_status');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  $this->data['column_s_order'] = $this->language->get('column_s_order');
  // 140408 ET-140408 Begin
  $this->data['entry_position'] = $this->language->get('entry_position');
  $this->data['entry_view_type'] = $this->language->get('entry_view_type');
  // 140408 ET-140408 End
  
  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');
  $this->data['button_add_banner'] = $this->language->get('button_add_banner');
  $this->data['button_remove'] = $this->language->get('button_remove');
  
  $this->data['tab_general'] = $this->language->get('tab_general');

  //$this->data['token'] = $this->session->data['token'];

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

   if (isset($this->error['banner_image'])) {
   $this->data['error_banner_image'] = $this->error['banner_image'];
  } else {
   $this->data['error_banner_image'] = array();
  } 
      
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

     $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->https('common/home'),
        'separator' => false
     );

     $this->document->breadcrumbs[] = array(
         'text'      => $this->language->get('heading_title'),
         'href'      => $this->url->https('design/banner' . $url),
         'separator' => ' :: '
     );
       
  if (!isset($this->request->get['banner_id'])) { 
   $this->data['action'] = $this->url->https('design/banner/insert' . $url);
  } else {
   $this->data['action'] = $this->url->https('design/banner/update' . '&banner_id=' . $this->request->get['banner_id'] . $url);
  }
  
  $this->data['cancel'] = $this->url->https('design/banner' . $url);
  
  if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
   $banner_info = $this->model_design_banner->getBanner($this->request->get['banner_id']);
  }

  if (isset($this->request->post['name'])) {
   $this->data['name'] = $this->request->post['name'];
  } elseif (!empty($banner_info)) {
   $this->data['name'] = $banner_info['name'];
  } else {
   $this->data['name'] = '';
  }
  
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (!empty($banner_info)) {
   $this->data['sort_order'] = $banner_info['sort_order'];
  } else {
   $this->data['sort_order'] = '0';
  }
  
  if (isset($this->request->post['status'])) {
   $this->data['status'] = $this->request->post['status'];
  } elseif (!empty($banner_info)) {
   $this->data['status'] = $banner_info['status'];
  } else {
   $this->data['status'] = true;
  }
  
  // 140408 ET-140408 Begin
  if (isset($this->request->post['position'])) {
   $this->data['position'] = $this->request->post['position'];
  } elseif (!empty($banner_info)) {
   $this->data['position'] = $banner_info['position'];
  } else {
   $this->data['position'] = 'h';
  }
  
  if (isset($this->request->post['view_type'])) {
   $this->data['view_type'] = $this->request->post['view_type'];
  } elseif (!empty($banner_info)) {
   $this->data['view_type'] = $banner_info['view_type'];
  } else {
   $this->data['view_type'] = 's';
  }
  // 140408 ET-140408 End

  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();
  
  //$this->load->model('tool/image');
  $this->load->helper('image');
 
  if (isset($this->request->post['banner_image'])) {
   $banner_images = $this->request->post['banner_image'];
  } elseif (isset($this->request->get['banner_id'])) {
   $banner_images = $this->model_design_banner->getBannerImages($this->request->get['banner_id']); 
  } else {
   $banner_images = array();
  }
  
  $this->data['banner_images'] = array();
  
  foreach ($banner_images as $banner_image) {
   if ($banner_image['image'] && file_exists(DIR_IMAGE . $banner_image['image'])) {
    $image = $banner_image['image'];
   } else {
    $image = 'no_image.jpg';
   }   
   
   $this->data['banner_images'][] = array(
    'banner_image_description' => $banner_image['banner_image_description'],
    'link'                     => $banner_image['link'],
    'image'                    => $image,
    'thumb'                    => image_resize($image, 100, 100),
    'sort_order'               => $banner_image['sort_order']
   ); 
  } 
 
  $this->data['no_image'] = image_resize('no_image.jpg', 100, 100);  

  $this->template = 'design/banner_form.tpl';
  $this->children = array(
   'common/header',
   'common/footer'
  );
    
  //$this->response->setOutput($this->render());
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validateForm() {
  if (!$this->user->hasPermission('modify', 'design/banner')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
   $this->error['name'] = $this->language->get('error_name');
  }
  
  if (isset($this->request->post['banner_image'])) {
   foreach ($this->request->post['banner_image'] as $banner_image_id => $banner_image) {
    foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
     if ((utf8_strlen($banner_image_description['title']) < 2) || (utf8_strlen($banner_image_description['title']) > 64)) {
      $this->error['banner_image'][$banner_image_id][$language_id] = $this->language->get('error_title'); 
     }     
    }
   } 
  }
  
  if (!$this->error) {
   return true;
  } else {
   return false;
  }
 }

 private function validateDelete() {
  if (!$this->user->hasPermission('modify', 'design/banner')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }
 
  if (!$this->error) {
   return true;
  } else {
   return false;
  }
 }
}
?>
<?php 
class ControllerCatalogCategory extends Controller { 
 private $error = array();
 
 public function index() {
  $this->load->language('catalog/category');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/category');
   
  $this->getList();
 }

 public function insert() {
  $this->load->language('catalog/category');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/category');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();
   
   if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));
    
    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }
   }

    // (+) ALNAUA 091114 (START)
    if (is_uploaded_file($this->request->files['image1']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image1']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image1']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image1']['name'])))) {
     $data['image1'] = strtolower(translite($this->request->files['image1']['name']));
    }
   }

            if (is_uploaded_file($this->request->files['image2']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image2']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image2']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image2']['name'])))) {
     $data['image2'] = strtolower(translite($this->request->files['image2']['name']));
    }
   }
            // (+) ALNAUA 091114 (FINISH)
   
   $this->model_catalog_category->addCategory(array_merge($this->request->post, $data));

   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/category')); 
  }

  $this->getForm();
 }

 public function update() {
  $this->load->language('catalog/category');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/category');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array();
   
            if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }
   }

   // (+) ALNAUA 091114 (START)
   if (is_uploaded_file($this->request->files['image1']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image1']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image1']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image1']['name'])))) {
     $data['image1'] = strtolower(translite($this->request->files['image1']['name']));
    }
   }

   if (is_uploaded_file($this->request->files['image2']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image2']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image2']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image2']['name'])))) {
     $data['image2'] = strtolower(translite($this->request->files['image2']['name']));
    }
   }
            // (+) ALNAUA 091114 (FINISH)

   $this->model_catalog_category->editCategory($this->request->get['category_id'], array_merge($this->request->post, $data));
   
   $this->session->data['success'] = $this->language->get('text_success');
   
   $this->redirect($this->url->https('catalog/category'));
  }

  $this->getForm();
 }

 public function delete() {
  $this->load->language('catalog/category');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/category');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $category_id) {
    $this->model_catalog_category->deleteCategory($category_id);
   }

   $this->session->data['success'] = $this->language->get('text_success');

   $this->redirect($this->url->https('catalog/category'));
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
         'href'      => $this->url->https('catalog/category'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
         
  $this->data['insert'] = $this->url->https('catalog/category/insert');
  $this->data['delete'] = $this->url->https('catalog/category/delete');
  
  $this->data['categories'] = array();
  
  $results = $this->model_catalog_category->getCategories(0);

  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('catalog/category/update&category_id=' . $result['category_id'])
   );
     
   $this->data['categories'][] = array(
    'category_id' => $result['category_id'],
    'name'        => $result['name'],
    'sort_order'  => $result['sort_order'],
    'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']),
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
  
  $this->template = 'catalog/category_list.tpl';
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
  $this->data['entry_keyword'] = $this->language->get('entry_keyword');
  $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
  $this->data['entry_description'] = $this->language->get('entry_description');
  // 100908 Add Category Tips Begin
  $this->data['entry_tip'] = $this->language->get('entry_tip');
  // 100908 Add Category Tips End
  // 121210 SEO optimization Begin
  $this->data['entry_bottom_description'] = $this->language->get('entry_bottom_description');
  // 121210 SEO optimization End
  $this->data['entry_category'] = $this->language->get('entry_category');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  // 100223 ALNAUA Site redesign Begin
  $this->data['entry_display_images'] = $this->language->get('entry_display_images');
  $this->data['text_yes'] = $this->language->get('text_yes');
  $this->data['text_no'] = $this->language->get('text_no');
  // 100223 ALNAUA Site redesign End
  $this->data['entry_image'] = $this->language->get('entry_image');
  // (+) ALNAUA 091114 (START)
  $this->data['entry_image1'] = $this->language->get('entry_image1');
  $this->data['entry_image2'] = $this->language->get('entry_image2');
  // (+) ALNAUA 091114 (FINISH)
  // (+) ALNAUA 100112 Tags (START)
  $this->data['entry_index_description'] = $this->language->get('entry_index_description');
  $this->data['entry_page_title'] = $this->language->get('entry_page_title');
  $this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
  // (+) ALNAUA 100112 Tags (FINISH)
  // 101028 ALNAUA Export To Yandex Begin
  $this->data['entry_yml_export'] = $this->language->get('entry_yml_export');
  $this->data['entry_yandex_export'] = $this->language->get('entry_yandex_export');
  // 101028 ALNAUA Export To Yandex End
  // 110816 ET-110816 Category Tree Begin
  $this->data['entry_expanded'] = $this->language->get('entry_expanded');
  // 110816 ET-110816 Category Tree End
  // 120902 ET-120828 External links to categories Begin
  $this->data['entry_external'] = $this->language->get('entry_external');
  $this->data['entry_external_link'] = $this->language->get('entry_external_link');
  // 120902 ET-120828 External links to categories End
  // 121210 SEO optimization Begin
  $this->data['entry_hide'] = $this->language->get('entry_hide');
  // 121210 SEO optimization End
  // 140413 ET-140413 End
  $this->data['entry_installation_percent'] = $this->language->get('entry_installation_percent');
  $this->data['entry_installation_threshold'] = $this->language->get('entry_installation_threshold');
  $this->data['entry_update_product_installation'] = $this->language->get('entry_update_product_installation');
  // 140413 ET-140413 End
  
  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_general'] = $this->language->get('tab_general');
  $this->data['tab_data'] = $this->language->get('tab_data');
  // 140413 ET-140413 Begin
  $this->data['tab_installation'] = $this->language->get('tab_installation');
  // 140413 ET-140413 End

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

  // (+) ALNAUA 100112 Tags (START)
  if (isset($this->error['index_description'])) {
   $this->data['error_index_description'] = $this->error['index_description'];
  } else {
   $this->data['error_index_description'] = '';
  }
  // (+) ALNAUA 100112 Tags (FINISH)

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('catalog/category'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
  
  if (!isset($this->request->get['category_id'])) {
   $this->data['action'] = $this->url->https('catalog/category/insert');
  } else {
   $this->data['action'] = $this->url->https('catalog/category/update&category_id=' . $this->request->get['category_id']);
  }
  
  $this->data['cancel'] = $this->url->https('catalog/category');

  if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
        $category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
                }
  
  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();

  if (isset($this->request->post['category_description'])) {
   $this->data['category_description'] = $this->request->post['category_description'];
  } elseif (isset($category_info)) {
   $this->data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
  } else {
   $this->data['category_description'] = array();
  }

  if (isset($this->request->post['keyword'])) {
   $this->data['keyword'] = $this->request->post['keyword'];
  } elseif (isset($category_info)) {
   $this->data['keyword'] = $category_info['keyword'];
  } else {
   $this->data['keyword'] = '';
  }
  
  $this->data['categories'] = $this->model_catalog_category->getCategories(0);

  if (isset($this->request->post['parent_id'])) {
   $this->data['parent_id'] = $this->request->post['parent_id'];
  } elseif (isset($category_info)) {
   $this->data['parent_id'] = $category_info['parent_id'];
  } else {
   $this->data['parent_id'] = 0;
  }

  // 100223 ALNAUA Site redesign Begin
  if (isset($this->request->post['display_images'])) {
   $this->data['display_images'] = $this->request->post['display_images'];
  } elseif (isset($category_info)) {
   $this->data['display_images'] = $category_info['display_images'];
  } else {
   $this->data['display_images'] = 1;
  }
  // 100223 ALNAUA Site redesign End

  $this->load->helper('image');

  if (isset($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
   $this->data['preview'] = image_resize($category_info['image'], 100, 100);
  } else {
   $this->data['preview'] = image_resize('no_image.jpg', 100, 100);
  }

  // (+) ALNAUA 091114 (START)
  if (isset($category_info) && $category_info['image1'] && file_exists(DIR_IMAGE . $category_info['image1'])) {
   $this->data['preview1'] = image_resize($category_info['image1'], 100, 100);
  } else {
   $this->data['preview1'] = image_resize('no_image.jpg', 100, 100);
  }

  if (isset($category_info) && $category_info['image2'] && file_exists(DIR_IMAGE . $category_info['image2'])) {
   $this->data['preview2'] = image_resize($category_info['image2'], 100, 100);
  } else {
   $this->data['preview2'] = image_resize('no_image.jpg', 100, 100);
  }
  // (+) ALNAUA 091114 (FINISH)

  // 101028 ALNAUA Export To Yandex Begin
  if (isset($this->request->post['yml_export'])) {
   $this->data['yml_export'] = $this->request->post['yml_export'];
  } elseif (isset($category_info)) {
   $this->data['yml_export'] = $category_info['yml_export'];
  } else {
   $this->data['yml_export'] = 1;
  }
  if (isset($this->request->post['yandex_export'])) {
   $this->data['yandex_export'] = $this->request->post['yandex_export'];
  } elseif (isset($category_info)) {
   $this->data['yandex_export'] = $category_info['yandex_export'];
  } else {
   $this->data['yandex_export'] = 0;
  }
  // 101028 ALNAUA Export To Yandex End

  // 110816 ET-110816 Category Tree Begin
  if (isset($this->request->post['expanded'])) {
   $this->data['expanded'] = $this->request->post['expanded'];
  } elseif (isset($category_info)) {
   $this->data['expanded'] = $category_info['expanded'];
  } else {
   $this->data['expanded'] = 1;
  }
  // 110816 ET-110816 Category Tree End
  
  // 120902 ET-120828 External links to categories Begin
  if (isset($this->request->post['external'])) {
   $this->data['external'] = $this->request->post['external'];
  } elseif (isset($category_info)) {
   $this->data['external'] = $category_info['external'];
  } else {
   $this->data['external'] = 0;
  }
  
  if (isset($this->request->post['external_link'])) {
   $this->data['external_link'] = $this->request->post['external_link'];
  } elseif (isset($category_info)) {
   $this->data['external_link'] = $category_info['external_link'];
  } else {
   $this->data['external_link'] = '';
  }
  // 120902 ET-120828 External links to categories End
  
  // 121210 SEO optimization Begin
  if (isset($this->request->post['hide'])) {
   $this->data['hide'] = $this->request->post['hide'];
  } elseif (isset($category_info)) {
   $this->data['hide'] = $category_info['hide'];
  } else {
   $this->data['hide'] = 0;
  }
  // 121210 SEO optimization End
  
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (isset($category_info)) {
   $this->data['sort_order'] = $category_info['sort_order'];
  } else {
   $this->data['sort_order'] = 0;
  }
  
  // 140413 ET-140413 Begin
  if (isset($this->request->post['installation_percent'])) {
   $this->data['installation_percent'] = $this->request->post['installation_percent'];
  } elseif (isset($category_info)) {
   $this->data['installation_percent'] = $category_info['installation_percent'];
  } else {
   $this->data['installation_percent'] = 0;
  }
  
  if (isset($this->request->post['installation_threshold'])) {
   $this->data['installation_threshold'] = $this->request->post['installation_threshold'];
  } elseif (isset($category_info)) {
   $this->data['installation_threshold'] = $category_info['installation_threshold'];
  } else {
   $this->data['installation_threshold'] = 0;
  }
  // 140413 ET-140413 End
  
  $this->template = 'catalog/category_form.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validateForm() {
  if (!$this->user->hasPermission('modify', 'catalog/category')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  foreach ($this->request->post['category_description'] as $language_id => $value) {
   if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 80)) {
    $this->error['name'][$language_id] = $this->language->get('error_name');
   }
            if ((strlen(utf8_decode($value['index_description'])) < 2) || (strlen(utf8_decode($value['index_description'])) > 128)) {
    $this->error['index_description'][$language_id] = $this->language->get('error_index_description');
   }
  }
   
    if ($this->request->files['image']['name']) {
     if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }
            // 100129 ALNAUA Home Page change, add product sorting, block russian filename upload Begin
            // если есть недопустимые символы, то выводим ошибку
            //if (preg_match("~[ˆa-zA-Z0-9_\.-]~", utf8_decode($this->request->files['image']['name']))) {
            //  $this->error['warning'] = $this->language->get('error_filename');
            //}
            // 100129 ALNAUA Home Page change, add product sorting, block russian filename upload End

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

        // (+) ALNAUA 091114 (START)
        if ($this->request->files['image1']['name']) {
     if ((strlen(utf8_decode($this->request->files['image1']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image1']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );

   if (!in_array($this->request->files['image1']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['image1']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['image1']['error']);
   }
  }

        if ($this->request->files['image2']['name']) {
     if ((strlen(utf8_decode($this->request->files['image2']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image2']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }
            // 100129 ALNAUA Home Page change, add product sorting, block russian filename upload Begin
            // если есть недопустимые символы, то выводим ошибку
            //if (preg_match("~[ˆa-zA-Z0-9_\.-]~", $this->request->files['image2']['name'])) {
            //  $this->error['warning'] = $this->language->get('error_filename');
            //}
            // 100129 ALNAUA Home Page change, add product sorting, block russian filename upload End

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );

   if (!in_array($this->request->files['image2']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['image2']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['image2']['error']);
   }
  }
        // (+) ALNAUA 091114 (FINISH)

  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

 private function validateDelete() {
  if (!$this->user->hasPermission('modify', 'catalog/category')) {
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
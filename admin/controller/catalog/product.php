<?php 
class ControllerCatalogProduct extends Controller {
 private $error = array(); 
     
  public function index() {
   $this->load->language('catalog/product');

   $this->document->title = $this->language->get('heading_title'); 

   $this->load->model('catalog/product');
   $this->load->model('catalog/category');

   $this->getList();
  }
  
  public function insert() {
   $this->load->language('catalog/product');

   $this->document->title = $this->language->get('heading_title'); 

   $this->load->model('catalog/product');
  
   if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    $data = array();
   
   if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));
    
    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }   
   }
   
   if (isset($this->request->files['product_image'])) {
    foreach (array_keys($this->request->files['product_image']['name']) as $key) {
     if (is_uploaded_file($this->request->files['product_image']['tmp_name'][$key]) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
      move_uploaded_file($this->request->files['product_image']['tmp_name'][$key], DIR_IMAGE . strtolower(translite($this->request->files['product_image']['name'][$key])));
      
      if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['product_image']['name'][$key])))) {
       $data['product_image'][] = strtolower(translite($this->request->files['product_image']['name'][$key]));
      }
     }
    }
   }
   
   
   $this->model_catalog_product->addProduct(array_merge($this->request->post, $data));
     
   $this->session->data['success'] = $this->language->get('text_success');
   
   $url = '';
   
   if (isset($this->request->get['filter_name'])) {
    $url .= '&filter_name=' . $this->request->get['filter_name'];
   }
  
   if (isset($this->request->get['filter_model'])) {
    $url .= '&filter_model=' . $this->request->get['filter_model'];
   }
   
   if (isset($this->request->get['filter_quantity'])) {
    $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
   }
   
   if (isset($this->request->get['filter_status'])) {
    $url .= '&filter_status=' . $this->request->get['filter_status'];
   }

   // 101030 ALNAUA Add Category Filter To Product List Begin
   if (isset($this->request->get['filter_category'])) {
       $url .= '&filter_category=' . $this->request->get['filter_category'];
   }
   // 101030 ALNAUA Add Category Filter To Product List End
     
   if (isset($this->request->get['page'])) {
    $url .= '&page=' . $this->request->get['page'];
   }

   if (isset($this->request->get['sort'])) {
    $url .= '&sort=' . $this->request->get['sort'];
   }

   if (isset($this->request->get['order'])) {
    $url .= '&order=' . $this->request->get['order'];
   }
   
   $this->redirect($this->url->https('catalog/product' . $url));
  }

  $this->getForm();
 }

 public function update() {
   $this->load->language('catalog/product');
     //var_dump($this->request);

   $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/product');
 
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $data = array(); 
   
   if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])));
    
    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['image']['name'])))) {
     $data['image'] = strtolower(translite($this->request->files['image']['name']));
    }   
   }
 
   if (isset($this->request->files['product_image'])) {
    foreach (array_keys($this->request->files['product_image']['name']) as $key) {
     if (is_uploaded_file($this->request->files['product_image']['tmp_name'][$key]) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
      move_uploaded_file($this->request->files['product_image']['tmp_name'][$key], DIR_IMAGE . strtolower(translite($this->request->files['product_image']['name'][$key])));
      
      if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['product_image']['name'][$key])))) {
       $data['product_image'][] = strtolower(translite($this->request->files['product_image']['name'][$key]));
      }
      
      unset($this->request->post['product_image'][$key]);
     }
    }
   }
   
   if (isset($this->request->post['product_image'])) {
    foreach (array_keys($this->request->post['product_image']) as $key) {
     $data['product_image'][] = $this->request->post['product_image'][$key];
     
     unset($this->request->post['product_image'][$key]);
    }
   } 
    
   $this->model_catalog_product->editProduct($this->request->get['product_id'], array_merge($this->request->post, $data));
   
   $this->session->data['success'] = $this->language->get('text_success');
   
   $url = '';
   
   if (isset($this->request->get['filter_name'])) {
    $url .= '&filter_name=' . $this->request->get['filter_name'];
   }
  
   if (isset($this->request->get['filter_model'])) {
    $url .= '&filter_model=' . $this->request->get['filter_model'];
   }
   
   if (isset($this->request->get['filter_quantity'])) {
    $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
   } 
  
   if (isset($this->request->get['filter_status'])) {
    $url .= '&filter_status=' . $this->request->get['filter_status'];
   }

            // 101030 ALNAUA Add Category Filter To Product List Begin
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            // 101030 ALNAUA Add Category Filter To Product List End
     
   if (isset($this->request->get['page'])) {
    $url .= '&page=' . $this->request->get['page'];
   }

   if (isset($this->request->get['sort'])) {
    $url .= '&sort=' . $this->request->get['sort'];
   }

   if (isset($this->request->get['order'])) {
    $url .= '&order=' . $this->request->get['order'];
   }
   
  $this->redirect($this->url->https('catalog/product' . $url));
  }

     $this->getForm();
   }

   public function delete() {
     $this->load->language('catalog/product');

     $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/product');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $product_id) {
    $this->model_catalog_product->deleteProduct($product_id);
     }

   $this->session->data['success'] = $this->language->get('text_success');
   
   $url = '';
   
   if (isset($this->request->get['filter_name'])) {
    $url .= '&filter_name=' . $this->request->get['filter_name'];
   }
  
   if (isset($this->request->get['filter_model'])) {
    $url .= '&filter_model=' . $this->request->get['filter_model'];
   }
   
   if (isset($this->request->get['filter_quantity'])) {
    $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
   } 
  
   if (isset($this->request->get['filter_status'])) {
    $url .= '&filter_status=' . $this->request->get['filter_status'];
   }
     
   if (isset($this->request->get['page'])) {
    $url .= '&page=' . $this->request->get['page'];
   }

   if (isset($this->request->get['sort'])) {
    $url .= '&sort=' . $this->request->get['sort'];
   }

   if (isset($this->request->get['order'])) {
    $url .= '&order=' . $this->request->get['order'];
   }
   
   $this->redirect($this->url->https('catalog/product' . $url));
  }

     $this->getList();
   }

   private function getList() {    
  if (isset($this->request->get['page'])) {
   $page = $this->request->get['page'];
  } else {
   $page = 1;
  }
  
  if (isset($this->request->get['sort'])) {
   $sort = $this->request->get['sort'];
  } else {
            // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
   //$sort = 'pd.name';
            $sort = 'category_sort_order, p.sort_order, pd.name';
            // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  }
  
  if (isset($this->request->get['order'])) {
   $order = $this->request->get['order'];
  } else {
   $order = 'ASC';
  }

  if (isset($this->request->get['filter_name'])) {
   $filter_name = $this->request->get['filter_name'];
  } else {
   $filter_name = NULL;
  }

  if (isset($this->request->get['filter_model'])) {
   $filter_model = $this->request->get['filter_model'];
  } else {
   $filter_model = NULL;
  }

  if (isset($this->request->get['filter_quantity'])) {
   $filter_quantity = $this->request->get['filter_quantity'];
  } else {
   $filter_quantity = NULL;
  }

  if (isset($this->request->get['filter_status'])) {
   $filter_status = $this->request->get['filter_status'];
  } else {
   $filter_status = NULL;
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($this->request->get['filter_category'])) {
   $filter_category = $this->request->get['filter_category'];
  } else {
   $filter_category = NULL;
  }
        // 101030 ALNAUA Add Category Filter To Product List End
  
  $url = '';
      
  if (isset($this->request->get['filter_name'])) {
   $url .= '&filter_name=' . $this->request->get['filter_name'];
  }
  
  if (isset($this->request->get['filter_model'])) {
   $url .= '&filter_model=' . $this->request->get['filter_model'];
  }
  
  if (isset($this->request->get['filter_quantity'])) {
   $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
  }  

  if (isset($this->request->get['filter_status'])) {
   $url .= '&filter_status=' . $this->request->get['filter_status'];
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($this->request->get['filter_category'])) {
   $url .= '&filter_category=' . $this->request->get['filter_category'];
  }
        // 101030 ALNAUA Add Category Filter To Product List End
      
  if (isset($this->request->get['page'])) {
   $url .= '&page=' . $this->request->get['page'];
  }
  
  if (isset($this->request->get['sort'])) {
   $url .= '&sort=' . $this->request->get['sort'];
  }

  if (isset($this->request->get['order'])) {
   $url .= '&order=' . $this->request->get['order'];
  }

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('catalog/product' . $url),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
    
  $this->data['insert'] = $this->url->https('catalog/product/insert' . $url);
  $this->data['delete'] = $this->url->https('catalog/product/delete' . $url);

        // 101030 ALNAUA Add Category Filter To Product List Begin
        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategoriesFilter(0);

        foreach ($categories as $category) {
          $this->data['categories'][] = array(
             'category_id' => $category['category_id'],
             'name' => $category['name']
          );
        }
        // 101030 ALNAUA Add Category Filter To Product List End
          
     $this->data['products'] = array();

  $data = array(
   'filter_name'   => $filter_name, 
   'filter_model'   => $filter_model,
   'filter_quantity' => $filter_quantity,
   'filter_status'   => $filter_status,
            // 101030 ALNAUA Add Category Filter To Product List Begin
            'filter_category'   => $filter_category,
            // 101030 ALNAUA Add Category Filter To Product List End
   'sort'            => $sort,
   'order'           => $order,
   'start'           => ($page - 1) * 30,
   'limit'           => 30
  );
  
  $product_total = $this->model_catalog_product->getTotalProducts($data);
   
  $results = $this->model_catalog_product->getProducts($data);
       //var_dump($results);
         
  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('catalog/product/update&product_id=' . $result['product_id'] . $url)
   );

            // 100223 ALNAUA Site redesign Begin
            $action[] = array(
    'text' => $this->language->get('text_copy'),
                'href' => $this->url->https('catalog/product/copy&product_id=' . $result['product_id'] . $url)
   );
            // 100223 ALNAUA Site redesign End
   
        $this->data['products'][] = array(
    'product_id' => $result['product_id'],
    'name'       => $result['name'],
    'model'      => $result['model'],
    'quantity'   => $result['quantity'],
                'price'      => $result['price'],
                'nds'        => $result['nds'],
                // 100531 ALNAUA Add sborka to list Begin
                'sborka'     => $result['sborka'],
                // 100531 ALNAUA Add sborka to list End
    'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
                'sort_order' => $result['sort_order'],
                // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
    'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
    'action'     => $action
   );
     }
  
  $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_none'] = $this->language->get('text_none');

  $this->data['text_enabled'] = $this->language->get('text_enabled');
  $this->data['text_disabled'] = $this->language->get('text_disabled');
  $this->data['text_no_results'] = $this->language->get('text_no_results');

  $this->data['column_name'] = $this->language->get('column_name');
     $this->data['column_model'] = $this->language->get('column_model');
  $this->data['column_quantity'] = $this->language->get('column_quantity');
  $this->data['column_status'] = $this->language->get('column_status');
  $this->data['column_action'] = $this->language->get('column_action');
        // (+) ALNAUA 091114 (START)
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_nds'] = $this->language->get('column_nds');
        // (+) ALNAUA 091114 (FINISH)
        // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
        $this->data['column_sort_order'] = $this->language->get('column_sort_order');
        // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
        // 100531 ALNAUA Add sborka to list Begin
        $this->data['column_sborka'] = $this->language->get('column_sborka');
        // 100531 ALNAUA Add sborka to list End

  $this->data['button_insert'] = $this->language->get('button_insert');
  $this->data['button_delete'] = $this->language->get('button_delete');
  $this->data['button_filter'] = $this->language->get('button_filter');
 
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

  if (isset($this->request->get['filter_name'])) {
   $url .= '&filter_name=' . $this->request->get['filter_name'];
  }
  
  if (isset($this->request->get['filter_model'])) {
   $url .= '&filter_model=' . $this->request->get['filter_model'];
  }
  
  if (isset($this->request->get['filter_quantity'])) {
   $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
  }
  
  if (isset($this->request->get['filter_status'])) {
   $url .= '&filter_status=' . $this->request->get['filter_status'];
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($this->request->get['filter_category'])) {
   $url .= '&filter_category=' . $this->request->get['filter_category'];
  }
        // 101030 ALNAUA Add Category Filter To Product List End
        
  if ($order == 'ASC') {
   $url .= '&order=' .  'DESC';
  } else {
   $url .= '&order=' .  'ASC';
  }

  if (isset($this->request->get['page'])) {
   $url .= '&page=' . $this->request->get['page'];
  }
     
  $this->data['sort_name'] = $this->url->https('catalog/product&sort=pd.name' . $url);
  $this->data['sort_model'] = $this->url->https('catalog/product&sort=pd.model' . $url);
  $this->data['sort_quantity'] = $this->url->https('catalog/product&sort=p.quantity' . $url);
  $this->data['sort_status'] = $this->url->https('catalog/product&sort=p.status' . $url);
  $this->data['sort_order'] = $this->url->https('catalog/product&sort=p.sort_order' . $url);
  
  $url = '';

  if (isset($this->request->get['filter_name'])) {
   $url .= '&filter_name=' . $this->request->get['filter_name'];
  }
  
  if (isset($this->request->get['filter_model'])) {
   $url .= '&filter_model=' . $this->request->get['filter_model'];
  }
  
  if (isset($this->request->get['filter_quantity'])) {
   $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
  }

  if (isset($this->request->get['filter_status'])) {
   $url .= '&filter_status=' . $this->request->get['filter_status'];
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($this->request->get['filter_category'])) {
   $url .= '&filter_category=' . $this->request->get['filter_category'];
  }
        // 101030 ALNAUA Add Category Filter To Product List End

  if (isset($this->request->get['sort'])) {
   $url .= '&sort=' . $this->request->get['sort'];
  }
            
  if (isset($this->request->get['order'])) {
   $url .= '&order=' . $this->request->get['order'];
  }
    
  $pagination = new Pagination();
  $pagination->total = $product_total;
  $pagination->page = $page;
  $pagination->limit = 30;
  $pagination->text = $this->language->get('text_pagination');
  $pagination->url = $this->url->https('catalog/product' . $url . '&page=%s');
   
  $this->data['pagination'] = $pagination->render();
 
  $this->data['filter_name'] = $filter_name;
  $this->data['filter_model'] = $filter_model;
  $this->data['filter_quantity'] = $filter_quantity;
  $this->data['filter_status'] = $filter_status;
  // 101030 ALNAUA Add Category Filter To Product List Begin
  $this->data['filter_category'] = $filter_category;
  // 101030 ALNAUA Add Category Filter To Product List End
  
  $this->data['sort'] = $sort;
  $this->data['order'] = $order;
  
  //var_dump($this->request);
  $this->template = 'catalog/product_list.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
   }

   private function getForm() {
     $this->data['heading_title'] = $this->language->get('heading_title');
 
     $this->data['text_enabled'] = $this->language->get('text_enabled');
     $this->data['text_disabled'] = $this->language->get('text_disabled');
     $this->data['text_none'] = $this->language->get('text_none');
     $this->data['text_yes'] = $this->language->get('text_yes');
     $this->data['text_no'] = $this->language->get('text_no');
     $this->data['text_plus'] = $this->language->get('text_plus');
     $this->data['text_minus'] = $this->language->get('text_minus');
     // 100604 ALNAUA Add Color Group Colors to Attributes Begin
     $this->data['text_select'] = $this->language->get('text_select');
     $this->data['text_loading'] = $this->language->get('text_loading');
     // 100604 ALNAUA Add Color Group Colors to Attributes End

     $this->data['entry_name'] = $this->language->get('entry_name');
     $this->data['entry_keyword'] = $this->language->get('entry_keyword');
     $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
     $this->data['entry_description'] = $this->language->get('entry_description');
     // 100223 ALNAUA Site redesign Begin
     $this->data['entry_advanced_description'] = $this->language->get('entry_advanced_description');
     // 100223 ALNAUA Site redesign End
     $this->data['entry_model'] = $this->language->get('entry_model');
     $this->data['entry_sku'] = $this->language->get('entry_sku');
     $this->data['entry_location'] = $this->language->get('entry_location');
     $this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
     $this->data['entry_shipping'] = $this->language->get('entry_shipping');
     // 100128 ALNAUA Product Banner Flag Begin
     $this->data['entry_random_display'] = $this->language->get('entry_random_display');
     // 100128 ALNAUA Product Banner Flag End
     $this->data['entry_date_available'] = $this->language->get('entry_date_available');
     $this->data['entry_quantity'] = $this->language->get('entry_quantity');
     $this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
     $this->data['entry_status'] = $this->language->get('entry_status');
     $this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
     // 100426 Prepayment Invoice Begin
     $this->data['entry_prepayment'] = $this->language->get('entry_prepayment');
     // 100426 Prepayment Invoice End
     // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
     $this->data['entry_use_in_order_discount'] = $this->language->get('entry_use_in_order_discount');
     // 100708 ALNAUA Add prepayment and use in order discount to product and order product End
     // 101115 Add icon layers to products images Begin
     $this->data['entry_is_24_hour_delivery'] = $this->language->get('entry_is_24_hour_delivery');
     $this->data['entry_is_new_item'] = $this->language->get('entry_is_new_item');
     // 101115 Add icon layers to products images End
     $this->data['entry_price'] = $this->language->get('entry_price');
     $this->data['entry_special'] = $this->language->get('entry_special');  
     $this->data['entry_power'] = $this->language->get('entry_power');
     $this->data['entry_nds'] = $this->language->get('entry_nds');
     // (+) ALNAUA 091114 (START)
     $this->data['entry_sborka'] = $this->language->get('entry_sborka');
     // (+) ALNAUA 091114 (FINISH)
     // 20120204 ALNAUA ET-111227 Begin
     $this->data['entry_credit'] = $this->language->get('entry_credit');
     // 20120204 ALNAUA ET-111227 End
     // 130829 ET-130808 Begin
     $this->data['entry_show_min_price_warranty'] = $this->language->get('entry_show_min_price_warranty');
     // 130829 ET-130808 End
     // 130829 ET-130815 Begin
     $this->data['entry_is_5_days_delivery'] = $this->language->get('entry_is_5_days_delivery');
     // 130829 ET-130815 End
     // ET-150223 Begin
     $this->data['entry_min_order_qty'] = $this->language->get('entry_min_order_qty');
     // ET-150223 End
     $this->data['entry_subtract'] = $this->language->get('entry_subtract');
     $this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
     $this->data['entry_weight'] = $this->language->get('entry_weight');
     $this->data['entry_dimension'] = $this->language->get('entry_dimension');
     $this->data['entry_measurement'] = $this->language->get('entry_measurement');
     $this->data['entry_image'] = $this->language->get('entry_image');
     $this->data['entry_download'] = $this->language->get('entry_download');
     $this->data['entry_category'] = $this->language->get('entry_category');
     $this->data['entry_related'] = $this->language->get('entry_related');
     // 130415 ET-130411 Begin
     $this->data['entry_video'] = $this->language->get('entry_video');
     // 130415 ET-130411 End
     $this->data['entry_option'] = $this->language->get('entry_option');
      // 100223 ALNAUA Site redesign Begin
      $this->data['entry_color_option'] = $this->language->get('entry_color_option');
      // 100223 ALNAUA Site redesign End
     $this->data['entry_option_value'] = $this->language->get('entry_option_value');
     $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
     $this->data['entry_prefix'] = $this->language->get('entry_prefix');
     $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
     $this->data['entry_date_start'] = $this->language->get('entry_date_start');
     $this->data['entry_date_end'] = $this->language->get('entry_date_end');
     $this->data['entry_priority'] = $this->language->get('entry_priority');
     // (+) ALNAUA 091114 (START)
     $this->data['entry_techparam'] = $this->language->get('entry_techparam');
     $this->data['entry_techparam_measurement'] = $this->language->get('entry_techparam_measurement');
     $this->data['entry_techparam_value'] = $this->language->get('entry_techparam_value');
     // (+) ALNAUA 091114 (FINISH)
     // (+) ALNAUA 100112 Tags (START)
     $this->data['entry_page_title'] = $this->language->get('entry_page_title');
     $this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
     // (+) ALNAUA 100112 Tags (FINISH)
     // 100223 ALNAUA Site redesign Begin
     $this->data['entry_serial_no'] = $this->language->get('entry_serial_no');
     // 100223 ALNAUA Site redesign End
  
     $this->data['button_save'] = $this->language->get('button_save');
     $this->data['button_cancel'] = $this->language->get('button_cancel');
     $this->data['button_add_option'] = $this->language->get('button_add_option');
     $this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
     $this->data['button_add_discount'] = $this->language->get('button_add_discount');
     $this->data['button_add_special'] = $this->language->get('button_add_special');
     $this->data['button_add_image'] = $this->language->get('button_add_image');
     $this->data['button_remove'] = $this->language->get('button_remove');
     // (+) ALNAUA 091114 (START)
     $this->data['button_add_techparam'] = $this->language->get('button_add_techparam');
     // (+) ALNAUA 091114 (FINISH)
     // 100604 ALNAUA Add Color Group Colors to Attributes Begin
     $this->data['button_add_option_value_group_color'] = $this->language->get('button_add_option_value_group_color');
     // 100604 ALNAUA Add Color Group Colors to Attributes End
  
     $this->data['tab_general'] = $this->language->get('tab_general');
     $this->data['tab_data'] = $this->language->get('tab_data');
     $this->data['tab_discount'] = $this->language->get('tab_discount');
     $this->data['tab_special'] = $this->language->get('tab_special');
     $this->data['tab_option'] = $this->language->get('tab_option');
     // (+) ALNAUA 091114 (START)
     $this->data['tab_techparam'] = $this->language->get('tab_techparam');
     // (+) ALNAUA 091114 (FINISH)
     $this->data['tab_image'] = $this->language->get('tab_image');
 
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

   if (isset($this->error['meta_description'])) {
   $this->data['error_meta_description'] = $this->error['meta_description'];
  } else {
   $this->data['error_meta_description'] = '';
  }  
   
  if (isset($this->error['description'])) {
   $this->data['error_description'] = $this->error['description'];
  } else {
   $this->data['error_description'] = '';
  } 
  
     if (isset($this->error['model'])) {
   $this->data['error_model'] = $this->error['model'];
  } else {
   $this->data['error_model'] = '';
  }  
      
  if (isset($this->error['date_available'])) {
   $this->data['error_date_available'] = $this->error['date_available'];
  } else {
   $this->data['error_date_available'] = '';
  } 

  $url = '';

  if (isset($this->request->get['filter_name'])) {
   $url .= '&filter_name=' . $this->request->get['filter_name'];
  }
  
  if (isset($this->request->get['filter_model'])) {
   $url .= '&filter_model=' . $this->request->get['filter_model'];
  }
  
  if (isset($this->request->get['filter_quantity'])) {
   $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
  } 
  
  if (isset($this->request->get['filter_status'])) {
   $url .= '&filter_status=' . $this->request->get['filter_status'];
  }

        // 101030 ALNAUA Add Category Filter To Product List Begin
        if (isset($this->request->get['filter_category'])) {
   $url .= '&filter_category=' . $this->request->get['filter_category'];
  }
        // 101030 ALNAUA Add Category Filter To Product List End
        
  if (isset($this->request->get['page'])) {
   $url .= '&page=' . $this->request->get['page'];
  }
  
  if (isset($this->request->get['sort'])) {
   $url .= '&sort=' . $this->request->get['sort'];
  }

  if (isset($this->request->get['order'])) {
   $url .= '&order=' . $this->request->get['order'];
  }

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
   'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('catalog/product' . $url),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );

  // 100223 ALNAUA Site redesign Begin
  //if (!isset($this->request->get['product_id'])) {
  if (!isset($this->request->get['product_id']) && $this->method != "copy") {
  // 100223 ALNAUA Site redesign End
   $this->data['action'] = $this->url->https('catalog/product/insert' . $url);
        // 100223 ALNAUA Site redesign Begin
        } elseif ($this->method == "copy") {
   $this->data['action'] = $this->url->https('catalog/product/copy' . $url);
        // 100223 ALNAUA Site redesign End
  } else {
   $this->data['action'] = $this->url->https('catalog/product/update&product_id=' . $this->request->get['product_id'] . $url);
    //$this->data['action'] = $this->url->https('catalog/product'. $url);
  }
  
  $this->data['cancel'] = $this->url->https('catalog/product' . $url);

  if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] = 'POST')) {
        $product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
     }
  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();
  
  if (isset($this->request->post['product_description'])) {
   $this->data['product_description'] = $this->request->post['product_description'];
  } elseif (isset($product_info)) {
   $this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
  } else {
   $this->data['product_description'] = array();
  }

  if (isset($this->request->post['serial_no'])) {
        $this->data['serial_no'] = $this->request->post['serial_no'];
     } elseif (isset($product_info)) {
   $this->data['serial_no'] = $product_info['serial_no'];
  } else {
        $this->data['serial_no'] = '';
     }
//  if (isset($this->request->post['model'])) {
//        $this->data['model'] = $this->request->post['model'];
//     } elseif (isset($product_info)) {
//   $this->data['model'] = $product_info['model'];
//  } else {
//        $this->data['model'] = '';
//     }

//  if (isset($this->request->post['sku'])) {
//        $this->data['sku'] = $this->request->post['sku'];
//     } elseif (isset($product_info)) {
//   $this->data['sku'] = $product_info['sku'];
//  } else {
//        $this->data['sku'] = '.';
//     }
//
//  if (isset($this->request->post['location'])) {
//        $this->data['location'] = $this->request->post['location'];
//     } elseif (isset($product_info)) {
//   $this->data['location'] = $product_info['location'];
//  } else {
//        $this->data['location'] = '';
//     }

  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (isset($product_info)) {
   $this->data['sort_order'] = $product_info['sort_order'];
  } else {
   $this->data['sort_order'] = 0;
  }
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  
  if (isset($this->request->post['keyword'])) {
   $this->data['keyword'] = $this->request->post['keyword'];
  } elseif (isset($product_info)) {
   $this->data['keyword'] = $product_info['keyword'];
  } else {
   $this->data['keyword'] = '';
  }
  
  $this->load->helper('image');
  
  if (isset($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
   $this->data['preview'] = image_resize($product_info['image'], 100, 100);
  } else {
   $this->data['preview'] = image_resize('no_image.jpg', 100, 100);
  }
 
  $this->load->model('catalog/manufacturer');

  $this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

  if (isset($this->request->post['manufacturer_id'])) {
     $this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
  } elseif (isset($product_info)) {
   $this->data['manufacturer_id'] = $product_info['manufacturer_id'];
  } else {
        $this->data['manufacturer_id'] = 1;
     }
  
     if (isset($this->request->post['shipping'])) {
        $this->data['shipping'] = $this->request->post['shipping'];
     } elseif (isset($product_info)) {
        $this->data['shipping'] = $product_info['shipping'];
     } else {
   $this->data['shipping'] = 1;
  }

    // 100128 ALNAUA Product Banner Flag Begin
    if (isset($this->request->post['random_display'])) {
        $this->data['random_display'] = $this->request->post['random_display'];
     } elseif (isset($product_info)) {
        $this->data['random_display'] = $product_info['random_display'];
     } else {
   $this->data['random_display'] = 0;
  }
  // 100128 ALNAUA Product Banner Flag End
       
  if (isset($this->request->post['date_available'])) {
         $this->data['date_available'] = $this->request->post['date_available'];
  } elseif (isset($product_info)) {
   $this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
  } else {
   $this->data['date_available'] = date('Y-m-d', time());
  }
           
//     if (isset($this->request->post['quantity'])) {
//        $this->data['quantity'] = $this->request->post['quantity'];
//     } elseif (isset($product_info)) {
//        $this->data['quantity'] = $product_info['quantity'];
//     } else {
//   $this->data['quantity'] = 1;
//  }

  $this->load->model('localisation/stock_status');
  
  $this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
     
  if (isset($this->request->post['stock_status_id'])) {
        $this->data['stock_status_id'] = $this->request->post['stock_status_id'];
     } else if (isset($product_info)) {
        $this->data['stock_status_id'] = $product_info['stock_status_id'];
     } else {
   $this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
  }
  
     if (isset($this->request->post['price'])) {
        $this->data['price'] = $this->request->post['price'];
     } else if (isset($product_info)) {
        $this->data['price'] = $product_info['price'];
     } else {
        $this->data['price'] = '';
     }

       if (isset($this->request->post['special'])) {
           $this->data['special'] = $this->request->post['special'];
       } else if (isset($product_info)) {
           $this->data['special'] = $product_info['special'];
       } else {
           $this->data['special'] = '';
       }

       if (isset($this->request->post['power'])) {
           $this->data['power'] = $this->request->post['power'];
       } else if (isset($product_info)) {
           $this->data['power'] = $product_info['power'];
       } else {
           $this->data['power'] = 1;
       }

       if (isset($this->request->post['nds'])) {
           $this->data['nds'] = $this->request->post['nds'];
       } else if (isset($product_info)) {
           $this->data['nds'] = $product_info['nds'];
       } else {
           $this->data['nds'] = 1;
       }

       //var_dump($this->data);
       //var_dump($this->data['nds']);
       //var_dump($product_info);
       //var_dump($this->data['power']);

  // (+) ALNAUA 091114 (START)
  if (isset($this->request->post['sborka'])) {
  $this->data['sborka'] = $this->request->post['sborka'];
  } else if (isset($product_info)) {
   $this->data['sborka'] = $product_info['sborka'];
  } else {
   // ET-150725 Begin
   //$this->data['sborka'] = '';
   $this->data['sborka'] = 0.01;
   // ET-150725 End
  }
  // (+) ALNAUA 091114 (FINISH)
  
  // 20120204 ALNAUA ET-111227 Begin
  $this->load->model('catalog/credit');
  
  $this->data['credits'] = $this->model_catalog_credit->getCredits();
  
  if (isset($this->request->post['credit_id'])) {
   $this->data['credit_id'] = $this->request->post['credit_id'];
  } else if (isset($product_info)) {
   $this->data['credit_id'] = $product_info['credit_id'];
  } else {
   $this->data['credit_id'] = $this->config->get('config_default_credit_id');
  }
  // 20120204 ALNAUA ET-111227 End

  if (isset($this->request->post['status'])) {
     $this->data['status'] = $this->request->post['status'];
  } else if (isset($product_info)) {
   $this->data['status'] = $product_info['status'];
  } else {
      $this->data['status'] = 1;
  }
  
  $this->load->model('localisation/tax_class');
  
  $this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
     
  if (isset($this->request->post['tax_class_id'])) {
        $this->data['tax_class_id'] = $this->request->post['tax_class_id'];
     } else if (isset($product_info)) {
   $this->data['tax_class_id'] = $product_info['tax_class_id'];
  } else {
        $this->data['tax_class_id'] = 0;
     }

        // 100426 Prepayment Invoice Begin
        if (isset($this->request->post['prepayment'])) {
        $this->data['prepayment'] = $this->request->post['prepayment'];
     } else if (isset($product_info)) {
   $this->data['prepayment'] = $product_info['prepayment'];
  } else {
        $this->data['prepayment'] = 50;
     }
        // 100426 Prepayment Invoice End

        // 100708 ALNAUA Add prepayment and use in order discount to product and order product Begin
        if (isset($this->request->post['use_in_order_discount'])) {
        $this->data['use_in_order_discount'] = $this->request->post['use_in_order_discount'];
     } else if (isset($product_info)) {
   $this->data['use_in_order_discount'] = $product_info['use_in_order_discount'];
  } else {
        $this->data['use_in_order_discount'] = 1;
     }
        // 100708 ALNAUA Add prepayment and use in order discount to product and order product End

        // 101115 Add icon layers to products images Begin
        if (isset($this->request->post['is_24_hour_delivery'])) {
        $this->data['is_24_hour_delivery'] = $this->request->post['is_24_hour_delivery'];
     } else if (isset($product_info)) {
   $this->data['is_24_hour_delivery'] = $product_info['is_24_hour_delivery'];
  } else {
        $this->data['is_24_hour_delivery'] = 1;
     }

  if (isset($this->request->post['is_new_item'])) {
    $this->data['is_new_item'] = $this->request->post['is_new_item'];
  } else if (isset($product_info)) {
    $this->data['is_new_item'] = $product_info['is_new_item'];
  } else {
    $this->data['is_new_item'] = 1;
  }
  // 101115 Add icon layers to products images End
  
  // 130829 ET-130808 Begin
  if (isset($this->request->post['show_min_price_warranty'])) {
    $this->data['show_min_price_warranty'] = $this->request->post['show_min_price_warranty'];
  } else if (isset($product_info)) {
    $this->data['show_min_price_warranty'] = $product_info['show_min_price_warranty'];
  } else {
    $this->data['show_min_price_warranty'] = 0;
  }
  // 130829 ET-130808 End

  // 130829 ET-130815 Begin
  if (isset($this->request->post['is_5_days_delivery'])) {
    $this->data['is_5_days_delivery'] = $this->request->post['is_5_days_delivery'];
  } else if (isset($product_info)) {
   $this->data['is_5_days_delivery'] = $product_info['is_5_days_delivery'];
  } else {
    $this->data['is_5_days_delivery'] = 0;
  }
  // 130829 ET-130815 End

  // ET-150223 Begin
  if (isset($this->request->post['min_order_qty'])) {
   $this->data['min_order_qty'] = $this->request->post['min_order_qty'];
  } else if (isset($product_info)) {
   $this->data['min_order_qty'] = $product_info['min_order_qty'];
  } else {
   $this->data['min_order_qty'] = 1;
  }
  // ET-150223 End


//     if (isset($this->request->post['weight'])) {
//        $this->data['weight'] = $this->request->post['weight'];
//  } else if (isset($product_info)) {
//   $this->data['weight'] = $product_info['weight'];
//     } else {
//        $this->data['weight'] = '';
//     }
  
//  $this->load->model('localisation/weight_class');
//
//  $this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
//
//  if (isset($this->request->post['weight_class_id'])) {
//        $this->data['weight_class_id'] = $this->request->post['weight_class_id'];
//     } elseif (isset($product_info)) {
//        $this->data['weight_class_id'] = $product_info['weight_class_id'];
//     } else {
//        $this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
//     }
//
//  if (isset($this->request->post['length'])) {
//        $this->data['length'] = $this->request->post['length'];
//     } elseif (isset($product_info)) {
//   $this->data['length'] = $product_info['length'];
//  } else {
//        $this->data['length'] = '';
//     }
//
//  if (isset($this->request->post['width'])) {
//        $this->data['width'] = $this->request->post['width'];
//  } elseif (isset($product_info)) {
//   $this->data['width'] = $product_info['width'];
//     } else {
//        $this->data['width'] = '';
//     }
//
//  if (isset($this->request->post['height'])) {
//        $this->data['height'] = $this->request->post['height'];
//  } elseif (isset($product_info)) {
//   $this->data['height'] = $product_info['height'];
//     } else {
//        $this->data['height'] = '';
//     }

  $this->load->model('localisation/measurement_class');

  $this->data['measurement_classes'] = $this->model_localisation_measurement_class->getMeasurementClasses();

  if (isset($this->request->post['measurement_class_id'])) {
        $this->data['measurement_class_id'] = $this->request->post['measurement_class_id'];
     } elseif (isset($product_info)) {
        $this->data['measurement_class_id'] = $product_info['measurement_class_id'];
     } else {
        $this->data['measurement_class_id'] = $this->config->get('config_measurement_class_id');
     }
  
  if (isset($this->request->post['product_option'])) {
   $this->data['product_options'] = $this->request->post['product_option'];
  } elseif (isset($product_info)) {
   $this->data['product_options'] = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
  } else {
   $this->data['product_options'] = array();
  }
  
  $this->load->model('customer/customer_group');
  
  $this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
  
//  if (isset($this->request->post['product_discount'])) {
//   $this->data['product_discounts'] = $this->request->post['product_discount'];
//  } elseif (isset($product_info)) {
//   $this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
//  } else {
//   $this->data['product_discounts'] = array();
//  }
//
//  if (isset($this->request->post['product_special'])) {
//   $this->data['product_specials'] = $this->request->post['product_special'];
//  } elseif (isset($product_info)) {
//   $this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
//  } else {
//   $this->data['product_specials'] = array();
//  }
  
  $this->data['no_image'] = image_resize('no_image.jpg', 100, 100);
  
//  $this->data['product_images'] = array();
//
//  if (isset($product_info)) {
//   $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
//
//   foreach ($results as $result) {
//    if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
//     $this->data['product_images'][] = array(
//      'preview' => image_resize($result['image'], 100, 100),#
//      'file'    => $result['image']
//     );
//    } else {
//     $this->data['product_images'][] = array(
//      'preview' => image_resize('no_image.jpg', 100, 100),
//      'file'    => $result['image']
//     );
//    }
//   }
//  }

  $this->load->model('catalog/download');
  
  $this->data['downloads'] = $this->model_catalog_download->getDownloads();
  
  if (isset($this->request->post['product_download'])) {
   $this->data['product_download'] = $this->request->post['product_download'];
  } elseif (isset($product_info)) {
   $this->data['product_download'] = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
  } else {
   $this->data['product_download'] = array();
  }  
  
  $this->load->model('catalog/category');
    
  $this->data['categories'] = $this->model_catalog_category->getCategories(0);
  
  if (isset($this->request->post['product_category'])) {
   $this->data['product_category'] = $this->request->post['product_category'];
  } elseif (isset($product_info)) {
   $this->data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
  } else {
   $this->data['product_category'] = array();
  }
  
   if (isset($this->request->post['product_related'])) {
   $this->data['product_related'] = $this->request->post['product_related'];
  } elseif (isset($product_info)) {
   $this->data['product_related'] = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
  } else {
   $this->data['product_related'] = array();
        }

  // (+) ALNAUA 091114 (START)
  $this->load->model('catalog/color');

  // 100223 ALNAUA Site redesign Begin
  //$this->data['colors'] = $this->model_catalog_color->getColors();
  $this->data['colors'] = $this->model_catalog_color->getColorsAndCategories();
  $this->data['colors_lang'] = $this->model_catalog_color->getColorsAndCategoriesAllLang();
  // 100223 ALNAUA Site redesign End

  // 100604 ALNAUA Add Color Group Colors to Attributes Begin
  $this->load->model('catalog/colorcategory');

  $this->data['color_categories'] = $this->model_catalog_colorcategory->getColorCategories();
  // 100604 ALNAUA Add Color Group Colors to Attributes End

  $this->load->model('catalog/techparam');

  $this->data['techparams'] = $this->model_catalog_techparam->getTechParams();

  if (isset($this->request->post['product_techparam'])) {
   $this->data['product_techparams'] = $this->request->post['product_techparam'];
  } elseif (isset($product_info)) {
   $this->data['product_techparams'] = $this->model_catalog_product->getProductTechParams($this->request->get['product_id']);
  } else {
   $this->data['product_techparams'] = array();
  }
  // (+) ALNAUA 091114 (FINISH)
  
  // 130415 ET-130411 End
  $this->load->model('catalog/video');
  
  $this->data['videos'] = $this->model_catalog_video->getVideos();
  
  if (isset($this->request->post['product_video'])) {
   $this->data['product_video'] = $this->request->post['product_video'];
  } elseif (isset($product_info)) {
   $this->data['product_video'] = $this->model_catalog_product->getProductVideos($this->request->get['product_id']);
  } else {
   $this->data['product_video'] = array();
  }
  // 130415 ET-130411 End
   // if($this->request->post){
     // var_dump($this->url->https('catalog/product' . $url));
   // $this->data['action'] = $this->url->https('catalog/product'. $url);     
     // header('Location: '.$this->url->https('catalog/product' . $url));     
  //  }
  
  $this->template = 'catalog/product_form.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
   } 
 
   private function validateForm() { 
     if (!$this->user->hasPermission('modify', 'catalog/product')) {
        $this->error['warning'] = $this->language->get('error_permission');
     }

        if (!isset($this->request->post['product_description'])) {
          return FALSE;
        }

     foreach ($this->request->post['product_description'] as $language_id => $value) {
        if ((strlen(utf8_decode($value['name'])) < 3) || (strlen(utf8_decode($value['name'])) > 255)) {
          $this->error['name'][$language_id] = $this->language->get('error_name');
        }
            // (+) ALNAUA 091114 (START)
            if ((strlen(utf8_decode($value['model'])) < 3) || (strlen(utf8_decode($value['model'])) > 64)) {
          $this->error['model'][$language_id] = $this->language->get('error_model');
        }
            // (+) ALNAUA 091114 (FINISH)
     }
//     if ((strlen(utf8_decode($this->request->post['model'])) < 3) || (strlen(utf8_decode($this->request->post['model'])) > 64)) {
//        $this->error['model'] = $this->language->get('error_model');
//     }
  
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
  
  if (isset($this->request->files['product_image'])) {
   foreach (array_keys($this->request->files['product_image']['name']) as $key) {
    if ($this->request->files['product_image']['name'][$key]) {
     if ((strlen(utf8_decode($this->request->files['product_image']['name'][$key])) < 3) || (strlen(utf8_decode($this->request->files['product_image']['name'][$key])) > 255)) {
      $this->error['warning'] = $this->language->get('error_filename');
     }
 
     $allowed = array(
      'image/jpeg',
      'image/pjpeg',
      'image/png',
      'image/x-png',
      'image/gif'
     );
      
     if (!in_array($this->request->files['product_image']['type'][$key], $allowed)) {
      $this->error['warning'] = $this->language->get('error_filetype');
     }
     
     if (!is_writable(DIR_IMAGE)) {
      $this->error['warning'] = $this->language->get('error_writable_image');
     }
     
     if (!is_writable(DIR_IMAGE . 'cache/')) {
      $this->error['warning'] = $this->language->get('error_writable_image_cache');
     }
     
     if ($this->request->files['product_image']['error'][$key] != UPLOAD_ERR_OK) { 
      $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['product_image']['error'][$key]);
     } 
    }
   }
  }
  
     if (!$this->error) {
        return TRUE;
     } else {
        return FALSE;
     }
   }

 public function category() {
  $this->load->model('catalog/product');
  
  if (isset($this->request->get['category_id'])) {
   $category_id = $this->request->get['category_id'];
  } else {
   $category_id = 0;
  }
  
  $product_data = array();
  
  $results = $this->model_catalog_product->getProductsByCategoryId($category_id);
  
  foreach ($results as $result) {
   $product_data[] = array(
    'product_id' => $result['product_id'],
    'name'       => $result['name']
   );
  }
  
  $this->load->library('json');
  
  $this->response->setOutput(Json::encode($product_data));
 }
 
 public function related() {
  $this->load->model('catalog/product');
  
  if (isset($this->request->post['product_related'])) {
   $products = $this->request->post['product_related'];
  } else {
   $products = array();
  }
 
  $product_data = array();
  
  foreach ($products as $product_id) {
   $product_info = $this->model_catalog_product->getProduct($product_id);
   
   if ($product_info) {
    $product_data[] = array(
     'product_id' => $product_info['product_id'],
     'name'       => $product_info['name']
    );
   }
  }
  
  $this->load->library('json');
  
  $this->response->setOutput(Json::encode($product_data));
 }
    // ET-151217 Begin
    public function sales() {
        $this->load->model('catalog/product');

        if (isset($this->request->post['sales_products'])) {
            $products = $this->request->post['sales_products'];
        } else {
            $products = array();
        }

        $product_data = array();

        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                $product_data[] = array(
                    'product_id' => $product_info['product_id'],
                    'name'       => $product_info['name']
                );
            }
        }

        $this->load->library('json');

        $this->response->setOutput(Json::encode($product_data));
    }
    // ET-151217 End
 
   private function validateDelete() {
     if (!$this->user->hasPermission('modify', 'catalog/product')) {
        $this->error['warning'] = $this->language->get('error_permission');  
     }
  
  if (!$this->error) {
     return TRUE;
  } else {
     return FALSE;
  }
   }

    // 100223 ALNAUA Site redesign Begin
    public function copy() {
  $this->method = "copy";
  $this->insert();
 }

    public function getcolordesc() {

        if (isset($this->request->get['language_id'])) {
            $language_id = $this->request->get['language_id'];
        } else {
            return '';
        }

        if (isset($this->request->get['color_id'])) {
            $product_color = $this->request->get['color_id'];
        } else {
            return '';
        }
        
        $this->load->model('catalog/color');
        
        $color = $this->model_catalog_color->getColorAndCategoryByLang($product_color, $language_id);

        $output = ($color['category_name'] != '' ? $color['category_name']. ' -> ' : '') . $color['name'];

  $this->response->setOutput($output, $this->config->get('config_compression'));
 }
    // 100223 ALNAUA Site redesign End

    // 100604 ALNAUA Add Color Group Colors to Attributes Begin
    public function ColorsByColorCategory() {
  $this->load->model('catalog/color');

  if (isset($this->request->post['colorcategory_id'])) {
   $colorcategory_id = $this->request->post['colorcategory_id'];
  } else {
   return;
  }

        $colors_data = $this->model_catalog_color->getColorsByCategoryId($colorcategory_id);

  $this->load->library('json');

  $this->response->setOutput(Json::encode($colors_data));
 }
    // 100604 ALNAUA Add Color Group Colors to Attributes End
}
?>
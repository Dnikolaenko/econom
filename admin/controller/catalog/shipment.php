<?php 
class ControllerCatalogShipment extends Controller {
 private $error = array();
 
 public function index() {
  $this->load->language('catalog/shipment');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/shipment');
  
  $this->getList();
 }

 public function insert() {
  $this->load->language('catalog/shipment');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/shipment');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
   $this->model_catalog_shipment->addShipment($this->request->post);
   
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
   
   //$this->redirect($this->url->https('catalog/shipment' . $url));
   $this->redirect($this->url->https('catalog/shipment' . $url));
  }

  $this->getForm();
 }

 public function update() {
  $this->load->language('catalog/shipment');

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/shipment');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {   
   $this->model_catalog_shipment->editShipment($this->request->get['shipment_id'], $this->request->post);

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
     
   $this->redirect($this->url->https('catalog/shipment' . $url));
  }

  $this->getForm();
 }
 
 public function delete() {
  $this->load->language('catalog/shipment');
 
  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('catalog/shipment');
  
  if (isset($this->request->post['selected']) && $this->validateDelete()) {
   foreach ($this->request->post['selected'] as $shipment_id) {
    $this->model_catalog_shipment->deleteShipment($shipment_id);
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

   $this->redirect($this->url->https('catalog/shipment' . $url));
  }

  $this->getList();
 }

 private function getList() {
  if (isset($this->request->get['sort'])) {
   $sort = $this->request->get['sort'];
  } else {
   $sort = 'sort_order';
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
         'href'      => $this->url->https('catalog/shipment' . $url),
         'separator' => ' :: '
     );
  
  $this->data['insert'] = $this->url->https('catalog/shipment/insert' . $url);
  $this->data['delete'] = $this->url->https('catalog/shipment/delete' . $url);
   
  $this->data['shipments'] = array();

  $data = array(
   'sort'  => $sort,
   'order' => $order,
   'start' => ($page - 1) * $this->config->get('config_admin_limit'),
   'limit' => $this->config->get('config_admin_limit')
  );
  
  $shipment_total = $this->model_catalog_shipment->getTotalShipments();
  
  $results = $this->model_catalog_shipment->getShipments($data);
  
  foreach ($results as $result) {
   $action = array();
   
   $action[] = array(
    'text' => $this->language->get('text_edit'),
    'href' => $this->url->https('catalog/shipment/update' . '&shipment_id=' . $result['shipment_id'] . $url)
   );

   $this->data['shipments'][] = array(
    'shipment_id' => $result['shipment_id'],
    'name'      => $result['name'],
    'sort_order'=> $result['sort_order'],
    'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),    
    'selected'  => isset($this->request->post['selected']) && in_array($result['shipment_id'], $this->request->post['selected']),    
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
  
  $this->data['sort_name'] = $this->url->https('catalog/shipment' . '&sort=name' . $url);
  $this->data['sort_status'] = $this->url->https('catalog/shipment' . '&sort=status' . $url);
  $this->data['sort_order'] = $this->url->https('catalog/shipment' . '&sort=sort_order' . $url);
  
  
  $url = '';

  if (isset($this->request->get['sort'])) {
   $url .= '&sort=' . $this->request->get['sort'];
  }
            
  if (isset($this->request->get['order'])) {
   $url .= '&order=' . $this->request->get['order'];
  }

  $pagination = new Pagination();
  $pagination->total = $shipment_total;
  $pagination->page = $page;
  $pagination->limit = 30;
  $pagination->text = $this->language->get('text_pagination');
  $pagination->url = $this->url->https('catalog/shipment' . $url . '&page=%s');

  $this->data['pagination'] = $pagination->render();
  
  $this->data['sort'] = $sort;
  $this->data['order'] = $order;

  $this->template = 'catalog/shipment_list.tpl';
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
  // 140606 ET-140606 Begin
  $this->data['text_yes'] = $this->language->get('text_yes');
  $this->data['text_no'] = $this->language->get('text_no');
  // 140606 ET-140606 End
    
  $this->data['entry_name'] = $this->language->get('entry_name');
  $this->data['entry_rates'] = $this->language->get('entry_rates');
  $this->data['entry_status'] = $this->language->get('entry_status');
  $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  // 140606 ET-140606 Begin
  $this->data['entry_door_delivery'] = $this->language->get('entry_door_delivery');
  $this->data['entry_cash_on_delivery'] = $this->language->get('entry_cash_on_delivery');
  $this->data['entry_region'] = $this->language->get('entry_region');
  $this->data['entry_city'] = $this->language->get('entry_city');
  $this->data['entry_address'] = $this->language->get('entry_address');
  $this->data['entry_phone'] = $this->language->get('entry_phone');
  $this->data['entry_map_link'] = $this->language->get('entry_map_link');
  $this->data['entry_information'] = $this->language->get('entry_information');
  $this->data['column_warehouse_paramters'] = $this->language->get('column_warehouse_paramters');
  $this->data['column_s_order'] = $this->language->get('column_s_order');
  $this->data['column_action'] = $this->language->get('column_action');
  // 140606 ET-140606 End
  
  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');
  // 140606 ET-140606 Begin
  $this->data['button_add_shipment_detail'] = $this->language->get('button_add_shipment_detail');
  $this->data['button_remove'] = $this->language->get('button_remove');
  // 140606 ET-140606 End
  
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
         'href'      => $this->url->https('catalog/shipment' . $url),
         'separator' => ' :: '
     );
       
  if (!isset($this->request->get['shipment_id'])) { 
   $this->data['action'] = $this->url->https('catalog/shipment/insert' . $url);
  } else {
   $this->data['action'] = $this->url->https('catalog/shipment/update' . '&shipment_id=' . $this->request->get['shipment_id'] . $url);
  }
  
  $this->data['cancel'] = $this->url->https('catalog/shipment' . $url);
  
  if (isset($this->request->get['shipment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
   $shipment_info = $this->model_catalog_shipment->getShipment($this->request->get['shipment_id']);
  }

  if (isset($this->request->post['name'])) {
   $this->data['name'] = $this->request->post['name'];
  } elseif (!empty($shipment_info)) {
   $this->data['name'] = $shipment_info['name'];
  } else {
   $this->data['name'] = '';
  }

  if (isset($this->request->post['rates'])) {
   $this->data['rates'] = $this->request->post['rates'];
  } elseif (!empty($shipment_info)) {
   $this->data['rates'] = $shipment_info['rates'];
  } else {
   $this->data['rates'] = '';
  }
  
  if (isset($this->request->post['sort_order'])) {
   $this->data['sort_order'] = $this->request->post['sort_order'];
  } elseif (!empty($shipment_info)) {
   $this->data['sort_order'] = $shipment_info['sort_order'];
  } else {
   $this->data['sort_order'] = '0';
  }
  
  if (isset($this->request->post['status'])) {
   $this->data['status'] = $this->request->post['status'];
  } elseif (!empty($shipment_info)) {
   $this->data['status'] = $shipment_info['status'];
  } else {
   $this->data['status'] = true;
  }
  
  // 140606 ET-140606 Begin
  if (isset($this->request->post['door_delivery'])) {
   $this->data['door_delivery'] = $this->request->post['door_delivery'];
  } elseif (!empty($shipment_info)) {
   $this->data['door_delivery'] = $shipment_info['door_delivery'];
  } else {
   $this->data['door_delivery'] = 0;
  }
  
  if (isset($this->request->post['cash_on_delivery'])) {
   $this->data['cash_on_delivery'] = $this->request->post['cash_on_delivery'];
  } elseif (!empty($shipment_info)) {
   $this->data['cash_on_delivery'] = $shipment_info['cash_on_delivery'];
  } else {
   $this->data['cash_on_delivery'] = 0;
  }
  
  if (isset($this->request->post['shipment_detail'])) {
   $shipment_details = $this->request->post['shipment_detail'];
  } elseif (isset($this->request->get['shipment_id'])) {
   $shipment_details = $this->model_catalog_shipment->getShipmentDetails($this->request->get['shipment_id']); 
  } else {
   $shipment_details = array();
  }
  
  $this->data['shipment_details'] = array();
  
  foreach ($shipment_details as $shipment_detail) {
   $this->data['shipment_details'][] = array(
    'region'      => $shipment_detail['region'],
    'city'        => $shipment_detail['city'],
    'address'     => $shipment_detail['address'],
    'phone'       => $shipment_detail['phone'],
    'map_link'    => $shipment_detail['map_link'],
    'information' => $shipment_detail['information'],
    'sort_order'  => $shipment_detail['sort_order']
   ); 
  }
  // 140606 ET-140606 End

  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();
  
  $this->load->helper('image');
  
  $this->template = 'catalog/shipment_form.tpl';
  $this->children = array(
   'common/header',
   'common/footer'
  );

  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validateForm() {
  if (!$this->user->hasPermission('modify', 'catalog/shipment')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
   $this->error['name'] = $this->language->get('error_name');
  }
  
  if (!$this->error) {
   return true;
  } else {
   return false;
  }
 }

 private function validateDelete() {
  if (!$this->user->hasPermission('modify', 'catalog/shipment')) {
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
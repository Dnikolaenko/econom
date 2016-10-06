<?php
class ControllerModuleSales extends Controller {
    private $error = array(); 
    
    public function index() {   
        $this->load->language('module/sales');

        $this->document->title = $this->language->get('heading_title');
        
        $this->load->model('setting/setting');
                
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

            if (isset($this->request->post['sales_products'])) {
                $this->request->post['sales_products'] = serialize($this->request->post['sales_products']);
            } else {
                $this->request->post['sales_products'] = serialize(array());
            }

            $this->model_setting_setting->editSetting('sales', $this->request->post);
                    
            $this->session->data['success'] = $this->language->get('text_success');
                        
            $this->redirect($this->url->https('extension/module'));
        }
                
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_left'] = $this->language->get('text_left');
        $this->data['text_right'] = $this->language->get('text_right');
        
        $this->data['entry_limit'] = $this->language->get('entry_limit');
        $this->data['entry_position'] = $this->language->get('entry_position');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_products'] = $this->language->get('entry_products');
        
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
               'href'      => $this->url->https('module/sales'),
               'text'      => $this->language->get('heading_title'),
              'separator' => ' :: '
           );
        
        $this->data['action'] = $this->url->https('module/sales');
        
        $this->data['cancel'] = $this->url->https('extension/module');

        if (isset($this->request->post['sales_limit'])) {
            $this->data['sales_limit'] = $this->request->post['sales_limit'];
        } else {
            $this->data['sales_limit'] = $this->config->get('sales_limit');
        }    
        
        if (isset($this->request->post['sales_position'])) {
            $this->data['sales_position'] = $this->request->post['sales_position'];
        } else {
            $this->data['sales_position'] = $this->config->get('sales_position');
        }
        
        if (isset($this->request->post['sales_status'])) {
            $this->data['sales_status'] = $this->request->post['sales_status'];
        } else {
            $this->data['sales_status'] = $this->config->get('sales_status');
        }
        
        if (isset($this->request->post['sales_sort_order'])) {
            $this->data['sales_sort_order'] = $this->request->post['sales_sort_order'];
        } else {
            $this->data['sales_sort_order'] = $this->config->get('sales_sort_order');
        }

        $this->load->model('catalog/category');

        $this->data['categories'] = $this->model_catalog_category->getCategories(0);

        $sales_products = unserialize($this->config->get('sales_products'));

        if (isset($this->request->post['sales_products'])) {
            $this->data['sales_products'] = $this->request->post['sales_products'];
        } elseif (isset($sales_products)) {
            $this->data['sales_products'] = $sales_products;
        } else {
            $this->data['sales_products'] = array();
        }
        
        $this->template = 'module/sales.tpl';
        $this->children = array(
            'common/header',    
            'common/footer'    
        );
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/sales')) {
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
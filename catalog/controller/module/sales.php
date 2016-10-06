<?php  
class ControllerModuleSales extends Controller {
    protected function index() {
        $this->language->load('module/sales');

          $this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->load->model('catalog/product');
        $this->load->model('tool/seo_url');
        $this->load->helper('image');
            
        $this->data['products'] = array();
        
        $results = $this->model_catalog_product->getSalesProducts($this->config->get('sales_limit'), implode(',', unserialize($this->config->get('sales_products'))));
            
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $result['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $special = FALSE;
            
            $discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
            
            if ($discount) {
                $price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            
                $special = $this->model_catalog_product->getProductSpecial($result['product_id']);
            
                if ($special) {
                    $special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
                }                        
            }
            
            $this->data['products'][] = array(                                              
                'name'    => $result['name'],
                'model'   => $result['model'],
                'price'   => $price,
                'special' => $special,
                'image'   => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
            );
        }

        if (!$this->config->get('config_customer_price')) {
            $this->data['display_price'] = TRUE;
        } elseif ($this->customer->isLogged()) {
            $this->data['display_price'] = TRUE;
        } else {
            $this->data['display_price'] = FALSE;
        }
        
        $this->id = 'sales';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/sales.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/sales.tpl';
        } else {
            $this->template = 'default/template/module/sales.tpl';
        }
        
        $this->render();
    }
}
?>
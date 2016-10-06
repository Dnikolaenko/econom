<?php
class ModelTotalOrderDiscount extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->config->get('order_discount_status')) {
			$this->load->language('total/order_discount');
			
			$total_data[] = array( 
        		'title'      => $this->language->get('text_order_discount'),
        		'text'       => $this->currency->format($this->cart->getOrderDiscount()),
        		'value'      => $this->cart->getOrderDiscount(),
		        'sort_order' => $this->config->get('order_discount_sort_order')
			);
			
			$total -= $this->cart->getOrderDiscount();
		}
	}
}
?>
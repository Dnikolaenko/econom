<?php
class ModelTotalShipment extends Model {
 public function getTotal(&$total_data, &$total, &$taxes) {
  if ($this->config->get('shipment_status')) {
   
   $this->load->language('total/shipment');
   
   if(isset($this->session->data['shipment_id'])) {
    $shipment_id = $this->session->data['shipment_id'];
    $this->load->model('checkout/shipment');
    $shipment_info = $this->model_checkout_shipment->getShipment($shipment_id);
    
    // 140606 ET-140606 Begin
    if (isset($this->session->data['shipment_detail_id']) && $this->session->data['guest']['door_delivery'] == 0) {
     $shipment_detail_id = $this->session->data['shipment_detail_id'];
     $shipment_details = $this->model_checkout_shipment->getShipmentDetails($shipment_id);
     $shipping = FALSE;
     foreach ($shipment_details as $shipment_detail) {
      if ($shipment_detail['shipment_detail_id'] === $shipment_detail_id) {
       $shipping = TRUE;
       break;
      }
     }
     if ($shipping) {
      $shipment_detail_info = $this->model_checkout_shipment->getShipmentDetail($shipment_detail_id);
     } else {
      $shipment_detail_id = 0;
     }
    } else {
     $shipment_detail_id = 0;
    }
    // 140606 ET-140606 End
   } else {
    $shipment_id = 0;
    // 140606 ET-140606 Begin
    $shipment_detail_id = 0;
    // 140606 ET-140606 End
   }
   
   $shipping_cost = $this->cart->getShipmentCost($shipment_id, $total);
   
   $total_data[] = array( 
          // 140606 ET-140606 Begin
          //'title'      => ($shipment_id > 0 ? $this->language->get('text_shipment').' - '.$shipment_info['name'].':' : $this->language->get('text_shipment').':'),
          'title'      => ($shipment_id > 0 ? $this->language->get('text_shipment').' - '.$shipment_info['name'].(($shipment_detail_id > 0) ? ' ('.($shipment_detail_info['region'].', '.$shipment_detail_info['city'].': '.$shipment_detail_info['address'].($shipment_detail_info['phone'] ? ', '.$shipment_detail_info['phone'].')' : '')) : '').':' : $this->language->get('text_shipment').':'),
          // 140606 ET-140606 End
          'text'       => $this->currency->format($shipping_cost),
          'value'      => $shipping_cost,
          'sort_order' => $this->config->get('shipment_sort_order')
   );
   
   $total += $shipping_cost;
  }
 }
}
?>
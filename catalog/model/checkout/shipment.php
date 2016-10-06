<?php
class ModelCheckoutShipment extends Model {
 public function getShipment($shipment_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shipment WHERE shipment_id = '" . (int)$shipment_id . "' AND status = '1'");
  
  return $query->row;
 }
  
 public function getShipments($data = array()) {
  $sql = "SELECT * FROM " . DB_PREFIX . "shipment WHERE status = '1'";
  
  $sort_data = array(
   'name',
   'status',
   'sort_order'
  ); 
  
  if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
   $sql .= " ORDER BY " . $data['sort']; 
  } else {
   $sql .= " ORDER BY sort_order, status"; 
  }
  
  if (isset($data['order']) && ($data['order'] == 'DESC')) {
   $sql .= " DESC";
  } else {
   $sql .= " ASC";
  }
  
  if (isset($data['start']) || isset($data['limit'])) {
   if ($data['start'] < 0) {
    $data['start'] = 0;
   }     

   if ($data['limit'] < 1) {
    $data['limit'] = 99;
   } 
  
   $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
  }  
  
  $query = $this->db->query($sql);

  return $query->rows;
 }
 
 public function getDefaultShipment() {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shipment WHERE status = '1' ORDER BY sort_order LIMIT 1");
  
  return $query->row;
 }
 // 140606 ET-140606 Begin
 public function getDefaultShipmentDetail($shipment_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shipment_detail WHERE shipment_id = '" . (int)$shipment_id . "' ORDER BY sort_order, region, city, address LIMIT 1");
  
  return $query->row;
 }
 
 public function getShipmentDetails($shipment_id) {  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shipment_detail WHERE shipment_id = '" . (int)$shipment_id . "' ORDER BY sort_order, region, city, address");
  
  return $query->rows;
 }
 
 public function getShipmentDetail($shipment_detail_id) {  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shipment_detail WHERE shipment_detail_id = '" . (int)$shipment_detail_id . "'");
  
  return $query->row;
 }
 // 140606 ET-140606 End
}
?>
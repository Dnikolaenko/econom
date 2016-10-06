<?php
class ModelCatalogShipment extends Model {
 public function addShipment($data) {
  // 140606 ET-140606 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "shipment SET name = '" . $this->db->escape($data['name']) . "', rates = '" . $this->db->escape($data['rates']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
  $this->db->query("INSERT INTO " . DB_PREFIX . "shipment SET name = '" . $this->db->escape($data['name']) . "', rates = '" . $this->db->escape($data['rates']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', door_delivery = '" . (int)$data['door_delivery'] . "', cash_on_delivery = '" . (int)$data['cash_on_delivery'] . "'");
  // 140606 ET-140606 End
 
  $shipment_id = $this->db->getLastId();
 
  // 140606 ET-140606 Begin
  if (isset($data['shipment_detail'])) {
   foreach ($data['shipment_detail'] as $shipment_detail) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "shipment_detail SET shipment_id = '" . (int)$shipment_id . "', region = '" .  $this->db->escape($shipment_detail['region']) . "', city = '" .  $this->db->escape($shipment_detail['city']) . "', address = '" .  $this->db->escape($shipment_detail['address']) . "', phone = '" .  $this->db->escape($shipment_detail['phone']) . "', map_link = '" .  $this->db->escape($shipment_detail['map_link']) . "', information = '" .  $this->db->escape($shipment_detail['information']) . "', sort_order = '" . (int)$shipment_detail['sort_order'] . "'");
   }
  }
  // 140606 ET-140606 End
 }
 
 public function editShipment($shipment_id, $data) {
  // 140606 ET-140606 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "shipment SET name = '" . $this->db->escape($data['name']) . "', rates = '" . $this->db->escape($data['rates']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE shipment_id = '" . (int)$shipment_id . "'");
  $this->db->query("UPDATE " . DB_PREFIX . "shipment SET name = '" . $this->db->escape($data['name']) . "', rates = '" . $this->db->escape($data['rates']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', door_delivery = '" . (int)$data['door_delivery'] . "', cash_on_delivery = '" . (int)$data['cash_on_delivery'] . "' WHERE shipment_id = '" . (int)$shipment_id . "'");
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "shipment_detail WHERE shipment_id = '" . (int)$shipment_id . "'");
  
  if (isset($data['shipment_detail'])) {
   foreach ($data['shipment_detail'] as $shipment_detail) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "shipment_detail SET shipment_id = '" . (int)$shipment_id . "', region = '" .  $this->db->escape($shipment_detail['region']) . "', city = '" .  $this->db->escape($shipment_detail['city']) . "', address = '" .  $this->db->escape($shipment_detail['address']) . "', phone = '" .  $this->db->escape($shipment_detail['phone']) . "', map_link = '" .  $this->db->escape($shipment_detail['map_link']) . "', information = '" .  $this->db->escape($shipment_detail['information']) . "', sort_order = '" . (int)$shipment_detail['sort_order'] . "'");
   }
  }
  // 140606 ET-140606 End
 }
 
 public function deleteShipment($shipment_id) {
  $this->db->query("DELETE FROM " . DB_PREFIX . "shipment WHERE shipment_id = '" . (int)$shipment_id . "'");
  // 140606 ET-140606 Begin
  $this->db->query("DELETE FROM " . DB_PREFIX . "shipment_detail WHERE shipment_id = '" . (int)$shipment_id . "'");
  // 140606 ET-140606 End
 }
 
 public function getShipment($shipment_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "shipment WHERE shipment_id = '" . (int)$shipment_id . "'");
  
  return $query->row;
 }
  
 public function getShipments($data = array()) {
  $sql = "SELECT * FROM " . DB_PREFIX . "shipment";
  
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
    $data['limit'] = 20;
   } 
  
   $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
  }  
  
  $query = $this->db->query($sql);

  return $query->rows;
 }
  
 public function getTotalShipments() {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shipment");
  
  return $query->row['total'];
 }
 
 // 140606 ET-140606 Begin
 public function getShipmentDetails($shipment_id) {
  $shipment_detail_data = array();
  
  $shipment_detail_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shipment_detail WHERE shipment_id = '" . (int)$shipment_id . "' ORDER BY sort_order, region, city, address");
  
  foreach ($shipment_detail_query->rows as $shipment_detail) {  
   $shipment_detail_data[] = array(
    'region'      => $shipment_detail['region'],
    'city'        => $shipment_detail['city'],
    'address'     => $shipment_detail['address'],
    'phone'       => $shipment_detail['phone'],
    'map_link'    => $shipment_detail['map_link'],
    'information'    => $shipment_detail['information'],
    'sort_order'  => $shipment_detail['sort_order']
   );
  }
  
  return $shipment_detail_data;
 }
 // 140606 ET-140606 End
}
?>
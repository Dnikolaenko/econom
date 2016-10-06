<?php
class ModelCatalogCredit extends Model {
 public function getCredit($credit_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE c.credit_id = '" . (int)$credit_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "'");
 
  return $query->row;
 }
 
 public function getCredits() {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");
 
  return $query->rows;
 }
 
 public function getEnabledCredits() {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' and status = 1 ORDER BY c.sort_order, cd.name ASC");
 
  return $query->rows;
 }
 
 public function getTotalCredits() {
  $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "credit");
  
  return $query->row['total'];
 }
 
 public function getTotalEnabledCredits() {
  $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "credit where status = 1");
  
  return $query->row['total'];
 }
}
?>
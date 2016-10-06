<?php
class ModelCatalogCredit extends Model {
 public function addCredit($data) {
  $this->db->query("INSERT INTO " . DB_PREFIX . "credit SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', image = '" . $this->db->escape($data['image']) . "'");
 
  $credit_id = $this->db->getLastId();
    
  foreach ($data['credit_description'] as $language_id => $value) {
   //$this->db->query("INSERT INTO " . DB_PREFIX . "credit_description SET credit_id = '" . (int)$credit_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "'");
   $this->db->query("INSERT INTO " . DB_PREFIX . "credit_description SET credit_id = '" . (int)$credit_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
  }
  
  //if ($data['keyword']) {
  // $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'credit_id=" . (int)$credit_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  //}
  
  $this->cache->delete('credit');
 }
 
 public function editCredit($credit_id, $data) {
  $this->db->query("UPDATE " . DB_PREFIX . "credit SET credit_id = '" . (int)$credit_id . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', image = " . (isset($data['image']) ? "'" . $this->db->escape($data['image']) . "'" : "image") . " WHERE credit_id = '" . (int)$credit_id . "'");

  $this->db->query("DELETE FROM " . DB_PREFIX . "credit_description WHERE credit_id = '" . (int)$credit_id . "'");

  foreach ($data['credit_description'] as $language_id => $value) {
   //$this->db->query("INSERT INTO " . DB_PREFIX . "credit_description SET credit_id = '" . (int)$credit_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "'");
   $this->db->query("INSERT INTO " . DB_PREFIX . "credit_description SET credit_id = '" . (int)$credit_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
  }

  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'credit_id=" . (int)$credit_id. "'");
  
  //if ($data['keyword']) {
  // $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'credit_id=" . (int)$credit_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  //}
  
  $this->cache->delete('credit');
 }
 
 public function deleteCredit($credit_id) {
  $this->db->query("DELETE FROM " . DB_PREFIX . "credit WHERE credit_id = '" . (int)$credit_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "credit_description WHERE credit_id = '" . (int)$credit_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'credit_id=" . (int)$credit_id . "'");
  
  $query = $this->db->query("SELECT credit_id FROM " . DB_PREFIX . "credit WHERE credit_id = '" . (int)$credit_id . "'");

  foreach ($query->rows as $result) {
   $this->deleteCredit($result['credit_id']);
  }
  
  $this->cache->delete('credit');
 }

 public function getCredit($credit_id) {
  $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'credit_id=" . (int)$credit_id . "') AS keyword FROM " . DB_PREFIX . "credit WHERE credit_id = '" . (int)$credit_id . "'");
  
  return $query->row;
 }
 
 public function getCreditWithDesc($credit_id) {
  $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'credit_id=" . (int)$credit_id . "') AS keyword FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE c.credit_id = '" . (int)$credit_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "'");
  
  return $query->row;
 } 
 
 public function getCredits() {
  $credit_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order ASC");

        $credit_data = $query->rows;
  
  return $credit_data;
 }
 
 public function getEnabledCredits() {
  $credit_data = array();

  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit c LEFT JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' and c.status = 1 ORDER BY c.sort_order ASC");

  $credit_data = $query->rows;
  
  return $credit_data;
 }
  
 public function getCreditDescriptions($credit_id) {
  $credit_description_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit_description WHERE credit_id = '" . (int)$credit_id . "'");
  
  foreach ($query->rows as $result) {
   $credit_description_data[$result['language_id']] = array(
    'name'             => $result['name'],
    'description'      => $result['description'],
    'page_title'       => $result['page_title'],
    'meta_description' => $result['meta_description']
   );
  }
  
  return $credit_description_data;
 } 
  
 public function getTotalCredits() {
  $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "credit");
  
  return $query->row['total'];
 }
}
?>
<?php
class ModelCatalogInformation extends Model {
 public function addInformation($data) {
  $this->db->query("INSERT INTO " . DB_PREFIX . "information SET sort_order = '" . (int)$this->request->post['sort_order'] . "', type = '" . $this->db->escape($data['type']) . "', date_added = '". $this->db->escape($data['date_added']) ."', name = '" . $this->db->escape($data['name']) . "', parent_information_id = '" . $this->db->escape($data['parent_information_id']) . "'");

  $information_id = $this->db->getLastId(); 
   
  foreach ($data['information_description'] as $language_id => $value) {
   // 100223 ALNAUA Site redesign Begin
   //$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', anons = '" . $this->db->escape($value['anons']) . "'");
   $this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', anons = '" . $this->db->escape($value['anons']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 100223 ALNAUA Site redesign End
  }

  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }
  
  $this->cache->delete('information');
 }
 
 public function editInformation($information_id, $data) {
  //$this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', type = '" . $data['type'] . "', date_added = '". $this->db->escape($data['date_added']) ."', name = '" . $this->db->escape($data['name']) . "' WHERE information_id = '" . (int)$information_id . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', type = '" . $data['type'] . "', date_added = '". $this->db->escape($data['date_added']) ."', name = '" . $this->db->escape($data['name']) . "', parent_information_id = '" . $this->db->escape($data['parent_information_id']) . "' WHERE information_id = '" . (int)$information_id . "'");

  $this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");
     
  foreach ($data['information_description'] as $language_id => $value) {
            // 100223 ALNAUA Site redesign Begin
   //$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', anons = '" . $this->db->escape($value['anons']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', anons = '" . $this->db->escape($value['anons']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
            // 100223 ALNAUA Site redesign End
  }
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id. "'");
  
  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }
  
  $this->cache->delete('information');
 }
 
 public function deleteInformation($information_id) {
  $this->db->query("DELETE FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "'");

  $this->cache->delete('information');
 } 

 public function getInformation($information_id) {
  $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id . "') AS keyword FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");
  
  return $query->row;
 }
  
 public function getInformations($data = array()) {
  if ($data) {
   $sql = "SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "'";

          if (isset($data['type'])) 
      $sql .= " AND type='" . $data['type'] . "'";
                        else 
                           $sql .= " AND type='page'";
    
   $sort_data = array(
    'id.title',
    'i.sort_order'
   );  
  
   if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
    $sql .= " ORDER BY " . $data['sort']; 
   } else {
    $sql .= " ORDER BY id.title"; 
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
  } else {
   $information_data = $this->cache->get('information.' . $this->language->getId());
  
   if (!$information_data) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' ORDER BY id.title");
 
    $information_data = $query->rows;
   
    $this->cache->set('information.' . $this->language->getId(), $information_data);
   } 
 
   return $information_data;   
  }
 }
 
 public function getInformationDescriptions($information_id) {
  $information_description_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

  foreach ($query->rows as $result) {
   $information_description_data[$result['language_id']] = array(
                'title'       => $result['title'],
                // 100223 ALNAUA Site redesign Begin
                'page_title' => $result['page_title'],
                'meta_description' => $result['meta_description'],
                'meta_keywords' => $result['meta_keywords'],
                // 100223 ALNAUA Site redesign End
    'anons'       => $result['anons'],
    'description' => $result['description']
   );
  }
  
  return $information_description_data;
 }
 
 public function getTotalInformations() {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information");
  
  return $query->row['total'];
 } 
 
 public function getTotalInformationsType($type) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information WHERE type='".$type."'");

  return $query->row['total'];
 }

    // (+) ALNAUA 091114 (START)
    public function getParentInformations() {
  //$informations_data = $this->cache->get('$information_parent.' . $this->language->getId());

  //if (!$informations_data) {
   $informations_data = array();

   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.name IS NOT NULL AND i.name != '' ORDER BY id.title");

   $informations_data = $query->rows;

  // $this->cache->set('$information_parent.' . $this->language->getId(), $informations_data);
  //}

  return $informations_data;
 }
    // (+) ALNAUA 091114 (FINISH)
}
?>
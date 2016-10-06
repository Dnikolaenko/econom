<?php
class ModelCatalogVideo extends Model {
 public function addVideo($data) {
  $this->db->query("INSERT INTO " . DB_PREFIX . "video SET video_code = '" . $this->db->escape($data['video_code']). "', sort_order = '" . (int)$data['sort_order'] . "'");
 
  $video_id = $this->db->getLastId();
  
  foreach ($data['video_description'] as $language_id => $value) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");
  }
  
  $this->cache->delete('video');
 }
 
 public function editVideo($video_id, $data) {
  $this->db->query("UPDATE " . DB_PREFIX . "video SET video_code = '" . $this->db->escape($data['video_code']). "', sort_order = '" . (int)$data['sort_order'] . "' WHERE video_id = '" . (int)$video_id . "'");

  $this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

  foreach ($data['video_description'] as $language_id => $value) {
  $this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");
  }
 
  $this->cache->delete('video');
 }
 
 public function deleteVideo($video_id) {
  $this->db->query("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_video WHERE video_id = '" . (int)$video_id . "'");

  $this->cache->delete('video');
 }

 public function getVideo($video_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
  
  return $query->row;
 } 
 
 public function getVideos() {
  $video_data = $this->cache->get('video.' . $this->language->getId());
 
  if (!$video_data) {
   $video_data = array();
  
   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video c LEFT JOIN " . DB_PREFIX . "video_description cd ON (c.video_id = cd.video_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

   $video_data = $query->rows;
 
   $this->cache->set('video.' . $this->language->getId(), $video_data);
  }
  
  return $video_data;
 }
 
 public function getVideoDescriptions($video_id) {
  $video_description_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
  
  foreach ($query->rows as $result) {
   $video_description_data[$result['language_id']] = array(
    'name'             => $result['name']
   );
  }
  
  return $video_description_data;
 } 
  
 public function getTotalVideos() {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video");
  
  return $query->row['total'];
 } 
}
?>
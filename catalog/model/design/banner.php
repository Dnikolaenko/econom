<?php
class ModelDesignBanner extends Model {
 // 140408 ET-140408 Begin
 //public function getEnabledBanners() {
 public function getHomeSlideBanners() {
  //$query = $this->db->query("SELECT b.banner_id, b.name, bi.link, bi.image, bid.title FROM " . DB_PREFIX . "banner b JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bid.language_id = '" . (int)$this->language->getId() . "' AND b.status = '1' ORDER BY b.sort_order, bi.sort_order");
  $query = $this->db->query("SELECT b.banner_id, b.name, bi.link, bi.image, bid.title FROM " . DB_PREFIX . "banner b JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE b.position = 'h' AND b.view_type = 's' AND  bid.language_id = '" . (int)$this->language->getId() . "' AND b.status = '1' ORDER BY b.sort_order, b.banner_id, bi.sort_order");
 // 140408 ET-140408 End

  return $query->rows;
 }
 
 // 140408 ET-140408 Begin
 public function getTopBanners() {
  //$query = $this->db->query("SELECT b.banner_id, b.name, bi.link, bi.image, bid.title FROM " . DB_PREFIX . "banner b JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE b.position = 't' AND  bid.language_id = '" . (int)$this->language->getId() . "' AND b.status = '1' ORDER BY b.sort_order, b.banner_id, bi.sort_order");
  $banners_data = array();
  
  $banners = $this->db->query("SELECT b.banner_id, b.name, b.position, b.view_type FROM " . DB_PREFIX . "banner b WHERE b.position = 't' AND b.status = '1' ORDER BY b.sort_order, b.banner_id");
  
  foreach ($banners->rows as $result) {
   
   $images = $this->db->query("SELECT bi.link, CONCAT('image/', bi.image) as image, bid.title FROM " . DB_PREFIX . "banner b JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE b.banner_id = '" . (int)$result['banner_id'] . "' AND b.position = 't' AND  bid.language_id = '" . (int)$this->language->getId() . "' AND b.status = '1' ORDER BY b.sort_order, b.banner_id, bi.sort_order");
   
   $banners_data[] = array(
       'banner_id' => $result['banner_id'],
       'name' => $result['name'],
       'position' => $result['position'],
       'view_type' => $result['view_type'],
       'images' => $images->rows
       
   );
  }
  return $banners_data;
 }
 // 140408 ET-140408 End
}
?>
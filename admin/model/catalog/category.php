<?php
class ModelCatalogCategory extends Model {
 public function addCategory($data) {
  // 100223 ALNAUA Site redesign Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  // 101028 ALNAUA Export To Yandex Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  // 110816 ET-110816 Category Tree Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  // 120902 ET-120828 External links to categories Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  // 121210 SEO optimization Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  // 140413 ET-140413 Begin
  //$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', yandex_export = '" . (int)$data['yandex_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
  $this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', yandex_export = '" . (int)$data['yandex_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', installation_percent = '" . (float)$data['installation_percent'] . "', installation_threshold = '" . (float)$data['installation_threshold'] . "', date_modified = NOW(), date_added = NOW()");
  // 140413 ET-140413 End
  // 121210 SEO optimization End
  // 120902 ET-120828 External links to categories End
  // 110816 ET-110816 Category Tree End
  // 101028 ALNAUA Export To Yandex End
  // 100223 ALNAUA Site redesign End
 
  $category_id = $this->db->getLastId();
  
  if (isset($data['image'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }

  // (+) ALNAUA 091114 (START)
  if (isset($data['image1'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image1 = '" . $this->db->escape($data['image1']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }

  if (isset($data['image2'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image2 = '" . $this->db->escape($data['image2']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }
  // (+) ALNAUA 091114 (FINISH)
  
  foreach ($data['category_description'] as $language_id => $value) {
    // (+/-) ALNAUA 100112 Tags (START)
    //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
    // 100908 Add Category Tips Begin
    //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
    // 121210 SEO optimization Begin
    //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tip = '" . $this->db->escape($value['tip']) . "'");
    $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tip = '" . $this->db->escape($value['tip']) . "', bottom_description = '" . $this->db->escape($value['bottom_description']) . "'");
    // 121210 SEO optimization End
    // 100908 Add Category Tips End
    // (+/-) ALNAUA 100112 Tags (FINISH)
  }
  
  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }
  
  $this->cache->delete('category');
  // 101030 ALNAUA Add Category Filter To Product List Begin
  $this->cache->delete('category_filter');
  // 101030 ALNAUA Add Category Filter To Product List End
 }

 public function editCategory($category_id, $data) {
  // 100223 ALNAUA Site redesign Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 101028 ALNAUA Export To Yandex Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 110816 ET-110816 Category Tree Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 120902 ET-120828 External links to categories Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 121210 SEO optimization Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 140413 ET-140413 Begin
  //$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', yandex_export = '" . (int)$data['yandex_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  $this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', display_images = '" . (int)$data['display_images'] . "', yml_export = '" . (int)$data['yml_export'] . "', yandex_export = '" . (int)$data['yandex_export'] . "', expanded = '" . (int)$data['expanded'] . "', external = '" . (int)$data['external'] . "', external_link = '" . $this->db->escape($data['external_link']) . "', hide = '" . (int)$data['hide'] . "', sort_order = '" . (int)$data['sort_order'] . "', installation_percent = '" . (float)$data['installation_percent'] . "', installation_threshold = '" . (float)$data['installation_threshold'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
  // 140413 ET-140413 End
  // 121210 SEO optimization End
  // 120902 ET-120828 External links to categories End
  // 110816 ET-110816 Category Tree End
  // 101028 ALNAUA Export To Yandex End
  // 100223 ALNAUA Site redesign End

  if (isset($data['image'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }

  // (+) ALNAUA 091114 (START)
  if (isset($data['image1'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image1 = '" . $this->db->escape($data['image1']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }

  if (isset($data['image2'])) {
   $this->db->query("UPDATE " . DB_PREFIX . "category SET image2 = '" . $this->db->escape($data['image2']) . "' WHERE category_id = '" . (int)$category_id . "'");
  }
                // (+) ALNAUA 091114 (FINISH)

  $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

  foreach ($data['category_description'] as $language_id => $value) {
   // (+/-) ALNAUA 100112 Tags (START)
   //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
   // 100908 Add Category Tips Begin
   //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "'");
   // 121210 SEO optimization Begin
   //$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tip = '" . $this->db->escape($value['tip']) . "'");
   $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', index_description = '" . $this->db->escape($value['index_description']) . "', page_title = '" . $this->db->escape($value['page_title']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tip = '" . $this->db->escape($value['tip']) . "', bottom_description = '" . $this->db->escape($value['bottom_description']) . "'");
   // 121210 SEO optimization End
   // 100908 Add Category Tips End
   // (+/-) ALNAUA 100112 Tags (FINISH)
  }

  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");
  
  if ($data['keyword']) {
   $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
  }
  
  if ($data['update_product_installation']) {
   // ET-150725 Begin
   /*$this->db->query("UPDATE " . DB_PREFIX . "product p
                            JOIN " . DB_PREFIX . "product_installation_category_v piv
                              ON p.product_id = piv.product_id AND piv.category_id = '" . (int)$category_id . "'
                        SET p.sborka = piv.new_sborka,
                            p.date_modified = NOW()
                      WHERE p.sborka != piv.new_sborka");*/
   $this->db->query("UPDATE " . DB_PREFIX . "product p
                            JOIN " . DB_PREFIX . "product_installation_category_v piv
                              ON p.product_id = piv.product_id AND piv.category_id = '" . (int)$category_id . "'
                        SET p.sborka = piv.new_sborka,
                            p.date_modified = NOW()
                      WHERE p.sborka != piv.new_sborka
                        AND p.sborka != 0");
   // ET-150725 End
   }
  
  $this->cache->delete('category');
  // 101030 ALNAUA Add Category Filter To Product List Begin
  $this->cache->delete('category_filter');
  // 101030 ALNAUA Add Category Filter To Product List End
 }
 
  public function deleteCategory($category_id) {
    // (+) ALNAUA 091114 (START)
    $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
    foreach ($query->rows as $result) {
        if (file_exists(DIR_IMAGE . $result['image'])) {
          @unlink(DIR_IMAGE . $result['image']);
        }
        if (file_exists(DIR_IMAGE . $result['image1'])) {
          @unlink(DIR_IMAGE . $result['image1']);
        }
        if (file_exists(DIR_IMAGE . $result['image2'])) {
          @unlink(DIR_IMAGE . $result['image2']);
        }
  }
     // (+) ALNAUA 091114 (FINISH)

  $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
  
  $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'");

  foreach ($query->rows as $result) {
   $this->deleteCategory($result['category_id']);
  }
  
  $this->cache->delete('category');
  // 101030 ALNAUA Add Category Filter To Product List Begin
  $this->cache->delete('category_filter');
  // 101030 ALNAUA Add Category Filter To Product List End
 }

 public function getCategory($category_id) {
  $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
  
  return $query->row;
 } 
 
 public function getCategories($parent_id) {
  $category_data = $this->cache->get('category.' . $this->language->getId() . '.' . $parent_id);
 
  if (!$category_data) {
   $category_data = array();
  
   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");
  
   foreach ($query->rows as $result) {
    $category_data[] = array(
     'category_id' => $result['category_id'],
     'parent_id'   => $result['parent_id'],
     'name'        => $this->getPath($result['category_id']),
     'sort_order'  => $result['sort_order']
    );
   
    $category_data = array_merge($category_data, $this->getCategories($result['category_id']));
   } 
 
   $this->cache->set('category.' . $this->language->getId() . '.' . $parent_id, $category_data);
  }
  
  return $category_data;
 }
 
 public function getPath($category_id) {
  $query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");
  
  $category_info = $query->row;
  
  if ($category_info['parent_id']) {
   return $this->getPath($category_info['parent_id'], $this->language->getId()) . $this->language->get('text_separator') . $category_info['name'];
  } else {
   return $category_info['name'];
  }
 }
 
 public function getCategoryDescriptions($category_id) {
  $category_description_data = array();
  
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
  
  foreach ($query->rows as $result) {
   $category_description_data[$result['language_id']] = array(
    'name'             => $result['name'],
    'meta_description' => $result['meta_description'],
    'description'      => $result['description'],
    // 100908 Add Category Tips Begin
    'tip'              => $result['tip'],
    // 100908 Add Category Tips End
    // 121210 SEO optimization Begin
    'bottom_description' => $result['bottom_description'],
    // 121210 SEO optimization End
    // (+) ALNAUA 100112 Tags (START)
    'index_description' => $result['index_description'],
    'page_title' => $result['page_title'],
    'meta_keywords' => $result['meta_keywords']
    // (+) ALNAUA 100112 Tags (FINISH)
   );
  }
  
  return $category_description_data;
 } 
 
 public function getTotalCategories() {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");
  
  return $query->row['total'];
 }
  
 public function getTotalCategoriesByImageId($image_id) {
       $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");
  
  return $query->row['total'];
 }

 public function getCategoriesFilter($parent_id, $level = 0) {
  $category_data = $this->cache->get('category_filter.' . $this->language->getId() . '.' . $parent_id);

  if (!$category_data) {
   $category_data = array();

   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

   foreach ($query->rows as $result) {
    $category_data[] = array(
     'category_id' => $result['category_id'],
     'name'        => $this->getPathFilter($result['category_id'], $level, $this->language->getId()),
     'sort_order'  => $result['sort_order']
    );

    $category_data = array_merge($category_data, $this->getCategoriesFilter($result['category_id'], $level + 1));
   }

   $this->cache->set('category_filter.' . $this->language->getId() . '.' . $parent_id, $category_data);
  }

  return $category_data;
 }

 public function getPathFilter($category_id, $level = 0) {
  $query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

  $category_info = $query->row;

  if ($category_info['parent_id']) {
          return str_repeat('&nbsp;&nbsp;&nbsp;', $level) . $category_info['name'];
  } else {
   return $category_info['name'];
  }
 }
}
?>

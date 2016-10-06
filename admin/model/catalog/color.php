<?php
class ModelCatalogColor extends Model {
	public function addColor($data) {
        // 100223 ALNAUA Site redesign Begin
		//$this->db->query("INSERT INTO " . DB_PREFIX . "color SET sort_order = '" . (int)$data['sort_order'] . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "color SET colorcategory_id = '" . (int)$data['colorcategory_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
        // 100223 ALNAUA Site redesign End
	
		$color_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "color SET image = '" . $this->db->escape($data['image']) . "' WHERE color_id = '" . (int)$color_id . "'");
		}
		
		foreach ($data['color_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "color_description SET color_id = '" . (int)$color_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'color_id=" . (int)$color_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('color');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}
	
	public function editColor($color_id, $data) {
        // 100223 ALNAUA Site redesign Begin
		//$this->db->query("UPDATE " . DB_PREFIX . "color SET sort_order = '" . (int)$data['sort_order'] . "' WHERE color_id = '" . (int)$color_id . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "color SET colorcategory_id = '" . (int)$data['colorcategory_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE color_id = '" . (int)$color_id . "'");
        // 100223 ALNAUA Site redesign End

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "color SET image = '" . $this->db->escape($data['image']) . "' WHERE color_id = '" . (int)$color_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "color_description WHERE color_id = '" . (int)$color_id . "'");

		foreach ($data['color_description'] as $language_id => $value) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "color_description SET color_id = '" . (int)$color_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");

          // 100223 ALNAUA Site redesign Begin
          $color_category = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "colorcategory_description WHERE colorcategory_id = '" . (int)$data['colorcategory_id'] . "' AND language_id = '" . (int)$language_id . "'");
          $desc = (isset ($color_category->row['name']) ? $color_category->row['name']. ' -> ' : '').$value['name'];
          $this->db->query("UPDATE " . DB_PREFIX . "product_option_value_description SET name = '" . $this->db->escape($desc). "' WHERE product_option_value_id IN (SELECT product_option_value_id from product_option_value WHERE color_id = '" . (int)$color_id . "' AND language_id = '" . (int)$language_id . "')");
          // 100223 ALNAUA Site redesign End
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'color_id=" . (int)$color_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'color_id=" . (int)$color_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('color');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}
	
	public function deleteColor($color_id) {
        // (+) ALNAUA 091114 (START)
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "color WHERE color_id = '" . (int)$color_id . "'");
        foreach ($query->rows as $result) {
			@unlink(DIR_IMAGE . $result['image']);;
		}
        // (+) ALNAUA 091114 (FINISH)
		$this->db->query("DELETE FROM " . DB_PREFIX . "color WHERE color_id = '" . (int)$color_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "color_description WHERE color_id = '" . (int)$color_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'color_id=" . (int)$color_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id IN (SELECT product_option_value_id from product_option_value WHERE color_id = '" . (int)$color_id . "')");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE color_id = '" . (int)$color_id . "'");
		
		$this->cache->delete('color');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}

    public function getColorDescCurrLang($color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . (int)$color_id . "' AND ad.language_id = '" . (int)$this->language->getId() . "'");

		return $query->row;
	}

	public function getColor($color_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'color_id=" . (int)$color_id . "') AS keyword FROM " . DB_PREFIX . "color WHERE color_id = '" . (int)$color_id . "'");
		
		return $query->row;
	} 
	
	public function getColors() {
		$color_data = $this->cache->get('color.' . $this->language->getId());
	
		if (!$color_data) {
			$color_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

            $color_data = $query->rows;
	
			$this->cache->set('color.' . $this->language->getId(), $color_data);
		}
		
		return $color_data;
	}

	public function getColorsAndCategoriesAllLang() {
		$color_data = $this->cache->get('colorandcategoryalllang.');

		if (!$color_data) {
			$color_data = array();

			$query = $this->db->query("SELECT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) ORDER BY cc.sort_order, ccd.name, c.sort_order, cd.language_id, cd.name ASC");

            $color_data = $query->rows;

			$this->cache->set('colorandcategoryalllang.', $color_data);
		}

		return $color_data;
	}

    public function getColorsAndCategories() {
		$color_data = $this->cache->get('colorandcategory.' . $this->language->getId());

		if (!$color_data) {
			$color_data = array();

			$query = $this->db->query("SELECT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY cc.sort_order, ccd.name, c.sort_order, cd.name ASC");

            $color_data = $query->rows;

			$this->cache->set('colorandcategory.' . $this->language->getId(), $color_data);
		}

		return $color_data;
	}
	
	public function getColorDescriptions($color_id) {
		$color_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "color_description WHERE color_id = '" . (int)$color_id . "'");
		
		foreach ($query->rows as $result) {
			$color_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		
		return $color_description_data;
	}	
		
	public function getTotalColors() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "color");
		
		return $query->row['total'];
	}	
		
	public function getTotalColorsByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "color WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

    // 100223 ALNAUA Site redesign Begin
    public function getColorAndCategoryByLang($color_id, $language_id) {

      $query = $this->db->query("SELECT DISTINCT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '". (int)$color_id ."' AND cd.language_id = '" . (int)$language_id . "' ORDER BY cc.sort_order, ccd.name, c.sort_order, cd.name ASC");

      return $query->row;
	}
    // 100223 ALNAUA Site redesign End

    // 100604 ALNAUA Add Color Group Colors to Attributes Begin
    public function getColorsByCategoryId($colorcategory_id) {

      $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color c WHERE c.colorcategory_id = '". (int)$colorcategory_id ."' ORDER BY c.sort_order ASC");

      return $query->rows;
	}
    // 100604 ALNAUA Add Color Group Colors to Attributes End
}
?>
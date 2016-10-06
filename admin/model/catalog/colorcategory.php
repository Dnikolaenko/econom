<?php
class ModelCatalogColorcategory extends Model {
	public function addColorCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "colorcategory SET sort_order = '" . (int)$data['sort_order'] . "'");
	
		$colorcategory_id = $this->db->getLastId();
				
		foreach ($data['colorcategory_description'] as $language_id => $value) {
            // 100611 ALNAUA Add Color Group Tips Begin
			//$this->db->query("INSERT INTO " . DB_PREFIX . "colorcategory_description SET colorcategory_id = '" . (int)$colorcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "colorcategory_description SET colorcategory_id = '" . (int)$colorcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', tip = '" . $this->db->escape($value['tip']) . "'");
            // 100611 ALNAUA Add Color Group Tips End
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'colorcategory_id=" . (int)$colorcategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('colorcategory');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}
	
	public function editColorCategory($colorcategory_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "colorcategory SET sort_order = '" . (int)$data['sort_order'] . "' WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "colorcategory_description WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");

		foreach ($data['colorcategory_description'] as $language_id => $value) {
            // 100611 ALNAUA Add Color Group Tips Begin
			//$this->db->query("INSERT INTO " . DB_PREFIX . "colorcategory_description SET colorcategory_id = '" . (int)$colorcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "colorcategory_description SET colorcategory_id = '" . (int)$colorcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', tip = '" . $this->db->escape($value['tip']) . "'");
            // 100611 ALNAUA Add Color Group Tips End

            // 100223 ALNAUA Site redesign Begin
            $colors = $this->db->query("SELECT * FROM " . DB_PREFIX . "color AS c LEFT JOIN " . DB_PREFIX . "color_description AS cd ON (c.color_id = cd.color_id) WHERE c.colorcategory_id = '".(int)$colorcategory_id."' AND cd.language_id = '" . (int)$language_id ."'");
            foreach ($colors->rows as $color) {
            //$color_category = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "colorcategory_description WHERE colorcategory_id = '" . (int)$data['colorcategory_id'] . "' AND language_id = '" . (int)$language_id . "'");
            $desc = $value['name'] . ' -> '.$color['name'];
            $this->db->query("UPDATE " . DB_PREFIX . "product_option_value_description SET name = '" . $this->db->escape($desc). "' WHERE product_option_value_id IN (SELECT product_option_value_id from product_option_value WHERE color_id = '" . (int)$color['color_id'] . "' AND language_id = '" . (int)$language_id . "')");
            }
            // 100223 ALNAUA Site redesign End
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'colorcategory_id=" . (int)$colorcategory_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'colorcategory_id=" . (int)$colorcategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('colorcategory');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}
	
	public function deleteColorCategory($colorcategory_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "colorcategory WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "colorcategory_description WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'colorcategory_id=" . (int)$colorcategory_id . "'");
		
		$this->cache->delete('colorcategory');
        $this->cache->delete('colorandcategory');
        $this->cache->delete('colorandcategoryalllang');
	}

	public function getColorCategory($colorcategory_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'colorcategory_id=" . (int)$colorcategory_id . "') AS keyword FROM " . DB_PREFIX . "colorcategory WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");
		
		return $query->row;
	} 
	
	public function getColorCategories() {
		$colorcategory_data = $this->cache->get('colorcategory.' . $this->language->getId());
	
		if (!$colorcategory_data) {
			$colorcategory_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "colorcategory c LEFT JOIN " . DB_PREFIX . "colorcategory_description cd ON (c.colorcategory_id = cd.colorcategory_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

            $colorcategory_data = $query->rows;

			$this->cache->set('colorcategory.' . $this->language->getId(), $colorcategory_data);
		}
		
		return $colorcategory_data;
	}
		
	public function getColorCategoryDescriptions($colorcategory_id) {
		$colorcategory_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "colorcategory_description WHERE colorcategory_id = '" . (int)$colorcategory_id . "'");
		
		foreach ($query->rows as $result) {
			$colorcategory_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
                // 100611 ALNAUA Add Color Group Tips Begin
                'tip'             => $result['tip'],
                // 100611 ALNAUA Add Color Group Tips End
			);
		}
		
		return $colorcategory_description_data;
    }
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "colorcategory");
		
		return $query->row['total'];
	}	
}
?>
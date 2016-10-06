<?php
class ModelCatalogAdvcategory extends Model {
	public function addAdvCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "advcategory SET sort_order = '" . (int)$data['sort_order'] . "'");
	
		$advcategory_id = $this->db->getLastId();
				
		foreach ($data['advcategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "advcategory_description SET advcategory_id = '" . (int)$advcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'advcategory_id=" . (int)$advcategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('advcategory');
	}
	
	public function editAdvCategory($advcategory_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "advcategory SET sort_order = '" . (int)$data['sort_order'] . "' WHERE advcategory_id = '" . (int)$advcategory_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "advcategory_description WHERE advcategory_id = '" . (int)$advcategory_id . "'");

		foreach ($data['advcategory_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "advcategory_description SET advcategory_id = '" . (int)$advcategory_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'advcategory_id=" . (int)$advcategory_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'advcategory_id=" . (int)$advcategory_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('advcategory');
	}
	
	public function deleteAdvCategory($advcategory_id) {
        // (+) ALNAUA 091114 (START)
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "advcategory WHERE advcategory_id = '" . (int)$advcategory_id . "'");
        foreach ($query->rows as $result) {
			@unlink(DIR_IMAGE . $result['image']);;
		}
        // (+) ALNAUA 091114 (FINISH)

		$this->db->query("DELETE FROM " . DB_PREFIX . "advcategory WHERE advcategory_id = '" . (int)$advcategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "advcategory_description WHERE advcategory_id = '" . (int)$advcategory_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'advcategory_id=" . (int)$advcategory_id . "'");
		
		$this->cache->delete('advcategory');
	}

	public function getAdvCategory($advcategory_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'advcategory_id=" . (int)$advcategory_id . "') AS keyword FROM " . DB_PREFIX . "advcategory WHERE advcategory_id = '" . (int)$advcategory_id . "'");
		
		return $query->row;
	} 
	
	public function getAdvCategories() {
		$advcategory_data = $this->cache->get('advcategory.' . $this->language->getId());
	
		if (!$advcategory_data) {
			$advcategory_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advcategory c LEFT JOIN " . DB_PREFIX . "advcategory_description cd ON (c.advcategory_id = cd.advcategory_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

            $advcategory_data = $query->rows;

			$this->cache->set('advcategory.' . $this->language->getId(), $advcategory_data);
		}
		
		return $advcategory_data;
	}
		
	public function getAdvCategoryDescriptions($advcategory_id) {
		$advcategory_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advcategory_description WHERE advcategory_id = '" . (int)$advcategory_id . "'");
		
		foreach ($query->rows as $result) {
			$advcategory_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
			);
		}
		
		return $advcategory_description_data;
	}	
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "advcategory");
		
		return $query->row['total'];
	}	
}
?>
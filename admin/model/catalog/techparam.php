<?php
class ModelCatalogTechParam extends Model {
	public function addTechParam($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "techparam SET sort_order = '" . (int)$data['sort_order'] . "'");
	
		$techparam_id = $this->db->getLastId();
		
		foreach ($data['techparam_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "techparam_description SET techparam_id = '" . (int)$techparam_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");
		}
		
		$this->cache->delete('techparam');
	}
	
	public function editTechParam($techparam_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "techparam SET sort_order = '" . (int)$data['sort_order'] . "' WHERE techparam_id = '" . (int)$techparam_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "techparam_description WHERE techparam_id = '" . (int)$techparam_id . "'");

		foreach ($data['techparam_description'] as $language_id => $value) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "techparam_description SET techparam_id = '" . (int)$techparam_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']). "'");
		}
	
		$this->cache->delete('techparam');
	}
	
	public function deleteTechParam($techparam_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "techparam WHERE techparam_id = '" . (int)$techparam_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "techparam_description WHERE techparam_id = '" . (int)$techparam_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_techparam_value WHERE techparam_id = '" . (int)$techparam_id . "'");
				
		$this->cache->delete('techparam');
	}

	public function getTechParam($techparam_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "techparam WHERE techparam_id = '" . (int)$techparam_id . "'");
		
		return $query->row;
	} 
	
	public function getTechParams() {
		$techparam_data = $this->cache->get('techparam.' . $this->language->getId());
	
		if (!$techparam_data) {
			$techparam_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "techparam c LEFT JOIN " . DB_PREFIX . "techparam_description cd ON (c.techparam_id = cd.techparam_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.sort_order, cd.name ASC");

            $techparam_data = $query->rows;
	
			$this->cache->set('techparam.' . $this->language->getId(), $techparam_data);
		}
		
		return $techparam_data;
	}
	
	public function getTechParamDescriptions($techparam_id) {
		$techparam_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "techparam_description WHERE techparam_id = '" . (int)$techparam_id . "'");
		
		foreach ($query->rows as $result) {
			$techparam_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		
		return $techparam_description_data;
	}	
		
	public function getTotalTechParams() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "techparam");
		
		return $query->row['total'];
	}	
		
//	public function getTotalTechParamsByImageId($image_id) {
//      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "techparam WHERE image_id = '" . (int)$image_id . "'");
//
//		return $query->row['total'];
//	}
}
?>
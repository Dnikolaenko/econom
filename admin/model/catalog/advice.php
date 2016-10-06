<?php
class ModelCatalogAdvice extends Model {
	public function addAdvice($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "advice SET advcategory_id = '" . (int)$data['advcategory_id'] . "', date_added = '". $this->db->escape($data['date_added']) ."'");
	
		$advice_id = $this->db->getLastId();
				
		foreach ($data['advice_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "advice_description SET advice_id = '" . (int)$advice_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'advice_id=" . (int)$advice_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('advice');
	}
	
	public function editAdvice($advice_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "advice SET advcategory_id = '" . (int)$data['advcategory_id'] . "', date_added = '". $this->db->escape($data['date_added']) ."' WHERE advice_id = '" . (int)$advice_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "advice_description WHERE advice_id = '" . (int)$advice_id . "'");

		foreach ($data['advice_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "advice_description SET advice_id = '" . (int)$advice_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'advice_id=" . (int)$advice_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'advice_id=" . (int)$advice_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('advice');
	}
	
	public function deleteAdvice($advice_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "advice WHERE advice_id = '" . (int)$advice_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "advice_description WHERE advice_id = '" . (int)$advice_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'advice_id=" . (int)$advice_id . "'");
		
		$query = $this->db->query("SELECT advice_id FROM " . DB_PREFIX . "advice WHERE advice_id = '" . (int)$advice_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteAdvice($result['advice_id']);
		}
		
		$this->cache->delete('advice');
	}

	public function getAdvice($advice_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'advice_id=" . (int)$advice_id . "') AS keyword FROM " . DB_PREFIX . "advice WHERE advice_id = '" . (int)$advice_id . "'");
		
		return $query->row;
	} 
	
	public function getAdvices() {
		$advice_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advice c LEFT JOIN " . DB_PREFIX . "advice_description cd ON (c.advice_id = cd.advice_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY c.date_added DESC, cd.name ASC");

        $advice_data = $query->rows;
		
		return $advice_data;
	}
		
	public function getAdviceDescriptions($advice_id) {
		$advice_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advice_description WHERE advice_id = '" . (int)$advice_id . "'");
		
		foreach ($query->rows as $result) {
			$advice_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $advice_description_data;
	}	
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "advice");
		
		return $query->row['total'];
	}
}
?>
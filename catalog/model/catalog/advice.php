<?php
class ModelCatalogAdvice extends Model {
	public function getAdvice($advice_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "advice a LEFT JOIN " . DB_PREFIX . "advice_description ad ON (a.advice_id = ad.advice_id) WHERE a.advice_id = '" . (int)$advice_id . "' AND ad.language_id = '" . (int)$this->language->getId() . "'");
	
		return $query->row;
	}
	
	public function getAdvices($advcategory_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advice a LEFT JOIN " . DB_PREFIX . "advice_description ad ON (a.advice_id = ad.advice_id) WHERE ad.language_id = '" . (int)$this->language->getId() . "'".($advcategory_id == 0 ? '' : " AND a.advcategory_id= '".(int)$advcategory_id."'")." ORDER BY a.date_added DESC, ad.name ASC");
		return $query->rows;
	}
}
?>
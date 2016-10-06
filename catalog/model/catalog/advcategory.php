<?php
class ModelCatalogAdvCategory extends Model {
	public function getAdvCategory($advcategory_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "advcategory a LEFT JOIN " . DB_PREFIX . "advcategory_description ad ON (a.advcategory_id = ad.advcategory_id) WHERE a.advcategory_id = '" . (int)$advcategory_id . "' AND ad.language_id = '" . (int)$this->language->getId() . "'");
	
		return $query->row;
	}
	
	public function getAdvCategories() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "advcategory a LEFT JOIN " . DB_PREFIX . "advcategory_description ad ON (a.advcategory_id = ad.advcategory_id) WHERE ad.language_id = '" . (int)$this->language->getId() . "' ORDER BY a.sort_order, ad.name ASC");
	
		return $query->rows;
	}
}
?>
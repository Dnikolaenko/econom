<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
	
		return $query->row;	
	}
	
	public function getManufacturers() {
		$manufacturer = $this->cache->get('manufacturer');
		
		if (!$manufacturer) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . " manufacturer m JOIN " . DB_PREFIX . " product p WHERE (p.manufacturer_id = m.manufacturer_id) AND p.status = 1");
	
			$manufacturer = $query->rows;
			
			$this->cache->set('manufacturer', $manufacturer);
		}
		 
		return $manufacturer;
	}

	public function getManufactures() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer ORDER BY manufacturer_id");

		return $query->rows;
	}
}
?>
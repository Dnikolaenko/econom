<?php
class ModelCatalogColor extends Model {
	public function getColor($color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . (int)$color_id . "' AND ad.language_id = '" . (int)$this->language->getId() . "'");
	
		return $query->row;
	}
	
	public function getColors() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE ad.language_id = '" . (int)$this->language->getId() . "' ORDER BY a.sort_order, ad.name ASC");
	
		return $query->rows;
	}

    // 100223 ALNAUA Site redesign Begin
    public function getColorAndCategory($color_id) {
        // 100611 ALNAUA Add Color Group Tips Begin
        //$query =  $this->db->query("SELECT DISTINCT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '" . (int)$color_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "'");
        $query =  $this->db->query("SELECT DISTINCT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name, ccd.tip FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE c.color_id = '" . (int)$color_id . "' AND cd.language_id = '" . (int)$this->language->getId() . "'");
        // 100611 ALNAUA Add Color Group Tips End
		return $query->row;
	}

    public function getColorsAndCategories() {
        $query = $this->db->query("SELECT c.color_id, c.image, c.sort_order, cd.language_id, cd.name, cc.colorcategory_id, cc.sort_order as category_sort_order, ccd.name as category_name FROM " . DB_PREFIX . "color c LEFT JOIN " . DB_PREFIX . "color_description cd ON (c.color_id = cd.color_id) LEFT JOIN " . DB_PREFIX . "colorcategory cc ON (c.colorcategory_id = cc.colorcategory_id) LEFT JOIN " . DB_PREFIX . "colorcategory_description ccd ON (cc.colorcategory_id = ccd.colorcategory_id AND cd.language_id = ccd.language_id) WHERE cd.language_id = '" . (int)$this->language->getId() . "' ORDER BY cc.sort_order, ccd.name, c.sort_order, cd.name ASC");

        return $query->rows;
	}
    // 100223 ALNAUA Site redesign End
}
?>
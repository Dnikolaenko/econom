<?php 
class ModelModuleRemarket extends Model {
	public function getPrices(){
		$this->load->language('module/remarket');
		
		$query = $this->db->query("SELECT DISTINCT p.product_id, pd.name, p.price, p.special, p.image, c.category_id, c.parent_id, cd.name AS lol FROM " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id)
                                                                                                    LEFT JOIN " . DB_PREFIX . " product_to_category ptc ON (p.product_id = ptc.product_id)
                                                                                                    LEFT JOIN " . DB_PREFIX . " category c ON (c.category_id = ptc.category_id)
                                                                                                    LEFT JOIN " . DB_PREFIX . " category_description cd ON (c.category_id = cd.category_id)    
                                                                                                    WHERE pd.language_id = 2 AND p.status = 1");


        return $query->rows;
	}
        
        public function getCategories(){
            
            $query = $this->db->query("SELECT DISTINCT c.category_id, cd.name  FROM " . DB_PREFIX . " category c LEFT JOIN " . DB_PREFIX . " category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = 2");
            
            return $query->rows;
        }
	
	//public function updatePrices(){
    //   $query = $this->db->query("UPDATE product SET price = '".$prices[2]."' WHERE product_id = '".$prices[0]."'");

	//	return $query->rows;
	//}
}
?>
<?php
class ModelLocalisationLanguage extends Model {
	public function getLanguages() {
        // (-) ALNAUA 091114 (START)
		//$language_data = $this->cache->get('language');
		
		//if (!$language_data) {
        // (-) ALNAUA 091114 (FINISH)
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE status = 1 ORDER BY sort_order, name");

        foreach ($query->rows as $result) {
            $language_data[$result['language_id']] = array(
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['code'],
                'locale'      => $result['locale'],
                'image'       => $result['image'],
                'directory'   => $result['directory'],
                'filename'    => $result['filename'],
                'sort_order'  => $result['sort_order'],
                'status'      => $result['status']
            );
        }
		// (-) ALNAUA 091114 (START)
		//	$this->cache->set('language', $language_data);
		//}
        // (-) ALNAUA 091114 (FINISH)
		
		return $language_data;	
	}
}
?>
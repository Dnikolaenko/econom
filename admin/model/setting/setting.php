<?php 
class ModelSettingSetting extends Model {
	public function getSetting($group) {
		$data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			$data[$result['key']] = $result['value'];
		}
				
		return $data;
	}
	
	public function editSetting($group, $data) {
		// (-/+) ALNAUA 100120 Banner Upload (START)
        //$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "'");
        // (-/+) ALNAUA 100120 Banner Upload (FINISH)
		
		foreach ($data as $key => $value) {
            // (+) ALNAUA 100120 Banner Upload (START)
            $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
            // (+) ALNAUA 100120 Banner Upload (FINISH)
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
		}
	}
	
	public function deleteSetting($group) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "'");
	}
}
?>
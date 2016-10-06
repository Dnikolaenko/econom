<?php
class ModelCatalogQuestion extends Model {
	public function addQuestion($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "question SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', text = '" . $this->db->escape($data['text']) . "', date_added = NOW(), answer = '" . $this->db->escape($data['answer']) . "', published = '" . (int) $data['published'] . "'");

		$question_id = $this->db->getLastId(); 
			
		$this->cache->delete('question');
	}
	
	public function editQuestion($question_id, $data) {
    $this->db->query("UPDATE " . DB_PREFIX . "question SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', text = '" . $this->db->escape($data['text']) . "', date_added = '". $this->db->escape($data['date_added']) ."', answer = '" . $this->db->escape($data['answer']) . "', published = '" . (int) $data['published'] . "' WHERE question_id = ". (int) $question_id);

		$this->cache->delete('question');
	}
	
	public function deleteQuestion($question_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "question WHERE question_id = '" . (int)$question_id . "'");

		$this->cache->delete('question');
	}	

	public function getQuestion($question_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "question WHERE question_id = '" . (int)$question_id . "'");
		
		return $query->row;
	}
		
	public function getQuestions($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "question order by date_added DESC";

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
	}
	
	public function getTotalQuestions() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "question");
		
		return $query->row['total'];
	}	
	
}
?>
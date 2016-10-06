<?php 
class ModelPaymentPrivat24gs extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/privat24gs');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('privat24gs_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('privat24gs_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('privat24gs_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'privat24gs',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('privat24gs_sort_order')
			);
		}

		return $method_data;
	}
}
?>
<?php
class ModelCheckoutStoreCredit extends Model {
	public function addStoreCredit($order_id = 0, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$data['from_name'] . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($data['description']) . "', amount = '" . (float)$data['amount'] . "', date_added = NOW()");
	}
}
?>
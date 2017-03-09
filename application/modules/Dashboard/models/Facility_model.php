<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_model extends CI_Model {

	public function get_consumption_total($drugs){
		$columns = array();
		$tmp_data = array();

		$sql = "SELECT
					drug,
					CONCAT_WS('/', data_month, data_year) period,
				    SUM(total) total
				FROM vw_facility_consumption
				WHERE drug IN ?
				GROUP BY drug, period
				ORDER BY period DESC";
		$query = $this->db->query($sql, array($drugs));
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data[$result['drug']]['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$consumption_data[$counter]['name'] = $name;
			$consumption_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $consumption_data, 'columns' => array_values(array_unique($columns)));
	}

}
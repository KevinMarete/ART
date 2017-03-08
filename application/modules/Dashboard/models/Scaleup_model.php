<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scaleup_model extends CI_Model {

	public function get_category_total(){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Adult ART', 'data' => array()),
			array('type' => 'column', 'name' => 'Paediatric ART', 'data' => array()),
			array('type' => 'spline', 'name' => 'Total ART', 'data' => array())
		);

		$sql = "SELECT
					CONCAT_WS('/', data_month, data_year) period,
				    SUM(IF(regimen_category = 'Adult ART', total, NULL)) adult_total,
				    SUM(IF(regimen_category = 'Paediatric ART', total, NULL)) paed_total,
				    SUM(total) combined_total
				FROM vw_patients_regimen_category
				WHERE regimen_category IN ('Adult ART', 'Paediatric ART')
				GROUP BY period
				ORDER BY period DESC";
		$query = $this->db->query($sql);
		$results = $query->result_array();

		foreach ($results as $result) {
			$columns[] = $result['period'];
			foreach ($scaleup_data as $index => $scaleup) {
				if($scaleup['name'] == 'Adult ART'){
					array_push($scaleup_data[$index]['data'], $result['adult_total']);
				}else if($scaleup['name'] == 'Paediatric ART'){
					array_push($scaleup_data[$index]['data'], $result['paed_total']);
				}else if($scaleup['name'] == 'Total ART'){
					array_push($scaleup_data[$index]['data'], $result['combined_total']);	
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pipeline_model extends CI_Model {

	public function get_mos_total($year, $month){
		$columns = array();
		$scaleup_data = array(
			array('name' => 'Pending Orders', 'data' => array()),
			array('name' => 'CMS', 'data' => array()),
			array('name' => 'Facilities', 'data' => array())
		);

		$sql = "SELECT drug, facility_mos, cms_mos, supplier_mos
				FROM vw_pipeline_mos
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY drug
				ORDER BY drug DESC
				LIMIT 5";
		$query = $this->db->query($sql, array($year, $month));
		$results = $query->result_array();

		foreach ($results as $result) {
			$columns[] = $result['drug'];
			foreach ($scaleup_data as $index => $scaleup) {
				if($scaleup['name'] == 'Facilities'){
					array_push($scaleup_data[$index]['data'], $result['facility_mos']);
				}else if($scaleup['name'] == 'CMS'){
					array_push($scaleup_data[$index]['data'], $result['cms_mos']);
				}else if($scaleup['name'] == 'Pending Orders'){
					array_push($scaleup_data[$index]['data'], $result['supplier_mos']);	
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

}
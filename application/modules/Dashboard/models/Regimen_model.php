<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regimen_model extends CI_Model {

	public function get_category_total($year, $month){
		$sql = "SELECT 
				    regimen_category name,
				    SUM(total) y,
				    LOWER(REPLACE(regimen_category, ' ', '_')) drilldown
				FROM vw_patients_regimen_category
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY name
				ORDER BY y DESC";
		$query = $this->db->query($sql, array($year, $month));
		return $this->get_category_drilldown_regimen(array('main' => $query->result_array()), $year, $month);
	}

	public function get_category_drilldown_regimen($main_data, $year, $month){
		$drilldown_data = array();
		$sql = "SELECT
					LOWER(REPLACE(regimen_category, ' ', '_')) category,
					regimen name,
					SUM(total) y
				FROM vw_patients_regimen_category
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY name
				ORDER BY y DESC";
		$sub_data = $this->db->query($sql, array($year, $month))->result_array();

		foreach ($main_data['main'] as $counter => $main) {
			$category = $main['drilldown'];

			$drilldown_data['drilldown'][$counter]['id'] = $category;
			$drilldown_data['drilldown'][$counter]['name'] = ucwords($category);
			$drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

			foreach ($sub_data as $sub) {
				if($category == $sub['category']){
					unset($sub['category']);
					$drilldown_data['drilldown'][$counter]['data'][] = $sub;	
				}
			}
		}
		return array_merge($main_data, $drilldown_data);
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

	public function get_county_total($year, $month){
		$sql = "SELECT 
				    CONCAT(UCASE(SUBSTRING(county, 1, 1)),LOWER(SUBSTRING(county, 2))) name,
				    SUM(total) y,
				    LOWER(REPLACE(county, ' ', '_')) drilldown
				FROM vw_patients_site
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY name
				ORDER BY y DESC";
		$query = $this->db->query($sql, array($year, $month));
		return $this->get_county_drilldown_subcounty(array('main' => $query->result_array()), $year, $month);
	}

	public function get_county_drilldown_subcounty($main_data, $year, $month){
		$drilldown_data = array();
		$sql = "SELECT
					LOWER(REPLACE(county, ' ', '_')) county,
					CONCAT(UCASE(SUBSTRING(sub_county, 1, 1)),LOWER(SUBSTRING(sub_county, 2))) name,
					SUM(total) y,
					LOWER(CONCAT_WS('_',REPLACE(county, ' ', '_'), REPLACE(sub_county, ' ', '_'))) drilldown
				FROM vw_patients_site
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY drilldown
				ORDER BY y DESC";
		$sub_data = $this->db->query($sql, array($year, $month))->result_array();

		foreach ($main_data['main'] as $counter => $main) {
			$county_name = $main['drilldown'];

			$drilldown_data['drilldown'][$counter]['id'] = $county_name;
			$drilldown_data['drilldown'][$counter]['name'] = ucwords($county_name);
			$drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

			foreach ($sub_data as $sub) {
				if($county_name == $sub['county']){
					unset($sub['county']);
					$drilldown_data['drilldown'][$counter]['data'][] = $sub;	
				}
			}
		}

		$drilldown_data = $this->get_county_drilldown_facility($drilldown_data, $year, $month);
		return array_merge($main_data, $drilldown_data);
	}

	public function get_county_drilldown_facility($drilldown_data, $year, $month){
		$sql = "SELECT
					LOWER(CONCAT_WS('_',REPLACE(county, ' ', '_'), REPLACE(sub_county, ' ', '_'))) county_sub,
					CONCAT(UCASE(SUBSTRING(facility, 1, 1)),LOWER(SUBSTRING(facility, 2))) name,
					SUM(total) y
				FROM vw_patients_site
				WHERE data_year = ?
				AND data_month = ?
				GROUP BY name
				ORDER BY y DESC";

		$facility_data = $this->db->query($sql, array($year, $month))->result_array();

		$counter = sizeof($drilldown_data['drilldown']);
		foreach ($drilldown_data['drilldown'] as $main_data) {
			foreach ($main_data['data'] as $item) {
				$filter_value = $item['name'];
				$filter_name = $item['drilldown'];

				$drilldown_data['drilldown'][$counter]['id'] = $filter_name;
				$drilldown_data['drilldown'][$counter]['name'] = ucwords($filter_name);
				$drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

				foreach ($facility_data as $facility) {
					if($filter_name == $facility['county_sub']){
						unset($facility['county_sub']);
						$drilldown_data['drilldown'][$counter]['data'][] = $facility;
					}
				}
				$counter += 1;
			}
			
		}
		return $drilldown_data;
	}

}
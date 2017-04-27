<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_patient_regimen_numbers($filters){
		$columns = array();

		$this->db->select("regimen_category, regimen, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where('regimen_category !=', '');
		$this->db->group_by('regimen');
		$this->db->order_by('regimen_category, regimen', 'ASC');
		$query = $this->db->get('tbl_dashboard_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

	public function get_national_mos($filters)
	{
		$columns = array();
		$scaleup_data = array(
			array('name' => 'Pending Orders', 'data' => array()),
			array('name' => 'KEMSA', 'data' => array()),
			array('name' => 'Facilities', 'data' => array())
		);

		$this->db->select('drug, facility_mos, cms_mos, supplier_mos');
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug');
		$this->db->order_by('drug', 'DESC');
		$query = $this->db->get('tbl_dashboard_mos');
		$results = $query->result_array();

		foreach ($results as $result) {
			$columns[] = $result['drug'];
			foreach ($scaleup_data as $index => $scaleup) {
				if($scaleup['name'] == 'Facilities'){
					array_push($scaleup_data[$index]['data'], $result['facility_mos']);
				}else if($scaleup['name'] == 'KEMSA'){
					array_push($scaleup_data[$index]['data'], $result['cms_mos']);
				}else if($scaleup['name'] == 'Pending Orders'){
					array_push($scaleup_data[$index]['data'], $result['supplier_mos']);	
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_drug_consumption_trend($filters){
		$columns = array();
		$tmp_data = array();

		$this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('tbl_dashboard_consumption');
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

	public function get_patient_in_care($filters){
		$this->db->select("CONCAT(UCASE(SUBSTRING(county, 1, 1)),LOWER(SUBSTRING(county, 2))) name, SUM(total) y, LOWER(REPLACE(county, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		return $this->get_patient_in_care_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_patient_in_care_drilldown_level1($main_data, $filters){
		$drilldown_data = array();

		$this->db->select("LOWER(REPLACE(county, ' ', '_')) county, CONCAT(UCASE(SUBSTRING(sub_county, 1, 1)),LOWER(SUBSTRING(sub_county, 2))) name, SUM(total) y, LOWER(CONCAT_WS('_',REPLACE(county, ' ', '_'), REPLACE(sub_county, ' ', '_'))) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drilldown');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		$sub_data = $query->result_array();

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

		$drilldown_data = $this->get_patient_in_care_drilldown_level2($drilldown_data, $filters);
		return array_merge($main_data, $drilldown_data);
	}

	public function get_patient_in_care_drilldown_level2($drilldown_data, $filters){
		$this->db->select("LOWER(CONCAT_WS('_',REPLACE(county, ' ', '_'), REPLACE(sub_county, ' ', '_'))) county_sub, CONCAT(UCASE(SUBSTRING(facility, 1, 1)),LOWER(SUBSTRING(facility, 2))) name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		$facility_data = $query->result_array();

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

	public function get_patient_regimen_category($filters){
		$this->db->select("regimen_category name, SUM(total) y, LOWER(REPLACE(regimen_category, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where('regimen_category !=', '');
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		return $this->get_patient_regimen_category_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_patient_regimen_category_drilldown_level1($main_data, $filters){
		$drilldown_data = array();
		$this->db->select("LOWER(REPLACE(regimen_category, ' ', '_')) category, regimen_line name, SUM(total) y, LOWER(CONCAT_WS('_', REPLACE(regimen_category, ' ', '_'), REPLACE(regimen_line, ' ', '_'))) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drilldown');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		$sub_data = $query->result_array();

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
		$drilldown_data = $this->get_patient_regimen_category_drilldown_level2($drilldown_data, $filters);
		return array_merge($main_data, $drilldown_data);
	}

	public function get_patient_regimen_category_drilldown_level2($drilldown_data, $filters){
		$this->db->select("LOWER(CONCAT_WS('_', REPLACE(regimen_category, ' ', '_'), REPLACE(regimen_line, ' ', '_'))) line, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		$regimen_data = $query->result_array();

		$counter = sizeof($drilldown_data['drilldown']);
		foreach ($drilldown_data['drilldown'] as $main_data) {
			foreach ($main_data['data'] as $item) {
				$filter_value = $item['name'];
				$filter_name = $item['drilldown'];

				$drilldown_data['drilldown'][$counter]['id'] = $filter_name;
				$drilldown_data['drilldown'][$counter]['name'] = ucwords($filter_name);
				$drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

				foreach ($regimen_data as $regimen) {
					if($filter_name == $regimen['line']){
						unset($regimen['line']);
						$drilldown_data['drilldown'][$counter]['data'][] = $regimen;
					}
				}
				$counter += 1;
			}
		}
		return $drilldown_data;
	}

	public function get_drugs_in_regimen($filters){
		$this->db->select("drug_base name, SUM(total) y, LOWER(REPLACE(drug_base, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where('drug_base !=', '');
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		return $this->get_drugs_in_regimen_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_drugs_in_regimen_drilldown_level1($main_data, $filters){
		$drilldown_data = array();

		$this->db->select("LOWER(REPLACE(drug_base, ' ', '_')) category, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('tbl_dashboard_patient');
		$sub_data = $query->result_array();

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

	public function get_art_scaleup($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Adult ART', 'data' => array()),
			array('type' => 'column', 'name' => 'Paediatric ART', 'data' => array()),
			array('type' => 'spline', 'name' => 'Total ART', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(IF(regimen_category = 'Adult ART', total, NULL)) adult_total, SUM(IF(regimen_category = 'Paediatric ART', total, NULL)) paed_total, SUM(total) combined_total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where_in('regimen_category', array('Adult ART', 'Paediatric ART'));
		$this->db->group_by('period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('tbl_dashboard_patient');
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

	public function get_filters($column_name, $view_name){
		//Order filtering
		if($column_name == 'data_month'){
			$order_by = "ORDER BY FIELD(".$column_name.", 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )";
		}else if($column_name == 'data_year'){
			$order_by = "ORDER BY ".$column_name." DESC";
		}else{
			$order_by = "ORDER BY ".$column_name;
		}
		$sql = "SELECT DISTINCT($column_name) AS filter FROM ".$view_name." WHERE $column_name IS NOT NULL ".$order_by;
        $query = $this->db->query($sql);
        return $query->result_array();
	}

	public function get_specific_filter($filter_name, $selected_options){
		//Set filter text
		$filter_text = "";
		if(is_array($selected_options)){
			$selected_options = implode("','", $selected_options);
			$filter_text = "WHERE c.name IN ('".$selected_options."')";
		}
		//Fetch data based on filter text
		if($filter_name == 'county'){
			$sql = "SELECT sc.name AS filter FROM tbl_county_sub sc INNER JOIN tbl_county c ON c.id = sc.county_id $filter_text GROUP BY filter ORDER BY filter";
		}else if($filter_name == 'sub_county'){
			$sql = "SELECT f.name AS filter FROM tbl_facility f INNER JOIN tbl_facility_master fm ON fm.id = f.master_id INNER JOIN tbl_county_sub c ON c.id = fm.county_sub_id $filter_text GROUP BY filter ORDER BY filter";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}
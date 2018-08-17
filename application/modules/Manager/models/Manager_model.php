<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends CI_Model {

	public function get_reporting_rates($filters){
		$columns = array();
		$tmp_data = array();
		$reporting_data = array();

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, COUNT(DISTINCT facility) total", FALSE);
		$this->db->where("data_date >=", date('Y-01-01'));
		$this->db->where_in("category", array('central', 'standalone'));
		$this->db->where_in("code", array('D-CDRR', 'F-CDRR_packs'));
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=", $filter);
				}else{
                    $this->db->where_in($category, $filter);
                }
			}
		}
		$this->db->group_by('period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('vw_cdrr_list');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data['Orders']['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$reporting_data[$counter]['name'] = $name;
			$reporting_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $reporting_data, 'columns' => array_values(array_unique($columns)));
	}

	public function get_patient_regimen($filters){
		$this->db->select("regimen_service name, SUM(total) y, LOWER(REPLACE(regimen_service, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
				$this->db->where_in('category', array('central', 'standalone'));
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('vw_maps_list');
		return $this->get_patient_regimen_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_patient_regimen_drilldown_level1($main_data, $filters){
		$drilldown_data = array();
		$this->db->select("LOWER(REPLACE(regimen_service, ' ', '_')) category, regimen_category name, SUM(total) y, LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
				$this->db->where_in('category', array('central', 'standalone'));
			}
		}
		$this->db->group_by('drilldown');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('vw_maps_list');
		$sub_data = $query->result_array();

		if($main_data){
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
		}
		$drilldown_data = $this->get_patient_regimen_drilldown_level2($drilldown_data, $filters);
		return array_merge($main_data, $drilldown_data);
	}

	public function get_patient_regimen_drilldown_level2($drilldown_data, $filters){
		$this->db->select("LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) line, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
				$this->db->where_in('category', array('central', 'standalone'));
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('vw_maps_list');
		$regimen_data = $query->result_array();

		if($drilldown_data){
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
		}
		return $drilldown_data;
	}

	public function get_drug_consumption_allocation_trend($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Allocated', 'data' => array()),
			array('type' => 'column', 'name' => 'Consumed', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(allocated) allocated_total, SUM(consumed) consumed_total", FALSE);
		$this->db->where("data_date >=", date('Y-01-01'));
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=", $filter);
				}else{
                    $this->db->where_in($category, $filter);
                }
			}
		}
		$this->db->group_by('period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('vw_cdrr_list');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['period'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'Allocated'){
						array_push($scaleup_data[$index]['data'], $result['allocated_total']);
					}else if($scaleup['name'] == 'Consumed'){
						array_push($scaleup_data[$index]['data'], $result['consumed_total']);
					}
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_facility_adt_version_distribution($filters){
		$columns = array();

		$this->db->select("adt_version name, COUNT(*) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('name', 'DESC');
		$query = $this->db->get('vw_install_list');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_facility_internet_access($filters){
		$columns = array();

		$this->db->select("has_internet name, COUNT(*) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('vw_install_list');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}
}
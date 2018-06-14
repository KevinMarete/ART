<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends CI_Model {

	public function get_reporting_rates($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Paediatric', 'data' => array()),
			array('type' => 'column', 'name' => 'Adult', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(IF(age_category = 'paed', total, NULL)) paed_total, SUM(IF(age_category = 'adult', total, NULL)) adult_total", FALSE);
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
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['period'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'Adult'){
						array_push($scaleup_data[$index]['data'], $result['adult_total']);
					}else if($scaleup['name'] == 'Paediatric'){
						array_push($scaleup_data[$index]['data'], $result['paed_total']);
					}
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_patient_regimen($filters){
		$columns = array();
		$patient_services_data = array(
			array('type' => 'column',  'name' => 'ART' , 'data' =>array()),
			array('type' => 'column',  'name' => 'HepB' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PEP' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT Mother' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT Child' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PrEP' , 'data' =>array())
		);

		$this->db->select("UPPER(county) county, SUM(IF(regimen_service= 'ART', total, 0)) art, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'adult', total, 0)) pmtct_mother, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'paed', total, 0)) pmtct_child, SUM(IF(regimen_service= 'HepB', total, 0)) hepb, SUM(IF(regimen_service= 'PrEP', total, 0)) prep, SUM(IF(regimen_service= 'PEP', total, 0)) pep", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where_not_in('regimen_service', 'OI Only');
		$this->db->group_by('county');
		$this->db->order_by("county, regimen_service asc");
		$query = $this->db->get('dsh_patient');
        $results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['county'];
				foreach ($patient_services_data as $index => $scaleup) {
					if($scaleup['name'] == 'ART'){
						array_push($patient_services_data[$index]['data'], $result['art']);
					}else if($scaleup['name'] == 'HepB'){
						array_push($patient_services_data[$index]['data'], $result['hepb']);
					}else if($scaleup['name'] == 'PEP'){
						array_push($patient_services_data[$index]['data'], $result['pep']);	
					}else if($scaleup['name'] == 'PMTCT Mother'){
						array_push($patient_services_data[$index]['data'], $result['pmtct_mother']);	
					}else if($scaleup['name'] == 'PMTCT Child'){
						array_push($patient_services_data[$index]['data'], $result['pmtct_child']);	
					}else if($scaleup['name'] == 'PrEP'){
						array_push($patient_services_data[$index]['data'], $result['prep']);	
					}
				}
			}
		}
		return array('main' => $patient_services_data, 'columns' => $columns);
	}
	
	public function get_drug_consumption_allocation_trend($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'line', 'name' => 'Allocated', 'data' => array()),
			array('type' => 'column', 'name' => 'Consumed', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(allocated) consumed_total, SUM(consumed) consumed_total", FALSE);
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
		$query = $this->db->get('dsh_patient');
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
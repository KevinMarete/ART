<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_model extends CI_Model {

	public function get_patient_scaleup($filters){
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

	public function get_patient_services($filters){
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
	
	public function get_national_mos($filters){
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
		$query = $this->db->get('dsh_mos');
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
}
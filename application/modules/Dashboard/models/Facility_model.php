<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_model extends CI_Model {

	public function get_facility_patient_distribution($filters){
		$columns = array();
		$patient_services_data = array(
			array('type' => 'column',  'name' => 'ART' , 'data' =>array()),
			array('type' => 'column',  'name' => 'HepB' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PEP' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT Mother' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT Child' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PrEP' , 'data' =>array())
		);

		$this->db->select("UPPER(facility) facility, SUM(IF(regimen_service= 'ART', total, 0)) art, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'adult', total, 0)) pmtct_mother, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'paed', total, 0)) pmtct_child, SUM(IF(regimen_service= 'HepB', total, 0)) hepb, SUM(IF(regimen_service= 'PrEP', total, 0)) prep, SUM(IF(regimen_service= 'PEP', total, 0)) pep", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where_not_in('regimen_service', 'OI Only');
		$this->db->group_by('facility');
		$this->db->order_by('art', 'DESC');
		$this->db->limit(50);
		$query = $this->db->get('dsh_patient');
        $results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['facility'];
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

	public function get_facility_commodity_soh($filters){
		$columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
		$consumption_data = array();
             
		$this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date >= ", date('Y-01-01', strtotime($filter . "- 1 year")));
					$this->db->where("data_date <=", $filter);
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by("drug, period");
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_stock');
        $results = $query->result_array();

		foreach ($results as $result) {
            $drug =  $result['drug'];
            $period =  $result['period'];
            array_push($columns, $period);
            array_push($drugs, $drug);
            $tmp_data[$drug][$period] = $result['total'];
        }
        
        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $drugs = array_values(array_unique($drugs));

        //Ensure values match for all drugs
        foreach ($drugs as $drug) {
            foreach($columns as $column){
                if(isset($tmp_data[$drug][$column])){
                    $main_data[$drug]['data'][]  =  $tmp_data[$drug][$column];
                }else{
                    $main_data[$drug]['data'][]  = 0;
                }  
            } 
        }

		$counter = 0;
		foreach ($main_data as $name => $item) {
			$consumption_data[$counter]['name'] = $name;
			$consumption_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $consumption_data, 'columns' => $columns);
	}

	public function get_facility_patient_distribution_numbers($filters){
		$columns = array();
		$this->db->select("facility name, county, sub_county subcounty, SUM(IF(regimen_service= 'ART', total, 0)) art, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'adult', total, 0)) pmtct_mother, SUM(IF(regimen_service= 'PMTCT' AND age_category = 'paed', total, 0)) pmtct_child, SUM(IF(regimen_service= 'HepB', total, 0)) hepb, SUM(IF(regimen_service= 'PrEP', total, 0)) prep, SUM(IF(regimen_service= 'PEP', total, 0)) pep, SUM(total) total_patients", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where_not_in('regimen_service', 'OI Only');
		$this->db->group_by('name');
		$this->db->order_by('total_patients', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

}
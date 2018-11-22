<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcounty_model extends CI_Model {

    public function get_subcounty_patient_distribution($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(sub_county, 1, 1)),UPPER(SUBSTRING(sub_county, 2))) name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$this->db->limit(50);
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_subcounty_commodity_soh($filters){
		$columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
		$consumption_data = array();
             
		$this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
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

	public function get_subcounty_patient_distribution_numbers($filters){
		$columns = array();

		$this->db->select("sub_county name, COUNT(DISTINCT facility) facilities, SUM(IF(age_category='adult', total, NULL)) adult, SUM(IF(age_category='paed', total, NULL)) child, SUM(total) total_patients", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('total_patients', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

}
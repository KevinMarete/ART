<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trend_model extends CI_Model {

    public function get_commodity_consumption($filters){
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
		$query = $this->db->get('dsh_consumption');
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

	public function get_patients_regimen($filters){
		$columns = array();
		$tmp_data = array();
		$patient_regm_data = array();
             
		$this->db->select("regimen, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=", $filter);
				}else{
					$this->db->where_in($category, $filter);
				}
			}
		}
		$this->db->group_by('regimen, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_patient');
        $results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data[$result['regimen']]['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$patient_regm_data[$counter]['name'] = $name;
			$patient_regm_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $patient_regm_data, 'columns' => array_values(array_unique($columns)));
	}

	public function get_commodity_month_stock($filters){
		$columns = array();

		$comm_month_data = array(
			array('name' => 'Pending Orders', 'data' => array()),
			array('name' => 'KEMSA', 'data' => array()),
			array('name' => 'Facilities', 'data' => array())
		);

		$this->db->select("drug, facility_mos, cms_mos, supplier_mos, data_month, data_year, CONCAT_WS('/', data_month, data_year) period", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=", $filter);
				}else{	
                    $this->db->where_in($category, $filter);
                }
			}
		}
		$this->db->group_by('drug, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_mos');
		$results = $query->result_array();
		
		foreach ($results as $result) {
			$columns[] = $result['period'];
			foreach ($comm_month_data as $index => $comm_month) {
				if($comm_month['name'] == 'Pending Orders'){
					array_push($comm_month_data[$index]['data'], $result['supplier_mos']);
				}else if($comm_month['name'] == 'Facilities'){
					array_push($comm_month_data[$index]['data'], $result['facility_mos']);
				}else if($comm_month['name'] == 'KEMSA'){
					array_push($comm_month_data[$index]['data'], $result['cms_mos']);
				}
			}
		}
		
		return array('main' => $comm_month_data, 'columns' => $columns);
	}
	
}
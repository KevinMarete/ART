<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_model extends CI_Model {

	public function get_procurement_consumption_issues($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'line', 'name' => 'Consumption', 'data' => array()),
			array('type' => 'line', 'name' => 'Issues', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(consumption) consumption_total, SUM(issues) issues_total", FALSE);
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
		$query = $this->db->get('vw_procurement_list');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['period'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'Consumption'){
						array_push($scaleup_data[$index]['data'], $result['consumption_total']);
					}else if($scaleup['name'] == 'Issues'){
						array_push($scaleup_data[$index]['data'], $result['issues_total']);
					}
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_procurement_patients_on_drug($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(m.regimen, 1, 1)),UPPER(SUBSTRING(m.regimen, 2))) name, SUM(m.total) y", FALSE);
		$this->db->from('vw_maps_list m');
		$this->db->join('vw_regimen_drug_list rd', 'rd.regimen = m.regimen', 'inner');
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get();
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_procurement_pipeline_stock($filters){
		$columns = array('In Stock', 'In Transit', 'Under Manufacturing', 'Waiting for Call Down'); 
		$pipeline_data = array(
			array('name' => 'USAID', 'data' => array()),
			array('name' => 'GF', 'data' => array()),
			array('name' => 'CPF', 'data' => array())
		);

		foreach ($columns as $column) {
			foreach ($pipeline_data as $index => $pipeline) {
				if($pipeline['name'] == 'USAID'){
					array_push($pipeline_data[$index]['data'], mt_rand(1500,10000));
				}else if($pipeline['name'] == 'GF'){
					array_push($pipeline_data[$index]['data'], mt_rand(1000,5000));
				}else if($pipeline['name'] == 'CPF'){
					array_push($pipeline_data[$index]['data'], mt_rand(500, 3000));	
				}
			}
		}

		return array('main' => $pipeline_data, 'columns' => $columns);
	}

	public function get_procurement_expected_delivery($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'USAID', 'data' => array()),
			array('type' => 'column', 'name' => 'GF', 'data' => array()),
			array('type' => 'column', 'name' => 'CPF', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(receipts_usaid) usaid_total, SUM(receipts_gf) gf_total, SUM(receipts_cpf) cpf_total, ", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date >", $filter);
				}else{
                    $this->db->where_in($category, $filter);
                }
			}
		}
		$this->db->group_by('period');
		$this->db->having('(SUM(receipts_usaid) + SUM(receipts_gf) + SUM(receipts_cpf)) > 0');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('vw_procurement_list');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['period'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'USAID'){
						array_push($scaleup_data[$index]['data'], $result['usaid_total']);
					}else if($scaleup['name'] == 'GF'){
						array_push($scaleup_data[$index]['data'], $result['gf_total']);
					}else if($scaleup['name'] == 'CPF'){
						array_push($scaleup_data[$index]['data'], $result['cpf_total']);
					}
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_procurement_pipeline_mos($filters){
		$columns = array('Months of Stock'); 
		$pipeline_data = array(
			array('name' => 'USAID', 'data' => array()),
			array('name' => 'GF', 'data' => array()),
			array('name' => 'CPF', 'data' => array())
		);
		$consumption = 500;

		foreach ($columns as $column) {
			foreach ($pipeline_data as $index => $pipeline) {
				if($pipeline['name'] == 'USAID'){
					array_push($pipeline_data[$index]['data'], round(mt_rand(1500,10000)/$consumption));
				}else if($pipeline['name'] == 'GF'){
					array_push($pipeline_data[$index]['data'], round(mt_rand(1000,5000)/$consumption));
				}else if($pipeline['name'] == 'CPF'){
					array_push($pipeline_data[$index]['data'], round(mt_rand(500, 3000)/$consumption));	
				}
			}
		}

		return array('main' => $pipeline_data, 'columns' => $columns);
	}
	
}
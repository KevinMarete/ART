<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_view_data($view_name, $chart_x_variable, $metric, $filter_array, $order, $limit)
	{	
		//Build custom view query
		$this->db->select("$chart_x_variable,SUM($metric) $metric", FALSE);
		if(!empty($filter_array)){
			foreach ($filter_array as $category => $filter_data) {
				$this->db->where_in($category, $filter_data);
			}
		}
		$this->db->where($chart_x_variable." IS NOT ", NULL);
		$this->db->where($metric." IS NOT ", NULL);
		$this->db->group_by($chart_x_variable);
		$this->db->order_by($metric, $order);
		$this->db->limit($limit);
		$query = $this->db->get($view_name);
        return $query->result_array();
	}

	public function get_filters($column_name, $view_name){
		$sql = "SELECT DISTINCT($column_name) AS filter FROM ".$view_name." WHERE $column_name IS NOT NULL";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
}
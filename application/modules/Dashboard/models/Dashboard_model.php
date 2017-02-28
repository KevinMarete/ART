<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_view_data($view_name, $chart_name, $metric, $filter_array, $order, $limit)
	{	
		//Build custom view query
		$this->db->select("$chart_name,SUM($metric) $metric", FALSE);
		if(!empty($filter_array)){
			foreach ($filter_array as $category => $filter_data) {
				$this->db->where_in($category, $filter_data);
			}
		}
		$this->db->where($chart_name." IS NOT ", NULL);
		$this->db->where($metric." IS NOT ", NULL);
		$this->db->group_by($chart_name);
		$this->db->order_by($metric, $order);
		$this->db->limit($limit);
		$query = $this->db->get($view_name);
        return $query->result_array();
	}

	public function get_categories()
	{
		$sql = "SELECT category from vw_usp_category";
        $query = $this->db->query($sql);
        return $query->result_array();
	}

	public function get_filters($section_name, $filter_name){
		$sql = "SELECT DISTINCT($filter_name) AS filter FROM vw_".$section_name."_dashboard WHERE $filter_name IS NOT NULL";
        $query = $this->db->query($sql);
        return $query->result_array();
	}

	public function get_custom_filters($section_name, $filter_name){
		$sql = "SELECT DISTINCT($filter_name) AS filter FROM vw_".$section_name."_dashboard WHERE $filter_name IS NOT NULL";
        $query = $this->db->query($sql);
        return $query->result_array();
	}

	public function get_table_data($view_name, $chart_name, $metric, $filter_array){
		//Build custom view query
		$this->db->select("$chart_name,FORMAT(SUM($metric),0) $metric", FALSE);
		if(!empty($filter_array)){
			foreach ($filter_array as $category => $filter_data) {
				$this->db->where_in($category, $filter_data);
			}
		}
		$this->db->where($chart_name." IS NOT ", NULL);
		$this->db->where($metric." IS NOT ", NULL);
		$this->db->group_by($chart_name);
		$query = $this->db->get($view_name);
        return $query->result_array();
	}

}
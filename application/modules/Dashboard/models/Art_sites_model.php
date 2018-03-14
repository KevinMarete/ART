<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Art_sites_model extends CI_Model {

    public function get_adt_sites_versions($filters){
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

    public function get_adt_sites_internet($filters){
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

    public function get_adt_sites_backup($filters){
        $columns = array();

		$this->db->select("has_backup name, COUNT(*) y", FALSE);
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

    public function get_adt_sites_distribution($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Installed', 'data' => array()),
			array('type' => 'column', 'name' => 'Not Installed', 'data' => array())
		);

		$this->db->select("UCASE(county) county, SUM(IF(has_install = 'Yes', 1, NULL)) installed_total, SUM(IF(has_install = 'No', 1, NULL)) not_installed_total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by("county");
		$this->db->order_by("installed_total DESC");
		$query = $this->db->get("vw_central_site_list");
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['county'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'Installed'){
						array_push($scaleup_data[$index]['data'], $result['installed_total']);
					}else if($scaleup['name'] == 'Not Installed'){
						array_push($scaleup_data[$index]['data'], $result['not_installed_total']);
					}
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
    }

	public function get_adt_sites_distribution_numbers($filters){
		$columns = array();

		$this->db->select("facility, county, subcounty, partner, adt_version version, has_internet internet, has_backup backup, active_patients total_patients", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->order_by('total_patients', 'DESC');
		$query = $this->db->get('vw_install_list');
		return array('main' => $query->result_array(), 'columns' => $columns);

    }
    
}
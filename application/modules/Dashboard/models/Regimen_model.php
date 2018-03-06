<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regimen_model extends CI_Model {
    
	public function get_patient_regimen_category($filters){
		$this->db->select("regimen_service name, SUM(total) y, LOWER(REPLACE(regimen_service, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
		return $this->get_patient_regimen_category_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_patient_regimen_category_drilldown_level1($main_data, $filters){
		$drilldown_data = array();
		$this->db->select("LOWER(REPLACE(regimen_service, ' ', '_')) category, regimen_category name, SUM(total) y, LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drilldown');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
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
		$drilldown_data = $this->get_patient_regimen_category_drilldown_level2($drilldown_data, $filters);
		return array_merge($main_data, $drilldown_data);
	}

	public function get_patient_regimen_category_drilldown_level2($drilldown_data, $filters){
		$this->db->select("LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) line, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
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

    public function get_nrti_drugs_in_regimen($filters){
		$this->db->select("nrti_drug name, SUM(total) y, LOWER(REPLACE(nrti_drug, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where('nrti_drug !=', '');
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
		return $this->get_nrti_drugs_in_regimen_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_nrti_drugs_in_regimen_drilldown_level1($main_data, $filters){
		$drilldown_data = array();

		$this->db->select("LOWER(REPLACE(nrti_drug, ' ', '_')) category, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
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
		return array_merge($main_data, $drilldown_data);
	}

	public function get_nnrti_drugs_in_regimen($filters){
		$this->db->select("nnrti_drug name, SUM(total) y, LOWER(REPLACE(nnrti_drug, ' ', '_')) drilldown", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->where('nnrti_drug !=', '');
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
		return $this->get_nnrti_drugs_in_regimen_drilldown_level1(array('main' => $query->result_array()), $filters);
	}

	public function get_nnrti_drugs_in_regimen_drilldown_level1($main_data, $filters){
		$drilldown_data = array();

		$this->db->select("LOWER(REPLACE(nnrti_drug, ' ', '_')) category, regimen name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
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
		return array_merge($main_data, $drilldown_data);
	}
	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regimen_drug_model extends CI_Model {

	public function read()
	{
		$query = $this->db->get('tbl_regimen_drug');
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_regimen_drug',	$data);
		$count = $this->db->affected_rows();
		if($count > 0)
		{
			$data['status'] = TRUE;
		}
		else
		{
			$data['status'] = FALSE;
		}
		return $data;
	}

	public function update($regimen_id, $data)
	{	
		$this->db->update('tbl_regimen_drug', $data, array('regimen_id' => $regimen_id));
		$count = $this->db->affected_rows();
		if($count > 0)
		{
			$data['status'] = TRUE;
		}
		else
		{
			$data['status'] = FALSE;
		}
		return $data;
	}

	public function delete($regimen_id)
	{	
		$this->db->delete('tbl_regimen_drug', array('regimen_id' => $regimen_id)); 
		$count = $this->db->affected_rows();
		if($count > 0)
		{
			$data['status'] = TRUE;
		}
		else
		{
			$data['status'] = FALSE;
		}
		return $data;
	}

}
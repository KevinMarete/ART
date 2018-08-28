<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nnrti_model extends CI_Model {

	public function read()
	{
		$query = $this->db->get('tbl_nnrti');
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_nnrti',	$data);
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
		$this->db->update('tbl_nnrti', $data, array('regimen_id' => $regimen_id));
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
		$this->db->delete('tbl_nnrti', array('regimen_id' => $regimen_id)); 
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
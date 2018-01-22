<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nrti_model extends CI_Model {

	public function read()
	{
		$query = $this->db->get('tbl_nrti');
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_nrti',	$data);
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
		$this->db->update('tbl_nrti', $data, array('regimen_id' => $regimen_id));
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
		$this->db->delete('tbl_nrti', array('regimen_id' => $regimen_id)); 
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
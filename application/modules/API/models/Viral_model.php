<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viral_model extends CI_Model {

	public function read($conditions)
	{
		$query = $this->db->get_where('tbl_viral', $conditions);
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_viral',	$data);
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

	public function update($test_id, $data)
	{	
		$this->db->update('tbl_viral', $data, array('test_id' => $test_id));
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

	public function delete($test_id)
	{	
		$this->db->delete('tbl_viral', array('test_id' => $test_id)); 
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model {

	public function read($conditions)
	{	
		$query = $this->db->get_where('tbl_stock', $conditions);
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_stock', $data);
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

	public function update($conditions, $data)
	{	
		$this->db->update('tbl_stock', $data, $conditions);
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

	public function delete($conditions)
	{	
		$this->db->delete('tbl_stock', $conditions); 
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
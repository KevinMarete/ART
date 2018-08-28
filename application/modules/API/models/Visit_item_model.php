<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_item_model extends CI_Model {

	public function read($conditions)
	{	
		$query = $this->db->get_where('tbl_visit_item', $conditions);
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_visit_item', $data);
		$count = $this->db->affected_rows();
		if($count > 0)
		{	
			$data['id'] = $this->db->insert_id();
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
		$this->db->update('tbl_visit_item', $data, $conditions);
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
		$this->db->delete('tbl_visit_item', $conditions); 
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
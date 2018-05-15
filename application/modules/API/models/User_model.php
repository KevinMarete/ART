<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function read()
	{
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_user',	$data);
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

	public function update($id, $data)
	{	
		$this->db->update('tbl_user', $data, array('id' => $id));
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

	public function delete($id)
	{	
		$this->db->delete('tbl_user', array('id' => $id)); 
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

	public function authenticate_user($data)
	{	
		$query = $this->db->get_where('tbl_user', $data);
		$data = $query->row_array();
		if(is_array($data))
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
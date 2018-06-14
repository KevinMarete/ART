<?php
/**
 * Description of Module_model
 *
 * @author k
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_model extends CI_Model {

	public function read()
	{
		$query = $this->db->get('tbl_module');
		return $query->result_array();
	}

	public function insert($data)
	{	
		$this->db->insert('tbl_module',	$data);
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
		$this->db->update('tbl_module', $data, array('id' => $id));
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
		$this->db->delete('tbl_module', array('id' => $id)); 
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
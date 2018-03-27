<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subcounty_model extends CI_Model {

    public function read($conditions) {
//    public function read() {
        $query = $this->db->get_where('tbl_subcounty', $conditions);
        return $query->result_array();
//        $this->db->select('tbl_subcounty.id,tbl_subcounty.name as s_name,tbl_county.id as c_id,tbl_county.name as c_name');
//        $this->db->from('tbl_subcounty');
//        $this->db->join('tbl_county', 'tbl_county.id=tbl_subcounty.county_id');
//        $query = $this->db->get();
//        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('tbl_subcounty', $data);
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['id'] = $this->db->insert_id();
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function update($id, $data) {
        $this->db->update('tbl_subcounty', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_subcounty', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

}

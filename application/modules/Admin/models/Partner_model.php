<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_model extends CI_Model {

    public function read() {
        $this->db->select('*');
        $this->db->from('tbl_partner');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data) {
        $this->db->insert('tbl_partner', $data);
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
        $this->db->update('tbl_partner', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_partner', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }
    //function get_partner
    public function get_partner() {
        $this->db->select('id, name');
        $this->db->from('tbl_partner');
        $query = $this->db->get();
        return $query->result();
    }

}

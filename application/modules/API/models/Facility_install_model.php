<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_install_model extends CI_Model {

    public function read() {
        $this->db->select('f.*');
        $this->db->from('tbl_facility f');
        $this->db->where('f.id NOT IN (SELECT tbl_install.facility_id FROM tbl_install)', NULL, FALSE);
        $this->db->order_by('f.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('tbl_facility', $data);
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
        $this->db->update('tbl_facility', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_facility', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

}

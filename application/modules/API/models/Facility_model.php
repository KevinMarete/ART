<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_model extends CI_Model {

   //function list facilities that are not yet installed
    public function read() {
        $this->db->select('tbl_facility.id,tbl_facility.name,tbl_facility.mflcode,tbl_facility.subcounty_id,tbl_facility.partner_id');
        $this->db->from('tbl_facility');
        $this->db->where('tbl_facility.id NOT IN (select tbl_install.facility_id from tbl_install)', NULL, FALSE);
        $this->db->order_by('tbl_facility.name','asc');
        $query = $this->db->get();
        return $query->result();
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

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Install_model extends CI_Model {

    //Get installed sites
    public function read() {
//		$query = $this->db->get('tbl_install');
//		return $query->result();

        $this->db->select('tbl_install.id,tbl_facility.name,tbl_install.version,tbl_install.setup_date,tbl_install.active_patients,tbl_install.contact_name,tbl_install.contact_phone');
        $this->db->from('tbl_install');
        $this->db->join('tbl_facility', 'tbl_install.facility_id=tbl_facility.id', 'inner');
        $query = $this->db->get();
        $result = $query->result();
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function insert($data) {
        $this->db->insert('tbl_install', $data);
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['id'] = $this->db->insert_id();
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    function getSiteInfo($id) {
        $this->db->select('*');
        $this->db->from('tbl_install');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function update($id, $data) {
        $this->db->update('tbl_install', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_install', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

}

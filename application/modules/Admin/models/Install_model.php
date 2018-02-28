<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Install_model extends CI_Model {

    //Get installed sites
    public function read() {
        $this->db->select('tbl_install.id,tbl_facility.name,tbl_install.version,tbl_install.setup_date,tbl_install.active_patients,'
                . 'tbl_install.contact_name,tbl_install.contact_phone');
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
    //function add site
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
    //function get site information
    function getSiteInfo($id) {
        $this->db->select('tbl_install.id as install_id,tbl_install.version,tbl_install.setup_date,tbl_install.upgrade_date,tbl_install.comments,'
                . 'tbl_install.contact_name,tbl_install.contact_phone,tbl_install.emrs_used,tbl_install.active_patients,tbl_install.is_internet,'
                . 'tbl_install.is_usage,tbl_install.user_id,tbl_facility.name,tbl_facility.mflcode,tbl_facility.category,tbl_facility.subcounty_id,'
                . 'tbl_subcounty.id,tbl_subcounty.name as subcounty_name,tbl_user.name as user_name,tbl_county.name as county_name,'
                . 'tbl_partner.name as partner_name');
        $this->db->from('tbl_install');
        $this->db->join('tbl_facility', 'tbl_install.facility_id=tbl_facility.id');
        $this->db->join('tbl_subcounty', 'tbl_facility.subcounty_id=tbl_subcounty.id');
        $this->db->join('tbl_county', 'tbl_subcounty.county_id=tbl_county.id');
        $this->db->join('tbl_user', 'tbl_user.id=tbl_install.user_id');
        $this->db->join('tbl_partner','tbl_partner.id=tbl_facility.partner_id');
        $this->db->where('tbl_install.id', $id);
        $query = $this->db->get();
        $result = $query->result();
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }
    //function update site
    public function update($id, $data) {
        $this->db->update('tbl_install', $data, array('id' =>$id));
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

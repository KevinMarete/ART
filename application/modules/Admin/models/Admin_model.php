<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin_model
 *
 * @author k
 */
class Admin_model extends CI_Model {

    function get_facility_name() {
        $this->db->select('name');
        $this->db->from('tbl_facility');

        //work with less data
        $this->db->where('id<50');
        $query = $this->db->get();

        return $query->result();
    }

    function get_county() {
        $this->db->select('*');
        $this->db->from('tbl_county');
        $query = $this->db->get();

        return $query->result();
    }

    function get_sub_county() {
        $this->db->select('tbl_subcounty.name as Subcounty, '
                . 'tbl_county.name as County');
        $this->db->from('tbl_subcounty');
        $this->db->join('tbl_county', 'tbl_county.id=tbl_subcounty.county_id');
        $query = $this->db->get();
        $result = $query->result();
        //print_r($result);E
//        echo json_encode($result);
//        die();
    }

    function get_count($search_term) {
        $this->db->SELECT('name');
        $this->db->like('name', $search_term);
        $query = $this->db->get('tbl_county');
        return $query->result_array();
    }

    //get partner

    function get_partner() {
        $this->db->select('name');
        $this->db->from('tbl_partner');
        $query = $this->db->get();

        return $query->result();
    }

    function addInstall($addInstall) {
        $this->db->trans_start();
        $this->db->insert('tbl_install', $addInstall);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function add_install_to_facility($add_to_facility) {
        $this->db->trans_start();
        $this->db->insert('tbl_facility', $add_to_facility);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

}

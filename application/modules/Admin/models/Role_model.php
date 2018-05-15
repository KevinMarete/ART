<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    //function get user_roles
    public function read() {
        $this->db->select('*');
        $this->db->from('auth_tbl_roles');
        $query = $this->db->get();
        return $query->result();
    }

}

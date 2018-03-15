<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_login_model extends CI_Model {

    public function login_user($email, $pass) {

        $this->db->select('*');
        $this->db->from('auth_tbl_users');
        $this->db->where('email', $email);
        $this->db->where('password', $pass);

        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    //check if email is registered
    public function email_check($email) {
        $this->db->select('*');
        $this->db->from('auth_tbl_users');
        $this->db->where('email', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_register_model extends CI_Model {

    //function used to register a new user
//    public function auth_register($userInfo) {
//        $this->db->trans_start();
//        $this->db->insert('auth_tbl_users', $userInfo);
//
//        $insert_id = $this->db->insert_id();
//
//        $this->db->trans_complete();
//
//        return $insert_id;
//    }

    public function register_user($user) {


        $this->db->insert('auth_tbl_users', $user);
    }

    public function email_check($email) {

        $this->db->select('*');
        $this->db->from('auth_tbl_users');
        $this->db->where('email', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

}

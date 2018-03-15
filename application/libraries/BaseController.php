<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller {
//
//    function __construct() {
//        parent::__construct();
//        if (!$this->session->userdata('isLoggedIn')) {
//            $this->load->view("Admin/pages/auth/login_view");
//        }
//    }

    protected $role = '';
    protected $first_name = '';
    protected $last_name = '';
    protected $email = '';
    protected $mobile = '';

    /**
     * This function used to check the user is logged in or not
     */
    public function isLoggedIn() {
//        $isLoggedIn = $this->session->userdata('isLoggedIn');
//
//        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
//            $this->load->view("Admin/pages/auth/login_view");
//        } else {
//            $this->role = $this->session->userdata('role');
//            $this->last_name = $this->session->userdata('last_name');
//            /**
//             * user isLoggedIn user parameters to be loaded here
//             */
//            $this->data['last_name']= $this->last_name;
//        }
        $user = $this->session->userdata('isLoggedIn');
        return isset($user);
    }

    /**
     * This function is used to check the access
     */
    function isAdmin() {
        if ($this->role != ROLE_ADMIN) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to check the access
     */
    function isTicketter() {
        if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to logged out user from system
     */
    function logout() {
        $this->session->sess_destroy();

        redirect('login');
    }

}

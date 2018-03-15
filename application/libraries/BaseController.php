<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller {

    protected $role = '';
    protected $first_name = '';
    protected $last_name = '';
    protected $email = '';
    protected $mobile = '';

    /**
     * This function used to check the user is logged in or not
     */
    public function isLoggedIn() {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view("Admin/pages/auth/login_view");
        } else {
            $this->role = $this->session->userdata('role');
            $this->last_name = $this->session->set_userdata('last_name');
            /**
             * user isloggedin user parameters to be loaded here
             */
            
        }
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

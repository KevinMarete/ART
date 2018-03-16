<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    protected $roleId = '';
    protected $id = '';
    protected $mobile = '';
    protected $last_name = '';
    protected $first_name = '';

    /**
     * Takes mixed data and optionally a status code, then creates the response
     *
     * @access public
     * @param array|NULL $data
     *        	Data to output to the user
     *        	running the script; otherwise, exit
     */
    public function response($data = NULL) {
        $this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))->_display();
        exit();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn() {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('Admin/Auth/Auth_login');
        } else {
            $this->roleId = $this->session->userdata('roleId');
            $this->id = $this->session->userdata('id');
            $this->mobile = $this->session->userdata('mobile');
            $this->last_name = $this->session->userdata('last_name');
            $this->first_name = $this->session->userdata('first_name');
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

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Auth_login extends BaseController {

    public function __construct() {

        parent::__construct();
        $this->load->model('Auth/Auth_login_model');
        $this->load->model('Auth/Auth_user_model');
    }

    public function index() {
        $this->isLoggedIn();
    }

    public function loginMe() {
        $user_login = array(
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );

        $email_check = $this->Auth_login_model->email_check($user_login['email']);
        //login in user if email is registered
        if ($email_check == TRUE) {
            //check email password match and if matches login in user
            $data = $this->Auth_login_model->login_user($user_login['email'], $user_login['password']);
            if (!empty($data)) {
                $this->session->set_userdata('email', $data['email']);
                $this->session->set_userdata('last_name', $data['last_name']);
                $this->session->set_userdata('mobile', $data['mobile']);
                $this->session->set_userdata('first_name', $data['first_name']);
                $this->session->set_userdata('roleId', $data['roleId']);

                //function load dashboard_view if email password match
                $this->home();
            } else {
                //login fails if user does not provide matching registered email and password
                $this->session->set_flashdata('error_msg', 'Email password mismatch!!,Try again.');
                $this->load->view("Admin/pages/auth/login_view");
            }
        } else {
            //login fails if email is not registered
            $this->session->set_flashdata('error_msg', 'Email Not registered,Try again.');
            $this->index();
        }
    }

    /*
     * function load dashboard_view
     */

    public function home() {
        $data['content_view'] = 'pages/dashboard_view';
        $data['page_title'] = 'ART Dashboard | Admin';
        $this->load->view('template/template_view', $data);
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn() {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view("Admin/pages/auth/login_view");
        } else {
            $this->home();
        }
    }

    /*
     * function logout and load login_view
     */

    public function user_logout() {
        $this->session->sess_destroy();
        $this->load->view("Admin/pages/auth/login_view");
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_login extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Auth/Auth_login_model');
        $this->load->library('session');
    }

    public function index() {
        $user_login = array(
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );

        $data = $this->Auth_login_model->login_user($user_login['email'], $user_login['password']);
        if ($data) {
            $this->session->set_userdata('email', $data['email']);
            $this->session->set_userdata('last_name', $data['last_name']);
            $this->session->set_userdata('mobile', $data['mobile']);

            //function load dashboard_view
            $this->home();
        } else {
            $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
            $this->load->view("Admin/pages/auth/login_view");
        }
    }

    //function load dashboard_view
    public function home() {
        $data['content_view'] = 'pages/dashboard_view';
        $data['page_title'] = 'ART Dashboard | Admin';
        $this->load->view('template/template_view', $data);
    }

    //function logout and load login_view
    public function user_logout() {
        $this->session->sess_destroy();
        $this->load->view("Admin/pages/auth/login_view");
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_register extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Auth/Auth_register_model');
        $this->load->library('session');
    }

    public function index() {

        $user = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('user_email'),
            'mobile' => $this->input->post('user_mobile'),
            'password' => md5($this->input->post('user_password')),
            'roleId' => $this->input->post('roleId'),
            'createdDtm' => date('Y-m-d H:i:s')
        );

        $email_check = $this->Auth_register_model->email_check($user['email']);

        if ($email_check) {
            $this->Auth_register_model->register_user($user);
            $this->session->set_flashdata('success_msg', 'Registration Successfully.Now login to your account.');
            $this->load->view('Admin/pages/auth/login_view');
        } else {

            $this->session->set_flashdata('error_msg', 'Email already registered');
            $this->load->view('Admin/pages/auth/registration_view');
        }
    }

}

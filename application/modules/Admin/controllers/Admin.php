<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

//class Admin extends MX_Controller {
class Admin extends BaseController {


    public function index() {
        $this->load->view('pages/auth/login_view');
    }

    public function home() {
//        $this->isLoggedIn();
        $data['content_view'] = 'pages/dashboard_view';
        $data['page_title'] = 'ART Dashboard | Admin';
        $this->load->view('template/template_view', $data);
    }

    public function register() {
        $this->load->view('pages/auth/registration_view');
    }

}

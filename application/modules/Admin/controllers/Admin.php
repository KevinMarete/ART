<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

//class Admin extends MX_Controller {
class Admin extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('pages/auth/login_view');
    }

    public function home() {
//        $this->isLoggedIn();
//        if ($this->isLoggedIn()==FALSE) {
            $data['content_view'] = 'pages/dashboard_view';
            $data['page_title'] = 'ART Dashboard | Admin';
            $this->load->view('template/template_view', $data);
//            echo $last_name;
//        }
    }

    public function register() {
        $this->load->view('pages/auth/registration_view');
    }

}

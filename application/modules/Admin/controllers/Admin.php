<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() {
        ini_set("max_execution_time", "100000");
        ini_set("memory_limit", '2048M');
//        $this->load->model('Admin_model');
    }

    public function index() {
        $this->load->view('pages/login_view');
    }

    public function home() {
        $data['content_view'] = 'pages/dashboard_view';
        $data['page_title'] = 'ART Dashboard | Admin';
        $this->load->view('template/template_view', $data);
    }
    
}

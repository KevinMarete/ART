<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/sites_view';
        $data['page_title'] = 'ART Dashboard | Sites';
        $this->load->view('template/template_view', $data);
    }

    public function save() {
        //Stub to save install
        echo '<pre>';
        print_r($this->input->post());
        //redirect('sites');
    }

    public function update() {
        //Stub to update install
        redirect('sites');
    }

}

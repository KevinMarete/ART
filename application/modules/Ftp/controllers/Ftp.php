<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ftp extends MX_Controller {

    function index() {
        if ($this->session->userdata('id')) {
            $data['page_title'] = 'ART | FTP';
            $this->load->view('template/elfinder', $data);
        } else {
            redirect("manager/login");
        }
    }

}

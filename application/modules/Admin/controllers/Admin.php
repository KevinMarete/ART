<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() {
        ini_set("max_execution_time", "100000");
        ini_set("memory_limit", '2048M');
        $this->load->model('Admin_model');
    }

    public function index() {
        $this->load->view('login_view');
        $this->load->model('Admin_model');
    }

    public function home() {
        $data['content_view'] = 'dashboard_view';
        $data['page_title'] = 'ART Dashboard | Admin';
        $this->load->view('template/template_view', $data);
    }

    public function rollout() {
        $data['content_view'] = 'rollout_view';
        $data['page_title'] = 'ART Dashboard | Rollout';
        $data['search_name'] = $this->Admin_model->get_facility_name();
        $data['get_county'] = $this->Admin_model->get_county();
        $data['partner'] = $this->Admin_model->get_partner();
        $data['get_subcounty'] = $this->Admin_model->get_sub_county();

        //AddInstall
        $install = array(
            '' => $this->input->post('county'),
            'partner_id' => $this->input->post('partner'),
            'contact_name' => $this->input->post('contactName'),
            'contact_phone' => $this->input->post('contactPhone'),
            'version' => $this->input->post('adtVersion'),
            'setup_date' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('setDate')))),
            'upgrade_date' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('upgradeDate')))),
            'is_usage' => $this->input->post('in_use'),
            'is_internet' => $this->input->post('internet'),
            'emrs_used' => $this->input->post('emrsUsed'),
            'active_patients' => $this->input->post('activePatient'),
            'mfl_code' => $this->input->post('assignedTo')
        );
//        $result_one = $this->Admin_model->addInstall($install);

        //Addfacility
        $facility = array(
            'name' => $this->input->post('facility_name'),
            'mflcode' => $this->input->post('mfl_code'),
            'category' => $this->input->post('classification'),
            'subcounty_id' => $this->input->post('subcounty'),
        );
//        $result_two = $this->Admin_model->add_install_to_facility($facility);

//        if ($result_one && $result_two > 0) {
//            $this->load->view('template/template_view', $data);
//        } else {
//            $this->session->set_flashdata('error', 'Failed');
//        }
        $this->load->view('template/template_view', $data);
    }

}

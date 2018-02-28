<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facility extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Facility_model', 'facility_listing');
        $this->load->model('Subcounty_model');
        $this->load->model('Partner_model');
    }

    public function index() {
        $data['content_view'] = 'pages/settings/facility_view';
        $data['page_title'] = 'ART Dashboard | Settings';
        $data['get_subcounty'] = $this->Subcounty_model->read();
        $data['get_partner'] = $this->Partner_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->facility_listing->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $facility_list) {
            $no++;
            $row = array();
            $row[] = $facility_list->facility_id;
            $row[] = $facility_list->name;
            $row[] = $facility_list->mflcode;
            $row[] = $facility_list->subcounty_name;
            $row[] = $facility_list->partner_name;
            //add html for action
            $row[] = '<a class="button btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_facility_listing(' . "'" . $facility_list->facility_id . "'" . ')"></a>
				  <a class="button btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_facility_listing(' . "'" . $facility_list->facility_id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->facility_listing->count_all(),
            "recordsFiltered" => $this->facility_listing->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->facility_listing->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'mflcode' => $this->input->post('mflcode'),
            'subcounty_id' => $this->input->post('subcounty_id'),
            'partner_id' => $this->input->post('partner_id')
        );
//        print_r($data);
//        die();
        $insert = $this->facility_listing->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'mflcode' => $this->input->post('mflcode')
        );
        $this->facility_listing->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->facility_listing->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Facility Name is Required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('mflcode') == '') {
            $data['inputerror'][] = 'mflcode';
            $data['error_string'][] = 'MflCode is Required';
            $data['status'] = FALSE;
        }
        
        if ($this->input->post('subcounty_id') == '') {
            $data['inputerror'][] = 'subcounty_id';
            $data['error_string'][] = 'Sub County is Required';
            $data['status'] = FALSE;
        }
        
        if ($this->input->post('partner_id') == '') {
            $data['inputerror'][] = 'partner_id';
            $data['error_string'][] = 'Partner Name is Required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

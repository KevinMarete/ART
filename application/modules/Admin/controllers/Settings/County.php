<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class County extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('County_model', 'county');
    }

    public function index() {
        $data['content_view'] = 'pages/settings/county_view';
        $data['page_title'] = 'ART Dashboard | Settings';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->county->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $county) {
            $no++;
            $row = array();
            $row[] = $county->name;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_county(' . "'" . $county->id . "'" . ')"></a>
				  <a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_county(' . "'" . $county->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->county->count_all(),
            "recordsFiltered" => $this->county->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->county->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $insert = $this->county->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->county->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->county->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'County Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    //function fetch data from db_table
    public function get_data($table) {
        $response = $this->Admin_model->get_table_data($table);
        if ($response['status']) {
            echo json_encode(array('data' => $response['data']));
        }
    }

    //function add data to db_table
    public function add_data() {
        $this->_validate();
        $insert = $this->Admin_model->save($_POST);
        echo json_encode(array("status" => TRUE));
    }

    //function edit data from db_table
    public function ajax_edit($id, $table) {
        $data = $this->Admin_model->get_by_id($id, $table);
        echo json_encode($data);
    }

    //function update data from db_table
    public function ajax_update() {
        $this->_validate();
        $this->Admin_model->update(array('id' => $this->input->post('id')), $_POST);
        echo json_encode(array("status" => TRUE));
    }
    //function delete from db_table
    public function ajax_delete($id,$table) {
        $this->Admin_model->delete_by_id($id,$table);
        echo json_encode(array("status" => TRUE));
    }

    //function form validations
    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }
//        if ($this->input->post('strength') == '') {
//            $data['inputerror'][] = 'strength';
//            $data['error_string'][] = 'Drug Strength is required';
//            $data['status'] = FALSE;
//        }
//
//        if ($this->input->post('packsize') == '') {
//            $data['inputerror'][] = 'packsize';
//            $data['error_string'][] = 'Drug Pack Size is required';
//            $data['status'] = FALSE;
//        }
//        if ($this->input->post('generic_id') == '') {
//            $data['inputerror'][] = 'generic_id';
//            $data['error_string'][] = 'Generic Name is required';
//            $data['status'] = FALSE;
//        }
//        if ($this->input->post('formulation_id') == '') {
//            $data['inputerror'][] = 'formulation_id';
//            $data['error_string'][] = 'Formulation is required';
//            $data['status'] = FALSE;
//        }
//        if ($this->input->post('county_id') == '') {
//            $data['inputerror'][] = 'county_id';
//            $data['error_string'][] = 'County Name is required';
//            $data['status'] = FALSE;
//        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

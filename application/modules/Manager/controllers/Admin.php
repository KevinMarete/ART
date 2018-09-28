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
    public function add_data($table) {
        // $this->_validate();
        $this->updateSysLogs('Created  (' . $table . ')');
        $this->Admin_model->save($table, $_POST);
    }

    //function edit data from db_table
    public function edit_data($id, $table) {
        $data = $this->Admin_model->get_by_id($id, $table);
        echo json_encode($data);
    }

    //function update data from db_table
    public function update_data($table) {
        // $this->_validate();
        $id = $this->input->post('id');
        $this->Admin_model->update($table, array('id' => $id), $_POST);
        $this->updateSysLogs('Updated  (' . $table . '> Record ID ' . $id . ')');
        echo json_encode(array("status" => TRUE));
    }

    //function delete from db_table
    public function delete_data($id, $table) {
        $this->Admin_model->delete_by_id($id, $table);
        $this->updateSysLogs('Deleted  (' . $id . '> Record ID ' . $table . ')');
        echo json_encode(array("status" => TRUE));
    }

    //function form validations
    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '' &&
                ($this->input->post('dhis_code') == '' || $this->input->post('dhis_name') == '' || $this->input->post('dhis_report') == '' || $this->input->post('target_report') == '' || $this->input->post('target_name') == '' || $this->input->post('target_category') == '' || $this->input->post('target_id') == '' ) && ($this->input->post('name') == '' || $this->input->post('value') == '' || $this->input->post('frequency') == '') && ($this->input->post('strength') == '' || $this->input->post('packsize') == '' || $this->input->post('generic_id') == '' || $this->input->post('formulation_id') == '') && ($this->input->post('name') == '' || $this->input->post('mflcode') == '' || $this->input->post('category') == '' || $this->input->post('dhiscode') == '' || $this->input->post('longitude') == '' || $this->input->post('latitude') == '' || $this->input->post('subcounty_id') == '' || $this->input->post('partner_id') == '') && ($this->input->post('name') == '' || $this->input->post('module_id') == '') && ($this->input->post('name') == '' || $this->input->post('abbreviation') == '') && ($this->input->post('facility_id') == '' || $this->input->post('version') == '' || $this->input->post('setup_date') == '' || $this->input->post('upgrade_date') == '' || $this->input->post('user_id') == '') && ($this->input->post('name') == '' || $this->input->post('icon') == '') && ($this->input->post('name') == '' || $this->input->post('code') == '' || $this->input->post('description') == '' || $this->input->post('category_id') == '' || $this->input->post('service_id') == '' || $this->input->post('line_id') == '') && ($this->input->post('drug_id') == '' || $this->input->post('regimen_id') == '') && ($this->input->post('submodule_id') == '') && ($this->input->post('name') == '' || $this->input->post('county_id') == '' )) {
            //common to many forms
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name is required';
            //dhis elements
            $data['inputerror'][] = 'dhis_code';
            $data['error_string'][] = 'Dhis Code is required';
            $data['inputerror'][] = 'dhis_name';
            $data['error_string'][] = 'Dhis Name is required';
            $data['inputerror'][] = 'dhis_report';
            $data['error_string'][] = 'Dhis Report is required';
            $data['inputerror'][] = 'target_report';
            $data['error_string'][] = 'Target Report is required';
            $data['inputerror'][] = 'target_name';
            $data['error_string'][] = 'Target Name is required';
            $data['inputerror'][] = 'target_category';
            $data['error_string'][] = 'Target category is required';
            $data['inputerror'][] = 'target_id';
            $data['error_string'][] = 'Target Elemnet is required';
            //dose
            $data['inputerror'][] = 'value';
            $data['error_string'][] = 'Value is required';
            $data['inputerror'][] = 'frequency';
            $data['error_string'][] = 'Frequency is required';
            //drug
            $data['inputerror'][] = 'strength';
            $data['error_string'][] = 'Strength is required';
            $data['inputerror'][] = 'packsize';
            $data['error_string'][] = 'Packsize is required';
            $data['inputerror'][] = 'generic_id';
            $data['error_string'][] = 'Generic is required';
            $data['inputerror'][] = 'formulation_id';
            $data['error_string'][] = 'Formulation is required';
            //facility
            $data['inputerror'][] = 'mflcode';
            $data['error_string'][] = 'MFLcode is required';
            $data['inputerror'][] = 'category';
            $data['error_string'][] = 'Category is required';
            $data['inputerror'][] = 'dhiscode';
            $data['error_string'][] = 'DhisCode is required';
            $data['inputerror'][] = 'longitude';
            $data['error_string'][] = 'Longitude is required';
            $data['inputerror'][] = 'latitude';
            $data['error_string'][] = 'Latitude is required';
            $data['inputerror'][] = 'subcounty_id';
            $data['error_string'][] = 'Subcounty Name is required';
            $data['inputerror'][] = 'partner_id';
            $data['error_string'][] = 'Partner Name is required';
            //generic
            $data['inputerror'][] = 'abbreviation';
            $data['error_string'][] = 'Abbreviation is required';
            //install
            $data['inputerror'][] = 'facility_id';
            $data['error_string'][] = 'Facility Name is required';
            $data['inputerror'][] = 'version';
            $data['error_string'][] = 'ADT Version is required';
            $data['inputerror'][] = 'setup_date';
            $data['error_string'][] = 'Set Up Date is required';
            $data['inputerror'][] = 'upgrade_date';
            $data['error_string'][] = 'UpGrade Date is required';
            //$data['inputerror'][] = 'contact_name';
            //$data['error_string'][] = 'Contact Name is required';
            //$data['inputerror'][] = 'contact_phone';
            //$data['error_string'][] = 'Contact Phone is required';
            //$data['inputerror'][] = 'active_patients';
            //$data['error_string'][] = 'Active Patients is required';
            $data['inputerror'][] = 'user_id';
            $data['error_string'][] = 'Assignee Name is required';
            //module
            $data['inputerror'][] = 'icon';
            $data['error_string'][] = 'Icon is required';
            //regimen
            $data['inputerror'][] = 'code';
            $data['error_string'][] = 'Code is required';
            $data['inputerror'][] = 'description';
            $data['error_string'][] = 'Description is required';
            $data['inputerror'][] = 'category_id';
            $data['error_string'][] = 'Category is required';
            $data['inputerror'][] = 'service_id';
            $data['error_string'][] = 'Service Name is required';
            $data['inputerror'][] = 'line_id';
            $data['error_string'][] = 'Line Name is required';
            //regimen_drug
            $data['inputerror'][] = 'drug_id';
            $data['error_string'][] = 'Drug is required';
            $data['inputerror'][] = 'regimen_id';
            $data['error_string'][] = 'Regimen is required';
            //subcounty
            $data['inputerror'][] = 'county_id';
            $data['error_string'][] = 'County Name is required';
            //submodule
            $data['inputerror'][] = 'module_id';
            $data['error_string'][] = 'Module Name is required';
            $data['status'] = FALSE;
            //role submodule
            $data['inputerror'][] = 'role_id';
            $data['error_string'][] = 'Role is required';
            $data['inputerror'][] = 'submodule_id';
            $data['error_string'][] = 'Submodule is required';
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

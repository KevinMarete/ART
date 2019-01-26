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
        }else{
            echo json_encode(array('data' => array()));
        }
    }

    //function add data to db_table
    public function add_data($table) {
        $this->_validate($table);
        $response = $this->Admin_model->save($table, $_POST);
        if($response['status']){
            $this->updateSysLogs('Created  (' . $table . ')');
        }
        echo json_encode($response);
    }

    //function edit data from db_table
    public function edit_data($id, $table) {
        $data = $this->Admin_model->get_by_id($id, $table);
        echo json_encode($data);
    }

    //function update data from db_table
    public function update_data($table) {
        $this->_validate($table);
        $id = $this->input->post('id');
        $response = $this->Admin_model->update($table, array('id' => $id), $_POST);
        if($response['status']){
            $this->updateSysLogs('Updated  (' . $table . '> Record ID ' . $id . ')');
        }
        echo json_encode($response);
    }

    //function delete from db_table
    public function delete_data($id, $table) {
        $this->Admin_model->delete_by_id($id, $table);
        $this->updateSysLogs('Deleted  (' . $id . '> Record ID ' . $table . ')');
        echo json_encode(array("status" => TRUE));
    }

    //function form validations
    private function _validate($table) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $required_inputs = array(
            'category' => array('name'),
            'change_reason' => array('name'),
            'county' => array('name'),
            'dhis_elements' => array('dhis_code', 'dhis_name', 'dhis_report', 'target_report', 'target_name', 'target_category', 'target_id'),
            'dose' => array('name', 'value', 'frequency'),
            'drug' => array('strength', 'packsize', 'generic_id', 'formulation_id', 'drug_category', 'min_mos', 'max_mos', 'amc_months', 'stock_status'),
            'facility' => array('name', 'mflcode', 'category', 'subcounty_id', 'partner_id', 'parent_id'),
            'formulation' => array('name'),
            'funding_agent' => array('name'),
            'generic' => array('name', 'abbreviation'),
            'install' => array('version', 'facility_id', 'setup_date', 'upgrade_date', 'user_id'),
            'line' => array('name'),
            'module' => array('name', 'icon'),
            'partner' => array('name'),
            'procurement_status' => array('name'),
            'purpose' => array('name'),
            'procurement_status' => array('name'),
            'regimen' => array('name', 'code', 'description', 'category_id', 'service_id', 'line_id'),
            'regimen_drug' => array('drug_id', 'regimen_id'),
            'role' =>  array('name'),
            'role_submodule' => array('role_id', 'submodule_id'),
            'service' => array('name'),
            'status' => array('name'),
            'subcounty' => array('name', 'county_id'),
            'submodule' => array('name', 'module_id'),
            'supplier' => array('name'),
            'user' => array('firstname', 'lastname', 'email_address', 'phone_number', 'password', 'role', 'scope_id')
        );

        foreach ($this->input->post() as $key => $value) {
            $index = str_ireplace('tbl_', '', $table);
            if(in_array($key, $required_inputs[$index]) && $value == ''){
                $data['inputerror'][] = $key;
                $data['error_string'][] = ucwords($key).' is required';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

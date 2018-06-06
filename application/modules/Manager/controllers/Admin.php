<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function get_data($table) {
        $response = $this->Admin_model->get_table_data($table);
        if ($response['status']) {
            echo json_encode(array('data' => $response['data']));
        }
    }

    //add data to database
    public function add_data() {
        $insert = $this->Admin_model->save($_POST);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id) {
        $data = $this->Admin_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update() {
        $this->Admin_model->update($_POST);
        echo json_encode(array("status" => TRUE));
    }

}

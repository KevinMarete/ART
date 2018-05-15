<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Backup extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Backup_model', 'backup');
        $this->load->model('Facility_model');
    }

    public function index() {
        $data['content_view'] = 'pages/backup_view';
        $data['page_title'] = 'ART | BackUp';
        $data['get_facility'] = $this->Facility_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->backup->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $backup) {
            $no++;
            $row = array();
            $row[] = $backup->name;
            $row[] = $backup->filename;
            $row[] = $backup->adt_version;
            $row[] = $backup->run_time;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_backup(' . "'" . $backup->id . "'" . ')"></a>
				  <a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_backup(' . "'" . $backup->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->backup->count_all(),
            "recordsFiltered" => $this->backup->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->backup->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'facility_id' => $this->input->post('name'),
            'filename' => $this->input->post('filename'),
            'adt_version' => $this->input->post('adt_version'),
        );
        $insert = $this->backup->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->backup->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->backup->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Facility Name is required';
            $data['status'] = FALSE;
        }

//        if ($this->input->post('filename') == '') {
//            $data['inputerror'][] = 'filename';
//            $data['error_string'][] = 'File Backup is required';
//            $data['status'] = FALSE;
//        }

        if ($this->input->post('adt_version') == '') {
            $data['inputerror'][] = 'adt_version';
            $data['error_string'][] = 'ADT Version is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

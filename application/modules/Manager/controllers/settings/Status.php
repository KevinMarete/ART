<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/admin/status_view';
        $data['page_title'] = 'ART | Status';
        $data['page_name']='status';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Status_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $status) {
            $no++;
            $row = array();
            $row[] = $status->name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_status(' . "'" . $status->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_status(' . "'" . $status->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Status_model->count_all(),
            "recordsFiltered" => $this->Status_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Status_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $insert = $this->Status_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->Status_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Status_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Status Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

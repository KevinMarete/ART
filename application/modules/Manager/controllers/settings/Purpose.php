<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purpose extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/admin/purpose_view';
        $data['page_title'] = 'ART | Purpose';
        $data['page_name']='purpose';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Purpose_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $purpose) {
            $no++;
            $row = array();
            $row[] = $purpose->name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_purpose(' . "'" . $purpose->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_purpose(' . "'" . $purpose->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Purpose_model->count_all(),
            "recordsFiltered" => $this->Purpose_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Purpose_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $insert = $this->Purpose_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->Purpose_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Purpose_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Purpose Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

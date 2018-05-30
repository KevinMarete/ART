<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formulation extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/admin/formulation_view';
        $data['page_title'] = 'ART | Formulation';
        $data['page_name']='formulation';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Formulation_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $formulation) {
            $no++;
            $row = array();
            $row[] = $formulation->name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_formulation(' . "'" . $formulation->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_formulation(' . "'" . $formulation->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Formulation_model->count_all(),
            "recordsFiltered" => $this->Formulation_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Formulation_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
        );
        $insert = $this->Formulation_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->Formulation_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Formulation_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Formulation Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

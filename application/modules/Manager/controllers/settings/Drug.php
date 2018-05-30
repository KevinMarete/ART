<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Drug extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/admin/drug_view';
        $data['page_title'] = 'ART | Drug';
        $data['page_name']='drug';
        $data['get_generic'] = $this->Generic_model->read();
        $data['get_formulation'] = $this->Formulation_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Drug_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $drug) {
            $no++;
            $row = array();
            $row[] = $drug->strength;
            $row[] = $drug->packsize;
            $row[] = $drug->generic_name;
            $row[] = $drug->formulation_name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_drug(' . "'" . $drug->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_drug(' . "'" . $drug->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Drug_model->count_all(),
            "recordsFiltered" => $this->Drug_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Drug_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'strength' => $this->input->post('strength'),
            'packsize' => $this->input->post('packsize'),
            'generic_id' => $this->input->post('generic_id'),
            'formulation_id' => $this->input->post('formulation_id')
        );
        $insert = $this->Drug_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'strength' => $this->input->post('strength'),
            'packsize' => $this->input->post('packsize'),
            'generic_id' => $this->input->post('generic_id'),
            'formulation_id' => $this->input->post('formulation_id')
        );
        $this->Drug_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Drug_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('strength') == '') {
            $data['inputerror'][] = 'strength';
            $data['error_string'][] = 'Drug Strength is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('packsize') == '') {
            $data['inputerror'][] = 'packsize';
            $data['error_string'][] = 'Drug Pack Size is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('generic_id') == '') {
            $data['inputerror'][] = 'generic_id';
            $data['error_string'][] = 'Generic Name is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('formulation_id') == '') {
            $data['inputerror'][] = 'formulation_id';
            $data['error_string'][] = 'Formulation is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

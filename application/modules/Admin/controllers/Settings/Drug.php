<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Drug extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Drug_model', 'drug');
        $this->load->model('Generic_model');
        $this->load->model('Formulation_model');
    }

    public function index() {
        $data['content_view'] = 'pages/settings/drug_view';
        $data['page_title'] = 'ART Dashboard | Settings';
        $data['get_generic'] = $this->Generic_model->read();
        $data['get_formulation'] = $this->Formulation_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->drug->get_datatables();
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
            $row[] = '<a class="btn btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_drug(' . "'" . $drug->id . "'" . ')"></a>
				  <a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_drug(' . "'" . $drug->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->drug->count_all(),
            "recordsFiltered" => $this->drug->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->drug->get_by_id($id);
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
        $insert = $this->drug->save($data);
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
        $this->drug->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->drug->delete_by_id($id);
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

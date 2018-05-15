<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Generic extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Generic_model', 'generic');
    }

    public function index() {
        $data['content_view'] = 'pages/settings/generic_view';
        $data['page_title'] = 'ART | Settings | Generic';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->generic->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $generic) {
            $no++;
            $row = array();
            $row[] = $generic->name;
            $row[] = $generic->abbreviation;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_generic(' . "'" . $generic->id . "'" . ')"></a>
				  <a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_generic(' . "'" . $generic->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->generic->count_all(),
            "recordsFiltered" => $this->generic->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->generic->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'abbreviation' => $this->input->post('abbreviation')
        );
        $insert = $this->generic->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'abbreviation' => $this->input->post('abbreviation')
        );
        $this->generic->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->generic->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Generic Name is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('abbreviation') == '') {
            $data['inputerror'][] = 'abbreviation';
            $data['error_string'][] = 'Abbreviation Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

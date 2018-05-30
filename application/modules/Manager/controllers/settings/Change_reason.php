<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Change_reason extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('settings/Change_reason_model', 'change_reason');
    }

    public function index() {
        $data['content_view'] = 'pages/admin/change_reason_view';
        $data['page_title'] = 'ART | Change Reason';
        $data['page_name']='change reason';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->change_reason->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $change_reason) {
            $no++;
            $row = array();
            $row[] = $change_reason->name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_change_reason(' . "'" . $change_reason->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_change_reason(' . "'" . $change_reason->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->change_reason->count_all(),
            "recordsFiltered" => $this->change_reason->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->change_reason->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $insert = $this->change_reason->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->change_reason->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->change_reason->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Change Reason is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

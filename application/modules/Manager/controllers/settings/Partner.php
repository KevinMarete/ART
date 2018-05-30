<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MX_Controller {
    public function index() {
        $data['content_view'] = 'pages/admin/partner_view';
        $data['page_title'] = 'ART | Partner';
        $data['page_name']='partner';
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Partner_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $partner) {
            $no++;
            $row = array();
            $row[] = $partner->name;
            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_partner(' . "'" . $partner->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_partner(' . "'" . $partner->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Partner_model->count_all(),
            "recordsFiltered" => $this->Partner_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Partner_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
        );
        $insert = $this->Partner_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->Partner_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Partner_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Partner Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

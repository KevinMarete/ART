<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subcounty extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/admin/subcounty_view';
        $data['page_title'] = 'ART | SubCounty';
        $data['page_name']='subcounty';
        $data['get_county'] = $this->County_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->Subcounty_model->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $subcounty) {
            $no++;
            $row = array();
            $row[] = $subcounty->subcounty_name;
            $row[] = $subcounty->county_name;

            //add html for action
            $row[] = '<a class="fa fa-pencil" href="javascript:void(0)" title="Edit" onclick="edit_subcounty(' . "'" . $subcounty->id . "'" . ')"></a> |
				  <a class="fa fa-trash" href="javascript:void(0)" title="Delete" onclick="delete_subcounty(' . "'" . $subcounty->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->Subcounty_model->count_all(),
            "recordsFiltered" => $this->Subcounty_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->Subcounty_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'county_id' => $this->input->post('county_id')
        );
        $insert = $this->Subcounty_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'county_id' => $this->input->post('county_id')
        );
        $this->Subcounty_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->Subcounty_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'SubCounty Name is required';
            $data['status'] = FALSE;
        }


        if ($this->input->post('county_id') == '') {
            $data['inputerror'][] = 'county_id';
            $data['error_string'][] = 'County Name is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

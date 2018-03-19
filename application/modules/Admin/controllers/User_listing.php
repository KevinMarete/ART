<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class User_listing extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('User_listing_model', 'user_listing');
        $this->load->model('Role_model');
    }

    public function index() {
        $data['content_view'] = 'pages/user_listing_view';
        $data['page_title'] = 'ART Dashboard | User Listing';
        $data['get_roles'] = $this->Role_model->read();
        $this->load->view('template/template_view', $data);
    }

    public function ajax_list() {
        $list = $this->user_listing->get_datatables();
        $data = array();
        $no = '';
        foreach ($list as $user_listing) {
            $no++;
            $row = array();
            $row[] = $user_listing->first_name;
            $row[] = $user_listing->last_name;
            $row[] = $user_listing->role;
            $row[] = $user_listing->email;
            $row[] = $user_listing->mobile;
            $row[] = $user_listing->updatedBy;
            $row[] = $user_listing->createdDtm;
            $row[] = $user_listing->updatedDtm;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary glyphicon glyphicon-pencil" href="javascript:void(0)" title="Edit" onclick="edit_user_listing(' . "'" . $user_listing->id . "'" . ')"></a>
				  <a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Delete" onclick="delete_user_listing(' . "'" . $user_listing->id . "'" . ')"></a>';

            $data[] = $row;
        }

        $output = array(
            "recordsTotal" => $this->user_listing->count_all(),
            "recordsFiltered" => $this->user_listing->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->user_listing->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('user_email'),
            'mobile' => $this->input->post('user_mobile'),
            'roleId' => $this->input->post('roleId'),
            'createdDtm' => date('Y-m-d H:i:s'),
            'updatedDtm' => date('Y-m-d H:i:s')
        );
        $insert = $this->user_listing->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('user_email'),
            'mobile' => $this->input->post('user_mobile'),
            'roleId' => $this->input->post('roleId'),
            'updatedDtm' => date('Y-m-d H:i:s'),
            'updatedBy' => $this->session->userdata('email')
        );
        $this->user_listing->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->user_listing->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('first_name') == '') {
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'First Name is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('last_name') == '') {
            $data['inputerror'][] = 'last_name';
            $data['error_string'][] = 'Last Name is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('user_email') == '') {
            $data['inputerror'][] = 'user_email';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('user_mobile') == '') {
            $data['inputerror'][] = 'user_mobile';
            $data['error_string'][] = 'User Mobile is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('roleId') == '') {
            $data['inputerror'][] = 'roleId';
            $data['error_string'][] = 'Please assign role';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}

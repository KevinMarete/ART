<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Procurement_model');
	}
	
	public function get_commodities(){
		$response = $this->Procurement_model->get_commodity_data();
		echo json_encode(array('data' => $response['data']));
	}

	public function get_tracker(){
		$response = $this->Procurement_model->get_tracker_data($this->input->post("drug_name"));
		echo json_encode(array('data' => $response['data']));
	}

	public function save_tracker(){
		$drug_id = $this->input->post('drug_id');
		$receipts = $this->input->post('receipt_qty');
		$transaction_date = $this->input->post('transaction_date');
		$status = $this->input->post('status');
		$funding_agent = $this->input->post('funding_agent');
		$supplier = $this->input->post('supplier');
		foreach ($receipts as $key => $qty) {
			$query = $this->db->query("CALL proc_save_tracker(?, ?, ? ,?, ?, ?, ?, ?)", array(
				date('Y', strtotime($transaction_date[$key])), date('M', strtotime($transaction_date[$key])), $drug_id, $qty, $funding_agent[$key], $supplier[$key], $status[$key], $this->session->userdata('id')
			));
		}
		$message = '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> Procurement was Added</div>';
		$this->session->set_flashdata('tracker_msg', $message);
		redirect('manager/procurement/tracker');
	}

}
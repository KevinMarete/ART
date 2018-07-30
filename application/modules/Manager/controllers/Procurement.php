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
		echo '<pre>';
		print_r($this->input->post());
	}

}
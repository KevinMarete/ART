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

	public function get_tracker($drug_id){
		$response = $this->Procurement_model->get_tracker_data($drug_id);
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

	public function get_transaction_table($drug_id, $period_year){
		$response = $this->Procurement_model->get_transaction_data($drug_id, $period_year);
		$open_kemsa = '';
		$receipts_kemsa = '';
		$issues_kemsa = '';
		$close_kemsa = '';
		$monthly_consumption = '';
		$avg_issues = '';
		$avg_consumption = '';
		$mos = '';
		$html_table = '<table class="table table-condensed table-striped table-bordered">';
		$thead = '<thead><tr><th>Description</th>';
		$tbody = '';
		foreach ($response['data'] as $values) {
			foreach ($values as $key => $value) {
				if($key == 'period'){
					$thead .= '<th>'.$value.'</th>';
				}else if($key == 'open_kemsa'){
					$open_kemsa .= '<td>'.$value.'</td>';
				}else if($key == 'receipts_kemsa'){
					$receipts_kemsa .= '<td>'.$value.'</td>';
				}else if($key == 'issues_kemsa'){
					$issues_kemsa .= '<td>'.$value.'</td>';
				}else if($key == 'close_kemsa'){
					$close_kemsa .= '<td>'.$value.'</td>';
				}else if($key == 'monthly_consumption'){
					$monthly_consumption .= '<td>'.$value.'</td>';
				}else if($key == 'avg_issues'){
					$avg_issues .= '<td>'.$value.'</td>';
				}else if($key == 'avg_consumption'){
					$avg_consumption .= '<td>'.$value.'</td>';
				}else if($key == 'mos'){
					if($value >= 6 && $value <= 9){
						$label = 'success';
					}else if($value >= 4  && $value <= 5){
						$label = 'warning';
					}else if($value <= 3){
						$label = 'danger';
					}else{
						$label = 'info';
					}
					$mos .= '<td class="'.$label.'">'.$value.'</td>';
				}
			}
		}
		$thead .= '</tr></thead><tbody>';
		$tbody .= '<tr><td>Open Balance</td>'.$open_kemsa.'</tr>';
		$tbody .= '<tr><td>Receipts from Suppliers</td>'.$receipts_kemsa.'</tr>';
		$tbody .= '<tr><td>Issues to Facility</td>'.$issues_kemsa.'</tr>';
		$tbody .= '<tr><td>Closing Balance</td>'.$close_kemsa.'</tr>';
		$tbody .= '<tr><td>Monthly Consumption</td>'.$monthly_consumption.'</tr>';
		$tbody .= '<tr><td>Average Issues</td>'.$avg_issues.'</tr>';
		$tbody .= '<tr><td>Average Consumption</td>'.$avg_consumption.'</tr>';
		$tbody .= '<tr><td>Months of Stock</td>'.$mos.'</tr>';
		$html_table .= $thead;
		$html_table .= $tbody;
		$html_table .= '</tbody></table>';
		echo $html_table;
	}

	public function get_order_table($drug_id){
		$response = $this->Procurement_model->get_order_data($drug_id);
		$html_table = '<table class="table table-condensed table-striped table-bordered">';
		$thead = '<thead><tr>';
		$tbody = '<tbody>';
		foreach ($response['data'] as $count => $values) {
			$tbody .= '<tr>';
			foreach ($values as $key => $value) {
				if($count == 0){
					$thead .= '<th>'.$key.'</th>';
				}
				$tbody .= '<td>'.$value.'</td>';
			}
			$tbody .= '</tr>';
		}
		$thead .= '</tr></thead>';
		$html_table .= $thead;
		$html_table .= $tbody;
		$html_table .= '</tbody></table>';
		echo $html_table;
	}

	public function get_log_table($drug_id){
		$response = $this->Procurement_model->get_log_data($drug_id);
		$html_table = '<table class="table table-condensed table-striped table-bordered">';
		$thead = '<thead><tr>';
		$tbody = '<tbody>';
		foreach ($response['data'] as $count => $values) {
			$tbody .= '<tr>';
			foreach ($values as $key => $value) {
				if($count == 0){
					$thead .= '<th>'.$key.'</th>';
				}
				$tbody .= '<td>'.$value.'</td>';
			}
			$tbody .= '</tr>';
		}
		$thead .= '</tr></thead>';
		$html_table .= $thead;
		$html_table .= $tbody;
		$html_table .= '</tbody></table>';
		echo $html_table;
	}

}
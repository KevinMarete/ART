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

	public function get_decisions($drug_id){
		$html_timeline = '';
		$response = $this->Procurement_model->get_decision_data($drug_id);
		foreach ($response['data'] as $values) {
			$html_timeline .= '<div class="row timeline-movement">
						            <div class="timeline-badge">
						                <span class="timeline-balloon-date-day">'.date("d", strtotime($values["decision_date"])).'</span>
						                <span class="timeline-balloon-date-month">'.date("M/y", strtotime($values["decision_date"])).'</span>
						            </div>
						            <div class="col-sm-6  timeline-item">
						                <div class="row">
						                    <div class="col-sm-11">
						                        <div class="timeline-panel credits">
						                            <ul class="timeline-panel-ul">
						                                <li><span class="importo">Discussions</span></li>
						                                <li><span class="causale">'.$values["discussion"].'</span> </li>
						                                <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>Last updated by '.$values["user"].' on '.date('d/m/Y h:i:s a', strtotime($values["created"])).'</small></p> </li>
						                            </ul>
						                        </div>

						                    </div>
						                </div>
						            </div>
						            <div class="col-sm-6  timeline-item">
						                <div class="row">
						                    <div class="col-sm-offset-1 col-sm-11">
						                        <div class="timeline-panel debits">
						                            <ul class="timeline-panel-ul">
						                                <li><span class="importo">Recommendations</span></li>
						                                <li><span class="causale">'.$values["recommendation"].'</span> </li>
						                                <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Last updated by '.$values["user"].' on '.date('d/m/Y h:i:s a', strtotime($values["created"])).'</small></p> </li>
						                            </ul>
						                        </div>

						                    </div>
						                </div>
						            </div>
						        </div>';
		}
		echo $html_timeline;
	}

	public function get_transaction_table($drug_id, $period_year){
		$responses = array();
		$headers = array();
		$widths = array();
		$columns = array();
		$alignments = array();
		$column_indices = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
		$drug_name = '';
		$response = $this->Procurement_model->get_transaction_data($drug_id, $period_year);
		//Initial sidebar labels
		$responses = array(
			'open_kemsa' => array('Open Balance'), 
			'receipts_kemsa' => array('Receipts from Suppliers'), 
			'issues_kemsa' => array('Issues to Facility'), 
			'close_kemsa' => array('Closing Balance'), 
			'monthly_consumption' => array('Monthly Consumption'), 
			'avg_issues' => array('Average Issues'), 
			'avg_consumption' => array('Average Consumption'), 
			'mos' => array('Months of Stock')
		);
		$headers[] = 'Description';
		$widths[] = '160';
		$columns[] = array('type' => 'text', 'readOnly' => true);
		$alignments[] = 'left';
		foreach ($response['data'] as $key => $value) {
			$headers[] = $value['period'];
			$widths[] = '80';
			$columns[] = array('type' => 'numeric');
			$alignments[] = 'center';
			//Put formaulas
			if($key == 0){
				$drug_name = $value['drug'];
				$responses['open_kemsa'][] = $value['open_kemsa'];
			}else{
				$responses['open_kemsa'][] = '='.$column_indices[$key-1].'4';
			}
			$responses['receipts_kemsa'][] = $value['receipts_kemsa'];
			$responses['issues_kemsa'][] = $value['issues_kemsa'];
			$responses['close_kemsa'][] = '='.$column_indices[$key].'1+'.$column_indices[$key].'2-'.$column_indices[$key].'3';
			$responses['monthly_consumption'][] = $value['monthly_consumption'];
			$responses['avg_issues'][] = $value['avg_issues'];
			$responses['avg_consumption'][] = $value['avg_consumption'];
			$responses['mos'][] = $value['mos'];
		}
		echo json_encode(array(
			'data' => array_values($responses), 
			'colHeaders' => $headers, 
			'colWidths' => $widths, 
			'columns' => $columns,
			'colAlignments' => $alignments,
			'csvFileName' => $drug_name.' Procurement Tracker for '.$period_year,
			'columnSorting' => false,
			'csvHeaders' => true
		), JSON_NUMERIC_CHECK);
	}

	public function get_order_table($drug_id){
		$response = $this->Procurement_model->get_order_data($drug_id);
		$html_table = '<table class="table table-condensed table-striped table-bordered order_tbl">';
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
		$html_table = '<table class="table table-condensed table-striped table-bordered log_tbl">';
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

	public function get_default_period()
	{	
		$default_period = array(
			'year' => $this->config->item('data_year'), 
			'month' => $this->config->item('data_month'), 
			'drug' => $this->config->item('drug'));
		echo json_encode($default_period);
    }

	public function get_chart()
	{
		$chartname = $this->input->post('name');
        $selectedfilters = $this->get_filter($chartname, $this->input->post('selectedfilters'));
        //Set filters based on role and scope
        $role = $this->session->userdata('role');
        if(!in_array($role, array('admin', 'national'))){
        	$selectedfilters[$role] = $this->session->userdata('scope_name');
        }
		//Get chart configuration
		$data['chart_name']  = $chartname;
		$data['chart_title']  = $this->config->item($chartname.'_title');
		$data['chart_yaxis_title'] = $this->config->item($chartname.'_yaxis_title');
		$data['chart_xaxis_title'] = $this->config->item($chartname.'_xaxis_title');
		$data['chart_source'] = $this->config->item($chartname.'_source');
		//Get data
		$main_data = array('main' => array(), 'drilldown' => array(), 'columns' => array());
		$main_data = $this->get_data($chartname, $selectedfilters);
		if($this->config->item($chartname.'_has_drilldown')){
			$data['chart_drilldown_data'] = json_encode(@$main_data['drilldown'], JSON_NUMERIC_CHECK);
		}else{
			$data['chart_categories'] =  json_encode(@$main_data['columns'], JSON_NUMERIC_CHECK);
		}
		$data['selectedfilters'] = htmlspecialchars(json_encode($selectedfilters), ENT_QUOTES, 'UTF-8');
        $data['chart_series_data'] = json_encode($main_data['main'], JSON_NUMERIC_CHECK);
        //Load chart
		$this->load->view($this->config->item($chartname.'_chartview'), $data);
    }

    public function get_filter($chartname, $selectedfilters)
	{   
		$filters = $this->config->item($chartname.'_filters_default');
        $filtersColumns = $this->config->item($chartname.'_filters');

		if(!empty($selectedfilters)){
            foreach(array_keys($selectedfilters) as $filter)
            {
                if(in_array($filter, $filtersColumns)){
                    $filters[$filter] = $selectedfilters[$filter];
                }
            } 	
        }
		return $filters;
    }

    public function get_data($chartname, $filters)
	{	
		if ($chartname == 'consumption_issues_chart') {
            $main_data = $this->Procurement_model->get_procurement_consumption_issues($filters);
        }else if ($chartname == 'actual_consumption_issues_chart') {
            $main_data = $this->Procurement_model->get_procurement_actual_consumption_issues($filters);
        }else if ($chartname == 'kemsa_soh_chart') {
            $main_data = $this->Procurement_model->get_procurement_kemsa_soh($filters);
        }else if ($chartname == 'adult_patients_on_drug_chart') {
            $main_data = $this->Procurement_model->get_procurement_adult_patients_on_drug($filters);
        }else if ($chartname == 'paed_patients_on_drug_chart') {
            $main_data = $this->Procurement_model->get_procurement_paed_patients_on_drug($filters);
        }else if($chartname == 'stock_status_chart'){
			$main_data = $this->Procurement_model->get_procurement_stock_status($filters);
		}else if ($chartname == 'expected_delivery_chart') {
            $main_data = $this->Procurement_model->get_procurement_expected_delivery($filters);
        }
		return $main_data;
	}

	public function edit_order(){
		$input = $this->input->post();
		//Evaluate type of action
		if ($input['action'] == 'edit') {
			unset($input['action']);
			$this->Procurement_model->edit_procurement_item($input);
			$input['action'] = 'edit';
		} else if ($input['action'] == 'delete') {
			unset($input['action']);
			$this->Procurement_model->delete_procurement_item($input['id']);
			$input['action'] = 'delete';
		} 
		echo json_encode($input);
	}

	public function get_order_items(){
		$response = array();
		$item_urls = array(
			'status' => base_url().'API/procurement_status',
			'funding' =>  base_url().'API/funding_agent',
			'supplier' =>  base_url().'API/supplier'
		);
		foreach ($item_urls as $key => $item_url) {
			if($key != 'status'){
				$response[$key][0] = 'Select one';
			}
			foreach (json_decode(file_get_contents($item_url), TRUE) as $values) {
			 	$response[$key][$values['id']] = $values['name'];
			} 
		}
		echo json_encode($response);
	}

}
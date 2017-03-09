<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
		ini_set("max_execution_time", "100000");
		ini_set("memory_limit", '2048M');
	}

	public function index()
	{	
		$data['page_title'] = 'ADT | Dashboard';
		$this->load->view('dashboard_view', $data);
	}

	public function get_chart()
	{
		$chartname = $this->input->post('name');
		$selectedfilters = $this->input->post('selectedfilters');
		//Get chart configuration
		$data['chart_name']  = $chartname;
		$data['chart_title']  = $this->config->item($chartname.'_title');
		$data['chart_yaxis_title'] = $this->config->item($chartname.'_yaxis_title');
		$data['chart_xaxis_title'] = $this->config->item($chartname.'_xaxis_title');
		$data['chart_source'] = $this->config->item($chartname.'_source');
		$chartview = $this->config->item($chartname.'_chartview');
		$has_drilldown = $this->config->item($chartname.'_has_drilldown');
		//Get data
		$main_data = $this->get_data($chartname);
		$data['chart_series_data'] = json_encode($main_data['main'], JSON_NUMERIC_CHECK);
		if($has_drilldown){
			$data['chart_drilldown_data'] = json_encode($main_data['drilldown'], JSON_NUMERIC_CHECK);
		}else{
			$data['chart_categories'] =  json_encode($main_data['columns'], JSON_NUMERIC_CHECK);
		}
		//Load chart
		$this->load->view($chartview, $data);
	}

	public function get_data($chartname)
	{	
		if($chartname == 'national_mos'){
			$main_data = $this->national_model->get_mos_total('2016', 'Oct');
		}else if($chartname == 'drug_consumption_trend'){
			$main_data = $this->facility_model->get_consumption_total(array('Abacavir (ABC) 300mg tabs(60)', 'Lamivudine (3TC) 150mg Tabs(60)'));
		}else if($chartname == 'patient_in_care'){
			$main_data = $this->patient_model->get_county_total('2017', 'Jan', array('Adult ART'));
		}else if($chartname == 'patient_regimen_category'){
			$main_data = $this->regimen_model->get_category_total('2017', 'Jan');
		}else if($chartname == 'art_scaleup'){
			$main_data = $this->scaleup_model->get_category_total();
		}
		return $main_data;
	}

	public function get_filter($chart_name)
	{	
		$data = array();
		//Get filters from chart cfg
		$filters = $this->config->item($chart_name.'_filters');
		$view_name = $this->config->item($chart_name.'_view_name');
		foreach ($filters as $column) {
			$filter_data = $this->dashboard_model->get_filters($column, $view_name);
			foreach ($filter_data as $item) {
				$data[$column][] = array('id'=> $item['filter'], 'text' =>  strtoupper($item['filter']));
			}
		}
		echo json_encode($data);
	}

}

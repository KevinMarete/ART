<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
		ini_set("max_execution_time", "100000");
		ini_set("memory_limit", '2048M');
	}

	public function index()
	{	
		$data['page_title'] = 'ART | Dashboard';
		$this->load->view('template/dashboard_view', $data);
	}

	/* load the defaults */
	public function get_latest_date()
	{	
		$data_date = $this->config->item('data_date');
		$period = explode('-', $data_date);
		$default_date = array('year' => $period[0], 'month' => $period[1]);

		header('Content-Type: application/json');
		echo json_encode($default_date);
	}

	public function get_selected_regimen() 
	{
		$selected_regimen = $this->config->item('selected_regimen_patients_on_regimen');

		header('Content-Type: application/json');
		echo json_encode($selected_regimen);
	}

	public function get_selected_counties() 
	{
		$counties = $this->config->item('counties');

		header('Content-Type: application/json');
		echo json_encode($counties);
	}

	public function get_selected_drugs_mos() 
	{
		$drugs = $this->config->item('selected_drugs_mos');

		header('Content-Type: application/json');
		echo json_encode($drugs);
	}

	public function get_selected_cms_drug() 
	{
		$cms_drug = $this->config->item('selected_cms_drug');

		header('Content-Type: application/json');
		echo json_encode($cms_drug);
	}

	public function get_selected_drugs_com_consumption() 
	{
		$drugs = $this->config->item('selected_drugs_com_consumption');

		header('Content-Type: application/json');
		echo json_encode($drugs);
	}

	public function get_filter($chartname, $selectedfilters)
	{
		$filter = array();	
		$defaultfilters = $this->config->item($chartname.'_filters_default');
		$filtersColumns = $this->config->item($chartname.'_filters');

		// check if input has filters/values
		if(empty($selectedfilters)){
			$filter = $defaultfilters;
		}
		else{

			// check if selectedfilters have the required filters 
			$missing_keys = array_keys(array_diff_key($selectedfilters, $defaultfilters));
			$merged_filters = array_merge($defaultfilters, $selectedfilters);
			foreach ($merged_filters as $key => $value) {
				if(!in_array($key, $missing_keys)){
					$filter[$key] = $value;
				}
			}	
		}
		return $filter;
	}

	public function get_chart()
	{

		/// use default filter columns & values if filters not set

		$chartname = $this->input->post('name');
		$selectedfilters = $this->get_filter($chartname,$this->input->post('selectedfilters'));

		// print_r($selectedfilters); exit;
		//Get default filters
		//Get chart configuration
		$data['chart_name']  = $chartname;
		$data['chart_title']  = $this->config->item($chartname.'_title');
		$data['chart_yaxis_title'] = $this->config->item($chartname.'_yaxis_title');
		$data['chart_xaxis_title'] = $this->config->item($chartname.'_xaxis_title');
		$data['chart_source'] = $this->config->item($chartname.'_source');
		$chartview = $this->config->item($chartname.'_chartview');
		$has_drilldown = $this->config->item($chartname.'_has_drilldown');
		//Get data
		$main_data = array('main' => array(), 'drilldown' => array(), 'columns' => array());
		$main_data = $this->get_data($chartname, $selectedfilters);
		$data['chart_series_data'] = json_encode($main_data['main'], JSON_NUMERIC_CHECK);
		if($has_drilldown){
			$data['chart_drilldown_data'] = json_encode(@$main_data['drilldown'], JSON_NUMERIC_CHECK);
		}else{
			$data['chart_categories'] =  json_encode(@$main_data['columns'], JSON_NUMERIC_CHECK);
		}
		// echo "<pre>";
		// print_r($main_data); exit;
		// echo "<pre>";
		//Load chart
		$this->load->view($chartview, $data);
	}

	public function get_data($chartname, $filters)
	{	

		if($chartname == 'patient_scaleup_chart'){
			$main_data = $this->dashboard_model->get_patient_scaleup($filters);
		}else if($chartname == 'patient_services_chart'){
			$main_data = $this->dashboard_model->get_patient_services($filters);
		}else if($chartname == 'national_mos_chart'){
			$main_data = $this->dashboard_model->get_national_mos($filters);
		}else if($chartname == 'commodity_consumption_chart'){
			$main_data = $this->dashboard_model->get_commodity_consumption($filters);
		}else if($chartname == 'county_patient_distribution_chart'){
			$main_data = $this->dashboard_model->get_county_patient_distribution($filters);
		}else if($chartname == 'county_patient_distribution_table'){
			$main_data = $this->dashboard_model->get_county_patient_distribution_numbers($filters);
		}else if($chartname == 'subcounty_patient_distribution_chart'){
			$main_data = $this->dashboard_model->get_subcounty_patient_distribution($filters);
		}else if($chartname == 'subcounty_patient_distribution_table'){
			$main_data = $this->dashboard_model->get_subcounty_patient_distribution_numbers($filters);
		}else if($chartname == 'facility_patient_distribution_chart'){
			$main_data = $this->dashboard_model->get_facility_patient_distribution($filters);
		}
		// else if($chartname == 'facility_patients_distribution_service_chart'){
		// 	$main_data = $this->dashboard_model->get_facility_patient_distribution_service($filters);
		// }
		else if($chartname == 'facility_regimen_distribution_chart'){
			$main_data = $this->dashboard_model->get_facility_regimen_distribution($filters);
		}else if($chartname == 'facility_commodity_consumption_chart'){
			$main_data = $this->dashboard_model->get_facility_commodity_consumption($filters);
		}else if($chartname == 'facility_patient_distribution_table'){
			$main_data = $this->dashboard_model->get_facility_patient_distribution_numbers($filters);
		}else if($chartname == 'partner_patient_distribution_chart'){
			$main_data = $this->dashboard_model->get_partner_patient_distribution($filters);
		}else if($chartname == 'partner_patient_distribution_table'){
			$main_data = $this->dashboard_model->get_partner_patient_distribution_numbers($filters);
		}else if($chartname == 'adt_site_distribution_chart'){
			$main_data = $this->dashboard_model->get_adt_site_distribution($filters);
			// echo json_encode($main_data);die;
		}else if($chartname == 'adt_site_distribution_table'){
			$main_data = $this->dashboard_model->get_adt_site_distribution_numbers($filters);
		}else if($chartname == 'regimen_patient_chart'){
			$main_data = $this->dashboard_model->get_regimen_patients($filters);
		}else if($chartname == 'drug_regimen_consumption_chart'){
			$main_data = $this->dashboard_model->get_regimen_top_commodities($filters);		
		}else if($chartname == 'regimen_patients_counties_chart'){
			$main_data = $this->dashboard_model->get_regimen_patients_by_county($filters);
		}else if($chartname == 'drug_consumption_chart'){
			$main_data = $this->dashboard_model->get_regimen_consumption($filters);
		}else if($chartname == 'adt_version_distribution_chart'){
			$main_data = $this->dashboard_model->get_adt_versions_summary($filters);
		}else if($chartname == 'adt_sites_overview_chart'){
			$main_data = $this->dashboard_model->get_adt_versions_summary($filters);
		}else if($chartname == 'patients_regimen_chart'){
			$main_data = $this->dashboard_model->get_patients_regimen($filters);
		}else if($chartname == 'commodity_month_stock_chart'){
			$main_data = $this->dashboard_model->get_commodity_month_stock($filters);
		}
		
		return $main_data;
	}

	function get_regimens(){
		$regimens = $this->dashboard_model->get_regimens();
		header('Content-Type: application/json');
		echo json_encode($regimens);

	}

	function get_counties(){
		$counties = $this->dashboard_model->get_counties();
		header('Content-Type: application/json');
		echo json_encode($counties);

	}

	function get_sites(){
		$sites = array();
		$sites['summary'] = $this->dashboard_model->get_adt_sites_summary();
		$sites['overview'] = $this->dashboard_model->get_adt_site_overview();

		header('Content-Type: application/json');
		echo json_encode($sites);

	}

	function get_consmp_drug_dropdowns() 
	{
		$drugs = $this->dashboard_model->get_consmp_drug_dropdowns();

		header('Content-Type: application/json');
		echo json_encode($drugs);
	}

	function get_stock_drug_dropdowns() 
	{
		$drugs = $this->dashboard_model->get_stock_drug_dropdowns();

		header('Content-Type: application/json');
		echo json_encode($drugs);
	}

	function get_regimen_dropdowns() 
	{
		$regimens = $this->dashboard_model->get_regimen_dropdowns();

		header('Content-Type: application/json');
		echo json_encode($regimens);
	}

	function get_facilities() 
	{
		$facilities = $this->dashboard_model->get_facilities();

		header('Content-Type: application/json');
		echo json_encode($facilities);
	}


	
	
}
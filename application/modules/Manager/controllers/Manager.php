<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {

	public function index()
	{	
		$this->load_page('user', 'login', 'Login');
	}
	
	public function load_page($module = 'user', $page = 'login', $title = 'Login')
	{	
		if($page == 'register'){
			$data['roles'] = $this->db->get('tbl_role')->result_array();
		}
		$data['page_title'] = 'ART | '.$title;
		$this->load->view('pages/'.$module.'/'.$page.'_view', $data);
	}

	public function load_template($module = 'dashboard', $page = 'dashboard', $title = 'Dashboard', $is_table = TRUE,$id1 = null,$id2 = null)
	{
		$data['page_name'] = $page;
		if($this->session->userdata('id')){
			$data['content_view'] = 'pages/'.$module.'/'.$page.'_view';
			if($is_table){
				$data['columns'] = $this->db->list_fields('tbl_'.$page);
				$data['content_view'] = 'template/table_view';
			}
			if($page == 'assign'){
				$data['scopes'] = $this->db->order_by('name', 'ASC')->get('tbl_'.$this->session->userdata('role'))->result_array();
			}else if($module == 'orders'){
				$this->load->model('Orders_model');
				$columns = array(
					'reports' => array(
						'subcounty' => array('#CDRR-ID', '#MAPS-ID', 'Period Beginning', 'Status', 'Facility Name', 'Options'),
						'county' => array('Subcounty', 'Reported Count', 'Options')
					),
					'allocation' => array(
						'subcounty' => array('#CDRR-ID', '#MAPS-ID', 'Period Beginning', 'Status', 'Facility Name', 'Options'),
						'county' => array('Subcounty', 'Reported Count', 'Options')
					),
					'reporting_rates' => array(
						'subcounty' => array('MFL Code', 'Facility Name', 'Order Reports', 'Options'),
						'county' => array('Subcounty', 'Reported Count', 'Options')
					),
					'cdrr_maps' => array(
						'subcounty' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_drugs(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), NULL,$this->session->userdata('sub_county')), // get cdrr list
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5') ,  NULL,$this->session->userdata('sub_county')) // get maps list
						)
					)
				);
				$data['columns'] = $columns[$page][$this->session->userdata('role')];

// load cdrr
				// echo "<pre>";				var_dump($data['columns']['maps']); die;
				// var_dump($id1);// get cdrr
				// var_dump($id2);// get map
				// die;
			}
        	$data['page_title'] = 'ART | '.ucwords($title);
        	$this->load->view('template/template_view', $data);
		}else{
			redirect("manager/login");
		}	

	}
	
}
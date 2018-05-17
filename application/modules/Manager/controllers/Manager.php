<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {

	public function index() {
		$this->load_page('user', 'login', 'Login');
	}

	public function load_page($module = 'user', $page = 'login', $title = 'Login') {
		if ($page == 'register') {
			$data['roles'] = $this->db->get('tbl_role')->result_array();
		}
		$data['page_title'] = 'ART | ' . $title;
		$this->load->view('pages/' . $module . '/' . $page . '_view', $data);
	}

	public function load_template($module = 'dashboard', $page = 'dashboard', $title = 'Dashboard', $is_table = TRUE) {

		if ($this->session->userdata('id')) {
			$data['content_view'] = 'pages/' . $module . '/' . $page . '_view';
			if ($is_table) {
				$data['page_name'] = $page;
				$data['columns'] = $this->db->list_fields('tbl_' . $page);
				$data['content_view'] = 'template/table_view';
			}
			if ($page == 'assign') {
            //$data['scopes'] = $this->db->order_by('name', 'ASC')->get('tbl_' . $this->session->userdata('role'))->result_array();
				$data['scopes'] = array();
			} else if ($module == 'orders') {
				$this->load->model('Orders_model');
				$data['page_name'] = $page;
				$columns = array(
					'reports' => array(
						'subcounty' => array('#CDRR-ID', '#MAPS-ID', 'Period Beginning', 'Status', 'Facility Name', 'Actions'),
						'county' => array('#CDRR-ID', '#MAPS-ID', 'Period Beginning', 'Status', 'Subcounty', 'Facility Name', 'Actions')
					),
					'reporting_rates' => array(
						'subcounty' => array('MFL Code', 'Facility Name', 'Status', 'Period', 'Actions'),
						'county' => array('Subcounty', 'Submitted', 'Progress')
					),
					'cdrr_maps' => array(
						'subcounty' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'),$this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'),$this->session->userdata('scope'),$this->session->userdata('role'))
						),
						'county' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'),$this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'),$this->session->userdata('scope'),$this->session->userdata('role'))
						)
					),
					'allocation' => array(
						'subcounty' => array('MFL Code','Facility Name', 'Period', 'Status', 'Actions'),
						'county' => array('Period', 'Allocated', 'Status', 'Actions')
					),
					'edit_allocation' => array(
						'subcounty' => array(),
						'county' => array('Subcounty', 'Status', 'Approval', 'Actions')
					)
				);
				$data['columns'] = $columns[$page][$this->session->userdata('role')];
				$data['role'] = $this->session->userdata('role');
				$data['cdrr_id'] = $this->uri->segment('4');
			}
			$data['page_title'] = 'ART | ' . ucwords($title);
			$this->load->view('template/template_view', $data);
		} else {
			redirect("manager/login");
		}
	}
}

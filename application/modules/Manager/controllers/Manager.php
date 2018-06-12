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
			$data['page_name'] = $page;
			$data['content_view'] = 'pages/' . $module . '/' . $page . '_view';
			if ($is_table) {
				$data['columns'] = $this->db->list_fields('tbl_' . $page);
				$data['content_view'] = 'template/table_view';
			}

			if ($module == 'orders') {
				$this->load->model('Orders_model');
				$columns = array(
					'reports' => array(
						'subcounty' => array('Facility Name', 'Period Beginning', 'Status',  'Actions'),
						'county' => array('Facility Name','Period Beginning', 'Subcounty', 'Status', 'Actions'),
						'national' => array('Facility Name', 'Period Beginning', 'County', 'Subcounty', 'Status', 'Actions')
					),
					'reporting_rates' => array(
						'subcounty' => array('MFL Code', 'Facility Name', 'Status', 'Period', 'Actions'),
						'county' => array('Subcounty', 'Submitted', 'Progress'),
						'national' => array('County', 'Submitted', 'Progress')
					),
					'cdrr_maps' => array(
						'subcounty' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						),
						'county' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						),
						'national' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						)
					),
					'allocation' => array(
						'subcounty' => array('MFL Code','Facility Name', 'Period', 'Status', 'Actions'),
						'county' => array('Period', 'Approved', 'Status', 'Actions'),
						'national' => array('Period', 'Reviewed', 'Status', 'Actions')
					),
					'allocate' => array(
						'subcounty' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						),
						'county' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						),
						'national' => array(
							'drugs' => $this->Orders_model->get_drugs(),
							'regimens' => $this->Orders_model->get_regimens(),
							'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'),$this->session->userdata('role')),
							'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'),$this->session->userdata('role'))
						)
					),
					'edit_allocation' => array(
						'subcounty' => array(),
						'county' => array('Subcounty', 'Report Count', 'Status', 'Approval', 'Actions'),
						'national' => array('County', 'Report Count', 'Status', 'Approval', 'Actions')
					),
					'subcounty_reports' => array(
						'subcounty' => array(),
						'county' => array('MFL Code', 'Facility Name', 'Status', 'Period', 'Actions'),
						'national' => array()
					),
					'county_reports' => array(
						'subcounty' => array(),
						'county' => array(),
						'national' => array('SubCounty', 'MFL Code', 'Facility Name', 'Status', 'Period', 'Actions')
					)
				);
				$data['columns'] = $columns[$page][$this->session->userdata('role')];
				$data['role'] = $this->session->userdata('role');
				$data['cdrr_id'] = $this->uri->segment('4');
				$data['map_id'] = $this->uri->segment('5');
				$data['seg_4'] = $this->uri->segment('4');
				$data['seg_5'] = $this->uri->segment('5');
				$data['seg_6'] = $this->uri->segment('6');
			}
			$data['page_title'] = 'ART | ' . ucwords($title);
			$this->load->view('template/template_view', $data);
		} else {
			redirect("manager/login");
		}
	}
}

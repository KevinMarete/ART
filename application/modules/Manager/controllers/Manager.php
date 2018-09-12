<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {

    public function index() {
        $this->load_page('user', 'login', 'Login');
    }

    public function load_page($module = 'user', $page = 'login', $title = 'Login') {
        if ($page == 'register') {
            $this->db->where_not_in('name', 'admin');
            $data['roles'] = $this->db->get('tbl_role')->result_array();
        }
        $data['page_title'] = 'ART | ' . $title;
        $this->load->view('pages/' . $module . '/' . $page . '_view', $data);
    }

    public function load_template($module = 'dashboard', $page = 'dashboard', $title = 'Dashboard', $is_table = TRUE) {
        //echo   $this->session->userdata('scope').$this->session->userdata('role');
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
                        'subcounty' => array('Facility Name', 'Period Beginning', 'Description', 'Status', 'Actions'),
                        'county' => array('Facility Name', 'Period Beginning', 'Description', 'Subcounty', 'Status', 'Actions'),
                        'national' => array('Facility Name', 'Period Beginning', 'Description', 'County', 'Subcounty', 'Status', 'Actions')
                    ),
                    'reporting_rates' => array(
                        'subcounty' => array('MFL Code', 'Facility Name', 'Status', 'Description', 'Period', 'Actions'),
                        'county' => array('Subcounty', 'Submitted', 'Progress'),
                        'national' => array('County', 'Submitted', 'Progress')
                    ),
                    'cdrr_maps' => array(
                        'subcounty' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'county' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'national' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        )
                    ),
                    'allocation' => array(
                        'subcounty' => array('MFL Code', 'Facility Name', 'Period', 'Description', 'Status', 'Actions'),
                        'county' => array('Period', 'Approved', 'Status', 'Actions'),
                        'national' => array('Period', 'Reviewed', 'Status', 'Actions')
                    ),
                    'allocate' => array(
                        'subcounty' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'county' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'national' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        )
                    ),
                    'edit_allocation' => array(
                        'subcounty' => array(),
                        'county' => array('Subcounty', 'Report Count', 'Status', 'Approval', 'Actions'),
                        'national' => array('County', 'Report Count', 'Status', 'Approval', 'Actions')
                    ),
                    'subcounty_reports' => array(
                        'subcounty' => array(),
                        'county' => array('MFL Code', 'Facility Name', 'Description', 'Status', 'Period', 'Actions'),
                        'national' => array()
                    ),
                    'county_reports' => array(
                        'subcounty' => array(),
                        'county' => array(),
                        'national' => array('SubCounty', 'MFL Code', 'Facility Name', 'Description', 'Status', 'Period', 'Actions')
                    ),
                    'satellites' => array(
                        'subcounty' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_satellite_cdrr($this->uri->segment('4')),
                            'maps' => $this->Orders_model->get_satellite_maps($this->uri->segment('5'))
                        ),
                        'county' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_satellite_cdrr($this->uri->segment('4')),
                            'maps' => $this->Orders_model->get_satellite_maps($this->uri->segment('5'))
                        ),
                        'national' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_satellite_cdrr($this->uri->segment('4')),
                            'maps' => $this->Orders_model->get_satellite_maps($this->uri->segment('5'))
                        )
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

   

    public function get_chart() {
        $chartname = $this->input->post('name');
        $selectedfilters = $this->get_filter($chartname, $this->input->post('selectedfilters'));
        //Set filters based on role and scope
        $role = $this->session->userdata('role');
        if (!in_array($role, array('admin', 'national'))) {
            $selectedfilters[$role] = $this->session->userdata('scope_name');
        }
        //Get chart configuration
        $data['chart_name'] = $chartname;
        $data['chart_title'] = $this->config->item($chartname . '_title');
        $data['chart_yaxis_title'] = $this->config->item($chartname . '_yaxis_title');
        $data['chart_xaxis_title'] = $this->config->item($chartname . '_xaxis_title');
        $data['chart_source'] = $this->config->item($chartname . '_source');
        //Get data
        $main_data = array('main' => array(), 'drilldown' => array(), 'columns' => array());
        $main_data = $this->get_data($chartname, $selectedfilters);
        if ($this->config->item($chartname . '_has_drilldown')) {
            $data['chart_drilldown_data'] = json_encode(@$main_data['drilldown'], JSON_NUMERIC_CHECK);
        } else {
            $data['chart_categories'] = json_encode(@$main_data['columns'], JSON_NUMERIC_CHECK);
        }
        $data['selectedfilters'] = htmlspecialchars(json_encode($selectedfilters), ENT_QUOTES, 'UTF-8');
        $data['chart_series_data'] = json_encode($main_data['main'], JSON_NUMERIC_CHECK);
        //Load chart
        $this->load->view($this->config->item($chartname . '_chartview'), $data);
    }

    public function get_filter($chartname, $selectedfilters) {
        $filters = $this->config->item($chartname . '_filters_default');
        $filtersColumns = $this->config->item($chartname . '_filters');

        if (!empty($selectedfilters)) {
            foreach (array_keys($selectedfilters) as $filter) {
                if (in_array($filter, $filtersColumns)) {
                    $filters[$filter] = $selectedfilters[$filter];
                }
            }
        }
        return $filters;
    }

    public function get_data($chartname, $filters) {
        if ($chartname == 'reporting_rates_chart') {
            $main_data = $this->manager_model->get_reporting_rates($filters);
        } else if ($chartname == 'patients_by_regimen_chart') {
            $main_data = $this->manager_model->get_patient_regimen($filters);
        } else if ($chartname == 'drug_consumption_allocation_trend_chart') {
            $main_data = $this->manager_model->get_drug_consumption_allocation_trend($filters);
        } else if ($chartname == 'facility_adt_version_distribution_chart') {
            $main_data = $this->manager_model->get_facility_adt_version_distribution($filters);
        } else if ($chartname == 'facility_internet_access_chart') {
            $main_data = $this->manager_model->get_facility_internet_access($filters);
        }
        return $main_data;
    }

}

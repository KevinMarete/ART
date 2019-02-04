<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Manager extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
    }

    public function index() {
        $this->load_page('user', 'login', 'Login');
    }

    public function load_page($module = 'user', $page = 'login', $title = 'Login') {
        if ($page == 'register') {
            $this->db->where_in('name', array('subcounty', 'county'));
            $data['roles'] = $this->db->get('tbl_role')->result_array();
        }

        if ($page == 'minute') {
            $data['minutes'] = $this->db->where('meeting_id', $this->uri->segment(4))->get('tbl_minutes')->result();
        }
        $data['page_title'] = 'ART | ' . $title;
        $this->load->view('pages/' . $module . '/' . $page . '_view', $data);
    }

    public function load_template($module = 'dashboard', $page = 'dashboard', $title = 'Dashboard', $is_table = TRUE) {
        $this->session->set_userdata('minute', '');

        if ($this->session->userdata('id')) {
            $data['page_name'] = $page;
            $data['content_view'] = 'pages/' . $module . '/' . $page . '_view';
            if ($is_table) {
                $data['columns'] = $this->db->list_fields('tbl_' . $page);
                $data['content_view'] = 'template/table_view';
            }

            if ($module == 'orders') {
                $columns = array(
                    'reports' => array(
                        'subcounty' => array('Facility Name', 'Period Beginning', 'Description', 'Status', 'Actions'),
                        'county' => array('Facility Name', 'Period Beginning', 'Description', 'Subcounty', 'Status', 'Actions'),
                        'nascop' => array('Facility Name', 'Period Beginning', 'Description', 'County', 'Subcounty', 'Status', 'Actions')
                    ),
                    'reporting_rates' => array(
                        'subcounty' => array('MFL Code', 'Facility Name', 'Status', 'Description', 'Period', 'Actions'),
                        'county' => array('Subcounty', 'Submitted', 'Progress'),
                        'nascop' => array('County', 'Submitted', 'Progress')
                    ),
                    'cdrr_maps' => array(
                        'subcounty' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'county' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'nascop' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        )
                    ),
                    'allocation' => array(
                        'subcounty' => array('MFL Code', 'Facility Name', 'Period', 'Description', 'Status', 'Actions'),
                        'county' => array('Period', 'Approved', 'Status', 'Actions'),
                        'nascop' => array('Period', 'Submitted to KEMSA', 'Status', 'Actions')
                    ),
                    'allocate' => array(
                        'subcounty' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'county' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        ),
                        'nascop' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'pcdrrs' => $this->Orders_model->get_cdrr_data_previous($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'maps' => $this->Orders_model->get_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role')),
                            'previousmaps' => $this->Orders_model->get_previous_maps_data($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'))
                        )
                    ),
                    'edit_allocation' => array(
                        'subcounty' => array(),
                        'county' => array('Subcounty', 'Report Count', 'Status', 'Approval', 'Actions'),
                        'nascop' => array('County', 'Report Count', 'Status', 'Approval', 'Actions')
                    ),
                    'subcounty_reports' => array(
                        'subcounty' => array(),
                        'county' => array('MFL Code', 'Facility Name', 'Description', 'Status', 'Period', 'Actions', 'Download'),
                        'nascop' => array('MFL Code', 'Facility Name', 'Description', 'Status', 'Period', 'Actions', 'Download')
                    ),
                    'county_reports' => array(
                        'subcounty' => array(),
                        'county' => array(),
                        'nascop' => array('SubCounty', 'MFL Code', 'Facility Name', 'Description', 'Status', 'Period', 'Actions', 'Download')
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
                        'nascop' => array(
                            'drugs' => $this->Orders_model->get_drugs(),
                            'regimens' => $this->Orders_model->get_regimens(),
                            'cdrrs' => $this->Orders_model->get_satellite_cdrr($this->uri->segment('4')),
                            'maps' => $this->Orders_model->get_satellite_maps($this->uri->segment('5'))
                        )
                    )
                );

                $data['columns'] = $columns[$page][$this->session->userdata('role')];
                $data['county'] = $this->getCountySubcounty();
                $data['data_maps'] = $this->Orders_model->get_maps_data_patients_against_regimen($this->uri->segment('5'), $this->session->userdata('scope'), $this->session->userdata('role'));
                $data['role'] = $this->session->userdata('role');
                $data['scope'] = $this->session->userdata('scope');
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

    function getRegimenDetails() {
       echo $this->response($this->Orders_model->get_maps_data_patients_against_drugs());
    }

    public function get_default_period() {
        $default_period = array(
            'year' => $this->config->item('data_year'),
            'month' => $this->config->item('data_month'),
            'drug' => $this->config->item('drug')
        );
        echo json_encode($default_period);
    }

    public function get_chart() {
        $chartname = $this->input->post('name');
        $selectedfilters = $this->get_filter($chartname, $this->input->post('selectedfilters'));
        //Set filters based on role and scope
        $role = str_ireplace('subcounty', 'sub_county', $this->session->userdata('role'));
        if (!in_array($role, array('admin', 'nascop'))) {
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

    function generateMinute() {
        $data['minutes'] = $this->db->where('meeting_id', $this->uri->segment(4))->get('tbl_minutes')->result();
        $page_builder = $this->load->view('pages/public/pdf_view', $data, true);
        $dompdf = new Dompdf;
        // Load HTML content
        $dompdf->loadHtml($page_builder);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $output = $dompdf->output();
        unlink('public/minutes_pdf/minutes.pdf');
        file_put_contents('public/minutes_pdf/minutes.pdf', $output);
    }

    public function get_data($chartname, $filters) {
        if ($chartname == 'reporting_rates_chart') {
            $main_data = $this->manager_model->get_reporting_rates($filters);
        } else if ($chartname == 'patients_by_regimen_chart') {
            $main_data = $this->manager_model->get_patient_regimen($filters);
        } else if ($chartname == 'drug_consumption_allocation_trend_chart') {
            $main_data = $this->manager_model->get_drug_consumption_allocation_trend($filters);
        } else if ($chartname == 'stock_status_trend_chart') {
            $main_data = $this->manager_model->get_drug_soh_trend($filters);
        } else if ($chartname == 'low_mos_commodity_table') {
            $main_data = $this->manager_model->get_low_mos_commodities($filters);
        } else if ($chartname == 'high_mos_commodity_table') {
            $main_data = $this->manager_model->get_high_mos_commodities($filters);
        }
        return $main_data;
    }

}

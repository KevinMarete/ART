<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function index() {

        if ($this->session->userdata('role') == '') {
            redirect('manager');
        } else {

            $data['page_title'] = 'ART | Dashboard';
            $this->load->view('template/dashboard_view', $data);
        }
    }

    public function get_default_period() {
        $default_period = array(
            'year' => $this->config->item('data_year'),
            'month' => $this->config->item('data_month')
        );
        echo json_encode($default_period);
    }

    public function get_chart() {
        $chartname = $this->input->post('name');
        $selectedfilters = $this->get_filter($chartname, $this->input->post('selectedfilters'));
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
        if ($chartname == 'patient_scaleup_chart') {
            $main_data = $this->summary_model->get_patient_scaleup($filters);
        } else if ($chartname == 'patient_services_chart') {
            $main_data = $this->summary_model->get_patient_services($filters);
        } else if ($chartname == 'national_mos_chart') {
            $main_data = $this->summary_model->get_national_mos($filters);
        } else if ($chartname == 'commodity_consumption_chart') {
            $main_data = $this->trend_model->get_commodity_consumption($filters);
        } else if ($chartname == 'patients_regimen_chart') {
            $main_data = $this->trend_model->get_patients_regimen($filters);
        } else if ($chartname == 'commodity_month_stock_chart') {
            $main_data = $this->trend_model->get_commodity_month_stock($filters);
        } else if ($chartname == 'county_patient_distribution_chart') {
            $main_data = $this->county_model->get_county_patient_distribution($filters);
        } else if ($chartname == 'county_commodity_soh_chart') {
            $main_data = $this->county_model->get_county_commodity_soh($filters);
        } else if ($chartname == 'county_commodity_stock_movement_table') {
            $main_data = $this->county_model->get_county_commodity_stock_movement_numbers($filters);
        } else if ($chartname == 'county_patient_distribution_table') {
            $main_data = $this->county_model->get_county_patient_distribution_numbers($filters);
        } else if ($chartname == 'subcounty_patient_distribution_chart') {
            $main_data = $this->subcounty_model->get_subcounty_patient_distribution($filters);
        } else if ($chartname == 'subcounty_commodity_soh_chart') {
            $main_data = $this->subcounty_model->get_subcounty_commodity_soh($filters);
        } else if ($chartname == 'subcounty_commodity_stock_movement_table') {
            $main_data = $this->subcounty_model->get_subcounty_commodity_stock_movement_numbers($filters);
        } else if ($chartname == 'subcounty_patient_distribution_table') {
            $main_data = $this->subcounty_model->get_subcounty_patient_distribution_numbers($filters);
        } else if ($chartname == 'facility_patient_distribution_chart') {
            $main_data = $this->facility_model->get_facility_patient_distribution($filters);
        } else if ($chartname == 'facility_commodity_soh_chart') {
            $main_data = $this->facility_model->get_facility_commodity_soh($filters);
        } else if ($chartname == 'facility_commodity_stock_movement_table') {
            $main_data = $this->facility_model->get_facility_commodity_stock_movement_numbers($filters);
        } else if ($chartname == 'facility_patient_distribution_table') {
            $main_data = $this->facility_model->get_facility_patient_distribution_numbers($filters);
        } else if ($chartname == 'partner_patient_distribution_chart') {
            $main_data = $this->partner_model->get_partner_patient_distribution($filters);
        } else if ($chartname == 'partner_patient_distribution_table') {
            $main_data = $this->partner_model->get_partner_patient_distribution_numbers($filters);
        } else if ($chartname == 'regimen_patient_chart') {
            $main_data = $this->regimen_model->get_patient_regimen_category($filters);
        } else if ($chartname == 'regimen_nrti_drugs_chart') {
            $main_data = $this->regimen_model->get_nrti_drugs_in_regimen($filters);
        } else if ($chartname == 'regimen_nnrti_drugs_chart') {
            $main_data = $this->regimen_model->get_nnrti_drugs_in_regimen($filters);
        } else if ($chartname == 'adt_sites_version_chart') {
            $main_data = $this->adt_sites_model->get_adt_sites_versions($filters);
        } else if ($chartname == 'adt_sites_internet_chart') {
            $main_data = $this->adt_sites_model->get_adt_sites_internet($filters);
        } else if ($chartname == 'adt_sites_backup_chart') {
            $main_data = $this->adt_sites_model->get_adt_sites_backup($filters);
        } else if ($chartname == 'adt_sites_distribution_chart') {
            $main_data = $this->adt_sites_model->get_adt_sites_distribution($filters);
        } else if ($chartname == 'adt_sites_distribution_table') {
            $main_data = $this->adt_sites_model->get_adt_sites_distribution_numbers($filters);
        } else if ($chartname == 'adt_reports_patients_started_art_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_patients_started_art($filters);
        } else if ($chartname == 'adt_reports_active_patients_regimen_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_patients_active_regimen($filters);
        } else if ($chartname == 'adt_reports_commodity_consumption_regimen_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_commodity_consumption_regimen($filters);
        } else if ($chartname == 'adt_reports_commodity_consumption_drug_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_commodity_consumption_drug($filters);
        } else if ($chartname == 'adt_reports_commodity_consumption_dose_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_commodity_consumption_dose($filters);
        } else if ($chartname == 'adt_reports_paediatric_weight_age_chart') {
            $main_data = $this->adt_reports_model->get_paediatric_patients_by_weight_age($filters);
        } else if ($chartname == 'adt_reports_commodity_consumption_chart') {
            $main_data = $this->adt_reports_model->get_adt_reports_commodity_consumption($filters);
        }
        return $main_data;
    }

    public function get_adt_data($table, $start_date, $end_date) {
        //Setup the elements
        $elements = array(
            'dsh_patient_adt' => array(
                'rows' => array('current_regimen'),
                'columns' => array('gender'),
                'query' => "SELECT gender, CASE WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 0 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 14 THEN '0-14' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 15 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 24 THEN '15-24' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 25 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 40 THEN '25-40' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 41 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 49 THEN '41-49' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 50 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 60 THEN '50-60' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) > 60  THEN 'Over 60' ELSE NULL END AS age, start_weight, current_weight, enrollment_date, start_regimen_date, status_change_date, start_regimen, current_regimen, service, status, CASE WHEN last_viral_test_result LIKE '%ldl%' THEN 'LDL' WHEN last_viral_test_result >= 1 AND last_viral_test_result < 1000 THEN '1-1000' WHEN last_viral_test_result >= 1000 AND last_viral_test_result < 5000 THEN '1000-5000' WHEN last_viral_test_result >= 5000 THEN 'Above 5000' ELSE NULL END AS viral_load FROM dsh_patient_adt WHERE enrollment_date >= ? AND enrollment_date <= ? "
            ),
            'dsh_visit_adt' => array(
                'rows' => array('drug'),
                'columns' => array('current_weight'),
                'query' => "SELECT gender, CASE WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 0 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 14 THEN '0-14' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 15 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 24 THEN '15-24' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 25 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 40 THEN '25-40' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 41 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 49 THEN '41-49' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) >= 50 AND ROUND(DATEDIFF(CURDATE(), birth_date)/365) <= 60 THEN '50-60' WHEN ROUND(DATEDIFF(CURDATE(), birth_date)/365) > 60  THEN 'Over 60' ELSE NULL END AS age, pv.current_weight, purpose, last_regimen, pv.current_regimen, regimen_change_reason, dispensing_date, appointment_date, appointment_adherence, non_adherence_reason, drug, dose, duration, pill_count_adherence, self_reporting_adherence  FROM dsh_visit_adt pv  INNER JOIN dsh_patient_adt p ON p.id = pv.patient_adt_id WHERE dispensing_date >= ? AND dispensing_date <= ? "
            )
        );
        //Get elements based on selected options
        $response['data'] = $this->db->query($elements[$table]['query'], array($start_date, $end_date))->result_array();
        $response['defs'] = array('rows' => $elements[$table]['rows'], 'cols' => $elements[$table]['columns']);
        echo json_encode($response);
    }

}

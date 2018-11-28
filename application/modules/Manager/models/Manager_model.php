<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends CI_Model {

    public function get_reporting_rates($filters) {
        $columns = array();
        $reporting_data = array(
            array('type' => 'column', 'name' => 'Reported', 'data' => array()),
            array('type' => 'column', 'name' => 'Not Reported', 'data' => array())
        );

        //Get total_ordering_sites
        $scope_id = $this->session->userdata('scope');
        $role = $this->session->userdata('role');
        $this->db->where_in("category", array('central', 'standalone'));
        if($role == 'subcounty'){
            $this->db->where('subcounty_id', $scope_id);
            $total_ordering_sites = $this->db->get('tbl_facility')->num_rows();
        }else if($role == 'county'){
            $this->db->from('tbl_facility f');
            $this->db->join('tbl_subcounty sc', 'sc.id = f.subcounty_id', 'inner');
            $this->db->where('sc.county_id', $scope_id);
            $total_ordering_sites = $this->db->get()->num_rows();
        }else{
            $total_ordering_sites = $this->db->get('tbl_facility')->num_rows();
        }
        
        $this->db->select("CONCAT_WS('/', data_month, data_year) period, COUNT(*) reported, ($total_ordering_sites - COUNT(*)) not_reported", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >= ", date('Y-01-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->where_in("facility_category", array('central', 'standalone'));
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_order');
        $results = $query->result_array();

        if ($results) {
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($reporting_data as $index => $report) {
                    if ($report['name'] == 'Reported') {
                        array_push($reporting_data[$index]['data'], $result['reported']);
                    } else if ($report['name'] == 'Not Reported') {
                        array_push($reporting_data[$index]['data'], $result['not_reported']);
                    } 
                }
            }
        }
        return array('main' => $reporting_data, 'columns' => $columns);
    }

    public function get_patient_regimen($filters) {
        $this->db->select("regimen_service name, SUM(total) y, LOWER(REPLACE(regimen_service, ' ', '_')) drilldown", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by('name');
        $this->db->order_by('y', 'DESC');
        $query = $this->db->get('dsh_patient');
        return $this->get_patient_regimen_drilldown_level1(array('main' => $query->result_array()), $filters);
    }

    public function get_patient_regimen_drilldown_level1($main_data, $filters) {
        $drilldown_data = array();
        $this->db->select("LOWER(REPLACE(regimen_service, ' ', '_')) category, regimen_category name, SUM(total) y, LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) drilldown", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by('drilldown');
        $this->db->order_by('y', 'DESC');
        $query = $this->db->get('dsh_patient');
        $sub_data = $query->result_array();

        if ($main_data) {
            foreach ($main_data['main'] as $counter => $main) {
                $category = $main['drilldown'];

                $drilldown_data['drilldown'][$counter]['id'] = $category;
                $drilldown_data['drilldown'][$counter]['name'] = ucwords($category);
                $drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

                foreach ($sub_data as $sub) {
                    if ($category == $sub['category']) {
                        unset($sub['category']);
                        $drilldown_data['drilldown'][$counter]['data'][] = $sub;
                    }
                }
            }
        }
        $drilldown_data = $this->get_patient_regimen_drilldown_level2($drilldown_data, $filters);
        return array_merge($main_data, $drilldown_data);
    }

    public function get_patient_regimen_drilldown_level2($drilldown_data, $filters) {
        $this->db->select("LOWER(CONCAT_WS('_', REPLACE(regimen_service, ' ', '_'), REPLACE(regimen_category, ' ', '_'))) line, regimen name, SUM(total) y", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by('name');
        $this->db->order_by('y', 'DESC');
        $query = $this->db->get('dsh_patient');
        $regimen_data = $query->result_array();

        if ($drilldown_data) {
            $counter = sizeof($drilldown_data['drilldown']);
            foreach ($drilldown_data['drilldown'] as $main_data) {
                foreach ($main_data['data'] as $item) {
                    $filter_value = $item['name'];
                    $filter_name = $item['drilldown'];

                    $drilldown_data['drilldown'][$counter]['id'] = $filter_name;
                    $drilldown_data['drilldown'][$counter]['name'] = ucwords($filter_name);
                    $drilldown_data['drilldown'][$counter]['colorByPoint'] = true;

                    foreach ($regimen_data as $regimen) {
                        if ($filter_name == $regimen['line']) {
                            unset($regimen['line']);
                            $drilldown_data['drilldown'][$counter]['data'][] = $regimen;
                        }
                    }
                    $counter += 1;
                }
            }
        }
        return $drilldown_data;
    }

    public function get_drug_consumption_allocation_trend($filters) {
        $columns = array();
        $scaleup_data = array(
            array('type' => 'areaspline', 'name' => 'Allocated', 'data' => array()),
            array('type' => 'areaspline', 'name' => 'Consumed', 'data' => array())
        );
        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(total) consumed_total, SUM(allocated) allocated_total", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >= ", date('Y-01-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_consumption');
        $results = $query->result_array();

        if ($results) {
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($scaleup_data as $index => $scaleup) {
                    if ($scaleup['name'] == 'Allocated') {
                        array_push($scaleup_data[$index]['data'], $result['allocated_total']);
                    } else if ($scaleup['name'] == 'Consumed') {
                        array_push($scaleup_data[$index]['data'], $result['consumed_total']);
                    }
                }
            }
        }
        return array('main' => $scaleup_data, 'columns' => $columns);
    }

    public function get_drug_soh_trend($filters){
        $columns = array();
        $soh_data = array(
            array(
                'type' => 'column', 
                'name' => 'Stock on Hand', 
                'data' => array()),
            array(
                'type' => 'spline', 
                'color' => '#9400D3', 
                'positiveColor' => '#9400D3', 
                'name' => 'Average Monthly Consumption (AMC)', 
                'data' => array()),
            array(
                'type' => 'line', 
                'color' => '#FF0000', 
                'negativeColor' => '#0088FF', 
                'name' => 'Months of Stock (MOS)', 
                'data' => array())
        );

        $this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) soh_total, SUM(amc_total) amc_total, (SUM(total)/SUM(amc_total)) mos_total", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >= ", date('Y-01-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by("drug, period");
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_stock');
        $results = $query->result_array();

        if ($results) {
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($soh_data as $index => $soh) {
                    if ($soh['name'] == 'Stock on Hand') {
                        array_push($soh_data[$index]['data'], $result['soh_total']);
                    } else if ($soh['name'] == 'Average Monthly Consumption (AMC)') {
                        array_push($soh_data[$index]['data'], $result['amc_total']);
                    } else if ($soh['name'] == 'Months of Stock (MOS)') {
                        array_push($soh_data[$index]['data'], empty($result['mos_total']) ? 0 : $result['mos_total']);
                    }
                }
            }
        }
        return array('main' => $soh_data, 'columns' => $columns);
    }

    public function get_low_mos_commodities($filters){
        $columns = array();

        $this->db->select("drug, facility, county, sub_county Subcounty, SUM(total) balance, SUM(amc_total) amc, IFNULL((SUM(total)/SUM(amc_total)), 0) mos", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by('drug, facility, county, sub_county');
        $this->db->having('mos < 3');
        $this->db->order_by('mos', 'ASC');
        $query = $this->db->get('dsh_stock');
        return array('main' => $query->result_array(), 'columns' => $columns);
    }

    public function get_high_mos_commodities($filters){
        $columns = array();

        $this->db->select("drug, facility, county, sub_county Subcounty, SUM(total) balance, SUM(amc_total) amc, IFNULL((SUM(total)/SUM(amc_total)), 0) mos", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by('drug, facility, county, sub_county');
        $this->db->having('mos > 6');
        $this->db->order_by('mos', 'DESC');
        $query = $this->db->get('dsh_stock');
        return array('main' => $query->result_array(), 'columns' => $columns);
    }

}

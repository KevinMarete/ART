<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adt_reports_model extends CI_Model {

    public function get_adt_reports_patients_started_art_chart($filters) {
        $columns = array();
        $started_art_data = array(
            array('name' => 'Paed Male', 'data' => array()),
            array('name' => 'Paed Female', 'data' => array()),
            array('name' => 'Adult Male', 'data' => array()),
            array('name' => 'Adult Female', 'data' => array()
            )
        );

        $this->db->select("start_regimen, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) >= 15  AND gender = 'male', 1, 0)) adult_male, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) >= 15  AND gender = 'female', 1, 0)) adult_female,SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) < 15  AND gender = 'male', 1, 0)) paed_male, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) < 15  AND gender = 'female', 1, 0)) paed_female", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_month') {
                    $this->db->where_in('date_format(start_regimen_date, "%b")', $filter);
                    continue;
                } else if ($category == 'data_year') {
                    $this->db->where_in('YEAR(start_regimen_date)', $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->where('service', 'ART');
        $this->db->group_by('start_regimen');
        $this->db->order_by('start_regimen', 'ASC');
        $query = $this->db->get('dsh_patient_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $columns[] = $result['start_regimen'];
            foreach ($started_art_data as $index => $started_art) {
                if ($started_art['name'] == 'Adult Male') {
                    array_push($started_art_data[$index]['data'], $result['adult_male']);
                } else if ($started_art['name'] == 'Adult Female') {
                    array_push($started_art_data[$index]['data'], $result['adult_female']);
                } else if ($started_art['name'] == 'Paed Male') {
                    array_push($started_art_data[$index]['data'], $result['paed_male']);
                } else if ($started_art['name'] == 'Paed Female') {
                    array_push($started_art_data[$index]['data'], $result['paed_female']);
                }
            }
        }
        return array('main' => $started_art_data, 'columns' => $columns);
    }

    public function get_adt_reports_patients_active_regimen_chart($filters) {
        $active_regimen_data = array(
            array('name' => 'Paed Male', 'data' => array()),
            array('name' => 'Paed Female', 'data' => array()),
            array('name' => 'Adult Male', 'data' => array()),
            array('name' => 'Adult Female', 'data' => array()
            )
        );

        $this->db->select("current_regimen, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) >= 15  AND gender = 'male', 1, 0)) adult_male, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) >= 15  AND gender = 'female', 1, 0)) adult_female,SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) < 15  AND gender = 'male', 1, 0)) paed_male, SUM(IF(ROUND(DATEDIFF(CURRENT_DATE, birth_date)/365) < 15  AND gender = 'female', 1, 0)) paed_female", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_month') {
                    $this->db->where_in('date_format(status_change_date, "%b")', $filter);
                    continue;
                } else if ($category == 'data_year') {
                    $this->db->where_in('YEAR(status_change_date)', $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->where('service', 'ART');
        $this->db->group_by('current_regimen');
        $this->db->order_by('current_regimen', 'ASC');
        $query = $this->db->get('dsh_patient_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $columns[] = $result['current_regimen'];
            foreach ($active_regimen_data as $index => $active_regimen) {
                if ($active_regimen['name'] == 'Adult Male') {
                    array_push($active_regimen_data[$index]['data'], $result['adult_male']);
                } else if ($active_regimen['name'] == 'Adult Female') {
                    array_push($active_regimen_data[$index]['data'], $result['adult_female']);
                } else if ($active_regimen['name'] == 'Paed Male') {
                    array_push($active_regimen_data[$index]['data'], $result['paed_male']);
                } else if ($active_regimen['name'] == 'Paed Female') {
                    array_push($active_regimen_data[$index]['data'], $result['paed_female']);
                }
            }
        }
        return array('main' => $active_regimen_data, 'columns' => $columns);
    }

    public function get_adt_reports_commodity_consumption_drug_visit_chart($filters) {
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
        $consumption_data = array();

        $this->db->select("drug, CONCAT_WS('/', date_format(dispensing_date, '%b'), year(dispensing_date)) period, SUM(quantity) total", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date') {
                    $this->db->where("dispensing_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by("drug, period");
        $this->db->order_by("year(dispensing_date) ASC, FIELD( date_format(dispensing_date, '%b'), 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_visit_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $drug = $result['drug'];
            $period = $result['period'];
            array_push($columns, $period);
            array_push($drugs, $drug);
            $tmp_data[$drug][$period] = $result['total'];
        }

        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $drugs = array_values(array_unique($drugs));

        //Ensure values match for all drugs
        foreach ($drugs as $drug) {
            foreach ($columns as $column) {
                if (isset($tmp_data[$drug][$column])) {
                    $main_data[$drug]['data'][] = $tmp_data[$drug][$column];
                } else {
                    $main_data[$drug]['data'][] = 0;
                }
            }
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $consumption_data[$counter]['name'] = $name;
            $consumption_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $consumption_data, 'columns' => $columns);
    }

    public function get_adt_reports_commodity_consumption_regimen_visit_chart($filters) {
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
        $consumption_data = array();

        $this->db->select("current_regimen, CONCAT_WS('/', date_format(dispensing_date, '%b'), year(dispensing_date)) period, SUM(quantity) total", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date') {
                    $this->db->where("dispensing_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by("current_regimen, period");
        $this->db->order_by("year(dispensing_date) ASC, FIELD( date_format(dispensing_date, '%b'), 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_visit_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $drug = $result['current_regimen'];
            $period = $result['period'];
            array_push($columns, $period);
            array_push($drugs, $drug);
            $tmp_data[$drug][$period] = $result['total'];
        }

        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $drugs = array_values(array_unique($drugs));

        //Ensure values match for all drugs
        foreach ($drugs as $drug) {
            foreach ($columns as $column) {
                if (isset($tmp_data[$drug][$column])) {
                    $main_data[$drug]['data'][] = $tmp_data[$drug][$column];
                } else {
                    $main_data[$drug]['data'][] = 0;
                }
            }
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $consumption_data[$counter]['name'] = $name;
            $consumption_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $consumption_data, 'columns' => $columns);
    }

    public function get_adt_reports_patients_commodity_dosing_chart($filters) {
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
        $consumption_data = array();

        $this->db->select("dose, CONCAT_WS('/', date_format(dispensing_date, '%b'), year(dispensing_date)) period, COUNT(*) total", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date') {
                    $this->db->where("dispensing_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by("dose, period");
        $this->db->order_by("year(dispensing_date) ASC, FIELD( date_format(dispensing_date, '%b'), 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_visit_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $drug = $result['dose'];
            $period = $result['period'];
            array_push($columns, $period);
            array_push($drugs, $drug);
            $tmp_data[$drug][$period] = $result['total'];
        }

        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $drugs = array_values(array_unique($drugs));

        //Ensure values match for all drugs
        foreach ($drugs as $drug) {
            foreach ($columns as $column) {
                if (isset($tmp_data[$drug][$column])) {
                    $main_data[$drug]['data'][] = $tmp_data[$drug][$column];
                } else {
                    $main_data[$drug]['data'][] = 0;
                }
            }
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $consumption_data[$counter]['name'] = $name;
            $consumption_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $consumption_data, 'columns' => $columns);
    }

    public function get_adt_reports_commodity_consumption_chart($filters) {
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $drugs = array();
        $consumption_data = array();

        $this->db->select("drug, CONCAT_WS('/', date_format(dispensing_date, '%b'), year(dispensing_date)) period, SUM(quantity) total", FALSE);
        if (!empty($filters)) {
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date') {
                    $this->db->where("dispensing_date <=", $filter);
                    continue;
                }
                $this->db->where_in($category, $filter);
            }
        }
        $this->db->group_by("drug, period");
        $this->db->order_by("year(dispensing_date) ASC, FIELD( date_format(dispensing_date, '%b'), 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('dsh_visit_adt');
        $results = $query->result_array();

        foreach ($results as $result) {
            $drug = $result['drug'];
            $period = $result['period'];
            array_push($columns, $period);
            array_push($drugs, $drug);
            $tmp_data[$drug][$period] = $result['total'];
        }

        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $drugs = array_values(array_unique($drugs));

        //Ensure values match for all drugs
        foreach ($drugs as $drug) {
            foreach ($columns as $column) {
                if (isset($tmp_data[$drug][$column])) {
                    $main_data[$drug]['data'][] = $tmp_data[$drug][$column];
                } else {
                    $main_data[$drug]['data'][] = 0;
                }
            }
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $consumption_data[$counter]['name'] = $name;
            $consumption_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $consumption_data, 'columns' => $columns);
    }

}

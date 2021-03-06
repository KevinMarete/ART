<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_model extends CI_Model {

    public function get_commodity_data() {
        $response = array('data'=> array());
        try {
            $sql = "SELECT id, UCASE(name) commodity, pack_size
                    FROM vw_drug_list
                    GROUP BY id";
            $table_data = $this->db->query($sql)->result_array();
            if (!empty($table_data)) {
                foreach ($table_data as $results) {
                    $response['data'][] = array(
                        $results['commodity'],
                        $results['pack_size'],
                        '<a class="btn btn-xs btn-primary tracker_drug" data-toggle="modal" data-target="#add_procurement_modal" data-drug_id="'.$results['id'].'"> 
                            <i class="fa fa-search"></i> View Options
                        </a>'
                    );
                }
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function get_tracker_data($drug_id){
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        drug_id,
                        drug commodity_name, 
                        IF(close_kemsa < 0, 0, FORMAT(close_kemsa, 0)) commodity_soh, 
                        ROUND(close_kemsa/avg_issues) commodity_mos, 
                        IF(((avg_issues * 9) - close_kemsa) < 0, 0, FORMAT(((avg_issues * 9) - close_kemsa), 0)) expected_qty,
                        IF(((avg_issues * 9) - close_kemsa)  < 0, 0, ((avg_issues * 9) - close_kemsa)) actual_qty 
                    FROM vw_procurement_list
                    WHERE drug_id = ? 
                    AND data_date = ?";
            $table_data = $this->db->query($sql, array($drug_id, date('Y-m-01', strtotime("-1 month"))))->row_array();
            if (!empty($table_data)) {
                $response['data'] = $table_data;
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function get_transaction_data($drug_id, $period_year){
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        CONCAT_WS('<br/>', data_month, data_year) period,
                        FORMAT(open_kemsa, 0) open_kemsa,
                        FORMAT(receipts_kemsa, 0) receipts_kemsa,
                        FORMAT(issues, 0) issues_kemsa,
                        FORMAT(close_kemsa, 0) close_kemsa,
                        FORMAT(consumption, 0) monthly_consumption,
                        FORMAT(avg_issues, 0) avg_issues,
                        FORMAT(avg_consumption, 0) avg_consumption,
                        ROUND(close_kemsa/avg_issues) mos
                    FROM vw_procurement_list p
                    WHERE p.drug_id = ? 
                    AND p.data_year = ?
                    GROUP BY period
                    ORDER BY data_year ASC, FIELD(data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )";
            $table_data = $this->db->query($sql, array($drug_id, $period_year))->result_array();
            if (!empty($table_data)) {
                $response['data'] = $table_data;
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;   
    }

    public function get_order_data($drug_id){
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        CONCAT_WS('-', transaction_month, transaction_year) period,
                        FORMAT(quantity, 0) quantity,
                        ps.name status,
                        fa.name funding_agent,
                        IF(s.name IS NULL, 'N/A', s.name) supplier
                    FROM tbl_procurement_item pi 
                    INNER JOIN tbl_procurement p ON p.id = pi.procurement_id
                    INNER JOIN tbl_procurement_status ps ON ps.id = pi.procurement_status_id
                    INNER JOIN tbl_funding_agent fa ON fa.id = pi.funding_agent_id
                    LEFT JOIN tbl_supplier s ON s.id = pi.supplier_id
                    WHERE p.drug_id = ? 
                    GROUP BY period, status, funding_agent, supplier
                    ORDER BY transaction_year DESC, FIELD(transaction_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ) DESC";
            $table_data = $this->db->query($sql, array($drug_id))->result_array();
            if (!empty($table_data)) {
                $response['data'] = $table_data;
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;   
    }

    public function get_log_data($drug_id){
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        pl.created transaction_time,
                        pl.description,
                        CONCAT_WS('/', transaction_month, transaction_year) period,
                        CONCAT_WS(' ', u.firstname, u.lastname) user
                    FROM tbl_procurement_log pl
                    INNER JOIN tbl_procurement p ON p.id = pl.procurement_id
                    INNER JOIN tbl_user u ON u.id = pl.user_id
                    WHERE p.drug_id = ? 
                    GROUP BY transaction_time, description, period, user
                    ORDER BY transaction_time DESC, transaction_year DESC, FIELD(transaction_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ) DESC";
            $table_data = $this->db->query($sql, array($drug_id))->result_array();
            if (!empty($table_data)) {
                $response['data'] = $table_data;
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;   
    }

    public function get_procurement_consumption_issues($filters){
        $columns = array();
        $scaleup_data = array(
            array('type' => 'line', 'name' => 'Avg Consumption', 'data' => array(), 'zoneAxis' => 'x', 'zones' => array(array('value' => 12, 'dashStyle' => 'solid'), array('value' => 24, 'dashStyle' => 'dot'))),
            array('type' => 'line', 'name' => 'Avg Issues', 'data' => array(), 'zoneAxis' => 'x', 'zones' => array(array('value' => 12, 'dashStyle' => 'solid'), array('value' => 24, 'dashStyle' => 'dot'))),
            array('type' => 'line', 'name' => 'Total Patients', 'data' => array(), 'zoneAxis' => 'x', 'zones' => array(array('value' => 12, 'dashStyle' => 'solid'), array('value' => 24, 'dashStyle' => 'dot')))
        );
        $patient_data = array();

        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(avg_consumption) consumption_avg, SUM(avg_issues) issues_avg, 0 patients", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", date('Y-m-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", date('Y-m-01', strtotime($filter . "+ 1 year")));
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('vw_procurement_list');
        $results = $query->result_array();

        //Get patient numbers
        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(p.total) total", FALSE);
        $this->db->from('dsh_patient p');
        $this->db->join('vw_regimen_drug_list rd', 'rd.regimen = p.regimen', 'inner');
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", date('Y-m-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", date('Y-m-01', strtotime($filter . "+ 1 year")));
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get();
        $patient_results = $query->result_array();
        if($patient_results){
            foreach ($patient_results as $patient_result) {
                $patient_data[$patient_result['period']] = $patient_result['total'];
            }
        }

        if($results){
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($scaleup_data as $index => $scaleup) {
                    if($scaleup['name'] == 'Avg Consumption'){
                        array_push($scaleup_data[$index]['data'], $result['consumption_avg']);
                    }else if($scaleup['name'] == 'Avg Issues'){
                        array_push($scaleup_data[$index]['data'], $result['issues_avg']);
                    }else if($scaleup['name'] == 'Total Patients'){
                        array_push($scaleup_data[$index]['data'], (isset($patient_data[$result['period']]) ? $patient_data[$result['period']] : 0) );
                    }
                }
            }
        }
        return array('main' => $scaleup_data, 'columns' => $columns);
    }

    public function get_procurement_actual_consumption_issues($filters){
        $columns = array();
        $scaleup_data = array(
            array('type' => 'column', 'name' => 'Consumption', 'data' => array()),
            array('type' => 'column', 'name' => 'Issues', 'data' => array())
        );

        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(consumption) consumption_total, SUM(issues) issues_total", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", date('Y-m-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('vw_procurement_list');
        $results = $query->result_array();

        if($results){
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($scaleup_data as $index => $scaleup) {
                    if($scaleup['name'] == 'Consumption'){
                        array_push($scaleup_data[$index]['data'], $result['consumption_total']);
                    }else if($scaleup['name'] == 'Issues'){
                        array_push($scaleup_data[$index]['data'], $result['issues_total']);
                    }
                }
            }
        }
        return array('main' => $scaleup_data, 'columns' => $columns);
    }

    public function get_procurement_kemsa_soh($filters){
        $columns = array();
        $scaleup_data = array(
            array('type' => 'line', 'name' => 'Minimum Stock', 'data' => array()),
            array('type' => 'line', 'name' => 'SOH', 'data' => array()),
            array('type' => 'line', 'name' => 'Maximum Stock', 'data' => array()),
            array('type' => 'column', 'name' => 'Contracted', 'data' => array())
        );

        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(close_kemsa) soh_total, SUM(receipts_usaid + receipts_gf + receipts_cpf) contracted_total, (avg_issues * 9) minimum_total, (avg_issues * 15) maximum_total", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", $filter);
                    $this->db->where("data_date <=", date('Y-m-01', strtotime($filter . "+ 2 year")));
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('vw_procurement_list');
        $results = $query->result_array();

        if($results){
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($scaleup_data as $index => $scaleup) {
                    if($scaleup['name'] == 'SOH'){
                        array_push($scaleup_data[$index]['data'], $result['soh_total']);
                    }else if($scaleup['name'] == 'Contracted'){
                        array_push($scaleup_data[$index]['data'], $result['contracted_total']);
                    }else if($scaleup['name'] == 'Minimum Stock'){
                        array_push($scaleup_data[$index]['data'], $result['minimum_total']);
                    }else if($scaleup['name'] == 'Maximum Stock'){
                        array_push($scaleup_data[$index]['data'], $result['maximum_total']);
                    }
                }
            }
        }
        return array('main' => $scaleup_data, 'columns' => $columns);
    }

    public function get_procurement_adult_patients_on_drug($filters){
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $regimens = array();
        $patient_data = array();

        $this->db->select("p.regimen, CONCAT_WS('/', data_month, data_year) period, SUM(p.total) total", FALSE);
        $this->db->from('dsh_patient p');
        $this->db->join('vw_regimen_drug_list rd', 'rd.regimen = p.regimen', 'inner');
        $this->db->where_in('age_category', 'adult');
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", date('Y-m-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('p.regimen, period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get();
        $results = $query->result_array();

        foreach ($results as $result) {
            $regimen =  $result['regimen'];
            $period =  $result['period'];
            array_push($columns, $period);
            array_push($regimens, $regimen);
            $tmp_data[$regimen][$period] = $result['total'];
        }
        
        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $regimens = array_values(array_unique($regimens));

        //Ensure values match for all regimens
        foreach ($regimens as $regimen) {
            foreach($columns as $column){
                if(isset($tmp_data[$regimen][$column])){
                    $main_data[$regimen]['data'][]  =  $tmp_data[$regimen][$column];
                }else{
                    $main_data[$regimen]['data'][]  = 0;
                }  
            } 
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $patient_data[$counter]['name'] = $name;
            $patient_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $patient_data, 'columns' => $columns);
    }

    public function get_procurement_paed_patients_on_drug($filters){
        $columns = array();
        $tmp_data = array();
        $main_data = array();
        $regimens = array();
        $patient_data = array();

        $this->db->select("p.regimen, CONCAT_WS('/', data_month, data_year) period, SUM(p.total) total", FALSE);
        $this->db->from('dsh_patient p');
        $this->db->join('vw_regimen_drug_list rd', 'rd.regimen = p.regimen', 'inner');
        $this->db->where_in('age_category', 'paed');
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >=", date('Y-m-01', strtotime($filter . "- 1 year")));
                    $this->db->where("data_date <=", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('p.regimen, period');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get();
        $results = $query->result_array();

        foreach ($results as $result) {
            $regimen =  $result['regimen'];
            $period =  $result['period'];
            array_push($columns, $period);
            array_push($regimens, $regimen);
            $tmp_data[$regimen][$period] = $result['total'];
        }
        
        //Reset array values to unique
        $columns = array_values(array_unique($columns));
        $regimens = array_values(array_unique($regimens));

        //Ensure values match for all regimens
        foreach ($regimens as $regimen) {
            foreach($columns as $column){
                if(isset($tmp_data[$regimen][$column])){
                    $main_data[$regimen]['data'][]  =  $tmp_data[$regimen][$column];
                }else{
                    $main_data[$regimen]['data'][]  = 0;
                }  
            } 
        }

        $counter = 0;
        foreach ($main_data as $name => $item) {
            $patient_data[$counter]['name'] = $name;
            $patient_data[$counter]['data'] = $item['data'];
            $counter++;
        }
        return array('main' => $patient_data, 'columns' => $columns);
    }

    public function get_procurement_stock_status($filters){
        $columns = array();
        $pipeline_data = array(
            array('name' => 'Contracted', 'data' => array()),
            array('name' => 'Pending', 'data' => array()),
            array('name' => 'In Stock', 'data' => array())
        );

        $this->db->select("drug, ROUND(SUM(close_kemsa)/avg_issues) soh_mos, ROUND(SUM(receipts_kemsa)/avg_issues) pending_mos, avg_issues", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date =", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('drug');
        $query = $this->db->get('vw_procurement_list');
        $result = $query->row_array();

        //Get contracted
        $this->db->select("drug, SUM(receipts_kemsa) contracted_total", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('drug');
        $query = $this->db->get('vw_procurement_list');
        $contracted_result = $query->row_array();

        foreach ($pipeline_data as $index => $pipeline) {
            if($pipeline['name'] == 'In Stock'){
                array_push($pipeline_data[$index]['data'], (isset($result['soh_mos']) ? $result['soh_mos'] : 0));
            }else if($pipeline['name'] == 'Pending'){
                array_push($pipeline_data[$index]['data'], (isset($result['pending_mos']) ? $result['pending_mos'] : 0));
            }else if($pipeline['name'] == 'Contracted'){
                array_push($pipeline_data[$index]['data'], (isset($contracted_result['contracted_total']) ? round($contracted_result['contracted_total']/$result['avg_issues']) : 0));  
            }
        }

        return array('main' => $pipeline_data, 'columns' => array('MOS'));
    }

    public function get_procurement_expected_delivery($filters){
        $columns = array();
        $scaleup_data = array(
            array('type' => 'column', 'name' => 'USAID', 'data' => array()),
            array('type' => 'column', 'name' => 'GF', 'data' => array()),
            array('type' => 'column', 'name' => 'CPF', 'data' => array())
        );

        $this->db->select("CONCAT_WS('/', data_month, data_year) period, SUM(receipts_usaid) usaid_total, SUM(receipts_gf) gf_total, SUM(receipts_cpf) cpf_total, ", FALSE);
        if(!empty($filters)){
            foreach ($filters as $category => $filter) {
                if ($category == 'data_date'){
                    $this->db->where("data_date >", $filter);
                }else{
                    $this->db->where_in($category, $filter);
                }
            }
        }
        $this->db->group_by('period');
        $this->db->having('(SUM(receipts_usaid) + SUM(receipts_gf) + SUM(receipts_cpf)) > 0');
        $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
        $query = $this->db->get('vw_procurement_list');
        $results = $query->result_array();

        if($results){
            foreach ($results as $result) {
                $columns[] = $result['period'];
                foreach ($scaleup_data as $index => $scaleup) {
                    if($scaleup['name'] == 'USAID'){
                        array_push($scaleup_data[$index]['data'], $result['usaid_total']);
                    }else if($scaleup['name'] == 'GF'){
                        array_push($scaleup_data[$index]['data'], $result['gf_total']);
                    }else if($scaleup['name'] == 'CPF'){
                        array_push($scaleup_data[$index]['data'], $result['cpf_total']);
                    }
                }
            }
        }
        return array('main' => $scaleup_data, 'columns' => $columns);
    }


}
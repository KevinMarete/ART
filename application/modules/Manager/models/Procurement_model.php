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

}
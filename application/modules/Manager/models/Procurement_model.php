<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_model extends CI_Model {

    public function get_commodity_data() {
        $response = array('data'=> array());
        try {
            $sql = "SELECT id, UCASE(name) commodity
                    FROM vw_drug_list
                    GROUP BY name";
            $table_data = $this->db->query($sql)->result_array();
            if (!empty($table_data)) {
                foreach ($table_data as $results) {
                    $response['data'][] = array(
                        $results['commodity'],
                        '<a class="btn btn-xs btn-primary tracker_drug" data-toggle="modal" data-target="#add_procurement_modal" data-drug_name="'.$results['commodity'].'"> 
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

    public function get_tracker_data($drug_name){
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        drug_id,
                        drug commodity_name, 
                        FORMAT(close_kemsa, 0) commodity_soh, 
                        ROUND(close_kemsa/avg_issues) commodity_mos, 
                        FORMAT(((avg_issues * 9) - close_kemsa), 0) expected_qty,
                        ((avg_issues * 9) - close_kemsa) actual_qty 
                    FROM vw_procurement_list
                    WHERE drug = ? 
                    AND data_date = ?";
            $table_data = $this->db->query($sql, array($drug_name, date('Y-m-01', strtotime("-1 month"))))->row_array();
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
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function read($year, $month, $service = '') {
        $response = array();
        $service_condition = '';
        if($service != ''){
            $service_condition = "AND regimen_service = '".$service."'";
        }
        $sql = "SELECT data_year, data_month, regimen_service service, SUM(total) patients
                FROM dsh_patient 
                WHERE data_year = ?
                AND data_month = ?
                $service_condition
                GROUP BY data_year, data_month, service";
        $results = $this->db->query($sql, array($year, $month))->result_array();
        if(!empty($results)){
            $response = $results;
        }else {
            $response = array('message' => 'No data found');
        }
        return $response;
    }

}

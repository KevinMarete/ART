<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_model extends CI_Model {

    public function get_commodity_data() {
        $response = array('data'=> array());
        try {
            $sql = "SELECT 
                        UCASE(name) commodity
                    FROM vw_drug_list
                    GROUP BY name";
            $table_data = $this->db->query($sql)->result_array();
            if (!empty($table_data)) {
                foreach ($table_data as $results) {
                    $response['data'][] = array(
                        $results['commodity'],
                        '<a class="btn btn-xs btn-primary" data-toggle="modal" data-target="#add_procurement_modal" data-drug="'.$results['commodity'].'"> 
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

}
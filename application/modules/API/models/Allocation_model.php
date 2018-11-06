<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation_model extends CI_Model {

    //function list facilities that are not yet installed
    public function read($period_begin, $mflcode = '') {
        $mfl = '';
        if (!empty($mflcode)) {
            $mfl = "AND f.mflcode = '$mflcode'";
        }
        $period = substr($period_begin, 0, 4) . '-' . substr($period_begin, -2) . '-01';
        // $period_begin = date($period, strtotime('-1 MONTH'));

        $sql = "SELECT 
                    c.period_begin,c.code,f.mflcode,f.name as facility,
                    d.name drug, ci.qty_allocated
                from tbl_cdrr c
                left join tbl_cdrr_item ci on ci.cdrr_id = c.id 
                left join tbl_facility f on c.facility_id = f.id
                left join vw_drug_list d on ci.drug_id = d.id            
                
                $mfl
                AND ci.qty_allocated > 0
                AND period_begin = '$period' LIMI 5";
        //where c.status = 'reviewed' 

        $drugs = array();
        $facility_info = array();

        $query = $this->db->query($sql);


        if (count($query->result_array()) > 0) {
            foreach ($query->result() as $key => $value) {
                array_push($drugs, array('kemsa_code' => 'PM01STR00' . $key, 'drug' => $value->drug, 'qty_allocated' => $value->qty_allocated));
            }
            $qu = $query->result()[0]->period_begin;
            $dat = explode("-", $qu);
            $facility_info = [
                'facility' => $query->result()[0]->facility,
                'mflcode' => $query->result()[0]->mflcode,
                'report_code' => $query->result()[0]->code,
                'report_year' => $dat[0],
                'report_month' => $dat[1],
                'commodities' => $drugs
            ];
        } else {
            $resp = ['message' => 'No data found'];
            $facility_info = $resp;
        }
        return $facility_info;
    }

}

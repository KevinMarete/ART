<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation_model extends CI_Model {

    //function list facilities that are not yet installed
    public function read($mflcode, $period_begin = null) {
        $period_begin = ($period_begin == NULL) ? date('Y-m-01', strtotime('-1 MONTH')) : $period_begin;
        $sql = "SELECT 
                    c.period_begin,c.code,f.mflcode,f.name as facility,
                    d.name drug, ci.qty_allocated
                from tbl_cdrr c
                left join tbl_cdrr_item ci on ci.cdrr_id = c.id 
                left join tbl_facility f on c.facility_id = f.id
                left join vw_drug_list d on ci.drug_id = d.id               
                where c.status = 'reviewed' 
                AND f.mflcode = ?
                AND ci.qty_allocated > 0
                AND period_begin = ?";

        $drugs = array();
        $facility_info = array();

        $query = $this->db->query($sql, array($mflcode, $period_begin));


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

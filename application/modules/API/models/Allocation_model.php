<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation_model extends CI_Model {

    //function list facilities that are not yet installed
    public function read($period_begin, $mflcode = '', $level = '') {
        $status = "AND c.status = 'reviewed'";
        $mfl = '';
        if (!empty($mflcode)) {
            $mfl = "AND f.mflcode = '$mflcode'";
        }
        $code = '';
        if(!empty($level)){
            if($level == 'central'){
                $code = "AND c.code = 'D-CDRR'";
            }else if($level == 'standalone'){
                $code = "AND c.code = 'F-CDRR'";
            }else if($level == 'satellite'){
                $status = "AND c.status = 'pending'";
                $code = "AND c.code = 'F-CDRR'";
            }
        }
        $period = substr($period_begin, 0, 4) . '-' . substr($period_begin, -2) . '-01';
        $sql = "SELECT 
                    c.period_begin,
                    c.code,
                    f.mflcode,
                    f.name as facility,
                    d.name drug,
                    d.kemsa_code, 
                    IF (d.stock_status != '2', ci.qty_allocated, 0) qty_allocated,
                    ci.balance,
                    ci.received,
                    ci.dispensed_packs,
                    ci.losses,
                    ci.adjustments,
                    ci.adjustments_neg,
                    ci.count,
                    ci.aggr_consumed,
                    ci.aggr_on_hand,
                    ci.expiry_date,
                    ci.out_of_stock
                FROM tbl_cdrr c
                INNER JOIN tbl_cdrr_item ci on ci.cdrr_id = c.id 
                INNER JOIN tbl_facility f on c.facility_id = f.id
                INNER JOIN vw_drug_list d on ci.drug_id = d.id            
                WHERE period_begin = '$period'
                $mfl
                $code
                $status";
        $drugs = array();
        $facility_info = array();
        $query = $this->db->query($sql);
        if (count($query->result_array()) > 0) {
            foreach ($query->result() as $key => $value) {
                $drugs[$query->result()[$key]->mflcode][] = [
                    'kemsa_code' => $value->kemsa_code,
                    'drug' => $value->drug,
                    'qty_allocated' => $value->qty_allocated,
                    "opening_bal" => $value->balance,
                    "receipts" => $value->received,
                    "dispensed" => $value->dispensed_packs,
                    "losses" => $value->losses,
                    "positive_adj" => $value->adjustments,
                    "negative_adj" => $value->adjustments_neg,
                    "closing" => $value->count,
                    "aggr_dispensed" => $value->aggr_consumed, // for central sites only
                    "aggr_closing" => $value->aggr_on_hand, // for central sites only
                    "short_expiry" => $value->expiry_date,
                    "expiry_date" => $value->expiry_date,
                    "months_stocked_out" => $value->out_of_stock
                ];

                $qu = $query->result()[$key]->period_begin;
                $dat = explode("-", $qu);
                $facility_info[$query->result()[$key]->mflcode] = [
                    'facility' => $query->result()[$key]->facility,
                    'mflcode' => $query->result()[$key]->mflcode,
                    'report_code' => $query->result()[$key]->code,
                    'report_year' => $dat[0],
                    'report_month' => $dat[1],
                    'commodities' => $drugs[$query->result()[$key]->mflcode]
                ];
            }
            $facility_info = array_values($facility_info);
        } else {
            $resp = ['message' => 'No data found'];
            $facility_info = $resp;
        }
        return $facility_info;
    }

}

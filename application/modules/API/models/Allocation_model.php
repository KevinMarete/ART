<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation_model extends CI_Model {

   //function list facilities that are not yet installed
    public function read($mflcode, $period_begin = null) {
        $period_begin = ($period_begin == NULL) ? date('Y-m-01', strtotime('-1 MONTH')) : $period_begin ;
        $sql = "SELECT 
                    c.period_begin,c.code,f.mflcode,f.name as facility,
                    concat (g.name,' (',d.strength,') ',  d.packsize,' ',fm.name) as drug, ci.qty_allocated
                from tbl_cdrr c
                inner join tbl_cdrr_item ci on ci.cdrr_id = c.id 
                inner join tbl_drug d on ci.drug_id = d.id 
                inner join tbl_generic g on g.id = d.generic_id
                inner join tbl_facility f on c.facility_id = f.id 
                inner join tbl_formulation fm on d.formulation_id = fm.id
                where status = 'reviewed' 
                AND f.mflcode = ?
                AND ci.qty_allocated > 0
                AND period_begin = ?";

        $returnable = array();
        
        $query = $this->db->query($sql, array($mflcode, $period_begin));
        if (count($query->result_array()) >0){
            foreach ($query->result() as $key => $value) {

                array_push($returnable, array('drug'=>$value->drug,'qty_allocated'=>$value->qty_allocated));
            }
            $returnable['period_begin'] = $query->result()[0]->period_begin;
            $returnable['facility'] = $query->result()[0]->facility;
            $returnable['mflcode'] = $query->result()[0]->mflcode;
            $returnable['code'] = $query->result()[0]->code;
        }
        else{
            $returnable = false;
        }
        return $returnable;
    }

}

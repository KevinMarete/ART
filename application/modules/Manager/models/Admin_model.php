<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function get_table_data($table) {
        $response = array();
        try {
            if ($table == 'tbl_backup') {
                $this->db->select('b.id,b.filename,b.foldername,b.adt_version,b.run_time,f.name');
                $this->db->from('tbl_backup b');
                $this->db->join('tbl_facility f', 'f.id=b.facility_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_dhis_elements') {
                $sql = "SELECT dhis.id, dhis.dhis_code,dhis.dhis_name,dhis.dhis_report,dhis.target_report,dhis.target_name,dhis.target_category, "
                        . "(CASE WHEN dhis.target_category='drug' THEN tbl_category.name ELSE tbl_regimen.name END) name "
                        . "FROM tbl_dhis_elements dhis "
                        . "LEFT JOIN tbl_category ON tbl_category.id=dhis.target_id "
                        . "LEFT JOIN tbl_regimen ON tbl_regimen.id=dhis.target_id";
                $table_data = $this->db->query($sql)->result_array();
            } else if ($table == 'tbl_subcounty') {
                $this->db->select('sc.id, sc.name, c.name county');
                $this->db->from('tbl_subcounty sc');
                $this->db->join('tbl_county c', 'c.id = sc.county_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_drug') {
                $this->db->select('d.id,d.strength,d.packsize,g.name generic,f.name formulation');
                $this->db->from('tbl_drug d');
                $this->db->join('tbl_generic g', 'g.id=d.generic_id', 'inner');
                $this->db->join('tbl_formulation f', 'f.id=d.formulation_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_facility') {
                $this->db->select('f.id,f.name,f.mflcode,f.category,f.dhiscode,f.longitude,f.latitude,sc.name subcounty,p.name partner, f.parent_id');
                $this->db->from('tbl_facility f');
                $this->db->join('tbl_subcounty sc', 'sc.id=f.subcounty_id', 'inner');
                $this->db->join('tbl_partner p', 'p.id=f.partner_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_install') {
                $this->db->select('i.id,i.version,UCASE(f.name)facility_name,i.setup_date,i.contact_name,i.contact_phone,i.emrs_used,i.active_patients,IF(`is_usage`=1,"Yes","No"),IF(`is_internet`=1,"Yes","No"),u.firstname user_name');
                $this->db->from('tbl_install i');
                $this->db->join('tbl_facility f', 'f.id=i.facility_id', 'inner');
                $this->db->join('tbl_user u', 'u.id=i.user_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_regimen') {
                $this->db->select('r.id,r.code,r.name,r.description,c.name category,s.name service,l.name line');
                $this->db->from('tbl_regimen r');
                $this->db->join('tbl_category c', 'c.id=r.category_id', 'inner');
                $this->db->join('tbl_service s', 's.id=r.service_id', 'inner');
                $this->db->join('tbl_line l', 'l.id=r.line_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_role_submodule') {
                $this->db->select('rsbm.role_id,sbm.name submodule_name');
                $this->db->from('tbl_role_submodule rsbm');
                $this->db->join('tbl_submodule sbm', 'sbm.module_id=rsbm.submodule_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_submodule') {
                $this->db->select('sbm.id,sbm.name,m.name module_name');
                $this->db->from('tbl_submodule sbm');
                $this->db->join('tbl_module m', 'm.id=sbm.module_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_user') {
                $this->db->select('u.id,u.firstname,u.lastname,u.email_address,u.phone_number,r.name');
                $this->db->from('tbl_user u');
                $this->db->join('tbl_role r', 'r.id=u.role_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else {
                $table_data = $this->db->get($table)->result_array();
            }
            if (!empty($table_data)) {
                foreach ($table_data as $result) {
                    $response['data'][] = array_values($result);
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

    //function save data to database
    public function save($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //function get_by_id
    public function get_by_id($table, $id) {
        if ($table == 'tbl_role_submodule') {
            $this->db->from($table);
            $this->db->where('role_id', $id);
            $query = $this->db->get();
            return $query->row();
        } else {
            $this->db->from($table);
            $this->db->where('id', $id);
            $query = $this->db->get();
            return $query->row();
        }
    }

    //function update db_table
    public function update($table, $where, $data) {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    //function delete from db_table
    public function delete_by_id($table, $id) {
        if ($table == 'tbl_role_submodule') {
            $this->db->where('role_id', $id);
            $this->db->delete($table);
        } else {
            $this->db->where('id', $id);
            $this->db->delete($table);
        }
    }

}

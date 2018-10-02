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
                $this->db->select('d.id,d.strength,d.packsize,g.name generic,f.name formulation,dc.name category,d.min_mos, d.max_mos,st.name stock_status');
                $this->db->from('tbl_drug d');
                $this->db->join('tbl_generic g', 'g.id=d.generic_id', 'inner');
                $this->db->join('tbl_formulation f', 'f.id=d.formulation_id', 'inner');
                $this->db->join('tbl_drug_category dc', 'dc.id=d.drug_category', 'inner');
                $this->db->join('tbl_stock_status st', 'd.stock_status=st.id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_mailing_list') {
                $this->db->select('ml.id,ml.name name, ml.email,c.name category,ml.sent_date , s.name status');
                $this->db->from('tbl_mailing_list ml');
                $this->db->join('tbl_email_status s', 'ml.status=s.id', 'left');
                $this->db->join('tbl_email_category c', 'c.id=ml.email_type', 'left');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_facility') {
                $sql = "SELECT f.id,f.name,f.mflcode,f.category,f.dhiscode,f.longitude,f.latitude,sc.name subcounty,p.name partner,(CASE WHEN f.parent_id=f.id THEN f.name END) fname "
                        . "FROM tbl_facility f "
                        . "LEFT JOIN tbl_subcounty sc ON sc.id=f.subcounty_id "
                        . "LEFT JOIN tbl_partner p ON p.id=f.partner_id";
                $table_data = $this->db->query($sql)->result_array();
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
            } else if ($table == 'tbl_regimen_drug') {
                $this->db->select('rg.id,r.name regimen_name,vdl.name drug_name');
                $this->db->from('tbl_regimen_drug rg');
                $this->db->join('tbl_regimen r', 'r.id=rg.regimen_id', 'inner');
                $this->db->join('vw_drug_list vdl', 'vdl.id=rg.drug_id', 'inner');
                $table_data = $this->db->get()->result_array();
            } else if ($table == 'tbl_role_submodule') {
                $this->db->select('rsbm.id,r.name,sbm.name submodule_name');
                $this->db->from('tbl_role_submodule rsbm');
                $this->db->join('tbl_role r', 'r.id=rsbm.role_id', 'inner');
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
            } else if ($table == 'tbl_meeting') {
               
                $this->db->select('id,meeting_date,meeting_date as action');
                $this->db->from('tbl_meeting');
  
                $table_data = $this->db->get()->result_array();
            }else if ($table == 'tbl_syslogs') {
                $table_data = $this->db->query("SELECT sy.id,sy.log_date,sy.action,sy.module,CONCAT_WS(' ',u.firstname,u.lastname) user
                                                                               FROM tbl_syslogs sy LEFT JOIN tbl_user u ON sy.user = u.id
                                                                              ORDER BY sy.id DESC;
                                                                            ")->result_array();
            
            }else {
                $table_data = $this->db->get($table)->result_array();
            }
            if (!empty($table_data)) {
                foreach ($table_data as $result) {
                    $response['data'][] = array_values($result);
                }
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            } else {
                $response['data'] = array();
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
        if ($table == 'tbl_user') {
            $user_array = [
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email_address' => $this->input->post('email_address'),
                'phone_number' => $this->input->post('phone_number'),
                'role_id' => $this->input->post('role'),
                'password' => md5($this->input->post('password'))
            ];
            $this->db->insert($table, $user_array);
            $id = $this->db->insert_id();

            $scope_array = [
                'scope_id' => $this->input->post('scope_id'),
                'role_id' => $this->input->post('role'),
                'user_id' => $id
            ];
            $this->db->insert($table . '_scope', $scope_array);
           
        } else {
            unset($data['id']);
            $this->db->insert($table, $data);
        }
        //echo $this->db->last_query();
        echo json_encode(array("status" => TRUE));
    }

    //function get_by_id
    public function get_by_id($table, $id) {
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    //function update db_table
    public function update($table, $where, $data) {
        if ($table == 'tbl_user') {
            $user_array = [
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email_address' => $this->input->post('email_address'),
                'phone_number' => $this->input->post('phone_number'),
                'role_id' => $this->input->post('role'),
                    // 'password' => md5($this->input->post('password'))
            ];
            $this->db->update($table, $where, $user_array);


            $scope_array = [
                'scope_id' => $this->input->post('scope_id'),
                'role_id' => $this->input->post('role'),
            ];
            //$this->db->insert($table . '_scope', $scope_array);
            $this->db->update($table . '_scope', $scope_array, ['user_id' => $this->input->post('id')]);
        } else {
            $this->db->update($table, $data, $where);
        }
        return $this->db->affected_rows();
    }

    //function delete from db_table
    public function delete_by_id($table, $id) {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}

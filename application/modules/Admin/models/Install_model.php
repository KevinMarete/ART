<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Install_model extends CI_Model {

    //Get installed sites


    var $table = 'tbl_install';
    var $column_order = array('tbl_facility.name','tbl_install.version','tbl_install.setup_date','tbl_install.active_patients','
        . tbl_install.contact_name','tbl_install.contact_phone');
    var $column_search = array('tbl_facility.name','tbl_install.version','tbl_install.setup_date','tbl_install.active_patients','
        . tbl_install.contact_name','tbl_install.contact_phone');
    var $order = array('tbl_facility.id' => 'desc');

    private function _get_datatables_query() {
        $this->db->select('tbl_install.id,tbl_facility.name,tbl_install.version,tbl_install.setup_date,tbl_install.active_patients,'
                . 'tbl_install.contact_name,tbl_install.contact_phone');
        $this->db->from($this->table);
        $this->db->join('tbl_facility', 'tbl_install.facility_id=tbl_facility.id', 'inner');
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    //function add site
    public function insert($data) {
        $this->db->insert('tbl_install', $data);
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['id'] = $this->db->insert_id();
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    //function get site information
    function get_siteInfo($id) {
        $this->db->select('tbl_install.id as install_id,tbl_install.version,tbl_install.setup_date,tbl_install.upgrade_date,tbl_install.comments,'
                . 'tbl_install.contact_name,tbl_install.contact_phone,tbl_install.emrs_used,tbl_install.active_patients,tbl_install.is_internet,'
                . 'tbl_install.is_usage,tbl_install.user_id,tbl_facility.name,tbl_facility.mflcode,tbl_facility.category,tbl_facility.subcounty_id,'
                . 'tbl_subcounty.id,tbl_subcounty.name as subcounty_name,tbl_user.name as user_name,tbl_county.name as county_name,'
                . 'tbl_partner.name as partner_name');
        $this->db->from('tbl_install');
        $this->db->join('tbl_facility', 'tbl_install.facility_id=tbl_facility.id');
        $this->db->join('tbl_subcounty', 'tbl_facility.subcounty_id=tbl_subcounty.id');
        $this->db->join('tbl_county', 'tbl_subcounty.county_id=tbl_county.id');
        $this->db->join('tbl_user', 'tbl_user.id=tbl_install.user_id');
        $this->db->join('tbl_partner', 'tbl_partner.id=tbl_facility.partner_id');
        $this->db->where('tbl_install.id', $id);
        $query = $this->db->get();
        $result = $query->result();
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    //function update site
    public function update($id, $data) {
        $this->db->update('tbl_install', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_install', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Regimen_regimen_drug_model extends CI_Model {

    public function read() {
        $this->db->select('r.*');
        $this->db->from('tbl_regimen r');
        $this->db->where('r.id NOT IN (SELECT tbl_regimen_drug.regimen_id FROM tbl_regimen_drug)', NULL, FALSE);
        $this->db->order_by('r.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_list() {
        $query = $this->db->get('vw_regimen_list');
        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('tbl_regimen', $data);
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['id'] = $this->db->insert_id();
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function update($id, $data) {
        $this->db->update('tbl_regimen', $data, array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

    public function delete($id) {
        $this->db->delete('tbl_regimen', array('id' => $id));
        $count = $this->db->affected_rows();
        if ($count > 0) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        return $data;
    }

}

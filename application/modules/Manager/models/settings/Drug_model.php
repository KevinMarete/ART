<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Drug_model extends CI_Model {

    var $table = 'tbl_drug';
    var $column_order = array('tbl_drug.strength','tbl_drug.packsize','tbl_generic.name','tbl_formulation.name');
    var $column_search = array('tbl_drug.strength','tbl_drug.packsize','tbl_generic.name','tbl_formulation.name');
    var $order = array('id' => 'desc');

    private function _get_datatables_query() {
        $this->db->select('tbl_drug.id,tbl_drug.strength,tbl_drug.packsize,tbl_generic.name as generic_name,tbl_formulation.name as formulation_name');
        $this->db->from($this->table);
        $this->db->join('tbl_generic','tbl_drug.generic_id=tbl_generic.id');
        $this->db->join('tbl_formulation','tbl_drug.formulation_id=tbl_formulation.id');
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) { // first loop
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end();
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

    public function get_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function get_table_data($table) {
        $response = array();
        try {
            $table_data = $this->db->get($table)->result_array();
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

    public function save($data) {
        $post_data = array();
        $table = '';
        foreach ($data as $key => $value) {
            if ($key == '_table_')
                $table = $value;
            else
                $post_data[$key] = $value;
        }
        $this->db->insert($table, $post_data);
        return $this->db->insert_id();
    }

    public function get_by_id($id) {
        $db_tables = [
            'county'=>'tbl_county',
            'facility'=>'tbl_facility'
        ];
        
        $table = $db_tables[$page_name];
        
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update($where, $data) {
        $post_data = array();
        $table = '';
        foreach ($data as $key => $value) {
            if ($key == '_table_')
                $table = $value;
            else
                $post_data[$key] = $value;
        }
        $this->db->update($table, $post_data, $where);
        return $this->db->affected_rows();
    }

}

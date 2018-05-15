<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function get_table_data($table){
		$response = array();
		try{
			$table_data = $this->db->get($table)->result_array();
			if(!empty($table_data)){
				foreach ($table_data as $result) {
					$response['data'][] = array_values($result);
				}
				$response['message'] = 'Table data was found!';
				$response['status'] = TRUE;
			}else{
				$response['message'] = 'Table is empty!';
				$response['status'] = FALSE;
			}
		}catch(Execption $e){
			$response['status'] = FALSE;
			$response['message'] = $e->getMessage();
		}
		return $response;
	}

}
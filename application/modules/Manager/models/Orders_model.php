<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

    public function update_user_scope($data) {
        $response = array();
        try {
            $this->db->replace('tbl_user_scope', $data);
            $count = $this->db->affected_rows();
            if ($count > 0) {
                $response['message'] = 'User account scope was updated!';
                $response['data'] = $data;
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'User account scope was not updated!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function get_order_data($scope) {
        $response = array();
        try {
            $sql = "SELECT 
						IF(c.code = 'D-CDRR', CONCAT('D-CDRR#', c.id), CONCAT('F-CDRR#', c.id)) cdrr_id,
						IF(m.code = 'D-MAPS', CONCAT('D-MAPS#', m.id), CONCAT('F-MAPS#', m.id)) maps_id,
						c.period_begin,
						c.status,
						f.name facility_name,
						CONCAT('<a href=view/', c.id,'/', m.id, '>View Order</a>') option
					FROM tbl_facility f
					INNER JOIN tbl_cdrr c ON c.facility_id = f.id
					INNER JOIN tbl_maps m ON m.facility_id = f.id
					WHERE c.facility_id = m.facility_id
					AND c.period_begin = m.period_begin
					AND c.period_end = m.period_end
					AND f.subcounty_id = ?
					GROUP BY c.id 
					ORDER BY c.period_begin DESC";
            $table_data = $this->db->query($sql, array($scope))->result_array();
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

    public function get_reporting_data($scope, $period_begin, $period_end) {
        $response = array();
        try {
            $month_name = date('F Y', strtotime($period_begin));
            $sql = "SELECT 
						f.mflcode,
						f.name facility_name,
						IF(c.period_begin IS NOT NULL, ?, ?) reporting_status,
						IF(c.period_begin IS NOT NULL, '<a href=reports>View</a>', CONCAT('<a href=get_report/', f.mflcode,'>Report</a>')) option
					FROM tbl_facility f  
					LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
					LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
					WHERE f.subcounty_id = ?
					GROUP BY f.mflcode
					ORDER BY f.name ASC";
            $table_data = $this->db->query($sql, array(
                        '<span class="label label-success">Submitted for ' . $month_name . '</span>',
                        '<span class="label label-danger">Pending for ' . $month_name . '</span>',
                        $period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
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

    public function get_drugs() {
        return $this->db->get('vw_drug_list')->result_array();
    }

    public function get_regimens() {
        return $this->db->get('vw_regimen_list')->result_array();
    }

    public function get_cdrr_data($cdrr_id) {
        $response = array();
        try {
            $sql = "SELECT *
				FROM tbl_cdrr c 
				INNER JOIN tbl_cdrr_item ci ON ci.cdrr_id = c.id
				INNER JOIN vw_drug_list d ON d.id = ci.drug_id
				INNER JOIN tbl_cdrr_log cl ON cl.cdrr_id = c.id
				INNER JOIN tbl_facility f ON f.id = c.facility_id
				INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
				INNER JOIN tbl_county co ON co.id = sc.county_id
				WHERE c.id = ?";
            $table_data = $this->db->query($sql, array($cdrr_id))->result_array();
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

    public function get_maps_data($maps_id) {
        $response = array();
        try {
            $sql = "SELECT *
				FROM tbl_maps m 
				INNER JOIN tbl_maps_item mi ON mi.maps_id = m.id
				INNER JOIN vw_regimen_list r ON r.id = mi.regimen_id
				INNER JOIN tbl_maps_log ml ON ml.maps_id = m.id
				INNER JOIN tbl_facility f ON f.id = m.facility_id
				INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
				INNER JOIN tbl_county co ON co.id = sc.county_id
				WHERE m.id = ?";
            $table_data = $this->db->query($sql, array($maps_id))->result_array();
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

    public function get_allocation_data($scope) {
        $response = array();
        try {
            $sql = "SELECT                      
                        f.mflcode,
                        f.name,
               		c.period_begin,
                        c.status,
			IF(c.status = 'received', CONCAT('<a href=allocate/', c.id,'/', m.id, '> Allocate</a>'), CONCAT('<a href=allocate/', c.id,'/', m.id, '>View Order</a>'))  option
                        FROM tbl_facility f
			INNER JOIN tbl_cdrr c ON c.facility_id = f.id
                        INNER JOIN tbl_maps m ON m.facility_id = f.id
			WHERE c.facility_id = m.facility_id
                        AND c.period_begin = m.period_begin
			AND c.period_end = m.period_end
			AND f.subcounty_id = ?
                        GROUP BY c.id 
			ORDER BY c.period_begin DESC";
            $table_data = $this->db->query($sql, array($scope))->result_array();
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

}

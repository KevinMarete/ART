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
    public function actionOrder($orderid,$action,$user) {
        $response = array();
        try {
            $this->db->set('status', $action);
            $this->db->where('id', $orderid);
            if ($this->db->update('tbl_cdrr')){
                $array = array(
                    'description' => $action,
                    'user_id' => $user,
                    'cdrr_id' => $orderid
                    );
                $this->db->set($array);
                $this->db->insert('tbl_cdrr_log');

                $response['message'] = 'Order status was updated!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Order status was not updated!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function updateOrder($orderid,$order,$user) {
        $response = array();
        try {   
            if ($this->db->update_batch('tbl_cdrr_item', $order, 'id') == 0) {

                $array = array(
                    'description' => 'updated',
                    'user_id' => $user,
                    'cdrr_id' => $orderid
                    );
                $this->db->set($array);
                $this->db->insert('tbl_cdrr_log');

                $response['message'] = 'Order was updated!';
                $response['status'] = TRUE;
            } else {
                $response['message'] = 'Order was not updated!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function get_order_data($scope, $role) {
        $response = array('data'=> array());
        $column = "";
        $join = "";
        $filter = "AND f.subcounty_id = '".$scope."'";
        try {
            //Set conditions
            if($role == 'county'){
                $column = "UCASE(sc.name) subcounty,";
                $join = "INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id";
                $filter = "AND sc.county_id = '".$scope."'";
            }

            $sql = "SELECT 
						IF(c.code = 'D-CDRR', CONCAT('D-CDRR#', c.id), CONCAT('F-CDRR#', c.id)) cdrr_id,
						IF(m.code = 'D-MAPS', CONCAT('D-MAPS#', m.id), CONCAT('F-MAPS#', m.id)) maps_id,
						c.period_begin,
						c.status,
                        $column
						UCASE(f.name) facility_name,
						CONCAT('<a href=view/', c.id,'/', m.id, '>View Order</a>') option
					FROM tbl_facility f
                    $join
					INNER JOIN tbl_cdrr c ON c.facility_id = f.id
					INNER JOIN tbl_maps m ON m.facility_id = f.id
					WHERE c.facility_id = m.facility_id
					AND c.period_begin = m.period_begin
					AND c.period_end = m.period_end
					$filter
					GROUP BY c.id 
					ORDER BY c.period_begin DESC";
            $table_data = $this->db->query($sql)->result_array();
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

    public function get_reporting_data($scope, $role, $period_begin, $period_end) {
        $response = array('data' => array());
        try {
            $month_name = date('F Y', strtotime($period_begin));

            if($role == 'county'){
                $sql = "SELECT 
                            UCASE(sc.name) subcounty,
                            CONCAT_WS('/', SUM(IF(c.period_begin IS NOT NULL, 1, 0)), (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0)))) submitted,
                            ROUND(SUM(IF(c.period_begin IS NOT NULL, 1, 0))/(SUM(IF(c.period_begin IS NOT NULL, 1, 0))+ SUM(IF(c.period_begin IS NULL, 1, 0)))*100) progress
                        FROM tbl_facility f  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                        LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                        LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                        WHERE sc.county_id = ?
                        AND f.category != 'satellite'
                        GROUP BY sc.name
                        ORDER BY sc.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
            }else{
                $sql = "SELECT 
                        f.mflcode,
                        UCASE(f.name) facility_name,
                        IF(c.period_begin IS NOT NULL, ?, ?) reporting_status,
                        ? period,
                        IF(c.period_begin IS NOT NULL, '<a href=reports>View</a>', CONCAT('<a href=get_report/', f.mflcode,'>Report</a>')) option
                    FROM tbl_facility f  
                    LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                    LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                    WHERE f.subcounty_id = ?
                    AND f.category != 'satellite'
                    GROUP BY f.mflcode
                    ORDER BY f.name ASC";
                $table_data = $this->db->query($sql, array(
                        '<span class="label label-success">Submitted</span>',
                        '<span class="label label-danger">Pending</span>',
                        $month_name, $period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
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

    public function get_allocation_data($scope, $role, $period_begin, $period_end) {
        $response = array('data' => array());
        try {
            if($role == 'county'){
                $sql = "SELECT 
                            DATE_FORMAT(c.period_begin, '%M-%Y') period,
                            CONCAT_WS('/', COUNT(DISTINCT sc.name),sb.total ) allocated,
                            IF(COUNT(DISTINCT sc.name) != sb.total, 'Incomplete', 'Complete') status,
                            CONCAT('<a href=edit_allocation/', c.period_begin, '>View/Edit</a>')  option
                        FROM tbl_cdrr c 
                        INNER JOIN tbl_maps m ON c.facility_id = m.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status = 'allocated'
                        INNER JOIN tbl_facility f ON c.facility_id = f.id  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id,
                        (SELECT COUNT(DISTINCT sb.name) total FROM tbl_facility fc INNER JOIN tbl_subcounty sb ON fc.subcounty_id = sb.id WHERE sb.county_id = ? AND fc.category != 'satellite') sb
                        WHERE sc.county_id = ?
                        AND f.category != 'satellite'
                        GROUP BY period
                        ORDER BY period ASC";
                $table_data = $this->db->query($sql, array($scope, $scope))->result_array();
            }else{
                $sql = "SELECT                      
                            f.mflcode,
                            UCASE(f.name) facility_name,
                            IF(c.period_begin IS NULL, DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%M-%Y') ,DATE_FORMAT(c.period_begin, '%M-%Y')) period,
                            IF(c.status IS NULL, 'Not Reported', c.status) reporting_status,
                            IF(c.status = 'pending', CONCAT('<a href=allocate/', c.id,'/', m.id, '> Allocate</a>'), CONCAT('<a href=view_allocate/', c.id,'/', m.id, '>View Allocation</a>'))  option
                        FROM tbl_facility f
                        LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                        LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                        WHERE f.subcounty_id = ?
                        AND f.category != 'satellite'
                        GROUP BY f.mflcode
                        ORDER BY f.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
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

    public function get_county_allocation_data($scope, $role, $period_begin, $period_end){
        $response = array('data' => array());
        try {
            $sql = "SELECT                      
                        UCASE(sc.name) subcounty,
                        IF(SUM(IF(c.period_begin IS NOT NULL, 1, 0)) = (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0))), 'Allocated', 'Unallocated') allocation,
                        'N/A' approval_status,
                        IF(SUM(IF(c.period_begin IS NOT NULL, 1, 0)) = (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0))), CONCAT('<a href=view_allocate/', sc.id,'/', c.period_begin, '>View/Verify Allocation</a>'), '<a> Pending Allocation</a>') option
                    FROM tbl_facility f
                    INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                    LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                    LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                    WHERE sc.county_id = ?
                    AND f.category != 'satellite'
                    GROUP BY sc.name
                    ORDER BY sc.name ASC";
            $table_data = $this->db->query($sql, array($period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();

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

   

  public function get_cdrr_data($cdrr_id,$scope = null,$role = null){
        
        $role_cond = ($role == 'subcounty') ? " AND sc.id = $scope" : " AND subcounty_id = $scope";

        $response = array();
        try{
            $sql = "SELECT *,d.name as drug_name,f.name as facility_name,co.name as county, sc.name as subcounty,ci.id as cdrr_item_id
            FROM tbl_cdrr c 
            INNER JOIN tbl_cdrr_item ci ON ci.cdrr_id = c.id
            INNER JOIN vw_drug_list d ON d.id = ci.drug_id
            INNER JOIN tbl_facility f ON f.id = c.facility_id
            INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
            INNER JOIN tbl_county co ON co.id = sc.county_id
            WHERE c.id = ?  ".$role_cond;

                  $table_data = $this->db->query($sql, array($cdrr_id))->result_array();
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

    public function get_maps_data($maps_id,$scope = null,$role = null){
        $role_cond = ($role == 'subcounty') ? " AND f.subcounty_id = $scope" : " AND sc.county_id = $scope";

        $response = array();
        try{
            $sql = "SELECT *,r.name as regimen_name, f.name as facility_name, sc.name as subcounty, co.name as county
            FROM tbl_maps m 
            INNER JOIN tbl_maps_item mi ON mi.maps_id = m.id
            INNER JOIN vw_regimen_list r ON r.id = mi.regimen_id
            INNER JOIN tbl_facility f ON f.id = m.facility_id
            INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
            INNER JOIN tbl_county co ON co.id = sc.county_id
            WHERE m.id = ? ".$role_cond;

            $table_data = $this->db->query($sql, array($maps_id))->result_array();
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

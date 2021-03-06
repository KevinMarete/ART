<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

    public function actionOrder($orderid,$mapid,$action,$user) {
        $response = array();
        try {
            $this->db->set('updated', date('Y-m-d H:i:s'));
            $this->db->set('status', $action);
            $this->db->where('id', $orderid);

            if ($this->db->update('tbl_cdrr')){
                $log_action = $action;
                if($action == 'pending'){
                    $log_action = 'updated';
                }
                $array = array(
                    'description' => $log_action,
                    'user_id' => $user,
                    'cdrr_id' => $orderid,
                    'created' => date('Y-m-d H:i:s')
                );
                $this->db->set($array);
                $this->db->insert('tbl_cdrr_log');

                //Update maps
                $this->db->set('updated', date('Y-m-d H:i:s'));
                $this->db->set('status', $action);
                $this->db->where('id', $mapid);
                if ($this->db->update('tbl_maps')){
                    $maps_log = array(
                        'description' => $log_action,
                        'user_id' => $user,
                        'maps_id' => $mapid,
                        'created' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('tbl_maps_log',$maps_log);
                }    
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

    public function updateOrder($orderid,$mapid,$order,$user) {
        $response = array();
        try {   
            if ($this->db->update_batch('tbl_cdrr_item', $order, 'id') == 0) {
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
        $filter = "";
        try {
            //Set conditions
            if($role == 'county'){
                $column = "UCASE(sc.name) subcounty,";
                $join = "INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id";
                $filter = "AND sc.county_id = '".$scope."'";
            }else if($role == 'subcounty'){
                $filter = "AND f.subcounty_id = '".$scope."'";
            }else if($role == 'national'){
                $column = "UCASE(co.name) county, UCASE(sc.name) subcounty,";
                $join = "INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id INNER JOIN tbl_county co ON sc.county_id = co.id";
            }

            $sql = "SELECT 
                        UCASE(f.name) facility_name,
                        c.period_begin,
                        CONCAT_WS('/', c.code, m.code) description,
                        $column
                        c.status,
                        CONCAT('<a href=view/', c.id,'/', m.id, '>View Order</a>') options
                    FROM tbl_facility f
                    $join
                    INNER JOIN tbl_cdrr c ON c.facility_id = f.id 
                    INNER JOIN tbl_maps m ON m.facility_id = f.id
                    WHERE c.facility_id = m.facility_id
                    AND c.period_begin = m.period_begin
                    AND c.period_end = m.period_end
                    AND SUBSTRING(c.code, 1, 1) = SUBSTRING(m.code, 1, 1)
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

    public function get_reporting_data($scope, $role, $period_begin, $period_end, $allocation = false) {
        $response = array('data' => array());
        try {
            $month_name = date('F Y', strtotime($period_begin));

            if($role == 'national'){
                $sql = "SELECT 
                            UCASE(co.name) county,
                            CONCAT_WS('/', COUNT(DISTINCT t.facility_id), COUNT(DISTINCT f.id)) submitted,
                            ROUND(COUNT(DISTINCT t.facility_id)/(COUNT(DISTINCT f.id))*100) progress
                        FROM tbl_facility f  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                        INNER JOIN tbl_county co ON co.id = sc.county_id
                        LEFT JOIN
                        (
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'D-CDRR' AND m.code = 'D-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'central'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                            UNION
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'F-CDRR' AND m.code = 'F-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'standalone'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                        ) t ON t.facility_id = f.id
                        WHERE f.category != 'satellite'
                        GROUP BY co.name
                        ORDER BY co.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end, $period_begin, $period_end))->result_array();
            } else if($role == 'county'){
                $sql = "SELECT 
                            UCASE(sc.name) subcounty,
                            CONCAT_WS('/', COUNT(DISTINCT t.facility_id), COUNT(DISTINCT f.id)) submitted,
                            ROUND(COUNT(DISTINCT t.facility_id)/(COUNT(DISTINCT f.id))*100) progress
                        FROM tbl_facility f  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                        LEFT JOIN
                        (
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'D-CDRR' AND m.code = 'D-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'central'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                            UNION
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'F-CDRR' AND m.code = 'F-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'standalone'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                        ) t ON t.facility_id = f.id
                        WHERE sc.county_id = ?
                        AND f.category != 'satellite'
                        GROUP BY sc.name
                        ORDER BY sc.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
            }else{
                $allocation_url = ($allocation) ? "../../../view_allocation" : "view" ;

                $sql = "SELECT 
                            f.mflcode,
                            UCASE(f.name) facility_name,
                            IF(t.period_begin IS NOT NULL, UCASE(t.status), 'PENDING') reporting_status,
                            IF(t.period_begin IS NOT NULL, t.description, 'N/A') description,
                            ? period,
                            IF(t.period_begin IS NOT NULL, CONCAT('<a href=$allocation_url/',t.cdrr_id,'/',t.maps_id,'>View Order</a>'), 'Not Reported') options
                        FROM tbl_facility f  
                        LEFT JOIN
                        (
                            SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'D-CDRR' AND m.code = 'D-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'central'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                            UNION 
                            SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'F-CDRR' AND m.code = 'F-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'standalone'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                        ) t ON t.facility_id = f.id
                        WHERE f.subcounty_id = ?
                        AND f.category != 'satellite'
                        GROUP BY f.mflcode
                        ORDER BY f.name ASC";
                $table_data = $this->db->query($sql, array($month_name, $period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();
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
            if($role == 'national'){
                $sql = "SELECT 
                            DATE_FORMAT(c.period_begin, '%M-%Y') period,
                            CONCAT_WS('/', SUM(IF(c.status = 'reviewed', 1, 0)) , sb.total) reviewed,
                            IF(SUM(IF(c.status = 'reviewed', 1, 0)) != sb.total, 'Incomplete', 'Complete') status,
                            CONCAT('<a href=edit_allocation/', c.period_begin, '>View/Edit</a>')  options
                        FROM tbl_cdrr c 
                        INNER JOIN tbl_maps m ON c.facility_id = m.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status IN('allocated', 'approved', 'reviewed') AND SUBSTRING(c.code, 1, 1) = SUBSTRING(m.code, 1, 1)
                        INNER JOIN tbl_facility f ON c.facility_id = f.id,  
                        (SELECT COUNT(DISTINCT fc.name) total FROM tbl_facility fc WHERE fc.category != 'satellite') sb
                        WHERE f.category != 'satellite'
                        GROUP BY period
                        ORDER BY period ASC";
                $table_data = $this->db->query($sql, array($scope, $scope))->result_array();
            }else if($role == 'county'){
                $sql = "SELECT 
                            DATE_FORMAT(c.period_begin, '%M-%Y') period,
                            CONCAT_WS('/', SUM(IF(c.status IN ('approved', 'reviewed'), 1, 0)) , sb.total) approved,
                            IF(SUM(IF(c.status IN ('approved', 'reviewed'), 1, 0)) != sb.total, 'Incomplete', 'Complete') status,
                            CONCAT('<a href=edit_allocation/', c.period_begin, '>View/Edit</a>')  options
                        FROM tbl_cdrr c 
                        INNER JOIN tbl_maps m ON c.facility_id = m.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status IN('allocated', 'approved', 'reviewed') AND SUBSTRING(c.code, 1, 1) = SUBSTRING(m.code, 1, 1)
                        INNER JOIN tbl_facility f ON c.facility_id = f.id  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id,
                        (SELECT COUNT(DISTINCT fc.name) total FROM tbl_facility fc INNER JOIN tbl_subcounty sb ON fc.subcounty_id = sb.id WHERE sb.county_id = ? AND fc.category != 'satellite') sb
                        WHERE sc.county_id = ?
                        AND f.category != 'satellite'
                        GROUP BY period
                        ORDER BY period ASC";
                $table_data = $this->db->query($sql, array($scope, $scope))->result_array();
            }else{
                $sql = "SELECT                      
                            f.mflcode,
                            UCASE(f.name) facility_name,
                            IF(t.period_begin IS NULL, DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%M-%Y') , DATE_FORMAT(t.period_begin, '%M-%Y')) period,
                            IF(t.period_begin IS NOT NULL, t.description, 'N/A') description,
                            IF(t.status IS NULL, 'PENDING', UCASE(t.status)) reporting_status,
                            CASE 
                                WHEN t.status = 'pending' THEN CONCAT('<a href=allocate/', t.cdrr_id,'/', t.maps_id, '> Allocate Order</a>')
                                WHEN t.status != 'pending' THEN CONCAT('<a href=view_allocation/', t.cdrr_id,'/', t.maps_id, '> View Allocation</a>') 
                                ELSE 'Not Reported'
                            END AS options
                        FROM tbl_facility f
                        LEFT JOIN
                        (   
                            SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'D-CDRR' AND m.code = 'D-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'central'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                            UNION
                            SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'F-CDRR' AND m.code = 'F-MAPS'
                            INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'standalone'
                            WHERE c.period_begin = ? AND c.period_end = ?
                            GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                        ) t ON t.facility_id = f.id
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
        $currmonth = date('Y-m-d', strtotime('first day of last month'));
        try {
            if($role == 'national'){
                $sql = "SELECT 
                            UCASE(co.name) county,
                            CONCAT_WS('/', COUNT(DISTINCT t.facility_id), COUNT(DISTINCT f.id)) submitted,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), 'Reviewed', 'Unreviewed') approval,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), 'Approved', 'N/A') reviewal_status,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), CONCAT('<a href=','../allocation/subcounty/', sc.id,'/', t.period_begin, '>View/Verify Allocation</a>'), CONCAT('<a href=','../allocation/county/', co.id,'/$currmonth','> Pending Allocation</a>')) options
                        FROM tbl_facility f  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                        INNER JOIN tbl_county co ON co.id = sc.county_id
                        LEFT JOIN
                        (
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status = m.status AND SUBSTRING(c.code, 1, 1) = SUBSTRING(m.code, 1, 1)
                            WHERE c.period_begin = ? 
                            AND c.period_end = ?
                            AND c.status = 'reviewed'
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                        ) t ON t.facility_id = f.id
                        WHERE f.category != 'satellite'
                        GROUP BY co.name
                        ORDER BY co.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end))->result_array();
            } else if($role == 'county'){
                $sql = "SELECT 
                            UCASE(sc.name) subcounty,
                            CONCAT_WS('/', COUNT(DISTINCT t.facility_id), COUNT(DISTINCT f.id)) submitted,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), 'Allocated', 'Unallocated') allocation,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), 'Approved', 'N/A') approval_status,
                            IF(COUNT(DISTINCT t.facility_id) = COUNT(DISTINCT f.id), CONCAT('<a href=','../allocation/subcounty/', sc.id,'/', t.period_begin, '>View/Verify Allocation</a>'), CONCAT('<a href=','../allocation/subcounty/', sc.id,'/$currmonth','> Pending Allocation</a>')) options
                        FROM tbl_facility f  
                        INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                        LEFT JOIN
                        (
                            SELECT c.facility_id, c.period_begin, c.period_end, c.code
                            FROM tbl_cdrr c 
                            INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status = m.status AND SUBSTRING(c.code, 1, 1) = SUBSTRING(m.code, 1, 1)
                            WHERE c.period_begin = ? 
                            AND c.period_end = ?
                            AND c.status IN ('approved', 'reviewed')
                            GROUP BY c.facility_id, c.period_begin, c.period_end, c.code
                        ) t ON t.facility_id = f.id
                        WHERE sc.county_id = ?
                        AND f.category != 'satellite'
                        GROUP BY sc.name
                        ORDER BY sc.name ASC";
                $table_data = $this->db->query($sql, array($period_begin, $period_end, $scope))->result_array();
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

    public function get_drugs() {
        return $this->db->get('vw_drug_list')->result_array();
    }

    public function get_regimens() {
        $response = array();
        $regimens = $this->db->get('vw_regimen_list')->result_array();
        foreach ($regimens as $regimen) {
            $response[$regimen['category']][] = array(
                'id' => $regimen['id'],
                'code' => $regimen['code'],
                'name' => $regimen['name']
            );
        }
        return $response;
    }

    public function get_cdrr_data($cdrr_id, $scope = null, $role = null){
        $conditions = array(
            "national" => "",
            "county" => " AND county_id = '$scope'",
            "subcounty" => " AND sc.id = '$scope'"
        );

        $role_cond = $conditions[$role];

        $response = array();

        //Go back if no cdrr_id
        if(!$cdrr_id){
            return $response;
        }

        try{
            $sql = "SELECT 
                        *, d.name AS drug_name, f.name AS facility_name, co.name AS county, sc.name AS subcounty, ci.id AS cdrr_item_id
                    FROM tbl_cdrr c 
                    INNER JOIN tbl_cdrr_item ci ON ci.cdrr_id = c.id
                    INNER JOIN vw_drug_list d ON d.id = ci.drug_id
                    INNER JOIN tbl_facility f ON f.id = c.facility_id
                    INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                    INNER JOIN tbl_county co ON co.id = sc.county_id
                    WHERE c.id = ?  ".$role_cond;
            $table_data = $this->db->query($sql, array($cdrr_id))->result_array();

            $logs_sql = "SELECT 
                            cl.description, cl.created, u.firstname, u.lastname, r.name AS role
                        FROM tbl_cdrr_log cl
                        INNER JOIN tbl_user u ON cl.user_id = u.id
                        INNER JOIN tbl_role r ON u.role_id = r.id
                        WHERE cdrr_id = ? 
                        ORDER BY cl.id ASC";
            $logs_table_data = $this->db->query($logs_sql, array($cdrr_id))->result_array();

            if(!empty($table_data)){
                foreach ($table_data as $result) {
                    $response['data'][] = array('status' => $result['status'], 
                        'created' => $result['created'], 
                        'updated' => $result['updated'], 
                        'code' => $result['code'], 
                        'period_begin' => $result['period_begin'], 
                        'period_end' => $result['period_end'], 
                        'comments' => $result['comments'], 
                        'reports_expected' => $result['reports_expected'], 
                        'reports_actual' => $result['reports_actual'], 
                        'services' => $result['services'], 
                        'sponsors' => $result['sponsors'], 
                        'non_arv' => $result['non_arv'], 
                        'delivery_note' => $result['delivery_note'], 
                        'order_id' => $result['order_id'], 
                        'facility_id' => $result['facility_id'],
                        'facility_name' => $result['facility_name'], 
                        'mflcode' => $result['mflcode'], 
                        'county' => $result['county'], 
                        'subcounty' => $result['subcounty']
                    );

                    $response['data']['cdrr_item'][$result['drug_id']] = array(
                        'cdrr_item_id' => $result['cdrr_item_id'],
                        'balance' => $result['balance'], 
                        'received' => $result['received'], 
                        'dispensed_units' => $result['dispensed_units'], 
                        'dispensed_packs' => $result['dispensed_packs'], 
                        'losses' => $result['losses'], 
                        'adjustments' => $result['adjustments'], 
                        'adjustments_neg' => $result['adjustments_neg'], 
                        'count' => $result['count'], 
                        'expiry_quant' => $result['expiry_quant'], 
                        'expiry_date' => $result['expiry_date'], 
                        'out_of_stock' => $result['out_of_stock'], 
                        'resupply' => $result['resupply'], 
                        'aggr_consumed' => $result['aggr_consumed'], 
                        'aggr_on_hand' => $result['aggr_on_hand'], 
                        'publish' => $result['publish'], 
                        'drugamc' => $this->get_drug_amc($result['facility_id'], $result['period_begin'], $result['drug_id'], $result['code']),
                        'cdrr_id' => $result['cdrr_id'], 
                        'drug_id' => $result['drug_id'], 
                        'qty_allocated' => $result['qty_allocated'], 
                        'feedback' => $result['feedback']
                    );

                    $response['data']['cdrr_logs'] = $logs_table_data;

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

    public function get_drug_amc($facility_id, $period_begin, $drug_id, $code){
        $first = date('Y-m-01', strtotime($period_begin));
        $second = date('Y-m-01', strtotime($period_begin . "- 1 month"));
        $third = date('Y-m-01', strtotime($period_begin . "- 2 month"));
        $amc = 0;

        $sql = "SELECT 
                    ROUND(SUM(ci.dispensed_packs) / 3) as dispensed_packs,
                    ROUND(SUM(ci.aggr_consumed) / 3) as aggr_consumed
                FROM tbl_cdrr_item ci 
                INNER JOIN (
                    SELECT 
                        id, period_begin, code
                    FROM tbl_cdrr 
                    WHERE period_begin IN (?, ?, ?) 
                    AND facility_id = ?
                    AND code = ?
                    GROUP BY period_begin
                ) c ON ci.cdrr_id = c.id
                AND ci.drug_id = ?
                GROUP BY ci.drug_id";
        $query = $this -> db -> query($sql, array($first, $second, $third, $facility_id, $code, $drug_id));
        $results = $query -> result_array();
        if ($results) {
            foreach ($results as $result) {
                if ($code == "D-CDRR") {
                    $amc = $result['aggr_consumed'];
                } else {
                    $amc = $result['dispensed_packs'];
                }
                $amc = ($amc > 0) ? $amc : 0;
            }
        }
        return $amc;
    }

    public function get_maps_data($maps_id, $scope = null,$role = null){
        $conditions = array(
            "national" => "",
            "county" => " AND sc.county_id = '$scope'",
            "subcounty" => " AND f.subcounty_id = '$scope'"
        );
        
        $role_cond = $conditions[$role];

        $response = array();

        //Go back if no maps_id
        if(!$maps_id){
            return $response;
        }

        try{
            $sql = "SELECT mi.total, mi.regimen_id
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
                    $response['data'][$result['regimen_id']] = $result['total'];
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

    public function get_county_reporting_data($scope, $role, $period_begin, $period_end, $allocation = false) {
        $response = array('data' => array());
        try {
            $month_name = date('F Y', strtotime($period_begin));

            $allocation_url = ($allocation) ? "../../../view_allocation" : "view" ;

            $sql = "SELECT
                        UCASE(sc.name) subcounty,
                        f.mflcode,
                        UCASE(f.name) facility_name,
                        IF(t.period_begin IS NOT NULL, t.description, 'N/A') description,
                        IF(t.period_begin IS NOT NULL, UCASE(t.status), 'N/A') reporting_status,
                        ? period,
                        IF(t.period_begin IS NOT NULL, CONCAT('<a href=$allocation_url/',t.cdrr_id,'/',t.maps_id,'>View Order</a>'), 'Not Reported') options
                    FROM tbl_facility f
                    INNER JOIN tbl_subcounty sc ON sc.id = f.subcounty_id
                    LEFT JOIN
                    (
                        SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                        FROM tbl_cdrr c 
                        INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'D-CDRR' AND m.code = 'D-MAPS'
                        INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'central'
                        WHERE c.period_begin = ? AND c.period_end = ?
                        GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                        UNION
                        SELECT c.facility_id, c.period_begin, c.period_end, c.id cdrr_id, m.id maps_id, c.status, CONCAT_WS('/', c.code, m.code) description
                        FROM tbl_cdrr c 
                        INNER JOIN tbl_maps m ON m.facility_id = c.facility_id  AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.code = 'F-CDRR' AND m.code = 'F-MAPS'
                        INNER JOIN tbl_facility f ON f.id = c.facility_id AND f.id = m.facility_id AND f.category = 'standalone'
                        WHERE c.period_begin = ? AND c.period_end = ?
                        GROUP BY c.facility_id, c.period_begin, c.period_end, cdrr_id, maps_id, c.code
                    ) t ON t.facility_id = f.id
                    WHERE sc.county_id = ?
                    AND f.category != 'satellite'
                    GROUP BY f.mflcode
                    ORDER BY f.name ASC";
            $table_data = $this->db->query($sql, array($month_name, $period_begin, $period_end, $period_begin, $period_end, $scope))->result_array();

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

    public function get_satellite_cdrr($cdrr_id){
        $response = array('data' => array());
        try {
            $sql = "SELECT CONCAT_WS('<br/>[', f.name, CONCAT(f.mflcode, ']')) facility, ci.drug_id,  IF(ci.dispensed_packs IS NOT NULL, ci.dispensed_packs, 0) consumed, IF(ci.count IS NOT NULL, ci.count, 0) stock_on_hand
                    FROM tbl_cdrr c
                    INNER JOIN tbl_facility f ON f.id = c.facility_id
                    INNER JOIN tbl_cdrr_item ci ON ci.cdrr_id = c.id
                    WHERE (f.parent_id, c.period_begin, c.period_end) IN (
                        SELECT c.facility_id, c.period_begin, c.period_end
                        FROM tbl_cdrr c
                        WHERE c.id = ? )
                    AND c.code = 'F-CDRR'
                    GROUP BY f.name, ci.drug_id,  ci.dispensed_packs, ci.count
                    ORDER BY f.name";
            $table_data = $this->db->query($sql, array($cdrr_id))->result_array();
            if(!empty($table_data)){
                foreach ($table_data as $result) {
                    $response['data'][$result['facility']][$result['drug_id']]['consumed'] = $result['consumed'];
                    $response['data'][$result['facility']][$result['drug_id']]['stock_on_hand'] = $result['stock_on_hand'];
                }
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            }else{
                $response['message'] = 'Table is empty!';
                $response['status'] = FALSE;
            }
        } catch (Execption $e) {
            $response['status'] = FALSE;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function get_satellite_maps($maps_id){
        $response = array('data' => array());
        try {
            $sql = "SELECT CONCAT_WS('<br/>[', f.name, CONCAT(f.mflcode, ']')) facility, mi.regimen_id, IF(mi.total IS NOT NULL, mi.total, 0) patients
                    FROM tbl_maps m
                    INNER JOIN tbl_facility f ON f.id = m.facility_id
                    INNER JOIN tbl_maps_item mi ON mi.maps_id = m.id
                    WHERE (f.parent_id, m.period_begin, m.period_end) IN (
                        SELECT m.facility_id, m.period_begin, m.period_end
                        FROM tbl_maps m
                        WHERE m.id = ? )
                    AND m.code = 'F-MAPS'
                    GROUP BY f.name, mi.regimen_id,  mi.total
                    ORDER BY f.name";
            $table_data = $this->db->query($sql, array($maps_id))->result_array();
            if(!empty($table_data)){
                foreach ($table_data as $result) {
                    $response['data'][$result['facility']][$result['regimen_id']]['patients'] = $result['patients'];
                }
                $response['message'] = 'Table data was found!';
                $response['status'] = TRUE;
            }else{
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
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
    public function actionOrder($orderid,$mapid,$action,$user) {
        $response = array();
        try {
            $this->db->set('status', $action);
            $this->db->where('id', $orderid);

            if ($this->db->update('tbl_cdrr')){
                    $array = array(
                    'description' => $action,
                    'user_id' => $user,
                    'cdrr_id' => $orderid,
                    'created' => date('Y-m-d H:i:s')
                );
                $this->db->set($array);
                $this->db->insert('tbl_cdrr_log');


                // update maps
                $this->db->set('status', $action);
                $this->db->where('id', $mapid);
                if ($this->db->update('tbl_maps')){

                $maps_log = array(
                    'description' => $action,
                    'user_id' => $user,
                    'maps_id' => $mapid,
                    'created' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_maps_log',$maps_log);
                }               
                // update maps  -/>


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

    public function get_reporting_data($scope, $role, $period_begin, $period_end,$allocation = false) {
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
                $allocation_cond = ($allocation) ? "IF(c.period_begin IS NOT NULL, CONCAT('<a href=../../../view_allocation/',c.id,'/',m.id,'>View</a>'), 'Not Reported ' ) option" : "IF(c.period_begin IS NOT NULL, CONCAT('<a href=view/',c.id,'/',m.id,'>View</a>'), 'Not Reported ' ) option" ;

                $sql = "SELECT 
                f.mflcode,
                UCASE(f.name) facility_name,
                IF(c.period_begin IS NOT NULL, ?, ?) reporting_status,
                ? period,
                $allocation_cond
                FROM tbl_facility f  
                LEFT JOIN tbl_cdrr c ON c.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                LEFT JOIN tbl_maps m ON m.facility_id = f.id  AND c.period_begin = ? AND c.period_end = ?
                WHERE f.subcounty_id = ?
                AND f.category != 'satellite'
                GROUP BY f.mflcode
                ORDER BY f.name ASC";
                // var_dump($sql);die;
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
                CONCAT_WS('/', SUM(IF(c.status = 'approved', 1, 0)) , sb.total) approved,
                IF(SUM(IF(c.status = 'approved', 1, 0)) != sb.total, 'Incomplete', 'Complete') status,
                CONCAT('<a href=edit_allocation/', c.period_begin, '>View/Edit</a>')  option
                FROM tbl_cdrr c 
                INNER JOIN tbl_maps m ON c.facility_id = m.facility_id AND c.period_begin = m.period_begin AND c.period_end = m.period_end AND c.status IN('allocated', 'approved')
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
                IF(c.period_begin IS NULL, DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%M-%Y') ,DATE_FORMAT(c.period_begin, '%M-%Y')) period,
                IF(c.status IS NULL, 'Not Reported', c.status) reporting_status,
                IF(c.status = 'pending', CONCAT('<a href=allocate/', c.id,'/', m.id, '> Allocate</a>'), CONCAT('<a href=view_allocation/', c.id,'/', m.id, '>View Allocation</a>'))  option
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
            $currmonth = date('Ym');
            $sql = "SELECT                      
            UCASE(sc.name) subcounty,
            CONCAT_WS('/', SUM(IF(c.period_begin IS NOT NULL, 1, 0)), (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0)))) submitted,
            IF(SUM(IF(c.period_begin IS NOT NULL, 1, 0)) = (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0))), 'Allocated', 'Unallocated') allocation,
            'N/A' approval_status,
            IF(SUM(IF(c.period_begin IS NOT NULL, 1, 0)) = (SUM(IF(c.period_begin IS NOT NULL, 1, 0)) + SUM(IF(c.period_begin IS NULL, 1, 0))), CONCAT('<a href=view_allocate/', sc.id,'/', c.period_begin, '>View/Verify Allocation</a>'), CONCAT('<a href=','../allocation/subcounty/',sc.id,'/$currmonth','> Pending Allocation</a>')) option
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

    public function get_cdrr_data($cdrr_id,$scope = null,$role = null){

        $role_cond = ($role == 'subcounty') ? " AND sc.id = $scope" : " AND county_id = $scope";

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

            $logs_sql = "SELECT cl.description,cl.created,u.firstname,u.lastname,r.name as role
            FROM tbl_cdrr_log cl
            inner join tbl_user u  on cl.user_id = u.id
            inner join tbl_role r on u.role_id = r.id
            where cdrr_id =? order by cl.id asc";
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

                    $response['data']['cdrr_item'][$result['drug_name']] = array(
                        'cdrr_item_id' => $result['cdrr_item_id'],
                        'balance' => $result['balance'], 
                        'received' => $result['received'], 
                        'dispensed_units' => $result['dispensed_units'], 
                        'dispensed_packs' => $result['dispensed_packs'], 
                        'losses' => $result['losses'], 
                        'adjustments' => $result['adjustments'], 
                        'count' => $result['count'], 
                        'expiry_quant' => $result['expiry_quant'], 
                        'expiry_date' => $result['expiry_date'], 
                        'out_of_stock' => $result['out_of_stock'], 
                        'resupply' => $result['resupply'], 
                        'aggr_consumed' => $result['aggr_consumed'], 
                        'aggr_on_hand' => $result['aggr_on_hand'], 
                        'publish' => $result['publish'], 
                        'cdrr_id' => $result['cdrr_id'], 
                        'drug_id' => $result['drug_id'], 
                        'qty_allocated' => $result['qty_allocated'], 
                        'feedback' => $result['feedback'], 
                        'decision' => $result['decision']
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

    public function get_maps_data($maps_id,$scope = null,$role = null){
        $role_cond = ($role == 'subcounty') ? " AND f.subcounty_id = $scope" : " AND sc.county_id = $scope";

        $response = array();
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
}

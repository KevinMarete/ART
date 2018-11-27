<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Orders extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
        $this->load->library('email_sender');
    }
    
    function pdf() {
        $pdfBuilder = '';
        $columns = @$this->Orders_model->get_cdrr_data($this->uri->segment('4'), $this->session->userdata('scope'), $this->session->userdata('role'));
        $drugs = $this->Orders_model->get_drugs();

        $pdfBuilder .= '<style> 
                         table {table-layout: fixed;width:900px; padding:10px;}
                         table ,th, td{border:1px solid black; max-width:300px; border-collapse: collapse;}
                         th {text-align: left; background-color: #4CAF50;color: white; height: 50px;}
                         tr,td{height:20px;}
                         tr:nth-child(even) {background-color: #f2f2f2;}
                       </style>            
                        
                                <table style="border:1px solid black;" >
                                    <tbody>
                                        <tr>
                                            <td>
                                                <b>Facility Name: </b>
                                                <span class="facility_name">' . ucwords($columns["data"][0]["facility_name"]) . '</span>
                                            </td>
                                            
                                            <td>
                                                <b>Facility code: </b>
                                                <span class="mflcode">' . ucwords($columns["data"][0]["mflcode"]) . '</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>County: </b>
                                                <span class="county">' . ucwords($columns["data"][0]["county"]) . '</span>
                                            </td>
                                            <td>
                                                <b>Subcounty: </b>
                                                <span class="subcounty">' . ucwords($columns["data"][0]["subcounty"]) . '</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Period of Reporting: </b>
                                                <span>' . ucwords(date("F Y", strtotime($columns["data"][0]["period_begin"]))) . '</span>
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                         ';

        $pdfBuilder .= '<table style="margin-top:20px;" >
                                    <thead style="">
                                        <tr width="500px;">
                                            <th width="300px;">DRUG NAME</th>
                                          
                                            <th width="100px;" >RESUPPLY QTY</th>
                                         
                                        </tr>
                                        
                                    </thead>
                                    <tbody>';

        foreach ($drugs as $drug) {
            $drugid = $drug['id'];

            if (in_array($drugid, array_keys($columns['data']['cdrr_item']))) {

                $pdfBuilder .= '<tr>
                                                    <td  width="300px">' . $drug["name"] . '</td>
                                                 
                                                    <td style="text-align:right; font-weight:bold;">' . $columns["data"]["cdrr_item"][$drugid]["resupply"] . '</td>
                                                    
                                                </tr>';
            }
        }

        $pdfBuilder .= '</tbody>
                                </table>
                              <span style="page-break-after:always;"></span>';


        // echo $pdfBuilder;
        // echo htmlspecialchars($pdfBuilder);
        //  exit;


        $dompdf = new Dompdf;
        // Load HTML content
        $dompdf->loadHtml($pdfBuilder);
        $dompdf->set_option('isHtml5ParserEnabled', true);
// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream();
    }

    function sendMail($message, $action) {
        $act = ucfirst($action);
        $role = $this->session->userdata('role');
        $requester = $this->session->userdata('email_address');
        $facility = $this->session->userdata('facility_name');
        $county = $this->session->userdata('county_pharm');
        if ($role == 'subcounty') {
            $get_pharmacist = $this->db->where('scope', $county)->get('vw_county_pharmacists')->result();
            $pharmacist = $get_pharmacist[0]->pharmacist;
            $approver = $get_pharmacist[0]->email_address;
            $final_string = '<p>Hello ' . $pharmacist . ',<br>' . $message . ' <strong>' . $facility . '</strong> | <a href="http://commodities.nascop.org/manager" target="_blank">Login Here</a></p>';
            $this->email_sender->sendEmail('ART Allocation Order ' . $act . ' - ' . $facility, 'Allocation Order', $requester, $approver, $final_string);
        } else if ($role == 'county') {
            $cdrr_id = $this->uri->segment(4);
            $get_pharmacist_user = $this->db->query("SELECT user_id FROM tbl_cdrr_log WHERE description='allocated' AND cdrr_id='$cdrr_id';")->result();
            $user_id = $get_pharmacist_user[0]->user_id;
            $get_pharm_details = $this->db->query("SELECT CONCAT_WS(' ',firstname,lastname) pharmacist,email_address FROM tbl_user WHERE id='$user_id';")->result();
            $pharmacist = $get_pharm_details[0]->pharmacist;
            $approver = $get_pharm_details[0]->email_address;
            $final_string = '<p>Hello ' . $pharmacist . ',<br>' . $message . ' | <a href="http://commodities.nascop.org/manager" target="_blank">Login Here</a></p>';
            $this->email_sender->sendEmail('ART Allocation Order ' . $act . ' - ' . $facility, 'Allocation Order', $requester, $approver, $final_string);
        } elseif ($role == 'nascop') {
            $cdrr_id = $this->uri->segment(4);
            $get_pharmacist_user = $this->db->query("SELECT CONCAT_WS(' ',firstname,lastname) pharmacist,email_address FROM tbl_user WHERE id IN(SELECT user_id FROM tbl_cdrr_log WHERE description IN('allocated','approved') AND cdrr_id='$cdrr_id')")->result();
            $approver = $get_pharmacist_user[0]->email_address . ',' . $get_pharmacist_user[1]->email_address;
            $final_string = '<p>Hello All ,<br>' . $message . ' | <a href="http://commodities.nascop.org/manager" target="_blank">Login Here</a></p>';
            $this->email_sender->sendEmail('ART Allocation Order ' . $act . ' - ' . $facility, 'Allocation Order', $requester, $approver, $final_string);
        }
    }

    function send_allocation_request() {
        $requester = $this->session->userdata('email_address');
        $approver = $this->config->item($this->session->userdata('county_pharm'));
        $facility = $this->session->userdata('facility_name');
        $final_string = '<p>Hello Sir/Madam,<br>You have a new allocation request order from <strong>' . $facility . '<strong></p>';
        $this->email_sender->send_allocation_request('ART Orders', 'Allocation', $requester, $approver, $final_string);
    }

    function get_drug() {
        $drug = $this->input->post('drug');
        echo json_encode($this->db->query("SELECT d.id, UPPER(CONCAT(g.name,' ',g.abbreviation, d.strength,' - ',f.name)) name ,d.min_qty_alloc,d.max_qty_alloc 
                    FROM tbl_drug d 
                    LEFT JOIN tbl_generic g ON g.id = d.generic_id 
                    LEFT JOIN tbl_formulation f ON d.formulation_id = f.id
                    WHERE d.id='$drug'")->result());
    }

    public function updateOrder($orderid, $mapid) {
        $updateArray = array();
        foreach ($_POST as $key => $value) {
            $vals = array(explode('-', $key)[0] => $value, 'id' => explode('-', $key)[1] + 0);
            array_push($updateArray, $vals);
        }
        $response = $this->Orders_model->updateOrder($orderid, $mapid, $updateArray, $this->session->userdata('id'));
        echo $response['message'];
    }

    public function actionOrder($orderid, $mapid, $action) {
        $message = 'You have a new allocation order request from';
        if ($action == 'rejected') {
            $rejection_reason = $this->input->post('reason');
            $message = 'Allocation order request has been rejected, reason being that '.$rejection_reason;
        } elseif ($action == 'approved') {
            $message = 'Allocation order has been approved and forwarded to Order Review Management Team at NASCOP';
        } elseif ($action == 'reviewed') {
            $message = 'Allocation order has been reviewed. Preparation for order fulfillment is underway.';
        }
        $response = $this->Orders_model->actionOrder($orderid, $mapid, $action, $this->session->userdata('id'));
        $this->sendMail($message, $action);
        echo $response['message'];
    }

    public function get_orders($subcounty = '') {
        $response = $this->Orders_model->get_order_data($this->session->userdata('scope'), $this->session->userdata('role'), $subcounty);
        echo json_encode(array('data' => $response['data']));
    }

    public function get_reporting_rates($role = null, $scope = null, $allocation = null) {
        $role = ($role) ? $role : $this->session->userdata('role');
        $scope = ($scope) ? $scope : $this->session->userdata('scope');
        $allocation = ($allocation) ? TRUE : FALSE;
        $response = $this->Orders_model->get_reporting_data($scope, $role, date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')), $allocation);
        echo json_encode(array('data' => $response['data']));
    }

    public function get_allocation() {
        $response = $this->Orders_model->get_allocation_data($this->session->userdata('scope'), $this->session->userdata('role'), date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')));
        echo json_encode(array('data' => $response['data']));
    }

    public function get_county_allocation($period_begin) {
        $response = $this->Orders_model->get_county_allocation_data($this->session->userdata('scope'), $this->session->userdata('role'), $period_begin, date('Y-m-t', strtotime($period_begin)));
        echo json_encode(array('data' => $response['data']));
    }

    public function get_county_reporting_rates($role = null, $scope = null, $allocation = null) {
        $role = ($role) ? $role : $this->session->userdata('role');
        $scope = ($scope) ? $scope : $this->session->userdata('scope');
        $allocation = ($allocation) ? TRUE : FALSE;
        $response = $this->Orders_model->get_county_reporting_data($scope, $role, date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')), $allocation);
        echo json_encode(array('data' => $response['data']));
    }

    function getMOS() {
        $amc_array = array();
        $cat = '';
        $fil = '';
        $amc = '';
        $amcfunction = 'fn_get_national_dyn_amc';
        $year = $this->input->post('data_year');
        $month = $this->input->post('data_month');
        $scope_name = $this->session->userdata('scope_name');
        $role = $this->session->userdata('role');
        if ($role == 'subcounty') {
            $query = "$role = '$scope_name'";
            $fil = $scope_name;
            $amc = "," . "'$scope_name'";
            $amcfunction = 'fn_get_subcounty_amc';
        } else if ($role == 'county') {
            $query = "$role = '$scope_name'";
            $fil = $scope_name;
            $amc = "," . "'$scope_name'";
            $amcfunction = 'fn_get_county_amc';
        }
        $sub_res = $this->Orders_model->getCalcMOS($year, $month, $query);

        foreach ($sub_res as $key => $res) {
            $date = $res['data_date'];
            $drug_id = $res['drug_id'];
            $no_of_mos = 3;
            $query2 = $this->db->query("SELECT  $amcfunction($drug_id,$no_of_mos,'$date'$amc) amc")->result_array();
            array_push($amc_array, $query2[0]['amc']);
        }

        $newarr = array_map(function($drugs, $amc) {
            $mapped_val = 0;
            $res = round($drugs['balance'] / $amc, 0);
            if (is_nan($res)) {
                $mapped_val = 0;
            } else if (is_infinite($res)) {
                $mapped_val = 0;
            } else {
                $mapped_val = (int) $res;
            }
            return $mapped_val;
        }, $sub_res, $amc_array);

        foreach ($sub_res as $key => $res) {
            $sub_res[$key] = array_merge($res, ['dmos' => $newarr[$key]]);
        }

        $high = $sub_res;
        $low = $sub_res;
        foreach ($high as $i => $v) {
            if ($v['dmos'] < 6) {
                unset($high[$i]);
            }
        }

        foreach ($low as $i => $v) {
            if ($v['dmos'] > 2) {
                unset($low[$i]);
            }
        }
        // print_r($sub_res);
        echo json_encode(['high' => array_values($high), 'low' => array_values($low)]);
    }

    function getHighMos() {
        $this->Orders_model->getHighMos();
    }

    function getLowMosFacilities() {
        $this->Orders_model->getLowMosFacilities();
    }

    function getFacilitiesMOS() {
        $this->Orders_model->getFacilitiesMOS();
    }

}

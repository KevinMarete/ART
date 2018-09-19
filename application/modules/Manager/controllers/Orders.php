<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries\dompdf\autoload.inc.php';

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

    function send_allocation_request() {
        $requester = $this->session->userdata('email_address');
        $approver = $this->config->item($this->session->userdata('county_pharm'));
        $facility = $this->session->userdata('facility_name');
        $final_string = '<p>Hello Sir/Madam,<br>You have a new allocation request order from "' . $facility . '"</p>';
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
        $this->send_allocation_request();
        $response = $this->Orders_model->actionOrder($orderid, $mapid, $action, $this->session->userdata('id'));
        echo $response['message'];
    }

    public function get_orders($subcounty='') {
        $response = $this->Orders_model->get_order_data($this->session->userdata('scope'), $this->session->userdata('role'),$subcounty);
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

}

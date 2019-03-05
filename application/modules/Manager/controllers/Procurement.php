<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Procurement extends MX_Controller {

    public $email;

    public function __construct() {
        parent::__construct();
        $this->load->model('Procurement_model');
        $this->email = new Email_sender;
    }

    function look() {
        echo (int) 01;
    }
    
    //

    function usm() {
//Server url
        $period = date('Ymd', strtotime('first day of previous month'));
        $workingMonth = date('M');
        $workingYear = date('Y');
        $this->db->query("UPDATE tbl_procurement p SET kemsa_code = (SELECT kemsa_code FROM tbl_drug  WHERE id = p.drug_id)");

        $url = "https://api.kemsa.co.ke/p_productmovements?filter[where][lmis_tool_id]=1000000&filter[where][startdate]=20180101";
        //$url = "https://api.kemsa.co.ke/p_productmovements?filter[where][lmis_tool_id]=1000000&filter[where][startdate]=$period";
        $apiKey = '$2y$10$S0JuZi5EAxAsuMaV2r4Nh.1HyC.nIfSW9Pnf1UPkPsapni6Vv/xLC'; // should match with Server key
        $headers = array(
            'apitoken:' . $apiKey
        );
// Send request to Server
        $ch = curl_init($url);
// To save response in a variable from server, set headers;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Get response
        $response = curl_exec($ch);
// Decode
        $result = json_decode($response);
        for ($i = 0; $i < count($result); $i++) {
            $update_data = [
                'open_kemsa' => $result[$i]->openingbal,
                'receipts_kemsa' => $result[$i]->receipts,
                'issues_kemsa' => $result[$i]->issues,
                'close_kemsa' => $result[$i]->stocks,
                'monthly_consumption' => $result[$i]->consumption,
                'adj_losses' => $result[$i]->adjustments
            ];
            $this->db
                    ->where('kemsa_code', $result[$i]->value)
                    ->where('transaction_year', $workingYear)
                    ->where('transaction_month', 'Jan')
                    ->update('tbl_procurement', $update_data);
        }

        echo 'Stock Movement ';
    }

    function stockMovement() {
//Server url
        $period = date('Ymd', strtotime('first day of previous month'));
        $workingMonth = date('M');
        $workingYear = date('Y');

        $this->db->query("UPDATE tbl_procurement p SET kemsa_code = (SELECT kemsa_code FROM tbl_drug  WHERE id = p.drug_id)");

        $url = "https://api.kemsa.co.ke/p_productmovements?filter[where][lmis_tool_id]=1000000&filter[where][startdate]=$period";
        $apiKey = '$2y$10$S0JuZi5EAxAsuMaV2r4Nh.1HyC.nIfSW9Pnf1UPkPsapni6Vv/xLC'; // should match with Server key
        $headers = array(
            'apitoken:' . $apiKey
        );
// Send request to Server
        $ch = curl_init($url);
// To save response in a variable from server, set headers;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Get response
        $response = curl_exec($ch);
// Decode
        $result = json_decode($response);
        echo '<pre>';
        print_r($result);
        echo '</pre>';

        echo 'Stock Movement ';
    }

    function Reminder() {
        $this->sendReminder();
    }

    function getAllDrugs() {
        $query = "SELECT * FROM `vw_drug_list` ORDER BY name ASC";
        $this->response($this->db->query($query)->result());
    }

    function getDrugsByName() {
        $drug_name = $this->input->post('phrase');
        $query = "SELECT * FROM `vw_drug_list` WHERE name LIKE '%$drug_name%'  ORDER BY name ASC";
        echo json_encode($this->db->query($query)->result());
    }

    function getDecision($id) {
        $query = $this->db->query("SELECT id,discussion,recommendation,DATE_FORMAT(decision_date,'%W %D %b, %Y') decision_date FROM `tbl_decision`  WHERE drug_id ='$id' ORDER BY id DESC LIMIT 1")->result();
        $this->response($query);
    }

    function loadMinute($id) {
        $query = $this->db->query("SELECT * FROM tbl_minutes WHERE meeting_id ='$id'")->result();
        $this->response($query);
    }

    function saveEvent() {
        $title = $this->input->post('title');
        $venue = $this->input->post('venue');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $this->db->insert('tbl_meetings', [
            'title' => $title,
            'start_event' => $start,
            'end_event' => $end,
            'venue' => $venue
        ]);
    }

    function FilterAvg() {
        $from = $this->input->post('from');
        $from_ = str_replace("-", '', $from);
        $to = $this->input->post('to');
        $to_ = str_replace("-", '', $to);
        $drug = $this->input->post('drug');
        $drugs = "'" . implode("', '", $drug) . "'";


        $query = $this->db->query("SELECT drug,FORMAT(SUM(issues)/PERIOD_DIFF($to_,$from_),0) issues,FORMAT(SUM(consumption)/PERIOD_DIFF($to_,$from_),0) consumption 
                                FROM vw_procurement_list
                                WHERE data_date BETWEEN '$from-01' AND '$to-01'
                                AND drug IN ($drugs)
                                GROUP BY drug")->result();
        $this->response($query);
    }

    function postDiscussions() {
        $meeting_id = $this->input->post('mid');
        $discussion = $this->input->post('disc');
        $recommendation = $this->input->post('rec');
        $meeting_date = $this->input->post('mdt');
        $new_date = explode("/", $meeting_date);
        $drug_id = $this->input->post('drug_id');

        $resp['response'] = '';
        if ($this->checkPostData($drug_id, $meeting_id) > 0) {
            $dis_id = $this->db->where('drug_id', $drug_id)->where('meeting_id', $meeting_id)->get('tbl_decision')->result();
            $this->db->where('drug_id', $drug_id)->where('meeting_id', $meeting_id)->update('tbl_decision', [
                'discussion' => $discussion,
                'recommendation' => $recommendation
            ]);

            $this->db->insert('tbl_decision_log', [
                'description' => 'Updated',
                'created' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('id'),
                'decision_id' => $dis_id[0]->id,
            ]);
            $resp['response'] = 0;
        } else {
            $this->db->insert('tbl_decision', [
                'meeting_id' => $meeting_id,
                'discussion' => $discussion,
                'recommendation' => $recommendation,
                'decision_date' => $new_date[2] . '-' . $new_date[1] . '-' . $new_date[0],
                'drug_id' => $drug_id,
            ]);
            $last_id = $this->db->insert_id();

            $this->db->insert('tbl_decision_log', [
                'description' => 'Created',
                'created' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('id'),
                'decision_id' => $last_id,
            ]);
            $resp['response'] = 1;
        }
        $this->response($resp['response']);
    }

    function checkPostData($did, $mid) {
        $email = $this->db->where('meeting_id', $mid)->where('drug_id', $did)->get('tbl_decision')->result();
        return count($email);
    }

    function loadEvents() {
        $load = $this->db->get('tbl_meetings')->result();
        foreach ($load as $row) {
            $data[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'start' => $row->start_event,
                'end' => $row->end_event,
                'venue' => $row->venue
            );
        }
        $this->response($data);
    }

    function updateEvent($id) {
        $this->db->where('id', $id)->update('tbl_meetings', ['venue' => $this->input->post('venue')]);
    }

    function minuteAdd($id) {
        $resp['response'] = '';
        if ($this->checkMinute($id) > 0) {
            $resp['response'] = 0;
        } else {
            $this->db->insert('tbl_minutes', [
                'meeting_id' => $id
            ]);
            $resp['response'] = 1;
        }
        $this->response($resp['response']);
    }

    function checkMinute($param) {
        $email = $this->db->where('meeting_id', $param)->get('tbl_minutes')->result();
        return count($email);
    }

    function lookForMeeting($id) {
        $resp = $this->db->where('meeting_id', $id)->get('tbl_minutes')->result();
        $count = ['count' => count($resp)];
        $this->response($count);
    }

    function loadMeetingDate($id) {
        $date = $this->db->query("SELECT DATE_FORMAT(start_event,'%d/%m/%Y') meeting_date FROM tbl_meetings WHERE id='$id'")->result();
        $this->response($date);
    }

    function loadMonthYear($id) {
        $date = $this->db->query("SELECT DATE_FORMAT(start_event,'%m-%Y') meeting_date FROM tbl_meetings WHERE id='$id'")->result();
        $this->response($date);
    }

    function updateMinutes($id) {
        header("Cache-Control: no-cache,no-store");
        $start = $this->input->post('start');
        $aob = $this->input->post('aob');
        $minute = htmlentities($this->input->post('minute'));
        $this->db->where('meeting_id', $id)->update('tbl_minutes', ['minute' => trim($minute), 'start' => trim(strip_tags($start)), 'aob' => trim(strip_tags($aob))]);
        $this->response(['status' => 'success']);
    }

    function getCounty() {
        $toplevel = $this->db->get('tbl_county')->result();
        echo json_encode(['data' => $toplevel]);
    }

    function generateMinute($id) {
        $data['minutes'] = $this->db->where('meeting_id', $id)->get('tbl_minutes')->result();
        $minutes = $this->db->where('id', $id)->get('tbl_meetings')->result();
        $file_date = date('dS_M_Y', strtotime($minutes[0]->start_event));
        $mail_title = date('F-Y', strtotime($minutes[0]->start_event));
        $filename = 'MINUTES_OF_PROCUREMENT_PLANNING_MEETING-' . strtoupper($file_date) . '.pdf';

        $page_builder = $this->load->view('pages/public/pdf_view', $data, true);
        $dompdf = new Dompdf;
        // Load HTML content
        $dompdf->loadHtml($page_builder);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        // $dompdf->stream();
        $output = $dompdf->output();
        unlink('public/minutes_pdf/' . $filename);
        file_put_contents('public/minutes_pdf/' . $filename, $output);
        $this->sendPlanningEmail($filename, $mail_title);
    }

    function sendPlanningEmail($filename, $mail_title) {

        $list = '';
        $mailing_list = $this->db->where('email_type', '1')->get('tbl_mailing_list')->result();
        foreach ($mailing_list as $m) {
            $list .= $m->email . ',';
        }
        $mailinglist = rtrim($list, ",");
        $this->email->sendProcurementEmail($mailinglist, $filename, $mail_title);
    }

    function loadMinutes($id) {
        $tr = '<tr>
                    <td width="193">
                        <p><strong>Product</strong></p>
                    </td>
                    <td width="358">
                        <p><strong>Discussion</strong></p>
                    </td>
                    <td width="350">
                        <p><strong>Recommendations</strong></p>
                    </td>
               </tr>';
        $categories = $this->db->query("SELECT dl.drug_category FROM tbl_decision d
                                        LEFT JOIN vw_drug_list dl ON dl.id = d.drug_id
                                        WHERE d.meeting_id='$id' GROUP BY dl.drug_category")->result();

        foreach ($categories as $cat):
            $category = $cat->drug_category;
            $tr .= '<tr  style="background:#fbd4b4;"><td colspan="3" width="901"><p><strong>' . $category . '</strong></p></td></tr>';
            $minutes = $this->db->query("SELECT d.*,dl.drug_category,dl.name drug FROM tbl_decision d
                                LEFT JOIN vw_drug_list dl ON dl.id = d.drug_id
                                WHERE d.meeting_id='$id' 
                                AND dl.drug_category='$category'")->result();
            foreach ($minutes as $min):
                $tr .= '<tr>
                    <td width="193">
                        <p>' . $min->drug . '</p>
                    </td>
                    <td width="358">'
                        . $min->discussion .
                        '</td>
                    <td width="350">'
                        . $min->recommendation .
                        '</td>
                </tr>';
            endforeach;
        endforeach;
        echo $tr;
    }

    function loadMenuData($column, $criteria = '') {
        $id = $this->input->post('id');
        if (empty($criteria)) {
            $res = $this->db->select($column)->group_by($column)->get('vw_csf_list')->result();
        } else {
            $res = $this->db->select($column)->where($criteria, $id)->group_by($column)->order_by($column, 'asc')->get('vw_csf_list')->result();
        }
        echo json_encode(['data' => $res]);
    }

    function getSubLevelMenus($table, $pcol, $id) {
        $res = $this->db->where($pcol, $id)->order_by('name', 'asc')->get($table)->result();
        echo json_encode(['data' => $res]);
    }

    function saveMeetingData() {
        $id = $this->input->post('drug_id');
        $did = $this->input->post('decision_id');
        $category = $this->input->post('drug_category');
        $discussion = $this->input->post('decision');
        $reccommendation = $this->input->post('recommendation');

        $cat = $category[0];
        $date = date('Y-m-d');

        if ($this->checkDecisionSave($cat, $date) > 0) {
            echo 1;

            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('drug_id', $id[$i])->where('decision_date', $date)->update('tbl_decision', [
                    'discussion' => $discussion[$i],
                    'recommendation' => $reccommendation[$i],
                ]);

                $this->db->insert('tbl_decision_log', [
                    'description' => 'Updated',
                    'user_id' => $this->session->userdata('id'),
                    'decision_id' => $did[$i]
                ]);
            }
            $this->updateSysLogs('Updated  (tbl_decision - Meeting Minute  > Discussion and Reccommendations  )');
        } else {
            echo 2;

            for ($i = 0; $i < count($discussion); $i++) {
                $this->db->insert('tbl_decision', [
                    'discussion' => $discussion[$i],
                    'recommendation' => $reccommendation[$i],
                    'decision_date' => date('Y-m-d'),
                    'drug_id' => $id[$i],
                    'drug_category' => $category[$i]
                ]);

                $decision = $this->db->insert_id();

                $this->db->insert('tbl_decision_log', [
                    'description' => 'Created',
                    'user_id' => $this->session->userdata('id'),
                    'decision_id' => $decision
                ]);
            }
            $this->db->where('discussion=', '')->delete('tbl_decision');
            $this->updateSysLogs('Created  (tbl_decision - Meeting Minute  > Discussion and Reccommendations  )');
        }
        echo json_encode(['status' => true]);
    }

    function checkDecisionSave($cat, $date) {
        return $this->db->where('drug_category', $cat)->where('decision_date', $date)->get('tbl_decision')->num_rows();
    }

    function loadLastMinutes() {
        $query = $this->db->query("SELECT *,DATE_FORMAT(meeting_date,'%W %D %b, %Y') minute_date FROM tbl_meeting ORDER BY id DESC ")->result();
        echo json_encode($query);
    }

    function loadLastMinutesHF() {
        $query = $this->db->query("SELECT *,DATE_FORMAT(date,'%W %D %b, %Y') minute_date FROM tbl_minutes ORDER BY id DESC ")->result();
        echo json_encode($query);
    }

    function loadLastMinutesBody($id) {
        echo json_encode($this->db->where('id', $id)->get('tbl_minutes')->result());
    }

    public function getMinutesData() {
        $cat = $this->input->post('category');
        $date = $this->input->post('date');
        $url = 'manager/procurement/minute/' . $cat . '/' . $date;
        $this->session->set_userdata('minute', $url);
        $sql = "SELECT d.*, de.discussion,de.recommendation,de.decision_date,de.id decision_id
                        FROM `vw_drug_list` d
                        LEFT JOIN tbl_decision de ON d.id = de.drug_id
                        WHERE de.decision_date = '$date'
                        AND d.drug_category='$cat'          

                        UNION ALL 

                        SELECT d.*, de.discussion,de.recommendation,de.decision_date,de.id decision_id
                        FROM `vw_drug_list` d
                        LEFT JOIN tbl_decision de ON d.id = de.drug_id
                        WHERE de.decision_date IS NULL
                         AND d.drug_category='$cat' ";
        $table_data = $this->db->query($sql)->result_array();

        $table = '<table   width="100%" class="table table-bordered table-hover"  id="minutesTable">';
        $table .= '<thead><tr><th>COMMODITY </th><th>PACK-SIZE</th><th>DISCUSSION</th><th>RECOMMENDATION</th><th>TRACKER</th></tr></thead>';
        $table .= '<tbody>';
        $i = 0;
        foreach ($table_data as $d) {
            $table .= '<tr>';
            $table .= '<td><input type="hidden" name=decision_id[] value=' . $d['decision_id'] . '><input type="hidden" name=drug_id[] value=' . $d['id'] . '><strong>' . strtoupper($d['name']) . '</strong></td><td>' . $d['pack_size'] . '</td><td><textarea class="textarea" name=decision[] >' . $d['discussion'] . '</textarea></td><td><textarea class="textarea" name=recommendation[]>' . $d['recommendation'] . '</textarea></td><td> 
                           <a class="btn btn-xs btn-primary tracker_drug" data-toggle="modal" data-target="#add_procurement_modal" data-drug_id="' . $d['id'] . '"> 
                            <i class="fa fa-search"></i> View Options
                        </a>
                        <input type="hidden" name=drug_category[] value=' . $d['drug_category'] . '>
                        </td>';
            $table .= '</tr>';

            $i++;
        }
        $table .= '</tbody>'
                . '</table>';

        echo $table;
    }

    function save_minutes() {
        $title = $this->input->post('title');
        $raw_present_names = $this->input->post('present_names');
        $raw_present_emails = $this->input->post('present_emails');
        $raw_absent_names = $this->input->post('absent_names');
        $raw_absent_email = $this->input->post('absent_emails');

        $present_names = $this->sanitize($raw_present_names);
        $present_emails = $this->sanitize($raw_present_emails);
        $absent_names = $this->sanitize($raw_absent_names);
        $absent_email = $this->sanitize($raw_absent_email);
        $opening_description = $this->input->post('opening_description');
        $aob = $this->input->post('aob');

        if ($this->checkMinuteSave(date('Y-m')) > 0) {
            $this->db->query("SET foreign_key_checks = 0");
            echo 'Update';
            $this->db->like('date', date('Y-m'), 'both')->update('tbl_minutes', [
                'title' => $title,
                'present_names' => $present_names,
                'present_emails' => $present_emails,
                'absent_names' => $absent_names,
                'absent_emails' => $absent_email,
                'opening_description' => $opening_description,
                'aob' => $aob,
            ]);
            // echo $this->db->last_query();
            $this->updateSysLogs('Updated  (tbl_minutes - Meeting Minute  > Minute Agenda & A.O.Bs)');
        } else {
            $this->db->query("SET foreign_key_checks = 0");
            echo 'Inserted';
            $this->db->insert('tbl_minutes', [
                'title' => $title,
                'present_names' => $present_names,
                'present_emails' => $present_emails,
                'absent_names' => $absent_names,
                'absent_emails' => $absent_email,
                'opening_description' => $opening_description,
                'aob' => $aob,
            ]);
            $this->updateSysLogs('Created  (tbl_minutes - Meeting Minute  > Minute Agenda & A.O.Bs)');
        }
    }

    function checkMinuteSave($date) {
        return $this->db->like('date', $date, 'both')->get('tbl_minutes')->num_rows();
    }

    function sanitize($array) {
        $final_string = '';
        foreach ($array as $s) {
            $final_string .= $s . ",";
        }
        return rtrim($final_string, ',');
    }

    public function get_test_email() {

        $date = date('Y') . "-" . sprintf("%02d", date('m') - 0);
        $minutes = $this->db->query("SELECT * FROM tbl_minutes WHERE date LIKE '%$date%'")->result();
        $recepients = $minutes[0]->present_emails . ',' . $minutes[0]->absent_emails;

        //$date = date('Y') . "-" . sprintf("%02d", date('m') - 1);
        $drug_ids = "SELECT GROUP_CONCAT(id) id FROM `tbl_decision`";
        $table_ids = $this->db->query($drug_ids)->result_array();
        $drugids_ = $table_ids[0]["id"];
        $sql = "SELECT * FROM vw_drug_list  ORDER BY name ASC";
        $table_data = $this->db->query($sql)->result_array();

        $sql2 = "SELECT 
                        d.id,
                        d.decision_date,
                        d.discussion,
                        d.recommendation,
                        d.drug_id,
                        t.created,
                        CONCAT_WS(' ', u.firstname, u.lastname) user
                    FROM tbl_decision d 
                    INNER JOIN (
                        SELECT *
                        FROM tbl_decision_log l
                        WHERE (l.created, l.decision_id) IN
                        (SELECT MAX(created), decision_id
                        FROM tbl_decision_log 
                        GROUP BY decision_id)
                    ) t ON t.decision_id = d.id
                    INNER JOIN tbl_user u ON u.id = t.user_id 
                    WHERE d.decision_date LIKE '%$date%'                        
                    AND d.deleted = '0'                    
                    ORDER BY d.decision_date DESC";
        $items = $this->db->query($sql2)->result_array();


        foreach ($table_data as &$mt) {
            foreach ($items as $it) {
                if ($it['drug_id'] == $mt['id']) {
                    if (!isset($mt['decisions'])) {
                        $mt['decisions'] = [];
                    }
                    $mt['decisions'][] = $it;
                }
            }
        }
        $present = explode(",", $minutes[0]->present_names);
        $absent = explode(",", $minutes[0]->absent_names);
        $final_string = '<div class="row">
                <p><strong>' . $minutes[0]->title . '</strong></p>
            </div>
            <p><strong>Members Present</strong></p>
            <p></p>
            <ol id="membersPresent">';
        foreach ($present as $p) {
            $final_string .= '<li>' . $p . '</li>';
        }
        $final_string .= '</ol>

            <p><strong>Absent with Apology</strong></p>
            <p></p>
            <ol id="membersAbsent">';
        foreach ($absent as $a) {
            $final_string .= '<li>' . $a . '</li>';
        }
        $final_string .= '</ol>

            <div class="row" style="margin-top:20px;">
               
                <p>' . $minutes[0]->opening_description . '</p>
            </div>';
        $final_string .= '<div class="row" style="margin-top:20px;">
                <p><strong>MINUTE 2: STOCK STATUS PER PRODUCT AND REQUIRED DELIVERIES AND NEW PROCUREMENTS</strong></p>
            </div> ';

        $final_string .= '<table style="border:1px solid black; margin-top:10px;"><tr><th><strong>Product</strong></th><th><strong>Discussion</strong></th><th><strong>Recommendations</strong></th></tr>';
        $final_string .= '<tr colspan="3" style="background:#FBD4B4;border:1px solid black;"><td colspan="3"><strong>Antiretroviral Therapy</strong></td></tr>';

        foreach ($table_data as $d) {
            $final_string .= '<tr style="border:1px solid black;">';
            if (isset($d['decisions'])) {
                $final_string .= '<td style="border:1px solid black;">' . $d['name'] . '</td>';
            } else {
                
            }
            if (isset($d['decisions'])) {
                foreach ($d['decisions'] as $e) {
                    $final_string .= '<td style="border:1px solid black;">' . $e['discussion'] . '</td><td style="border:1px solid black;">' . $e['recommendation'] . '</td>';
                }
            } else {
                
            }
            $final_string .= '</tr>';
        }
        $final_string .= '</table>';

        $final_string .= '
            <p style="margin-top:20px;"><strong>A.O.B</strong></p>
            <div class="row" style="margin-top:10px;">
                <p>' . $minutes[0]->aob . '</p>
            </div> ';
        $this->email_sender->send_email('Procurement', 'Meeting Minutes', $recepients, $names = '', $final_string);
        echo json_encode(['status' => 'success']);
    }

    public function get_commodities() {
        $response = $this->Procurement_model->get_commodity_data();
        echo json_encode(array('data' => $response['data']));
    }

    public function get_tracker($drug_id) {
        $response = $this->Procurement_model->get_tracker_data($drug_id);
        echo json_encode(array('data' => $response['data']));
    }

    function get_transaction_data() {
        $drug_id = $this->input->post('drug_id');
        $data = $this->input->post('data');
        $reporting_months = [];

        foreach ($data[0] as $index => $str) {
            if ($index > 1) {
                $str_arr = explode(' ', $str);
                $year = $str_arr[1];
                $month = $str_arr[0];
                array_push($reporting_months, $month);
            }
        }

        $open_kemsa = $data[1];
        $receipts_kemsa = $data[2];
        $issues_kemsa = $data[3];
        $close_kemsa = $data[4];
        $monthly_consumption = $data[5];

        for ($i = 0; $i < count($reporting_months); $i++) {

            $inner_count = 2;
            $j = $i + $inner_count;

            $update_data = [
                'open_kemsa' => $open_kemsa[$j],
                'receipts_kemsa' => $receipts_kemsa[$j],
                'issues_kemsa' => $issues_kemsa[$j],
                'close_kemsa' => $close_kemsa[$j],
                'monthly_consumption' => $monthly_consumption[$j],
            ];
            $this->db
                    ->where('transaction_year', $year)
                    ->where('transaction_month', $reporting_months[$i])
                    ->where('drug_id', $drug_id)
                    ->update('tbl_procurement', $update_data);
        }

        $this->db->insert('tbl_procurement_log', [
            'description' => 'updated',
            'user_id' => $this->session->userdata('id'),
            'procurement_id' => 1
        ]);
        $this->updateSysLogs('Updated  (Product Tracker Updated)');
        echo 'Data updated Successfully';
    }

    public function save_tracker() {
        $drug_id = $this->input->post('drug_id');
        $receipts = $this->input->post('receipt_qty');
        $transaction_date = $this->input->post('transaction_date');
        $status = $this->input->post('status');
        $funding_agent = $this->input->post('funding_agent');
        $supplier = $this->input->post('supplier');
        $this->db->query("SET foreign_key_checks = 0");
        foreach ($receipts as $key => $qty) {
            $query = $this->db->query("CALL proc_save_tracker(?, ?, ? ,?, ?, ?, ?, ?)", array(
                date('Y', strtotime($transaction_date[$key])), date('M', strtotime($transaction_date[$key])), $drug_id, $qty, $funding_agent[$key], $supplier[$key], $status[$key], $this->session->userdata('id')
            ));
        }


        $message = '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> Procurement was Added</div>';
        $this->updateSysLogs('Updated  (Tracker data updated)');
        $this->session->set_flashdata('tracker_msg', $message);
        $this->response(['status' => 'success']);
    }

    function save_decision() {
        $drug_id = $this->input->post('drug_id');
        $decision = $this->input->post('discussion');
        $reccomendation = $this->input->post('recommendation');
        $this->db->insert('tbl_decision', [
            'discussion' => $decision,
            'recommendation' => $reccomendation,
            'decision_date' => date('Y-m-d'),
            'drug_id' => $drug_id
        ]);

        $insert_id = $this->db->insert_id();
        $this->db->insert('tbl_decision_log', [
            'description' => 'created',
            'user_id' => $this->session->userdata('id'),
            'decision_id' => $insert_id
        ]);
        $this->updateSysLogs('Created  (tbl_decision > New Discussion/Reccommendation )');
    }

    function edit_decision() {
        $drug_id = $this->input->post('drug_id');
        $decision_id = $this->input->post('decision_id');
        $decision = $this->input->post('discussion');
        $reccomendation = $this->input->post('recommendation');
        $this->db->where('id', $decision_id)->update('tbl_decision', [
            'discussion' => $decision,
            'recommendation' => $reccomendation,
            'drug_id' => $drug_id
        ]);

        $this->db->insert('tbl_decision_log', [
            'description' => 'updated',
            'user_id' => $this->session->userdata('id'),
            'decision_id' => $decision_id
        ]);
        $this->updateSysLogs('Updated  (tbl_decision > Discussion/Reccommendation )');
    }

    public function delete_decision() {
        $decision_id = $this->input->post('decision_id');
        $this->db->where('id', $decision_id)->update('tbl_decision', [
            'deleted' => 1
        ]);

        $this->db->insert('tbl_decision_log', [
            'description' => 'deleted',
            'user_id' => $this->session->userdata('id'),
            'decision_id' => $decision_id
        ]);

        $this->updateSysLogs('Deleted  (tbl_decision > Discussion/Reccommendation )');
    }

    public function get_timeline() {

        $drug_ids = "SELECT GROUP_CONCAT(id) id FROM `tbl_decision`";
        $table_ids = $this->db->query($drug_ids)->result_array();
        $drugids_ = $table_ids[0]["id"];
        $sql = "SELECT * FROM vw_drug_list";
        $table_data = $this->db->query($sql)->result_array();

        $sql2 = "SELECT 
                        d.id,
                        d.decision_date,
                        d.discussion,
                        d.recommendation,
                        d.drug_id,
                        t.created,
                        CONCAT_WS(' ', u.firstname, u.lastname) user
                    FROM tbl_decision d 
                    LEFT JOIN (
                        SELECT *
                        FROM tbl_decision_log l
                        WHERE (l.created, l.decision_id) IN
                        (SELECT MAX(created), decision_id
                        FROM tbl_decision_log 
                        GROUP BY decision_id)
                    ) t ON t.decision_id = d.id
                    INNER JOIN tbl_user u ON u.id = t.user_id                    
                    AND d.deleted = '0'                    
                    ORDER BY d.decision_date DESC";
        $items = $this->db->query($sql2)->result_array();


        foreach ($table_data as &$mt) {
            foreach ($items as $it) {
                if ($it['drug_id'] == $mt['id']) {
                    if (!isset($mt['decisions'])) {
                        $mt['decisions'] = [];
                    }
                    $mt['decisions'][] = $it;
                }
            }
        }

        $final_string = '';

        foreach ($table_data as $d) {
            if (isset($d['decisions'])) {
                $final_string .= '<p style="font-weight:bold; font-size:16px; color:blue;">' . $d['name'] . '</p>';
            } else {
                
            }
            if (isset($d['decisions'])) {
                foreach ($d['decisions'] as $e) {
                    $final_string .= '<div class="row timeline-movement">
        <div class="timeline-badge">
            <span class="timeline-balloon-date-day">' . date("d", strtotime($e["decision_date"])) . '</span>
            <span class="timeline-balloon-date-month">' . date("M/y", strtotime($e["decision_date"])) . '</span>
        </div>
        <div class="col-sm-6  timeline-item">
            <div class="row ">
                <div class="col-sm-11 ">
                    <div class="timeline-panel credits mainContent">
                        <ul class="timeline-panel-ul ">
                            <li><span class="decAction"><a style="display:none;" href="#edit" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-primary edit readonly2" data-id=' . $e["id"] . '><i class="glyphicon glyphicon-edit"></i> | Edit</span></a>  <a style="display:none;" href="#trash" data-toggle="modal" data-target="#trashModal" class="btn btn-sm btn-danger trash readonly2" data-id=' . $e["id"] . '><i class="glyphicon glyphicon-trash"></i> | Trash</span></a></span></li>
                            <li><span class="importo">Discussions</span></li>
                            <li><span class="causale _disc' . $e["id"] . '">' . $e["discussion"] . '</span> </li>
                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>Last updated by ' . $e["user"] . ' on ' . date('d/m/Y h:i:s a', strtotime($e["created"])) . '</small></p> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-6  timeline-item">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-11">
                    <div class="timeline-panel debits mainContent">
                        <ul class="timeline-panel-ul">
                            <li><span class="decAction"><a style="display:none;" href="#edit" data-toggle="modal" data-target="#editModal"  class="btn btn-sm btn-primary edit" data-id=' . $e["id"] . '><i class="glyphicon glyphicon-edit"></i> | Edit</span></a> <a style="display:none;" href="#trash" data-toggle="modal" data-target="#trashModal" class="btn btn-sm btn-danger trash" data-id=' . $e["id"] . '><i class="glyphicon glyphicon-trash"></i> | Trash</span></a></span></li>
                            <li><span class="importo">Recommendations</span></li>
                            <li><span  class="causale _rec' . $e["id"] . '">' . $e["recommendation"] . '</spsn> </li>
                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Last updated by ' . $e["user"] . ' on ' . date('d/m/Y h:i:s a', strtotime($e["created"])) . '</small></p> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>';
                }
            } else {
                
            }
        }

        echo $final_string;
    }

    public function get_decisions($drug_id) {
        $html_timeline = '';
        $response = $this->Procurement_model->get_decision_data($drug_id);
        foreach ($response['data'] as $values) {
            $html_timeline .= '<div class="row timeline-movement">
        <div class="timeline-badge">
            <span class="timeline-balloon-date-day">' . date("d", strtotime($values["decision_date"])) . '</span>
            <span class="timeline-balloon-date-month">' . date("M/y", strtotime($values["decision_date"])) . '</span>
        </div>
        <div class="col-sm-6  timeline-item">
            <div class="row ">
                <div class="col-sm-11 ">
                    <div class="timeline-panel credits mainContent">
                        <ul class="timeline-panel-ul ">
                            <li><span class="decAction"><a style="display:none;" href="#edit" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-primary edit" data-id=' . $values["id"] . '><i class="glyphicon glyphicon-edit"></i> | Edit</span></a>  <a style="display:none;" href="#trash" data-toggle="modal" data-target="#trashModal" class="btn btn-sm btn-danger trash" data-id=' . $values["id"] . '><i class="glyphicon glyphicon-trash"></i> | Trash</span></a></span></li>
                            <li><span class="importo">Discussions</span></li>
                            <li><span class="causale _disc' . $values["id"] . '">' . $values["discussion"] . '</span> </li>
                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>Last updated by ' . $values["user"] . ' on ' . date('d/m/Y h:i:s a', strtotime($values["created"])) . '</small></p> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-6  timeline-item">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-11">
                    <div class="timeline-panel debits mainContent">
                        <ul class="timeline-panel-ul">
                            <li><span class="decAction"><a style="display:none;" href="#edit" data-toggle="modal" data-target="#editModal"  class="btn btn-sm btn-primary edit" data-id=' . $values["id"] . '><i class="glyphicon glyphicon-edit"></i> | Edit</span></a> <a style="display:none;" href="#trash" data-toggle="modal" data-target="#trashModal" class="btn btn-sm btn-danger trash" data-id=' . $values["id"] . '><i class="glyphicon glyphicon-trash"></i> | Trash</span></a></span></li>
                            <li><span class="importo">Recommendations</span></li>
                            <li><span  class="causale _rec' . $values["id"] . '">' . $values["recommendation"] . '</spsn> </li>
                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Last updated by ' . $values["user"] . ' on ' . date('d/m/Y h:i:s a', strtotime($values["created"])) . '</small></p> </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>';
        }
        echo $html_timeline;
    }

    public function get_decisions_byID($drug_id) {
        echo json_encode($this->Procurement_model->get_decision_data_by_id($drug_id));
    }

    function rv($v) {
        $rdata = $v;
        if (empty($v)) {
            $rdata = ' - ';
        } else if ($v == 0) {
            $rdata = ' - ';
        } else {
            $rdata = number_format($v);
        }
        return $rdata;
    }

    function cc($v) {
        $k = (int) $v;
        $class = '';
        if ($k >= 6 && $k <= 9) {
            $class = 'class1';
        } else if ($k >= 4 && $k <= 5) {
            $class = 'class2';
        } else if ($k <= 3) {
            $class = 'class3';
        } else {
            $class = 'class4';
        }
        return $class;
    }

    function newValue($x, $y, $z) {
        return (int) $x - (int) $y + (int) $z;
    }

    public function get_transaction_table2($drug_id, $period_year) {
        $column = $this->getTransactionStatus($drug_id, $period_year);
        $month = (int) date('m');
        $previousCount = $month - 1;
        $full = 11;

        $transaction_table = '
<table class="table table-hover table-condensed table-bordered TRACKER">
  <tr style="font-weight:bold !important;">
    <th class="tg-0pky" colspan="2"><strong>Description</th>
    <th class="tg-0pky"><strong>Jan-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Feb-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Mar-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Apr-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>May-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Jun-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Jul-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Aug-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Sep-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Oct-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Nov-' . $period_year . '</strong></th>
    <th class="tg-0pky"><strong>Dec-' . $period_year . '</strong></th>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="2"><strong>Opening Balance</strong></td>';
        //opening balance
        if ($period_year != date('Y')) {
            for ($i = 0; $i <= $full; $i++) {
                $col = (int) $i + 1;
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col . '">' . @$this->rv($column['tracker'][$i]['open_kemsa']) . '</td>';
            }
        } else {

            for ($i = 0; $i <= $previousCount; $i++) {
                $col = (int) $i + 1;
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col . '">' . @$this->rv($column['tracker'][$i]['open_kemsa']) . '</td>';
            }
            for ($i = $month; $i <= $full; $i++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col . '">' . @$this->rv(0) . '</td>';
            }
        }

        $transaction_table .= '</tr>
  <tr>
    <td class="tg-0pky" rowspan="6" vertical-align="middle"><strong>Receipts from Suppliers</strong></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>
     <td class="tt"></td>';


        $transaction_table .= '</tr>
            <tr>
    <td class="tg-0pky"><strong>Proposed</strong></td>';
        //proposed quantity
        if ($period_year != date('Y')) {
            for ($j = 0; $j <= $full; $j++) {
                $col1 = (int) $j + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col1 . '">' . @$this->rv($column['status'][0][$j]['quantity']) . ' </td>';
            }
        } else {
            for ($j = 0; $j <= $previousCount; $j++) {
                $col1 = (int) $j + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col1 . '">' . @$this->rv($column['status'][0][$j]['quantity']) . ' </td>';
            }

            for ($j = $month; $j <= $full; $j++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col1 . '">' . @$this->rv(0) . '</td>';
            }
        }

        $transaction_table .= '</tr>
        <tr>
        <td class = "tg-0pky"><strong>Contracted</strong></td>';
        //contracted quantity
        if ($period_year != date('Y')) {
            for ($k = 0; $k <= $full; $k++) {
                $col2 = (int) $k + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col2 . '">' . @$this->rv($column['status'][1][$k]['quantity']) . ' </td>';
            }
        } else {
            for ($k = 0; $k <= $previousCount; $k++) {
                $col2 = (int) $k + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col2 . '">' . @$this->rv($column['status'][1][$k]['quantity']) . ' </td>';
            }

            for ($co = $month; $co <= $full; $co++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col2 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>
        <tr>
        <td class = "tg-0pky"><strong>Call Down</strong></td>';
        //call down quantity
        if ($period_year != date('Y')) {
            for ($l = 0; $l <= $full; $l++) {
                $col3 = (int) $l + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col3 . '">' . @$this->rv($column['expected'][$l]['quantity']) . ' </td>';
            }
        } else {
            for ($l = 0; $l <= $previousCount; $l++) {
                $col3 = (int) $l + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col3 . '">' . @$this->rv($column['expected'][$l]['quantity']) . ' </td>';
            }

            for ($co1 = $month; $co1 <= $full; $co1++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col3 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>
        <tr>
        <td class = "tg-0pky"><strong>Received</strong></td>';
        //received  quantity
        if ($period_year != date('Y')) {
            for ($m1 = 0; $m1 <= $full; $m1++) {
                $col4 = (int) $m1 + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col4 . '">' . @$this->rv($column['status'][2][$m1]['quantity']) . ' </td>';
            }
        } else {
            for ($m1 = 0; $m1 <= $previousCount; $m1++) {
                $col4 = (int) $m1 + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col4 . '">' . @$this->rv($column['status'][2][$m1]['quantity']) . ' </td>';
            }

            for ($co2 = $month; $co2 <= $full; $co2++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col4 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>

        <tr>
        <td class = "tg-0pky"><strong>Pending</strong></td>';
        //pending quantity
        if ($period_year != date('Y')) {
            for ($m = 0; $m <= $full; $m++) {
                $col4 = (int) $m + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col4 . '">' . @$this->rv(((int) $column['status'][1][$m]['quantity'] - (int) $column['expected'][$m]['quantity']) + ((int) $column['expected'][$m]['quantity'] - (int) $column['status'][2][$m]['quantity'] )) . ' </td>';
            }
        } else {
            for ($m = 0; $m <= $previousCount; $m++) {
                $col4 = (int) $m + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col4 . '">' . @$this->rv(((int) $column['status'][1][$m]['quantity'] - (int) $column['expected'][$m]['quantity']) + ((int) $column['expected'][$m]['quantity'] - (int) $column['status'][2][$m]['quantity'] )) . ' </td>';
            }

            for ($co2 = $month; $co2 <= $full; $co2++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col4 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>

        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Issues to Facility</strong></td>';
        //issues quantity
        if ($period_year != date('Y')) {
            for ($n = 0; $n <= $full; $n++) {
                $col5 = (int) $n + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col5 . '">' . @$this->rv($column['tracker'][$n]['issues_kemsa']) . ' </td>';
            }
        } else {
            for ($n = 0; $n <= $previousCount; $n++) {
                $col5 = (int) $n + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col5 . '">' . @$this->rv($column['tracker'][$n]['issues_kemsa']) . ' </td>';
            }

            for ($co3 = $month; $co3 <= $full; $co3++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col5 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>
        
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Adjustments/Losses (+/-)</strong></td>';
        //loss/adj quantity
        if ($period_year != date('Y')) {
            for ($o = 0; $o <= $full; $o++) {
                $col6 = (int) $o + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col6 . '">' . @$this->rv($column['tracker'][$o]['adj_losses']) . ' </td>';
            }
        } else {
            for ($o = 0; $o <= $previousCount; $o++) {
                $col6 = (int) $o + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col6 . '">' . @$this->rv($column['tracker'][$o]['adj_losses']) . ' </td>';
            }

            for ($co7 = $month; $co7 <= $full; $co7++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col6 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>        
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Closing Balance</strong></td>';
        //Closing Balance
        if ($period_year != date('Y')) {
            for ($p = 0; $p <= $full; $p++) {
                $col7 = (int) $p + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col7 . '">' . @$this->rv($column['tracker'][$p]['close_kemsa']) . ' </td>';
            }
        } else {
            for ($p = 0; $p <= $previousCount; $p++) {
                $col7 = (int) $p + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col7 . '">' . @$this->rv($column['tracker'][$p]['close_kemsa']) . ' </td>';
            }

            for ($co8 = $month; $co8 <= $full; $co8++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col7 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>       
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Monthly Consumption</strong></td>';
        //Monthly Consumptions
        if ($period_year != date('Y')) {
            for ($q = 0; $q <= $full; $q++) {
                $col8 = (int) $q + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col8 . '">' . @$this->rv($column['tracker'][$q]['monthly_consumption']) . ' </td>';
            }
        } else {
            for ($q = 0; $q <= $previousCount; $q++) {
                $col8 = (int) $q + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col8 . '">' . @$this->rv($column['tracker'][$q]['monthly_consumption']) . ' </td>';
            }

            for ($co9 = $month; $co9 <= $full; $co9++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col8 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>  
        
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Average Issues</strong></td>';
        //Average Issues
        if ($period_year != date('Y')) {
            for ($r = 0; $r <= $full; $r++) {
                $col9 = (int) $r + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col9 . '">' . @$this->rv($column['tracker'][$r]['avg_issues']) . ' </td>';
            }
        } else {
            for ($r = 0; $r <= $previousCount; $r++) {
                $col9 = (int) $r + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col9 . '">' . @$this->rv($column['tracker'][$r]['avg_issues']) . ' </td>';
            }

            for ($co10 = $month; $co10 <= $full; $co10++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col9 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>  
        
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>Average Consumption</strong></td>';
        //Average Consumption
        if ($period_year != date('Y')) {
            for ($s = 0; $s <= $full; $s++) {
                $coll0 = (int) $s + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $coll0 . '">' . @$this->rv($column['tracker'][$s]['avg_consumption']) . ' </td>';
            }
        } else {
            for ($s = 0; $s <= $previousCount; $s++) {
                $coll0 = (int) $s + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $coll0 . '">' . @$this->rv($column['tracker'][$s]['avg_consumption']) . ' </td>';
            }

            for ($co11 = $month; $co11 <= $full; $co11++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $coll0 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr> 
        
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>MOS (Issues Based)</strong></td>';
        //Issues Based
        if ($period_year != date('Y')) {
            for ($t = 0; $t <= $full; $t++) {
                $col11 = (int) $t + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col11 . ' ' . @$this->cc($column['tracker'][$t]['mos']) . '">' . @$this->rv($column['tracker'][$t]['mos']) . ' </td>';
            }
        } else {
            for ($t = 0; $t <= $previousCount; $t++) {
                $col11 = (int) $t + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col11 . ' ' . @$this->cc($column['tracker'][$t]['mos']) . '">' . @$this->rv($column['tracker'][$t]['mos']) . ' </td>';
            }

            for ($co11 = $month; $co11 <= $full; $co11++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col11 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>         
        <tr>
        <td class = "tg-0pky" colspan = "2"><strong>MOS (Consumption Based)</strong></td>';
        //Consumption Based
        if ($period_year != date('Y')) {
            for ($u = 0; $u <= $full; $u++) {
                $col12 = (int) $t + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col12 . ' ' . @$this->cc($column['tracker'][0]['cmos']) . '">' . @$this->rv($column['tracker'][$u]['cmos']) . ' </td>';
            }
        } else {
            for ($u = 0; $u <= $previousCount; $u++) {
                $col12 = (int) $t + 1;
                $transaction_table .= '<td class = "tdata tg-0pky col-' . $col12 . ' ' . @$this->cc($column['tracker'][0]['cmos']) . '">' . @$this->rv($column['tracker'][$u]['cmos']) . ' </td>';
            }

            for ($co12 = $month; $co12 <= $full; $co12++) {
                $transaction_table .= '<td class="tdata tg-0pky col-' . $col12 . '">' . @$this->rv(0) . '</td>';
            }
        }
        $transaction_table .= '</tr>        

        </table>';
        echo $transaction_table;
    }

    function getTrackerData($drugid, $year) {
        $rmonths2 = $this->trackerMonthsOpen();
        $query2 = $this->db->query("SELECT                         
                           data_month,                           
                            open_kemsa,
                            receipts_kemsa,
                            issues issues_kemsa,
                            close_kemsa,
                            consumption monthly_consumption,
                            avg_issues,
                            avg_consumption,
                            adj_losses,
                        ROUND(close_kemsa/avg_issues) mos,
                        ROUND(close_kemsa/avg_consumption) cmos
                        FROM vw_procurement_list p
                        WHERE p.drug_id = '$drugid'
                        AND p.data_year = '$year'
                        GROUP BY data_month
                        ORDER BY data_year ASC, 
                        FIELD(data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )")->result_array();


        foreach ($query2 as $q) {
            unset($rmonths2[$q['data_month']]);
        }
        $arr = [];
        for ($i = 0; $i < count($rmonths2); $i++) {
            array_push($arr, $i);
        }
        $new_arr = $this->rename_keys($rmonths2, $arr);
        $final_arr = array_merge($new_arr, $query2);
        usort($final_arr, function ($a, $b) {
            $t1 = strtotime($a['data_month']);
            $t2 = strtotime($b['data_month']);
            return $t1 - $t2;
        });
        return $final_arr;
    }

    function getTransactionStatus($drugid, $year) {

        $rmonths = $this->trackeMonths();
        $tracker = $this->getTrackerData($drugid, $year);
        $new_arr = [];
        $transaction_status = $this->db->select('name')->from("tbl_procurement_status")->not_like('name', 'cancelled')->order_by('id', 'asc')->get()->result();
        foreach ($transaction_status as $stat):
            $status = strtolower($stat->name);
            $query[$status] = $this->db->query("SELECT                 
                    transaction_month data_month,                   
                    SUM(quantity) quantity                     
                    FROM tbl_procurement_item pi
                    INNER JOIN tbl_procurement p ON p.id = pi.procurement_id
                    INNER JOIN tbl_procurement_status ps ON ps.id = pi.procurement_status_id
                    LEFT JOIN tbl_funding_agent fa ON fa.id = pi.funding_agent_id
                    LEFT JOIN tbl_supplier s ON s.id = pi.supplier_id
                    WHERE p.drug_id = '$drugid'
                    AND transaction_year='$year'
                    AND ps.name LIKE '%$status%'
                    GROUP BY data_month
                    ORDER BY transaction_year DESC, FIELD(transaction_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )")->result_array();
        endforeach;


        //checking and removing months that already exist from the query
        foreach ($query as $k => $q):
            foreach ($query[$k] as $k) {
                unset($rmonths[$k['data_month']]);
            }
            array_push($new_arr, $rmonths);
        endforeach;


        //Getting number of array element so as to get keys for replacements in the resultant array above from name to index
        $renamed_arrays = [];
        foreach ($new_arr as $ki => $v):
            $arr[$ki] = [];
            for ($i = 0; $i < count($new_arr[$ki]); $i++) {
                array_push($arr[$ki], $i);
            }
            $new_arr1 = $this->rename_keys($new_arr[$ki], $arr[$ki]);
            array_push($renamed_arrays, $new_arr1);
        endforeach;



        //merging and sorting the resultant array by month
        $new_final_array = [];
        foreach ($transaction_status as $key => $stat):
            $status = strtolower($stat->name);
            $merged = array_merge($query[$status], $renamed_arrays[$key]);
            usort($merged, function ($a, $b) {
                $t1 = strtotime($a['data_month']);
                $t2 = strtotime($b['data_month']);
                return $t1 - $t2;
            });
            array_push($new_final_array, $merged);
        endforeach;

        //assigning the final array the procurement statuses as opposed to the array indexes for easier dynamic referencing``
        $tracker_data = [
            'tracker' => $tracker,
            'status' => $new_final_array,
            'expected' => $this->expected($drugid, $year)
        ];
        //$this->response($tracker_data);
        //

        return $tracker_data;
    }

    function expected($drug, $year) {
        $rmonths = $this->trackeMonths();
        $query = $this->db->query("SELECT                 
                    transaction_month data_month,                   
                    quantity quantity                     
                    FROM tbl_procurement_item pi
                    INNER JOIN tbl_procurement p ON p.id = pi.procurement_id
                    INNER JOIN tbl_procurement_status ps ON ps.id = pi.procurement_status_id
                    LEFT JOIN tbl_funding_agent fa ON fa.id = pi.funding_agent_id
                    LEFT JOIN tbl_supplier s ON s.id = pi.supplier_id
                    WHERE p.drug_id = '$drug'
                    AND transaction_year='$year'
                    AND ps.name LIKE '%Call_Down%'
                    GROUP BY transaction_month
                    ORDER BY transaction_year DESC, FIELD(transaction_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )")->result_array();


        foreach ($query as $k) {
            unset($rmonths[$k['data_month']]);
        }
        $renamed_arrays = [];
        $arr = [];
        for ($i = 0; $i < count($rmonths); $i++) {
            array_push($arr, $i);
        }
        $new_arr1 = $this->rename_keys($rmonths, $arr);
        array_push($renamed_arrays, $new_arr1);

        $merged = array_merge($query, $renamed_arrays[0]);
        usort($merged, function ($a, $b) {
            $t1 = strtotime($a['data_month']);
            $t2 = strtotime($b['data_month']);
            return $t1 - $t2;
        });

        return $merged;
    }

    function rename_keys($array, $replacement_keys) {
        return array_combine($replacement_keys, array_values($array));
    }

    public function get_transaction_table($drug_id, $period_year) {
        $responses = array();
        $headers = array();
        $widths = array();
        $columns = array();
        $alignments = array();
        $column_indices = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
        $drug_name = '';
        $response = $this->Procurement_model->get_transaction_data($drug_id, $period_year);
        //Initial sidebar labels
        $responses = array(
            'open_kemsa' => array('Open Balance'),
            'proposed' => array('Proposed'),
            'contracted' => array('Contracted'),
            'received' => array('Received'),
            'issues_kemsa' => array('Issues to Facility'),
            'close_kemsa' => array('Closing Balance'),
            'monthly_consumption' => array('Monthly Consumption'),
            'adjustments_loss' => array('Adjustment/Loss'),
            'avg_issues' => array('Average Issues'),
            'avg_consumption' => array('Average Consumption'),
            'mos' => array('Months of Stock'),
            'mosbc' => array('MOS on Consumption')
        );
        $headers[] = 'Description';
        $widths[] = '160';
        $columns[] = array('type' => 'text', 'readOnly' => true, 'class' => 'data');
        $alignments[] = 'left';
        foreach ($response['data'] as $key => $value) {
            $headers[] = $value['period'];
            $widths[] = '80';
            $columns[] = array('type' => 'numeric');
            $alignments[] = 'center';
            //Put formaulas
            if ($key == 0) {
                $drug_name = $value['drug'];
                $responses['open_kemsa'][] = $value['open_kemsa'];
            } else {
                $responses['open_kemsa'][] = ' = ' . $column_indices[$key - 1] . '4';
            }
            $responses['proposed'][] = $value['receipts_kemsa'];
            $responses['contracted'][] = $value['receipts_kemsa'];
            $responses['received'][] = $value['receipts_kemsa'];
            $responses['issues_kemsa'][] = $value['issues_kemsa'];
            $responses['close_kemsa'][] = ' = ' . $column_indices[$key] . '1+' . $column_indices[$key] . '2-' . $column_indices[$key] . '3';
            $responses['monthly_consumption'][] = $value['monthly_consumption'];
            $responses['adjustments_loss'][] = $value['monthly_consumption'];
            $responses['avg_issues'][] = $value['avg_issues'];
            $responses['avg_consumption'][] = $value['avg_consumption'];
            $responses['mos'][] = $value['mos'];
            $responses['mosbc'][] = $value['mos'];
        }
        echo json_encode(array(
            'data' => array_values($responses),
            'colHeaders' => $headers,
            'colWidths' => $widths,
            'columns' => $columns,
            'colAlignments' => $alignments,
            'csvFileName' => $drug_name . ' Procurement Tracker for ' . $period_year,
            'columnSorting' => false,
            'csvHeaders' => true
                ), JSON_NUMERIC_CHECK);
    }

    public function get_order_table($drug_id) {
        $response = $this->Procurement_model->get_order_data($drug_id);

        $html_table = '<table class = "table table-condensed table-striped table-bordered order_tbl">';
        $thead = '<thead><tr>';
        $tbody = '<tbody>';
        foreach ($response['data'] as $count => $values) {
            $tbody .= '<tr>';
            foreach ($values as $key => $value) {
                if ($count == 0) {
                    $thead .= '<th>' . $key . '</th>';
                }
                $tbody .= '<td>' . $value . '</td>';
            }
            $tbody .= '</tr>';
        }
        $thead .= '</tr></thead>';
        $html_table .= $thead;
        $html_table .= $tbody;
        $html_table .= '</tbody></table>';
        echo $html_table;
    }

    public function get_order_table_history($drug_id) {
        $response = $this->Procurement_model->get_history_data($drug_id);

        $html_table = '<table class = "table table-condensed table-striped table-bordered order_tbl_history">';
        $thead = '<thead><tr>';
        $tbody = '<tbody>';
        foreach ($response['data'] as $count => $values) {
            $tbody .= '<tr>';
            foreach ($values as $key => $value) {
                if ($count == 0) {
                    $thead .= '<th>' . $key . '</th>';
                }
                $tbody .= '<td>' . $value . '</td>';
            }
            $tbody .= '</tr>';
        }
        $thead .= '</tr></thead>';
        $html_table .= $thead;
        $html_table .= $tbody;
        $html_table .= '</tbody></table>';
        echo $html_table;
    }

    public function get_log_table($drug_id) {
        $response = $this->Procurement_model->get_log_data($drug_id);
        $html_table = '<table class = "table table-condensed table-striped table-bordered log_tbl">';
        $thead = '<thead><tr>';
        $tbody = '<tbody>';
        foreach ($response['data'] as $count => $values) {
            $tbody .= '<tr>';
            foreach ($values as $key => $value) {
                if ($count == 0) {
                    $thead .= '<th>' . $key . '</th>';
                }
                $tbody .= '<td>' . $value . '</td>';
            }
            $tbody .= '</tr>';
        }
        $thead .= '</tr></thead>';
        $html_table .= $thead;
        $html_table .= $tbody;
        $html_table .= '</tbody></table>';
        echo $html_table;
    }

    public function get_default_period() {
        $default_period = array(
            'year' => $this->config->item('data_year'),
            'month' => $this->config->item('data_month'),
            'drug' => $this->config->item('drug'));
        echo json_encode($default_period);
    }

    public function get_chart() {
        $chartname = $this->input->post('name');
        $selectedfilters = $this->get_filter($chartname, $this->input->post('selectedfilters'));
        //Set filters based on role and scope
        $role = $this->session->userdata('role');
        if (!in_array($role, array('admin', 'nascop'))) {
            $selectedfilters[$role] = $this->session->userdata('scope_name');
        }
        //Get chart configuration
        $data['chart_name'] = $chartname;
        $data['chart_title'] = $this->config->item($chartname . '_title');
        $data['chart_yaxis_title'] = $this->config->item($chartname . '_yaxis_title');
        $data['chart_xaxis_title'] = $this->config->item($chartname . '_xaxis_title');
        $data['chart_source'] = $this->config->item($chartname . '_source');
        //Get data
        $main_data = array('main' => array(), 'drilldown' => array(), 'columns' => array());
        $main_data = $this->get_data($chartname, $selectedfilters);
        if ($this->config->item($chartname . '_has_drilldown')) {
            $data['chart_drilldown_data'] = json_encode(@$main_data['drilldown'], JSON_NUMERIC_CHECK);
        } else {
            $data['chart_categories'] = json_encode(@$main_data['columns'], JSON_NUMERIC_CHECK);
        }
        $data['selectedfilters'] = htmlspecialchars(json_encode($selectedfilters), ENT_QUOTES, 'UTF-8');
        $data['chart_series_data'] = json_encode($main_data['main'], JSON_NUMERIC_CHECK);
        //Load chart
        $this->load->view($this->config->item($chartname . '_chartview'), $data);
    }

    public function get_filter($chartname, $selectedfilters) {
        $filters = $this->config->item($chartname . '_filters_default');
        $filtersColumns = $this->config->item($chartname . '_filters');

        if (!empty($selectedfilters)) {
            foreach (array_keys($selectedfilters) as $filter) {
                if (in_array($filter, $filtersColumns)) {
                    $filters[$filter] = $selectedfilters[$filter];
                }
            }
        }
        return $filters;
    }

    public function get_data($chartname, $filters) {
        if ($chartname == 'consumption_issues_chart') {
            $main_data = $this->Procurement_model->get_procurement_consumption_issues($filters);
        } else if ($chartname == 'actual_consumption_issues_chart') {
            $main_data = $this->Procurement_model->get_procurement_actual_consumption_issues($filters);
        } else if ($chartname == 'kemsa_soh_chart') {
            $main_data = $this->Procurement_model->get_procurement_kemsa_soh($filters);
        } else if ($chartname == 'adult_patients_on_drug_chart') {
            $main_data = $this->Procurement_model->get_procurement_adult_patients_on_drug($filters);
        } else if ($chartname == 'paed_patients_on_drug_chart') {
            $main_data = $this->Procurement_model->get_procurement_paed_patients_on_drug($filters);
        } else if ($chartname == 'stock_status_chart') {
            $main_data = $this->Procurement_model->get_procurement_stock_status($filters);
        } else if ($chartname == 'expected_delivery_chart') {
            $main_data = $this->Procurement_model->get_procurement_expected_delivery($filters);
        }
        return $main_data;
    }

    public function edit_order() {
        $input = $this->input->post();
        //Evaluate type of action
        if ($input['action'] == 'edit') {
            unset($input['action']);
            $this->Procurement_model->edit_procurement_item($input);
            $this->updateSysLogs('Updated (Order edited )');
            $input['action'] = 'edit';
        } else if ($input['action'] == 'delete') {
            unset($input['action']);
            $this->Procurement_model->delete_procurement_item($input['id']);
            $input['action'] = 'delete';
            $this->updateSysLogs('Deleted (Order deleted )');
        }
        echo json_encode($input);
    }

    function get_order_items() {
        header("Content-Type: application/json; charset=UTF-8");
        $response = array();
        $item_urls = array(
            'status' => $this->getStatuses('procurement_status'),
            'funding' => $this->getStatuses('funding_agent'),
            'supplier' => $this->getStatuses('supplier')
        );

        foreach ($item_urls as $key => $item_url) {
            if ($key != 'status') {
                $response[$key][0] = 'Select one';
            }
            foreach (json_decode(json_encode($item_url), TRUE) as $values) {
                $response[$key][$values['id']] = $values['name'];
            }
        }
        echo json_encode($response);
    }

    function getStatuses($table) {
        // header("Content-Type: application/json; charset=UTF-8");
        $resp = $this->db->get('tbl_' . $table)->result();
        return $resp;
    }

    function memberUpdates() {
        $present = $this->input->post('present');
        $absent = $this->input->post('absent');

        for ($i = 0; $i < count($present); $i++) {

            $this->db->where('email', $present[$i])->update('tbl_mailing_list', ['present' => 0]);
        }
        for ($j = 0; $j < count($absent); $j++) {
            $this->db->where('email', $absent[$j])->update('tbl_mailing_list', ['present' => 1]);
        }
        $success = ['success' => 1];
        $this->response($success);
    }

    function membersListAdd() {
        $resp['response'] = '';
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        if ($this->checkEmail($email) > 0) {
            $resp['response'] = 0;
        } else {
            $this->db->insert('tbl_mailing_list', [
                'name' => $name,
                'email' => $email,
                'email_type' => 1,
                'sent_date' => date('Y-m-d H:i:s'),
                'status' => 1,
                'present' => 0,
            ]);
            $resp['response'] = 1;
        }
        $this->response($resp['response']);
    }

    function checkEmail($param) {
        $email = $this->db->where('email', $param)->get('tbl_mailing_list')->result();
        return count($email);
    }

    function getEmails() {

        $present = $this->db->where('present', '0')->get('tbl_mailing_list')->result();
        $absent = $this->db->where('present', '1')->get('tbl_mailing_list')->result();
        $result = ['present' => $present, 'absent

        ' => $absent];
        $this->response($result);
    }

    function response($result) {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($result);
    }

}

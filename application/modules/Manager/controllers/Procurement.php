<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Procurement extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Procurement_model');
        $this->load->library('Email_sender');
    }

    function Reminder() {
        $this->sendReminder();
    }

    function getAllDrugs() {
        $query = "SELECT * FROM `vw_drug_list`  ORDER BY name ASC";
        echo json_encode($this->db->query($query)->result());
    }

    function menuBuilder() {
          
        $newmenu = '<div class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="/page.html">
                Dropdown <span class="caret"></span>
            </a>            
    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">';
        $toplevel = $this->db->get('tbl_county')->result();
          $newmenu .= '<em>County</em> ';   
        foreach ($toplevel as $top):
            $newmenu .= '<li class="dropdown-submenu">              
                <a tabindex="-1" href="#"><input type="checkbox">' . ucwords($top->name) . '</a> ';                     
                  $newmenu .= '<ul class="dropdown-menu">';
            $submenu = $this->getSubLevelMenus($top->id, 'county_id', 'tbl_subcounty');
            $newmenu .= '<em>Sub Counties</em> ';   
            foreach ($submenu as $sub):
                $newmenu .= '<li class="dropdown-submenu">';
                $newmenu .= '<a href="#"><input type="checkbox">' . ucwords($sub->name) . '</a>';
                $facilities = $this->getSubLevelMenus($sub->id, 'subcounty_id', 'tbl_facility');
                $newmenu .= '<ul class="dropdown-menu">';
                $newmenu .= '<em>Sub County Facilities</em> ';   
                foreach ($facilities as $facility):
                    $newmenu .= '<li><a href="#"><input type="checkbox">' . ucwords($facility->name) . '</a></li>';
                endforeach;
                $newmenu .= '</ul>';
                $newmenu .= '</li>';
            endforeach;
            $newmenu .= ' </ul>';
            $newmenu .= '</li>';
        endforeach;
        $newmenu .= '</ul>
        </div>';
        
     echo ' <div class="dropdown dropdown-inline">
            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li class="dropdown">
                <a href="#">Another dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu dropdownhover-right">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#">Another dropdown 2 <span class="caret"></span></a>
                <ul class="dropdown-menu dropdownhover-right">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li class="dropdown">
                    <a href="#">Another dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                      <li class="divider"></li>
                      <li><a href="#">One more separated link</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
              <li class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </div>';
        
       // echo $newmenu;
    }

    function getSubLevelMenus($pid, $pcol, $table) {
        return $this->db->where($pcol, $pid)->order_by('name', 'asc')->get($table)->result();
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
        echo json_encode($this->db->order_by('id', 'desc')->get('tbl_meeting')->result());
    }

    function loadLastMinutesHF() {
        echo json_encode($this->db->order_by('id', 'desc')->get('tbl_minutes')->result());
    }

    function loadLastMinutesBody($id) {
        echo json_encode($this->db->where('id', $id)->get('tbl_minutes')->result());
    }

    public function getMinutesData($cat, $date) {
        //$mindate = substr($date, 0, -3);

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

        $table = '<table   width="100%" class="table "  id="minutesTable">';
        $table .= '<thead><tr><th><br>COMMODITY </th><th>DISCUSSION</th><th>RECCOMMENDATION</th><th>TRACKER</th></tr></thead>';
        $table .= '<tbody>';
        $i = 0;
        foreach ($table_data as $d) {
            $table .= '<tr>';
            $table .= '<td><input type="hidden" name=decision_id[] value=' . $d['decision_id'] . '><input type="hidden" name=drug_id[] value=' . $d['id'] . '><strong>' . $d['name'] . '</strong></td><td><textarea class="textarea" name=decision[] >' . $d['discussion'] . '</textarea></td><td><textarea class="textarea" name=recommendation[]>' . $d['recommendation'] . '</textarea></td><td> 
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
            echo $this->db->last_query();
            $this->updateSysLogs('Updated  (tbl_minutes - Meeting Minute  > Minute Agenda & A.O.Bs)');
        } else {
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

        $date = date('Y') . "-" . sprintf("%02d", date('m') - 1);
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
        echo json_encode(['status'=>'success']);
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
        $year = date('Y');
        $data = $this->input->post('data');
        $new_month = [];

        foreach ($data[0] as $str) {
            $str = preg_replace('/[0-9]+/', '', $str);
            array_push($new_month, $str);
        }
        $reporting_months = $new_month;
        $open_kemsa = $data[1];
        $receipts_kemsa = $data[2];
        $issues_kemsa = $data[3];
        $close_kemsa = $data[4];
        $monthly_consumption = $data[5];

        for ($i = 0; $i < count($reporting_months); $i++) {
            $update_data = [
                'open_kemsa' => $open_kemsa[$i],
                'receipts_kemsa' => $receipts_kemsa[$i],
                'issues_kemsa' => $issues_kemsa[$i],
                'close_kemsa' => $close_kemsa[$i],
                'monthly_consumption' => $monthly_consumption[$i],
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
        // redirect('manager/procurement/commodity');
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
            'receipts_kemsa' => array('Receipts from Suppliers'),
            'issues_kemsa' => array('Issues to Facility'),
            'close_kemsa' => array('Closing Balance'),
            'monthly_consumption' => array('Monthly Consumption'),
            'avg_issues' => array('Average Issues'),
            'avg_consumption' => array('Average Consumption'),
            'mos' => array('Months of Stock')
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
                $responses['open_kemsa'][] = '=' . $column_indices[$key - 1] . '4';
            }
            $responses['receipts_kemsa'][] = $value['receipts_kemsa'];
            $responses['issues_kemsa'][] = $value['issues_kemsa'];
            $responses['close_kemsa'][] = '=' . $column_indices[$key] . '1+' . $column_indices[$key] . '2-' . $column_indices[$key] . '3';
            $responses['monthly_consumption'][] = $value['monthly_consumption'];
            $responses['avg_issues'][] = $value['avg_issues'];
            $responses['avg_consumption'][] = $value['avg_consumption'];
            $responses['mos'][] = $value['mos'];
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

        $html_table = '<table class="table table-condensed table-striped table-bordered order_tbl">';
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

        $html_table = '<table class="table table-condensed table-striped table-bordered order_tbl_history">';
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
        $html_table = '<table class="table table-condensed table-striped table-bordered log_tbl">';
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
        if (!in_array($role, array('admin', 'national'))) {
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
            $this->updateSysLogs('Updated  (Order edited )');
            $input['action'] = 'edit';
        } else if ($input['action'] == 'delete') {
            unset($input['action']);
            $this->Procurement_model->delete_procurement_item($input['id']);
            $input['action'] = 'delete';
            $this->updateSysLogs('Deleted  (Order deleted )');
        }
        echo json_encode($input);
    }

    public function get_order_items() {
        $response = array();
        $item_urls = array(
            'status' => base_url() . 'API/procurement_status',
            'funding' => base_url() . 'API/funding_agent',
            'supplier' => base_url() . 'API/supplier'
        );
        foreach ($item_urls as $key => $item_url) {
            if ($key != 'status') {
                $response[$key][0] = 'Select one';
            }
            foreach (json_decode(file_get_contents($item_url), TRUE) as $values) {
                $response[$key][$values['id']] = $values['name'];
            }
        }
        echo json_encode($response);
    }

}

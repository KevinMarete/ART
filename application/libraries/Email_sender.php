<?php

class Email_sender extends MX_Controller {

    private $_config = [];

    function __construct() {
        parent::__construct();
        $config['mailtype'] = 'html';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = stripslashes('webartmanager2018@gmail.com');
        $config['smtp_pass'] = stripslashes('WebArt_052013');
        $this->_config = $config;
    }

    public function send_email($module, $action, $recepients, $names = '', $data_content) {


        $to_email = $this->session->userdata('email_address');
        $this->load->library('email', $this->_config);
        $this->email->set_newline("\r\n");
        $this->email->from('webartmanager2018@gmail.com', $module . ' Manager');
        $this->email->to('webartmanager2018@gmail.com');
        $this->email->cc($recepients);
        $this->email->subject($module . ' Manager | ' . $action);
        //$this->email->set_mailtype('html');
        $data['email_content'] = $data_content;
        $data['meeting_date'] = '14/' . date('m/Y');
        $data['reporting_period'] = date('F', mktime(0, 0, 0, date('m') - 1, 10)) . "-" . date('Y');
        $this->email->message($this->load->view('template/email/email_template', $data, TRUE));

        if ($this->email->send()) {
            $data['message'] = '<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> Committee emails sent <b>' . @$email_address . '</b></div>';
            $data['status'] = TRUE;
            $this->email->clear(TRUE);
        } else {
            $data['message'] = '<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Error!</strong> ' . $this->email->print_debugger() . '</div>';
            ;
            $data['status'] = FALSE;
        }
        // print_r($data);
    }

    public function send_email_reminders($module, $action, $recepients, $names = '', $data_content) {


        $to_email = $this->session->userdata('email_address');
        $this->load->library('email', $this->_config);
        $this->email->set_newline("\r\n");
        $this->email->from('webartmanager2018@gmail.com', $module . ' Manager');
        $this->email->to($recepients);
        $this->email->subject($module . ' Allocation Manager - Reminder Notice | ' . $action);
        //$this->email->set_mailtype('html');
        $data['email_content'] = $data_content;
        $data['meeting_date'] = '14/' . date('m/Y');
        $data['reporting_period'] = date('F', mktime(0, 0, 0, date('m') - 1, 10)) . "-" . date('Y');
        $this->email->message($this->load->view('template/email/email_template', $data, TRUE));

        if ($this->email->send()) {
            $data['message'] = '<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> Committee emails sent <b>' . @$email_address . '</b></div>';
            $data['status'] = TRUE;
            $this->email->clear(TRUE);
        } else {
            $data['message'] = '<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Error!</strong> ' . $this->email->print_debugger() . '</div>';
            ;
            $data['status'] = FALSE;
        }
        // print_r($data);
    }

    function sendProcurementEmail($contacts) {

        $this->load->library('email', $this->_config);
        $this->email->set_newline("\r\n");
        $this->email->from('webartmanager2018@gmail.com', 'Procurement Manager');
        $this->email->to('webartmanager2018@gmail.com');
        $this->email->cc($contacts);
        $this->email->subject('Procurement Planning Manager');
        $this->email->message('Hello, Please find attached minutes from the NASCOP Procurement Planning Meeting');
        $this->email->attach('public/minutes_pdf/minutes.pdf');
        if ($this->email->send()) {
            $this->email->clear(TRUE);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
    }

}

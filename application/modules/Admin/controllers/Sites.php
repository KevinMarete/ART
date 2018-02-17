<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends MX_Controller {

    public function index() {
        $data['content_view'] = 'pages/sites_view';
        $data['page_title'] = 'ART Dashboard | Sites';
        $this->load->view('template/template_view', $data);
    }

    public function save() {
        
        //Extract data from the post and set post variables
        $url = base_url('API/install/index_post');

        $fields = array(
            'version' => urlencode($_POST['version']),
            'setup_date' => urlencode($_POST['setup_date']),
            'upgrade_date' => urlencode($_POST['update_date']),
            'comments' => urlencode($_POST['category']),
            'contact_name' => urlencode($_POST['contact_name']),
            'contact_phone' => urlencode($_POST['contact_phone']),
            'emrs_used' => urlencode($_POST['emrs_used']),
            'active_patients' => urlencode($_POST['active_patients']),
            'is_internet' => urlencode($_POST['is_internet']),
            'is_usage' => urlencode($_POST['is_usage']),
            'facility_id' => urlencode($_POST['facility_id']),
            'user_id' => urlencode($_POST['user_id'])
        );

        //urlify the data
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set Url, number of post and post data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection        
        curl_close($ch);

        //redirect
        redirect('Admin/Sites');
    }

    public function update() {
        //Stub to update install
        redirect('sites');
    }

}

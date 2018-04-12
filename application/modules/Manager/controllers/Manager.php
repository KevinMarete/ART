<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {

	public function index()
	{	
		$this->load_page('user', 'login', 'Login');
	}
	
	public function load_page($module = 'user', $page = 'login', $title = 'Login')
	{
		$data['page_title'] = 'ART | '.$title;
		$this->load->view('pages/'.$module.'/'.$page.'_view', $data);
	}

	public function user_authenticate()
	{	
		$auth_url = base_url().'API/authenticate';
		$auth_data = array('email_address' => $this->input->post('email_address'), 'password' => md5($this->input->post('password')));
		
		$curl = new Curl\Curl();
		$curl->post($auth_url, $auth_data);

		if ($curl->error) {
			echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
		} else {
			echo '<pre>';
			echo json_encode($curl->response, JSON_PRETTY_PRINT);
			echo '</pre>';
		}
	}

	public function user_create_account()
	{
		
	}

	public function user_reset_account()
	{
		
	}

}
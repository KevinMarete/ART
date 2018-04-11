<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {
	
	public function index()
	{	
		$data['page_title'] = 'ART | Manager';
		$this->load->view('template/dashboard_view', $data);
    }
}
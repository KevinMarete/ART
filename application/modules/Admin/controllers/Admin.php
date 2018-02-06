<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	public function index()
	{	
		$this->load->view('login_view');
	}

	public function home()
	{	
		$data['content_view'] = 'dashboard_view';
		$data['page_title'] = 'ART Dashboard | Admin';
		$this->load->view('template/template_view', $data);
	}
	
}
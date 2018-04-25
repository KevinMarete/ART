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
	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends MX_Controller {

	public function index()
	{	
		$this->load_page('user', 'login', 'Login');
	}
	
	public function load_page($module = 'user', $page = 'login', $title = 'Login')
	{	
		if($page == 'register'){
			$data['roles'] = $this->db->get('tbl_role')->result_array();
		}
		$data['page_title'] = 'ART | '.$title;
		$this->load->view('pages/'.$module.'/'.$page.'_view', $data);
	}

	public function load_template($module = 'dashboard', $page = 'dashboard', $title = 'Dashboard')
	{	
		if($this->session->userdata('id')){
			$data['content_view'] = 'pages/'.$module.'/'.$page.'_view';
        	$data['page_title'] = 'ART | '.$title;
        	$this->load->view('template/template_view', $data);
		}else{
			redirect("manager/login");
		}	

	}
	
}
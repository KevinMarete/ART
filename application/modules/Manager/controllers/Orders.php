<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MX_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
    }

    public function assign_scope(){
    	$post_data['scope_id'] = $this->input->post('scope');
    	$post_data['role_id'] = $this->session->userdata('role_id');
    	$post_data['user_id'] = $this->session->userdata('id');

    	$response = $this->Orders_model->update_user_scope($post_data);
    	if($response['status']){
			$this->session->set_userdata('scope', $post_data['scope_id']);
			$message = '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						'.$response['message'].'</div>';
			
		}else{
			$message = '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> '.$response['message'].'</div>';
		}
		$this->session->set_flashdata('orders_msg', $message);
		redirect('manager/orders/assign');
    }

	public function get_orders()
	{	
		$response = $this->Orders_model->get_order_data($this->session->userdata('scope'),$this->session->userdata('role'));
		if($response['status']){
			echo json_encode(array('data' => $response['data']));
		}
	}

	public function get_reporting_rates(){
		$response = $this->Orders_model->get_reporting_data($this->session->userdata('scope'), date('Y-m-01'), date('Y-m-t'));
		if($response['status']){
			echo json_encode(array('data' => $response['data']));
		}
	}
		
}
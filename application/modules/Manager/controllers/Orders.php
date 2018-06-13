<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Orders_model');
	}
	
	public function updateOrder($orderid,$mapid)
	{	
		$updateArray = array();
		foreach ($_POST as $key => $value) {
			$vals = array(explode('-', $key)[0] => $value, 'id'=>explode('-', $key)[1]+0 );
			array_push($updateArray, $vals);
		}
		$response = $this->Orders_model->updateOrder($orderid, $mapid, $updateArray, $this->session->userdata('id'));
		echo $response['message'];
	}

	public function actionOrder($orderid,$mapid,$action)
	{	
		$response = $this->Orders_model->actionOrder($orderid, $mapid, $action, $this->session->userdata('id'));
		echo $response['message'];
	}

	public function get_orders()
	{	
		$response = $this->Orders_model->get_order_data($this->session->userdata('scope'),$this->session->userdata('role'));
		echo json_encode(array('data' => $response['data']));
	}

	public function get_reporting_rates($role = null, $scope = null, $allocation = null){
		$role = ($role) ? $role : $this->session->userdata('role');
		$scope = ($scope) ? $scope : $this->session->userdata('scope');
		$allocation = ($allocation) ? TRUE : FALSE;
		$response = $this->Orders_model->get_reporting_data($scope, $role, date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')), $allocation);
		echo json_encode(array('data' => $response['data']));
	}

	public function get_allocation(){
		$response = $this->Orders_model->get_allocation_data($this->session->userdata('scope'), $this->session->userdata('role'), date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')));
		echo json_encode(array('data' => $response['data']));
	}

	public function get_county_allocation($period_begin){
		$response = $this->Orders_model->get_county_allocation_data($this->session->userdata('scope'), $this->session->userdata('role'), $period_begin, date('Y-m-t', strtotime($period_begin)));
		echo json_encode(array('data' => $response['data']));
	}

	public function get_county_reporting_rates($role = null, $scope = null, $allocation = null){
		$role = ($role) ? $role : $this->session->userdata('role');
		$scope = ($scope) ? $scope : $this->session->userdata('scope');
		$allocation = ($allocation) ? TRUE : FALSE;
		$response = $this->Orders_model->get_county_reporting_data($scope, $role, date('Y-m-d', strtotime('first day of last month')), date('Y-m-d', strtotime('last day of last month')), $allocation);
		echo json_encode(array('data' => $response['data']));
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FtpService extends MX_Controller {

	function __construct() {
		ini_set("max_execution_time", "100000");
		ini_set("memory_limit", '2048M');
	}

	public function index()
	{
		$this->load->view('ftpservice_view');
	}

	public function upload()
	{	
		$message = '';
		$uploader = new Uploader();
	    $data = $uploader->upload($_FILES['files'], array(
	        'extensions' => $this->config->item('allowed_extensions'),
	        'required' => true,
	        'uploadDir' => $this->config->item('local_upload_dir'),
	        'title' => array('name'),
	        'removeFiles' => true,
	        'replace' => true
	    ));

	    if($data['isComplete']){
	        $info = $data['data'];

           	//FTP configuration
            $ftp_config['hostname'] = $this->config->item('hostname');
            $ftp_config['username'] = $this->config->item('username');
            $ftp_config['password'] = $this->config->item('password');
            $ftp_config['debug'] = $this->config->item('debug');

            foreach ($info['metas'] as $item) {
            	$file_name = $item['name'];
            	$source = $item['file'];
            	//Connect to the remote server
	            $this->ftp->connect($ftp_config);
	            //File upload path of remote server
	            $destination = $this->config->item('pending_dir').'/'.$file_name;
	            //Upload file to the remote server
	            $this->ftp->upload($source, ".".$destination);
	            //Close FTP connection
	            $this->ftp->close();
	            //Delete file from local server
	            @unlink($source);
	            //Embed message
	            $message .= '<div class="alert alert-success alert-dismissible alert-msg" role="alert">
				  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  				<strong>Success!</strong> '.$file_name.' was uploaded!
							</div>';
            }
	    }

	    if($data['hasErrors']){
	        $errors = $data['errors'];
	        foreach ($data['errors'] as $index => $errors) {
	        	foreach ($errors as $error) {
	        		$message .= '<div class="alert alert-danger alert-dismissible alert-msg" role="alert">
					  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  				<strong>Error!</strong> File not uploaded because, '.$error.'!
								</div>';
	        	}
	        }
	    }

	    $this->session->set_flashdata('ftp_upload_message', $message);
	    redirect('ftp');
	}


	public function get_files($directory){
		$ftp_config['hostname'] = $this->config->item('hostname');
        $ftp_config['username'] = $this->config->item('username');
        $ftp_config['password'] = $this->config->item('password');
        $ftp_config['debug'] = $this->config->item('debug');

		$this->ftp->connect($ftp_config);

		$files = $this->ftp->list_files($this->config->item($directory));

		$data = array('data' => array());
		foreach ($files as $file) {
			$data['data'][] = array(basename($file));
		}	
		echo json_encode($data);
	}

	public function analysis(){
		$pending_dir = $this->config->item('pending_dir');
		$local_upload_dir = $this->config->item('local_upload_dir');
		$completed_dir = $this->config->item('completed_dir');

		//FTP configuration
		$ftp_config['hostname'] = $this->config->item('hostname');
        $ftp_config['username'] = $this->config->item('username');
        $ftp_config['password'] = $this->config->item('password');
        $ftp_config['debug'] = $this->config->item('debug');

		$this->ftp->connect($ftp_config);

		$remote_files = $this->ftp->list_files($pending_dir);
		if(!empty($remote_files)){
			foreach ($remote_files as $remote_file) {
				$remote_file_base = basename($remote_file);
				$this->benchmark->mark('start');
				//Download file from ftp to local server
				$local_file = str_ireplace($pending_dir, $local_upload_dir, $remote_file);
				$this->ftp->download($remote_file, $local_file, 'ascii');
				//Extract data from local file
				$response[$remote_file_base] = $this->extract_data($local_file);
				$this->benchmark->mark('stop');
				$finish_time = gmdate("H:i:s", $this->benchmark->elapsed_time('start', 'stop'));
				if($response[$remote_file_base]['status']){
					//Move file to completed
					$new_remote_file = str_ireplace($pending_dir, $completed_dir, $remote_file);
					$move_status = $this->ftp->move($remote_file, $new_remote_file);
					if(!$move_status){
						//If cannot overwrite then delete the existing one
						$this->ftp->delete_file($new_remote_file);
						//Then move new file to 'completed'
						$this->ftp->move($remote_file, $new_remote_file);
					}
					$response[$remote_file_base]['message'] =  'SUCCESS: '.basename($local_file).' analyzed in ['.$finish_time.']<br/>';
				}else{
					$response[$remote_file_base]['message'] =  'ERROR: '.basename($local_file).' File failed in ['.$finish_time.']<br/>';
				}
				//Delete file from local server
				@unlink($local_file);
			}
		}else{
			$response = array('NO FILES' => array('status' => FALSE, 'sheets' => array(), 'message' => 'INFO: There are no pending files to be processed'));
		}

		//Close FTP Conncetion
		$this->ftp->close();

		echo json_encode($response);
	}

	public function extract_data($file_name)
	{	
		$status = array('status' => FALSE, 'sheets' => array());
		$status_data = array();
		$inputFileType = PHPExcel_IOFactory::identify($file_name);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader -> load($file_name);
		$target_sheets = $this->config->item('target_sheets');
		$all_sheets = $objReader->listWorksheetNames($file_name);
		$sheets = array_intersect($all_sheets, $target_sheets);
		
		foreach ($sheets as $sheet_name) {
			$arr = $objPHPExcel->getSheetByName($sheet_name)->toArray(null, true, true, true);
			$highestColumm = $objPHPExcel->getSheetByName($sheet_name)->getHighestColumn();
			$highestRow = $objPHPExcel->getSheetByName($sheet_name)->getHighestRow();
			if($sheet_name == 'Ordering Points'){
				$status_data[$sheet_name] = $this->get_ordering_points($arr, $highestColumm, $highestRow);
			}else if($sheet_name == 'Current patients by ART site'){
				$status_data[$sheet_name] = $this->get_current_art_patients($arr, $highestColumm, $highestRow);
			}else if($sheet_name == 'Stock Status'){
				$status_data[$sheet_name] = $this->get_mos_pipeline($arr, $highestColumm, $highestRow);	
			}else if($sheet_name == 'Facility Cons by ARV Medicine'){
				$status_data[$sheet_name] = $this->get_facility_consumption($arr, $highestColumm, $highestRow);
			}else if($sheet_name == 'Facility SOH by ARV Medicine'){
				$status_data[$sheet_name] = $this->get_facility_soh($arr, $highestColumm, $highestRow);	
			}
		}
		if(!in_array(FALSE, array_values($status_data))){
			$status['status'] = TRUE;
		}
		$status['sheets'] = $status_data;
		return $status;
	}

	public function get_ordering_points($arr, $highestColumm, $highestRow){
		$status = FALSE;
		$cfg = $this->config->item('ordering_points_cfg');	
		$start_row = $cfg['first_row'];
		$id_col = $cfg['id_col'];
		$code_col = $cfg['code_col'];
		$facility_col = $cfg['facility_col'];
		$county_col = $cfg['county_col'];

		for($i = $start_row; $i <= $highestRow; $i++){
			$id = $arr[$i][$id_col];
			$facility_code = $arr[$i][$code_col];
			$facility_name = $arr[$i][$facility_col];
			$county_name = $arr[$i][$county_col];
			if($id){
				//run proc
		    	$proc_sql = "CALL ".$cfg['proc_name']."('".$facility_code."','".$facility_name."','".$county_name."')";
		    	if ($this->db->simple_query($proc_sql)){
					$status = TRUE;
				}
			}
		}
		return $status;
	}

	public function get_current_art_patients($arr, $highestColumm, $highestRow){
		$status = FALSE;
		$cfg = $this->config->item('current_art_patients_cfg');
		$start_row = $cfg['first_row'];
		$period = explode($cfg['period_splitter'], $arr[$cfg['period_row']][$cfg['period_col']]);
		$period_month = ucwords($period[0]);
		$period_year = $period[1];
		$facility_col = $cfg['facility_col'];
		$id_col = $cfg['id_col'];
		$first_col = $cfg['first_col'];
		$cols = $this->excel_column_range($first_col, $highestColumm);
		$regimen_row = $cfg['regimen_row'];

		for($i = $start_row; $i <= $highestRow; $i++){
			$id = $arr[$i][$id_col];
			$facility_name = $arr[$i][$facility_col];
			if($id){
				foreach ($cols as $col) {
				    $regimen_code = $arr[$regimen_row][$col];
				    if($regimen_code){
				    	$patient_total = $arr[$i][$col];
				    	//run proc
				    	$proc_sql = "CALL ".$cfg['proc_name']."('".$facility_name."','".$regimen_code."','".$patient_total."','".$period_month."','".$period_year."')";
				    	if ($this->db->simple_query($proc_sql)){
							$status = TRUE;
						}
				    }
				}
			}
		}
		return $status;
	}

	public function get_mos_pipeline($arr, $highestColumm, $highestRow){
		$status = FALSE;
		$cfg = $this->config->item('mos_pipeline_cfg');
		$start_row = $cfg['first_row'];
		$id_col = $cfg['id_col'];
		$drug_col = $cfg['drug_col'];
		$packsize_col = $cfg['packsize_col'];
		$first_col = $cfg['first_col'];
		$cols = $this->excel_column_range($first_col, $highestColumm);
		$period_year = $arr[$cfg['year_row']][$cfg['year_col']];
		$month_row = $cfg['month_row'];

		for($i = $start_row; $i <= $highestRow; $i++){
			$id = $arr[$i][$id_col];
			$drug_name = $arr[$i][$drug_col];
			$packsize = $arr[$i][$packsize_col];
			if($id){
				foreach ($cols as $index => $col) {
					if($arr[$month_row][$col]){
						$period_month = ucwords(strtolower($arr[$month_row][$col]));
						//set total indices
						$issue_col = $cols[$index+$cfg['issue_index']];
						$soh_col = $cols[$index+$cfg['soh_index']];
						$supplier_col = $cols[$index+$cfg['supplier_index']];
						$received_col = $cols[$index+$cfg['received_index']];
						//get totals
						$issues_total = $arr[$i][$issue_col];
						$soh_total = $arr[$i][$soh_col];
						$supplier_total = $arr[$i][$supplier_col];
						$received_total = $arr[$i][$received_col];
						//run proc
				    	$proc_sql = "CALL ".$cfg['proc_name']."('".$drug_name."','".$packsize."','".$period_year."','".$period_month."','".$issues_total."','".$soh_total."','".$supplier_total."','".$received_total."')";
				    	if ($this->db->simple_query($proc_sql)){
							$status = TRUE;
						}
					}
				}	
			}
		}
		return $status;
	}

	public function get_facility_consumption($arr, $highestColumm, $highestRow){
		$status = FALSE;
		$cfg = $this->config->item('facility_consumption_cfg');
		$start_row = $cfg['first_row'];
		$period = explode($cfg['period_splitter'], $arr[$cfg['period_row']][$cfg['period_col']]);
		$period_month = ucwords($period[0]);
		$period_year = DateTime::createFromFormat('y', $period[1])->format('Y');
		$id_col = $cfg['id_col'];
		$facility_col = $cfg['facility_col'];
		$first_col = $cfg['first_col'];
		$cols = $this->excel_column_range($first_col, $highestColumm);
		$drug_row = $cfg['drug_row'];
		$packsize_row = $cfg['packsize_row'];

		for($i = $start_row; $i <= $highestRow; $i++){
			$id = $arr[$i][$id_col];
			$facility_name = $arr[$i][$facility_col];
			if($id){
				foreach ($cols as $col) {
				    $drug_name = $arr[$drug_row][$col];
					$packsize = $arr[$packsize_row][$col];
				    if($drug_name && $packsize){
				    	$consumption_total = $arr[$i][$col];
						//run proc
						$proc_sql = "CALL ".$cfg['proc_name']."('".$facility_name."','".$drug_name."','".$packsize."','".$period_year."','".$period_month."','".$consumption_total."')";
				    	if ($this->db->simple_query($proc_sql)){
							$status = TRUE;
						}
				    }
				}
			}
		}
		return $status;
	}

	public function get_facility_soh($arr, $highestColumm, $highestRow){
		$status = FALSE;
		$cfg = $this->config->item('facility_soh_cfg');
		$start_row = $cfg['first_row'];
		$period = explode($cfg['period_splitter'], $arr[$cfg['period_row']][$cfg['period_col']]);
		$period_month = ucwords($period[0]);
		$period_year = DateTime::createFromFormat('y', $period[1])->format('Y');
		$id_col = $cfg['id_col'];
		$facility_col = $cfg['facility_col'];
		$first_col = $cfg['first_col'];
		$cols = $this->excel_column_range($first_col, $highestColumm);
		$drug_row = $cfg['drug_row'];
		$packsize_row = $cfg['packsize_row'];

		for($i = $start_row; $i <= $highestRow; $i++){
			$id = $arr[$i][$id_col];
			$facility_name = $arr[$i][$facility_col];
			if($id){
				foreach ($cols as $col) {
				    $drug_name = $arr[$drug_row][$col];
					$packsize = $arr[$packsize_row][$col];
				    if($drug_name && $packsize){
				    	$soh_total = $arr[$i][$col];
				    	//run proc
				    	$proc_sql = "CALL ".$cfg['proc_name']."('".$facility_name."','".$drug_name."','".$packsize."','".$period_year."','".$period_month."','".$soh_total."')";
				    	if ($this->db->simple_query($proc_sql)){
							$status = TRUE;
						}
				    }
				}
			}
		}
		return $status;
	}

	public function excel_column_range($lower, $upper) {
		$cols = array();
    	++$upper;
    	for ($i = $lower; $i !== $upper; ++$i) {
        	$cols[] = $i;
    	}
    	return $cols;
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*FtpService*/
$config['hostname'] = 'localhost';
$config['username'] = 'kemsa';
$config['password'] = 'kemsa';
$config['debug'] = FALSE;
$config['pending_dir'] = '/pending/';
$config['completed_dir'] = '/completed/';
$config['allowed_extensions'] = array('xls', 'xlsx');
$config['local_upload_dir'] = 'public/uploads/';
$config['target_sheets'] = array(
	'Ordering Points', 
	'Current patients by ART site', 
	'Pipeline Commodity Consumption', 
	'Facility Cons by ARV Medicine', 
	'Facility SOH by ARV Medicine'
);
$config['ordering_points_cfg'] = array(
	'first_row' => 9,
	'id_col' => 'L',
	'code_col' => 'M',
	'facility_col' => 'N',
	'county_col' => 'O',
	'proc_name' => 'proc_save_ordering_sites'
);
$config['current_art_patients_cfg'] = array(
	'first_row' => 7,
	'id_col' => 'A',
	'facility_col' => 'B',
	'regimen_row' => 5,
	'period_row' => 4,
	'period_col' => 'B',
	'period_splitter' => '/',
	'first_col' => 'D',
	'proc_name' => 'proc_save_current_art_patients'
);
$config['pipeline_consumption_cfg'] = array(
	'first_row' => 10,
	'id_col' => 'A',
	'drug_col' => 'B',
	'packsize_col' => 'C',
	'year_row' => 6,
	'month_row' => 7,
	'first_col' => 'D',
	'proc_name' => 'proc_save_pipeline_consumption'
);
$config['facility_consumption_cfg'] = array(
	'first_row' => 9,
	'id_col' => 'A',
	'facility_col' => 'B',
	'drug_row' => 7,
	'packsize_row' => 8,
	'period_row' => 4,
	'period_col' => 'B',
	'period_splitter' => '-',
	'first_col' => 'D',
	'proc_name' => 'proc_save_facility_consumption'
);
$config['facility_soh_cfg'] = array(
	'first_row' => 9,
	'id_col' => 'A',
	'facility_col' => 'B',
	'drug_row' => 7,
	'packsize_row' => 8,
	'period_row' => 4,
	'period_col' => 'B',
	'period_splitter' => '-',
	'first_col' => 'D',
	'proc_name' => 'proc_save_facility_soh'
);
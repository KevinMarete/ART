<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*patient_by_regimen_chart*/
$config['patient_by_regimen_chartview'] = 'table_view';
$config['patient_by_regimen_title'] = 'Patient Numbers by Regimen';
$config['patient_by_regimen_yaxis_title'] = 'No. of Patients';
$config['patient_by_regimen_source'] = 'Source: www.nascop.org';
$config['patient_by_regimen_has_drilldown'] = FALSE;
$config['patient_by_regimen_xaxis_title'] = '';
$config['patient_by_regimen_view_name'] = 'tbl_dashboard_patient';
$config['patient_by_regimen_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility', 'regimen');
$config['patient_by_regimen_filters_default'] = array(
	'data_year' => array('2016'), 
	'data_month' => array('Oct'),
	'regimen' => array(
		'AF1A | AZT + 3TC + NVP',
		'AF1B | AZT + 3TC + EFV',
		'AF2A | TDF + 3TC + NVP',
		'AF2B | TDF + 3TC + EFV',
		'CF1A | AZT + 3TC + NVP',
		'CF1B | AZT + 3TC + EFV',
		'CF2A | ABC + 3TC + NVP',
		'CF2B | ABC + 3TC + EFV'
	)
);

/*stock_status_chart*/
$config['stock_status_chartview'] = 'charts/stacked_bar_view';
$config['stock_status_title'] = 'National Stock Status';
$config['stock_status_yaxis_title'] = 'Months of Stock(MOS)';
$config['stock_status_source'] = 'Source: www.nascop.org';
$config['stock_status_has_drilldown'] = FALSE;
$config['stock_status_xaxis_title'] = '';
$config['stock_status_view_name'] = 'tbl_dashboard_mos';
$config['stock_status_filters'] = array('data_year', 'data_month', 'drug');
$config['stock_status_filters_default'] = array(
	'data_year' => array('2016'), 
	'data_month' => array('Oct'), 
	'drug' => array(
		'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) FDC 60/30/50mg tabs(60)',
		'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) FDC 300/150/200mg tabs(60)',
		'Zidovudine/Lamivudine(AZT/3TC) 60 mg/30mg FDC tabs(60)',
		'Zidovudine/Lamivudine (AZT/3TC) FDC 300/150mg tabs(60)',
		'Zidovudine liquid (AZT) 10mg/ml(1 * 240ml)'
	)
);

/*national_mos_chart*/
$config['national_mos_chartview'] = 'charts/stacked_bar_view';
$config['national_mos_title'] = 'National Commodity Months of Stock(MOS)';
$config['national_mos_yaxis_title'] = 'Months of Stock(MOS)';
$config['national_mos_source'] = 'Source: www.nascop.org';
$config['national_mos_has_drilldown'] = FALSE;
$config['national_mos_xaxis_title'] = '';
$config['national_mos_view_name'] = 'tbl_dashboard_mos';
$config['national_mos_filters'] = array('data_year', 'data_month', 'drug');
$config['national_mos_filters_default'] = array(
	'data_year' => array('2016'), 
	'data_month' => array('Oct'), 
	'drug' => array(
		'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) FDC 60/30/50mg tabs(60)',
		'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) FDC 300/150/200mg tabs(60)',
		'Zidovudine/Lamivudine(AZT/3TC) 60 mg/30mg FDC tabs(60)',
		'Zidovudine/Lamivudine (AZT/3TC) FDC 300/150mg tabs(60)',
		'Zidovudine liquid (AZT) 10mg/ml(1 * 240ml)'
	)
);

/*drug_consumption_trend_chart*/
$config['drug_consumption_trend_chartview'] = 'charts/line_view';
$config['drug_consumption_trend_title'] = 'Commodity Consumption Trend';
$config['drug_consumption_trend_yaxis_title'] = 'No. of Packs';
$config['drug_consumption_trend_source'] = 'Source: www.nascop.org';
$config['drug_consumption_trend_has_drilldown'] = FALSE;
$config['drug_consumption_trend_xaxis_title'] = '';
$config['drug_consumption_trend_view_name'] = 'tbl_dashboard_consumption';
$config['drug_consumption_trend_filters'] = array('county', 'sub_county', 'facility', 'drug');
$config['drug_consumption_trend_filters_default'] = array(
	'drug' => array(
		'Abacavir (ABC) 300mg tabs(60)', 
		'Lamivudine (3TC) 150mg Tabs(60)'
	)
);

/*patient_in_care_chart*/
$config['patient_in_care_chartview'] = 'charts/column_drilldown_view';
$config['patient_in_care_title'] = 'Patients Numbers in Treatment';
$config['patient_in_care_yaxis_title'] = 'No. of Patients';
$config['patient_in_care_source'] = 'Source: www.nascop.org';
$config['patient_in_care_has_drilldown'] = TRUE;
$config['patient_in_care_xaxis_title'] = 'County';
$config['patient_in_care_view_name'] = 'tbl_dashboard_patient';
$config['patient_in_care_filters'] = array('data_year', 'data_month', 'regimen_category', 'regimen');
$config['patient_in_care_filters_default'] = array(
	'data_year' => array('2017'), 
	'data_month' => array('Jan'), 
	'regimen_category' => array('Adult ART')
);

/*patient_regimen_category_chart*/
$config['patient_regimen_category_chartview'] = 'charts/bar_drilldown_view';
$config['patient_regimen_category_title'] = 'Patients Numbers By Age & Regimen Category';
$config['patient_regimen_category_yaxis_title'] = 'No. of Patients';
$config['patient_regimen_category_source'] = 'Source: www.nascop.org';
$config['patient_regimen_category_has_drilldown'] = TRUE;
$config['patient_regimen_category_xaxis_title'] = 'Regimen Category';
$config['patient_regimen_category_view_name'] = 'tbl_dashboard_patient';
$config['patient_regimen_category_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility');
$config['patient_regimen_category_filters_default'] = array(
	'data_year' => array('2017'), 
	'data_month' => array('Jan')
);

/*nrti_drugs_in_regimen_chart*/
$config['nrti_drugs_in_regimen_chartview'] = 'charts/pie_view';
$config['nrti_drugs_in_regimen_title'] = 'Patient Proportions By NRTI Drugs in Regimen';
$config['nrti_drugs_in_regimen_yaxis_title'] = 'No. of Patients';
$config['nrti_drugs_in_regimen_source'] = 'Source: www.nascop.org';
$config['nrti_drugs_in_regimen_has_drilldown'] = TRUE;
$config['nrti_drugs_in_regimen_xaxis_title'] = 'Drugs';
$config['nrti_drugs_in_regimen_view_name'] = 'tbl_dashboard_patient';
$config['nrti_drugs_in_regimen_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility', 'nrti_drug');
$config['nrti_drugs_in_regimen_filters_default'] = array(
	'data_year' => array('2017'), 
	'data_month' => array('Jan')
);

/*nnrti_drugs_in_regimen_chart*/
$config['nnrti_drugs_in_regimen_chartview'] = 'charts/pie_view';
$config['nnrti_drugs_in_regimen_title'] = 'Patient Proportions By NNRTI/PI/INSTI Drugs in Regimen';
$config['nnrti_drugs_in_regimen_yaxis_title'] = 'No. of Patients';
$config['nnrti_drugs_in_regimen_source'] = 'Source: www.nascop.org';
$config['nnrti_drugs_in_regimen_has_drilldown'] = TRUE;
$config['nnrti_drugs_in_regimen_xaxis_title'] = 'Drugs';
$config['nnrti_drugs_in_regimen_view_name'] = 'tbl_dashboard_patient';
$config['nnrti_drugs_in_regimen_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility', 'nnrti_drug');
$config['nnrti_drugs_in_regimen_filters_default'] = array(
	'data_year' => array('2017'), 
	'data_month' => array('Jan')
);

/*patient_scaleup_chart*/
$config['patient_scaleup_chartview'] = 'charts/combined_view';
$config['patient_scaleup_title'] = 'Patient Scaleup Trend';
$config['patient_scaleup_yaxis_title'] = 'No. of Patients';
$config['patient_scaleup_source'] = 'Source: www.nascop.org';
$config['patient_scaleup_has_drilldown'] = FALSE;
$config['patient_scaleup_xaxis_title'] = '';
$config['patient_scaleup_view_name'] = 'tbl_dashboard_patient';
$config['patient_scaleup_filters'] = array('data_year', 'county', 'sub_county', 'facility', 'regimen_service');
$config['patient_scaleup_filters_default'] = array(
	'data_year' => array('2016', '2017'), 
	'regimen_service' => array('ART')
);
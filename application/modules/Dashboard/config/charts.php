<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*patient_by_regimen_chart*/
$config['patient_by_regimen_chartview'] = 'table_view';
$config['patient_by_regimen_title'] = 'Patient Numbers by Regimen';
$config['patient_by_regimen_yaxis_title'] = 'No. of Patients';
$config['patient_by_regimen_source'] = 'Source: www.nascop.org';
$config['patient_by_regimen_has_drilldown'] = FALSE;
$config['patient_by_regimen_xaxis_title'] = '';
$config['patient_by_regimen_filters'] = array('period_year', 'period_month', 'c.id', 'sb.id', 'f.id', 'r.id');
$config['patient_by_regimen_filters_default'] = array(
	'period_year' => array('2017'), 
	'period_month' => array('May'),
	'r.id' => array(1, 2, 3, 4, 22, 23, 26, 27)
);

/*stock_status_chart*/
$config['stock_status_chartview'] = 'charts/stacked_bar_view';
$config['stock_status_title'] = 'National Stock Status';
$config['stock_status_yaxis_title'] = 'Months of Stock(MOS)';
$config['stock_status_source'] = 'Source: www.nascop.org';
$config['stock_status_has_drilldown'] = FALSE;
$config['stock_status_xaxis_title'] = '';
$config['stock_status_filters'] = array('period_year', 'period_month', 'drug_id');
$config['stock_status_filters_default'] = array(
	'period_year' => array('2017'), 
	'period_month' => array('May'), 
	'drug_id' => array(69, 70, 67, 68, 66)
);

/*national_mos_chart*/
$config['national_mos_chartview'] = 'charts/stacked_bar_view';
$config['national_mos_title'] = 'National Commodity Months of Stock(MOS)';
$config['national_mos_yaxis_title'] = 'Months of Stock(MOS)';
$config['national_mos_source'] = 'Source: www.nascop.org';
$config['national_mos_has_drilldown'] = FALSE;
$config['national_mos_xaxis_title'] = '';
$config['national_mos_filters'] = array('period_year', 'period_month', 'drug_id');
$config['national_mos_filters_default'] = array(
	'period_year' => array('2017'), 
	'period_month' => array('May'), 
	'drug_id' => array(69, 70, 67, 68, 66)
);

/*drug_consumption_trend_chart*/
$config['drug_consumption_trend_chartview'] = 'charts/line_view';
$config['drug_consumption_trend_title'] = 'Commodity Consumption Trend';
$config['drug_consumption_trend_yaxis_title'] = 'No. of Packs';
$config['drug_consumption_trend_source'] = 'Source: www.nascop.org';
$config['drug_consumption_trend_has_drilldown'] = FALSE;
$config['drug_consumption_trend_xaxis_title'] = '';
$config['drug_consumption_trend_view_name'] = 'tbl_consumption';
$config['drug_consumption_trend_filters'] = array('county_id', 'subcounty_id', 'facility_id', 'drug_id');
$config['drug_consumption_trend_filters_default'] = array(
	'drug_id' => array(1, 38)
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
	'data_month' => array('May'), 
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
$config['patient_scaleup_filters'] = array('period_year', 'county_id', 'subcounty_id', 'facility_id', 'service_id');
$config['patient_scaleup_filters_default'] = array(
	'period_year' => array('2017'), 
	'service_id' => array(1)
);
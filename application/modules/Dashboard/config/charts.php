<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*pipeline_consumption_chart*/
$config['pipeline_consumption_chart_type'] = 'bar';
$config['pipeline_consumption_total_chart_metric_title'] = 'total';
$config['pipeline_consumption_total_metric_prefix'] = ' (Packs)';
$config['pipeline_consumption_view_name'] = 'vw_consumption_pipeline';
$config['pipeline_consumption_color_point'] = TRUE;
$config['pipeline_consumption_x_variable'] = 'drug';
$config['pipeline_consumption_filters'] = array('drug', 'data_month', 'data_year');

/*facility_consumption_chart*/
$config['facility_consumption_chart_type'] = 'column';
$config['facility_consumption_total_chart_metric_title'] = 'total';
$config['facility_consumption_total_metric_prefix'] = ' (Packs)';
$config['facility_consumption_view_name'] = 'vw_consumption_facility';
$config['facility_consumption_color_point'] = TRUE;
$config['facility_consumption_x_variable'] = 'drug';
$config['facility_consumption_filters'] = array('drug', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*facility_soh_chart*/
$config['facility_soh_chart_type'] = 'pie';
$config['facility_soh_total_chart_metric_title'] = 'total';
$config['facility_soh_total_metric_prefix'] = ' (Packs)';
$config['facility_soh_view_name'] = 'vw_soh_facility';
$config['facility_soh_color_point'] = TRUE;
$config['facility_soh_x_variable'] = 'drug';
$config['facility_soh_filters'] = array('drug', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*adult_art_chart*/
$config['adult_art_chart_type'] = 'pie';
$config['adult_art_total_chart_metric_title'] = 'total';
$config['adult_art_total_metric_prefix'] = ' (Patients)';
$config['adult_art_view_name'] = 'vw_patients_adult_art';
$config['adult_art_color_point'] = TRUE;
$config['adult_art_x_variable'] = 'regimen';
$config['adult_art_filters'] = array('regimen', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*paed_art_chart*/
$config['paed_art_chart_type'] = 'pie';
$config['paed_art_total_chart_metric_title'] = 'total';
$config['paed_art_total_metric_prefix'] = ' (Patients)';
$config['paed_art_view_name'] = 'vw_patients_paed_art';
$config['paed_art_color_point'] = TRUE;
$config['paed_art_x_variable'] = 'regimen';
$config['paed_art_filters'] = array('regimen', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*oi_chart*/
$config['oi_chart_type'] = 'area';
$config['oi_total_chart_metric_title'] = 'total';
$config['oi_total_metric_prefix'] = ' (Patients)';
$config['oi_view_name'] = 'vw_patients_oi';
$config['oi_color_point'] = FALSE;
$config['oi_x_variable'] = 'regimen';
$config['oi_filters'] = array('regimen', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*patient_regimen_category_chart*/
$config['patient_regimen_category_chart_type'] = 'bar';
$config['patient_regimen_category_total_chart_metric_title'] = 'total';
$config['patient_regimen_category_total_metric_prefix'] = ' (Patients)';
$config['patient_regimen_category_view_name'] = 'vw_patients_regimen_category';
$config['patient_regimen_category_color_point'] = TRUE;
$config['patient_regimen_category_x_variable'] = 'regimen_category';
$config['patient_regimen_category_filters'] = array('regimen_category', 'regimen', 'facility', 'sub_county', 'county', 'data_month', 'data_year');

/*patient_site_chart*/
$config['patient_site_chart_type'] = 'column';
$config['patient_site_total_chart_metric_title'] = 'total';
$config['patient_site_total_metric_prefix'] = ' (Patients)';
$config['patient_site_view_name'] = 'vw_patients_site';
$config['patient_site_color_point'] = TRUE;
$config['patient_site_x_variable'] = 'facility';
$config['patient_site_filters'] = array('regimen', 'facility', 'sub_county', 'county', 'data_month', 'data_year');
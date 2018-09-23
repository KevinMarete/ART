<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//reporting_rates_chart
$config['reporting_rates_chart_chartview'] = 'pages/dashboard/charts/column_rotated_label_view';
$config['reporting_rates_chart_title'] = 'Reporting Rates Trend';
$config['reporting_rates_chart_yaxis_title'] = 'No. of Orders';
$config['reporting_rates_chart_source'] = 'Source: www.commodities.nascop.org';
$config['reporting_rates_chart_has_drilldown'] = FALSE;
$config['reporting_rates_chart_filters'] = array('county', 'subcounty');
$config['reporting_rates_chart_filters_default'] = array();

//patients_by_regimen_chart
$config['patients_by_regimen_chart_chartview'] = 'pages/dashboard/charts/bar_drilldown_view';
$config['patients_by_regimen_chart_title'] = 'Regimen Patient Numbers';
$config['patients_by_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['patients_by_regimen_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patients_by_regimen_chart_has_drilldown'] = TRUE;
$config['patients_by_regimen_chart_filters'] = array('county', 'subcounty', 'data_date');
$config['patients_by_regimen_chart_filters_default'] = array(
	'data_date' => date('Y-m-d', strtotime('first day of last month'))
);

//drug_consumption_allocation_trend_chart
$config['drug_consumption_allocation_trend_chart_chartview'] = 'pages/dashboard/charts/combined_column_line_view';
$config['drug_consumption_allocation_trend_chart_title'] = 'Commodity Consumption/Allocation Trend';
$config['drug_consumption_allocation_trend_chart_yaxis_title'] = 'No. of Packs';
$config['drug_consumption_allocation_trend_chart_source'] = 'Source: www.commodities.nascop.org';
$config['drug_consumption_allocation_trend_chart_has_drilldown'] = FALSE;
$config['drug_consumption_allocation_trend_chart_filters'] = array('county', 'subcounty', 'drug');
$config['drug_consumption_allocation_trend_chart_filters_default'] = array(
	'drug' => array('Dolutegravir (DTG) 50mg Tabs')
);



$config['stock_status_trend_chart_chartview'] = 'pages/dashboard/charts/combined_column_line_view_1';
$config['stock_status_trend_chart_title'] = 'Stock On Hand Trend';
$config['stock_status_trend_yaxis_title'] = 'Stock Levels';
$config['stock_status_trend_chart_source'] = 'Source: www.commodities.nascop.org';
$config['stock_status_trend_chart_has_drilldown'] = FALSE;
$config['stock_status_trend_chart_filters'] = array('county', 'subcounty', 'drug');
$config['stock_status_trend_chart_filters_default'] = array(
	'drug' => array('Dolutegravir (DTG) 50mg Tabs')
);

//facility_adt_version_distribution_chart
$config['facility_adt_version_distribution_chart_chartview'] = 'pages/dashboard/charts/column_view';
$config['facility_adt_version_distribution_chart_title'] = 'ADT Site(s) Installation (By Version)';
$config['facility_adt_version_distribution_chart_yaxis_title'] = 'No. of installations';
$config['facility_adt_version_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['facility_adt_version_distribution_chart_has_drilldown'] = FALSE;
$config['facility_adt_version_distribution_chart_filters'] = array('county', 'subcounty');
$config['facility_adt_version_distribution_chart_filters_default'] = array();

//facility_internet_access_chart
$config['facility_internet_access_chart_chartview'] = 'pages/dashboard/charts/pie_view';
$config['facility_internet_access_chart_title'] = 'Internet Availability';
$config['facility_internet_access_chart_yaxis_title'] = '% of Internet Available';
$config['facility_internet_access_chart_source'] = 'Source: www.commodities.nascop.org';
$config['facility_internet_access_chart_has_drilldown'] = FALSE;
$config['facility_internet_access_chart_filters'] = array('county', 'subcounty');
$config['facility_internet_access_chart_filters_default'] = array();
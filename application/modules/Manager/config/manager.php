<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Default values
$config['data_year'] = date('Y', strtotime('-1 month'));
$config['data_month'] = date('M', strtotime('-5 month'));
$config['data_date'] = date('Y-m-01', strtotime('-1 month'));

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
$config['patients_by_regimen_chart_filters'] = array('data_year', 'data_month', 'county', 'subcounty', 'regimen');
$config['patients_by_regimen_chart_filters_default'] = array(
	'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//drug_consumption_allocation_trend_chart
$config['drug_consumption_allocation_trend_chart_chartview'] = 'pages/dashboard/charts/combined_column_line_view';
$config['drug_consumption_allocation_trend_chart_title'] = 'Commodity Consumption/Allocation Trend';
$config['drug_consumption_allocation_trend_chart_yaxis_title'] = 'No. of Packs';
$config['drug_consumption_allocation_trend_chart_source'] = 'Source: www.commodities.nascop.org';
$config['drug_consumption_allocation_trend_chart_has_drilldown'] = FALSE;
$config['drug_consumption_allocation_trend_chart_filters'] = array('data_date', 'county', 'subcounty', 'drug');
$config['drug_consumption_allocation_trend_chart_filters_default'] = array(
	'data_date' => $config['data_date'],
	'drug' => array('Dolutegravir (DTG) 50mg Tabs')
);

$config['stock_status_trend_chart_chartview'] = 'pages/dashboard/charts/combined_column_line_view_1';
$config['stock_status_trend_chart_title'] = 'Stock On Hand / Months Of Stock (MOS) Trend';
$config['stock_status_trend_yaxis_title'] = 'Stock Levels / Months Of Stock (MOS)';
$config['stock_status_trend_chart_source'] = 'Source: www.commodities.nascop.org';
$config['stock_status_trend_chart_has_drilldown'] = FALSE;
$config['stock_status_trend_chart_filters'] = array('data_date', 'county', 'subcounty', 'drug');
$config['stock_status_trend_chart_filters_default'] = array(
	'data_date' => $config['data_date'],
	'drug' => array('Dolutegravir (DTG) 50mg Tabs')
);
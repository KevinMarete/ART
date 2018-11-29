<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Default values
$config['data_year'] = date('Y', strtotime('-1 month'));
$config['data_month'] = date('M', strtotime('-1 month'));
$config['data_date'] = date('Y-m-01', strtotime('-1 month'));
$config['drug'] = 'Dolutegravir (DTG) 50mg Tabs';

//reporting_rates_chart
$config['reporting_rates_chart_chartview'] = 'pages/dashboard/charts/column_rotated_label_view';
$config['reporting_rates_chart_title'] = 'Reporting Rates Trend';
$config['reporting_rates_chart_yaxis_title'] = 'No. of Orders';
$config['reporting_rates_chart_source'] = 'Source: www.commodities.nascop.org';
$config['reporting_rates_chart_has_drilldown'] = FALSE;
$config['reporting_rates_chart_filters'] = array('data_date', 'county', 'sub_county', 'facility');
$config['reporting_rates_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
);

//patients_by_regimen_chart
$config['patients_by_regimen_chart_chartview'] = 'pages/dashboard/charts/bar_drilldown_view';
$config['patients_by_regimen_chart_title'] = 'Regimen Patient Numbers';
$config['patients_by_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['patients_by_regimen_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patients_by_regimen_chart_has_drilldown'] = TRUE;
$config['patients_by_regimen_chart_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility');
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
$config['drug_consumption_allocation_trend_chart_filters'] = array('data_date', 'county', 'sub_county', 'facility', 'drug');
$config['drug_consumption_allocation_trend_chart_filters_default'] = array(
	'data_date' => $config['data_date'],
	'drug' => $config['drug']
);

//stock_status_trend_chart
$config['stock_status_trend_chart_chartview'] = 'pages/dashboard/charts/combined_column_line_view_1';
$config['stock_status_trend_chart_title'] = 'Stock On Hand / Months Of Stock (MOS) Trend';
$config['stock_status_trend_yaxis_title'] = 'Stock Levels / Months Of Stock (MOS)';
$config['stock_status_trend_chart_source'] = 'Source: www.commodities.nascop.org';
$config['stock_status_trend_chart_has_drilldown'] = FALSE;
$config['stock_status_trend_chart_filters'] = array('data_date', 'county', 'sub_county', 'facility', 'drug');
$config['stock_status_trend_chart_filters_default'] = array(
	'data_date' => $config['data_date'],
	'drug' => $config['drug']
);

//low_mos_commodity_table
$config['low_mos_commodity_table_chartview'] = 'pages/dashboard/charts/table_view';
$config['low_mos_commodity_table_title'] = 'Low MOS Commodities in Facilities';
$config['low_mos_commodity_table_yaxis_title'] = 'No. of Packs';
$config['low_mos_commodity_table_source'] = 'Source: www.commodities.nascop.org';
$config['low_mos_commodity_table_has_drilldown'] = FALSE;
$config['low_mos_commodity_table_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility', 'drug');
$config['low_mos_commodity_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'drug' => $config['drug']
);

//high_mos_commodity_table
$config['high_mos_commodity_table_chartview'] = 'pages/dashboard/charts/table_view';
$config['high_mos_commodity_table_title'] = 'High MOS Commodities in Facilities';
$config['high_mos_commodity_table_yaxis_title'] = 'No. of Packs';
$config['high_mos_commodity_table_source'] = 'Source: www.commodities.nascop.org';
$config['high_mos_commodity_table_has_drilldown'] = FALSE;
$config['high_mos_commodity_table_filters'] = array('data_year', 'data_month', 'county', 'sub_county', 'facility', 'drug');
$config['high_mos_commodity_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'drug' => $config['drug']
);
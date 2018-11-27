<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Default values
$config['data_year'] = date('Y', strtotime('-1 month'));
$config['data_month'] = date('M', strtotime('-1 month'));
$config['data_month_full'] = date('F', strtotime('-1 month'));
$config['data_date'] = date('Y-m-01', strtotime('-1 month'));
$config['drug'] = 'Dolutegravir (DTG) 50mg Tabs';

$config['committee_names']=['Alphonce Ochieng'];
$config['committee_emails']=['alpho07@gmail.com'];

//consumption_issues_chart
$config['consumption_issues_chart_chartview'] = 'pages/procurement/charts/line_view';
$config['consumption_issues_chart_title'] = 'Average Consumption/Issues Trend';
$config['consumption_issues_chart_yaxis_title'] = 'No. of Packs';
$config['consumption_issues_chart_source'] = 'Source: www.commodities.nascop.org';
$config['consumption_issues_chart_has_drilldown'] = FALSE;
$config['consumption_issues_chart_filters'] = array('data_date', 'drug');
$config['consumption_issues_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//actual_consumption_issues_chart
$config['actual_consumption_issues_chart_chartview'] = 'pages/procurement/charts/combined_column_view';
$config['actual_consumption_issues_chart_title'] = 'Actual Consumption/Issues Trend';
$config['actual_consumption_issues_chart_yaxis_title'] = 'No. of Packs';
$config['actual_consumption_issues_chart_source'] = 'Source: www.commodities.nascop.org';
$config['actual_consumption_issues_chart_has_drilldown'] = FALSE;
$config['actual_consumption_issues_chart_filters'] = array('data_date', 'drug');
$config['actual_consumption_issues_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//kemsa_soh_chart
$config['kemsa_soh_chart_chartview'] = 'pages/procurement/charts/combined_column_line_plotlines_view';
$config['kemsa_soh_chart_title'] = 'KEMSA Stock on Hand Trend';
$config['kemsa_soh_chart_yaxis_title'] = 'No. of Packs';
$config['kemsa_soh_chart_source'] = 'Source: www.commodities.nascop.org';
$config['kemsa_soh_chart_has_drilldown'] = FALSE;
$config['kemsa_soh_chart_filters'] = array('data_date', 'drug');
$config['kemsa_soh_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//adult_patients_on_drug_chart
$config['adult_patients_on_drug_chart_chartview'] = 'pages/procurement/charts/line_view';
$config['adult_patients_on_drug_chart_title'] = 'Adult Patients on Drug Trend';
$config['adult_patients_on_drug_chart_yaxis_title'] = 'No. of Patients';
$config['adult_patients_on_drug_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adult_patients_on_drug_chart_has_drilldown'] = FALSE;
$config['adult_patients_on_drug_chart_filters'] = array('data_date', 'drug');
$config['adult_patients_on_drug_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//paed_patients_on_drug_chart
$config['paed_patients_on_drug_chart_chartview'] = 'pages/procurement/charts/line_view';
$config['paed_patients_on_drug_chart_title'] = 'Paediatric Patients on Drug Trend';
$config['paed_patients_on_drug_chart_yaxis_title'] = 'No. of Patients';
$config['paed_patients_on_drug_chart_source'] = 'Source: www.commodities.nascop.org';
$config['paed_patients_on_drug_chart_has_drilldown'] = FALSE;
$config['paed_patients_on_drug_chart_filters'] = array('data_date', 'drug');
$config['paed_patients_on_drug_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//stock_status_chart
$config['stock_status_chart_chartview'] = 'pages/procurement/charts/stacked_bar_country_view';
$config['stock_status_chart_title'] = 'Stocks Status As at End of '.$config['data_month_full']."-".$config['data_year'];
$config['stock_status_chart_yaxis_title'] = 'Stock Quantity';
$config['stock_status_chart_source'] = 'Source: www.commodities.nascop.org';
$config['stock_status_chart_has_drilldown'] = FALSE;
$config['stock_status_chart_filters'] = array('data_date', 'drug');
$config['stock_status_chart_filters_default'] = array(
     'data_date' => $config['data_date'], 
    'drug' => array(
        $config['drug']
    )
);

//expected_delivery_chart
$config['expected_delivery_chart_chartview'] = 'pages/procurement/charts/combined_column_line_view';
$config['expected_delivery_chart_title'] = 'Expected Delivery';
$config['expected_delivery_chart_yaxis_title'] = 'No. of Patients';
$config['expected_delivery_chart_source'] = 'Source: www.commodities.nascop.org';
$config['expected_delivery_chart_has_drilldown'] = FALSE;
$config['expected_delivery_chart_filters'] = array('data_date', 'drug');
$config['expected_delivery_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        $config['drug']
    )
);

//Committee emails
$config['committee_emails'] = "alpho07@gmail.com,awstra07@gmail.com,oneshopke@gmail.com";

//Approvers
$config['Kiambu'] = "alpho07@gmail.com";


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Default values
$config['data_year'] = '2017';
$config['data_month'] = 'Dec';
$config['data_date'] = '2017-12-01';

//patient_scaleup_chart
$config['patient_scaleup_chart_chartview'] = 'charts/combined_column_line_view';
$config['patient_scaleup_chart_title'] = 'Patient (ART) Scaleup Trend';
$config['patient_scaleup_chart_yaxis_title'] = 'No. of Patients';
$config['patient_scaleup_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patient_scaleup_chart_has_drilldown'] = FALSE;
$config['patient_scaleup_chart_xaxis_title'] = '';
$config['patient_scaleup_chart_filters'] = array('data_date', 'county');
$config['patient_scaleup_chart_filters_default'] = array(
	'data_date' => $config['data_date']
);

//patient_services_by_county_chart
$config['patient_services_chart_chartview'] = 'charts/stacked_column_view';
$config['patient_services_chart_title'] = 'Patient Services by County';
$config['patient_services_chart_yaxis_title'] = 'No. of Patients';
$config['patient_services_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patient_services_chart_has_drilldown'] = FALSE;
$config['patient_services_chart_xaxis_title'] = '';
$config['patient_services_chart_filters'] = array('data_year', 'data_month', 'county');
$config['patient_services_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
	'data_month' => $config['data_month']  
);

//national_mos_chart
$config['national_mos_chart_chartview'] = 'charts/stacked_bar_view';
$config['national_mos_chart_title'] = 'National Commodity Months of Stock(MOS)';
$config['national_mos_chart_yaxis_title'] = 'Months of Stock(MOS)';
$config['national_mos_chart_source'] = 'Source: www.commodities.nascop.org';
$config['national_mos_chart_has_drilldown'] = FALSE;
$config['national_mos_chart_xaxis_title'] = '';
$config['national_mos_chart_filters'] = array('data_year', 'data_month', 'drug');
$config['national_mos_chart_filters_default'] = array(
	'data_year' => $config['data_year'], 
	'data_month' => $config['data_month'], 
	'drug' => array(
        'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) 60/30/50mg FDC Tabs',
        'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) 300/150/200mg FDC Tabs',
        'Zidovudine/Lamivudine (AZT/3TC) 60/30mg FDC Tabs',
        'Zidovudine/Lamivudine (AZT/3TC) 300/150mg FDC Tabs',
        'Zidovudine (AZT) 10mg/ml Liquid')
);
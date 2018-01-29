<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* default values */
$data_year = '2017';
$data_month = 'Sep';
$data_date = $data_year.'-'.$data_month;
$counties = ['baringo','bomet','bungoma','busia','elgeyo marakwet','embu','garissa','homa bay','isiolo','kajiado','kakamega','kericho','kiambu','kilifi','kirinyaga','kisii','kisumu','kitui','kwale','laikipia','lamu','machakos','makueni','mandera','marsabit','meru','migori','mombasa','muranga','nairobi','nakuru','nandi','narok','nyamira','nyandarua','nyeri','samburu','siaya','taita taveta','tana river','tharaka nithi','trans nzoia','turkana','uasin gishu','vihiga','wajir','west pokot'];
$selected_regimen = 'AF2B | TDF + 3TC + EFV';
$selected_drugs_mos = ['Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) 60/30/50mg FDC Tabs','Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) 300/150/200mg FDC Tabs','Zidovudine/Lamivudine (AZT/3TC) 60/30mg FDC Tabs','Zidovudine/Lamivudine (AZT/3TC) 300/150mg FDC Tabs','Zidovudine (AZT) 10mg/ml Liquid'];
$selected_cms_drug = 'Abacavir (ABC) 300mg Tabs';
$selected_drugs_com_consumption = ['Abacavir (ABC) 300mg Tabs', 'Lamivudine (3TC) 150mg Tabs'];

$config['data_date'] = $data_date;
$config['counties'] = $counties;
$config['selected_regimen_patients_on_regimen'] = $selected_regimen;
$config['selected_drugs_mos'] = $selected_drugs_mos;
$config['selected_cms_drug'] = $selected_cms_drug;
$config['selected_drugs_com_consumption'] = $selected_drugs_com_consumption;


/*patient_scaleup_chart*/
$config['patient_scaleup_chart_chartview'] = 'charts/grouped_stacked_view';
$config['patient_scaleup_chart_title'] = 'Patient Scaleup Trend';
$config['patient_scaleup_chart_yaxis_title'] = 'No. of Patients';
$config['patient_scaleup_chart_source'] = 'Source: www.nascop.org';
$config['patient_scaleup_chart_has_drilldown'] = FALSE;
$config['patient_scaleup_chart_xaxis_title'] = '';
$config['patient_scaleup_chart_view_name'] = 'dsh_patient';
$config['patient_scaleup_chart_filters'] = array('data_date','county', 'regimen_service');
$config['patient_scaleup_chart_filters_default'] = array(
	'county' => $counties,
	'data_date'=> $data_date,
	// 'regimen_service' => array('ART')
);


/*patient_services_by_county_chart*/
$config['patient_services_chart_chartview'] = 'charts/stacked_column_view';
$config['patient_services_chart_title'] = 'Patient Services by County';
$config['patient_services_chart_yaxis_title'] = 'No. of Patients';
$config['patient_services_chart_source'] = 'Source: www.nascop.org';
$config['patient_services_chart_has_drilldown'] = FALSE;
$config['patient_services_chart_xaxis_title'] = '';
$config['patient_services_chart_view_name'] = 'dsh_patient';
$config['patient_services_chart_filters'] = array('county');
$config['patient_services_chart_filters_default'] = array(
	'county' => $counties
);

/*national_mos_chart*/
$config['national_mos_chart_chartview'] = 'charts/stacked_bar_view';
$config['national_mos_chart_title'] = 'National Commodity Months of Stock(MOS)';
$config['national_mos_chart_yaxis_title'] = 'Months of Stock(MOS)';
$config['national_mos_chart_source'] = 'Source: www.nascop.org';
$config['national_mos_chart_has_drilldown'] = FALSE;
$config['national_mos_chart_xaxis_title'] = '';
$config['national_mos_chart_view_name'] = 'dsh_mos';
$config['national_mos_chart_filters'] = array('data_year', 'data_month', 'drug');
$config['national_mos_chart_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month, 
	'drug' => $selected_drugs_mos
);

/*commodity_consumption_chart*/
$config['commodity_consumption_chart_chartview'] = 'charts/line_view';
$config['commodity_consumption_chart_title'] = 'Commodity Consumption Trend';
$config['commodity_consumption_chart_yaxis_title'] = 'No. of Packs';
$config['commodity_consumption_chart_source'] = 'Source: www.nascop.org';
$config['commodity_consumption_chart_has_drilldown'] = FALSE;
$config['commodity_consumption_chart_xaxis_title'] = 'Regimens';
$config['commodity_consumption_chart_view_name'] = 'dsh_consumption';
$config['commodity_consumption_chart_filters'] = array('data_date', 'drug', 'county');
$config['commodity_consumption_chart_filters_default'] = array(
	'drug' => $selected_drugs_com_consumption,
	'data_date'=> $data_date,
	'county' => $counties
);

/*patients_regimen_chart*/
$config['patients_regimen_chart_chartview'] = 'charts/basic_column_view';
$config['patients_regimen_chart_title'] = 'Patients on Regimen';
$config['patients_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['patients_regimen_chart_source'] = 'Source: www.nascop.org';
$config['patients_regimen_chart_has_drilldown'] = FALSE;
$config['patients_regimen_chart_xaxis_title'] = '';
$config['patients_regimen_chart_view_name'] = 'dsh_patient';
$config['patients_regimen_chart_filters'] = array('patient_regimen','data_date', 'county');
$config['patients_regimen_chart_filters_default'] = array(
	'patient_regimen' => $selected_regimen,
	'data_date'=> $data_date,
	'county' => $counties
);

/*commodity_month_stock_chart*/
$config['commodity_month_stock_chart_chartview'] = 'charts/basic_stacked_view';
$config['commodity_month_stock_chart_title'] = 'Commodity Month of Stock';
$config['commodity_month_stock_chart_yaxis_title'] = 'Months of Stock';
$config['commodity_month_stock_chart_source'] = 'Source: www.nascop.org';
$config['commodity_month_stock_chart_has_drilldown'] = FALSE;
$config['commodity_month_stock_chart_xaxis_title'] = '';
$config['commodity_month_stock_chart_view_name'] = 'dsh_patient';
$config['commodity_month_stock_chart_filters'] = array('data_date', 'cms_drug');
$config['commodity_month_stock_chart_filters_default'] = array(
	'cms_drug' => $selected_cms_drug,
	'data_date'=> $data_date,
);

/*county_patient_distribution_chart*/
$config['county_patient_distribution_chart_chartview'] = 'charts/column_view';
$config['county_patient_distribution_chart_title'] = 'County Patient Numbers';
$config['county_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['county_patient_distribution_chart_source'] = 'Source: www.nascop.org';
$config['county_patient_distribution_chart_has_drilldown'] = FALSE;
$config['county_patient_distribution_chart_xaxis_title'] = 'County';
$config['county_patient_distribution_chart_view_name'] = 'dsh_patient';
$config['county_patient_distribution_chart_filters'] = array('data_date', 'county');
$config['county_patient_distribution_chart_filters_default'] = array(
	'data_date'=> $data_date,
	'county' => $counties
);

/*county_patient_distribution_table*/
$config['county_patient_distribution_table_chartview'] = 'charts/table_view';
$config['county_patient_distribution_table_title'] = 'Counties';
$config['county_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['county_patient_distribution_table_source'] = 'Source: www.nascop.org';
$config['county_patient_distribution_table_has_drilldown'] = FALSE;
$config['county_patient_distribution_table_xaxis_title'] = '';
$config['county_patient_distribution_table_view_name'] = 'dsh_patient';
$config['county_patient_distribution_table_filters'] = array('data_date', 'county');
$config['county_patient_distribution_table_filters_default'] = array(
	'data_date'=> $data_date,
	'county' => $counties
);

/*subcounty_patient_distribution_chart*/
$config['subcounty_patient_distribution_chart_chartview'] = 'charts/column_view';
$config['subcounty_patient_distribution_chart_title'] = 'Subcounty Patient Numbers';
$config['subcounty_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['subcounty_patient_distribution_chart_source'] = 'Source: www.nascop.org';
$config['subcounty_patient_distribution_chart_has_drilldown'] = FALSE;
$config['subcounty_patient_distribution_chart_xaxis_title'] = 'Subcounty';
$config['subcounty_patient_distribution_chart_view_name'] = 'dsh_patient';
$config['subcounty_patient_distribution_chart_filters'] = array('data_date', 'county');
$config['subcounty_patient_distribution_chart_filters_default'] = array(
	'data_date'=> $data_date,
	'county' => $counties
);

/*subcounty_patient_distribution_table*/
$config['subcounty_patient_distribution_table_chartview'] = 'charts/table_view';
$config['subcounty_patient_distribution_table_title'] = 'Subcounty Patient Numbers';
$config['subcounty_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['subcounty_patient_distribution_table_source'] = 'Source: www.nascop.org';
$config['subcounty_patient_distribution_table_has_drilldown'] = FALSE;
$config['subcounty_patient_distribution_table_xaxis_title'] = 'Subcounty';
$config['subcounty_patient_distribution_table_view_name'] = 'dsh_patient';
$config['subcounty_patient_distribution_table_filters'] = array('data_date', 'county');
$config['subcounty_patient_distribution_table_filters_default'] = array(
	'data_date'=> $data_date,
	'county' => $counties
);

/*facility_patient_distribution_chart*/
$config['facility_patient_distribution_chart_chartview'] = 'charts/stacked_column_view';
$config['facility_patient_distribution_chart_title'] = 'Facility Patient Numbers';
$config['facility_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['facility_patient_distribution_chart_source'] = 'Source: www.nascop.org';
$config['facility_patient_distribution_chart_has_drilldown'] = FALSE;
$config['facility_patient_distribution_chart_xaxis_title'] = 'Facility';
$config['facility_patient_distribution_chart_view_name'] = 'dsh_patient';
$config['facility_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'regimen_category', 'regimen','county');
$config['facility_patient_distribution_chart_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month,
	'county' => $counties
);

/*facility_regimen_distribution_chart*/
$config['facility_regimen_distribution_chart_chartview'] = 'charts/drilldown_column_view';
$config['facility_regimen_distribution_chart_title'] = 'Facility Patient Numbers';
$config['facility_regimen_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['facility_regimen_distribution_chart_source'] = 'Source: www.nascop.org';
$config['facility_regimen_distribution_chart_has_drilldown'] = TRUE;
$config['facility_regimen_distribution_chart_xaxis_title'] = 'Facility';
$config['facility_regimen_distribution_chart_view_name'] = 'dsh_patient';
$config['facility_regimen_distribution_chart_filters'] = array('data_year', 'data_month', 'regimen_category', 'facility');
$config['facility_regimen_distribution_chart_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month,
	'facility' => 'ahero county hospital'
);

/*facility_commodity_consumption_chart*/
$config['facility_commodity_consumption_chart_chartview'] = 'charts/line_view';
$config['facility_commodity_consumption_chart_title'] = 'Commodity Consumption in the Facility';
$config['facility_commodity_consumption_chart_yaxis_title'] = 'No. of Packets';
$config['facility_commodity_consumption_chart_source'] = 'Source: www.nascop.org';
$config['facility_commodity_consumption_chart_has_drilldown'] = FALSE;
$config['facility_commodity_consumption_chart_xaxis_title'] = 'Facility';
$config['facility_commodity_consumption_chart_view_name'] = 'dsh_patient';
$config['facility_commodity_consumption_chart_filters'] = array('data_year', 'data_month', 'regimen_category', 'facility');
$config['facility_commodity_consumption_chart_filters_default'] = array(
	'drug' => $selected_drugs_com_consumption,
	'facility' => 'ahero county hospital',
	'data_date' => $data_date
);

/*facility_patient_distribution_table*/
$config['facility_patient_distribution_table_chartview'] = 'charts/table_view';
$config['facility_patient_distribution_table_title'] = 'Facility Patient Numbers';
$config['facility_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['facility_patient_distribution_table_source'] = 'Source: www.nascop.org';
$config['facility_patient_distribution_table_has_drilldown'] = FALSE;
$config['facility_patient_distribution_table_xaxis_title'] = 'Facility';
$config['facility_patient_distribution_table_view_name'] = 'dsh_patient';
$config['facility_patient_distribution_table_filters'] = array('county','data_year', 'data_month', 'regimen_category', 'regimen');
$config['facility_patient_distribution_table_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month,
	'county' => $counties
);

/*partner_patient_distribution_chart*/
$config['partner_patient_distribution_chart_chartview'] = 'charts/column_view';
$config['partner_patient_distribution_chart_title'] = 'Partner Patient Numbers';
$config['partner_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['partner_patient_distribution_chart_source'] = 'Source: www.nascop.org';
$config['partner_patient_distribution_chart_has_drilldown'] = FALSE;
$config['partner_patient_distribution_chart_xaxis_title'] = 'Partner';
$config['partner_patient_distribution_chart_view_name'] = 'dsh_patient';
$config['partner_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'regimen_category', 'regimen');
$config['partner_patient_distribution_chart_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month
);

/*partner_patient_distribution_table*/
$config['partner_patient_distribution_table_chartview'] = 'charts/table_view';
$config['partner_patient_distribution_table_title'] = 'Partner Patient Numbers';
$config['partner_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['partner_patient_distribution_table_source'] = 'Source: www.nascop.org';
$config['partner_patient_distribution_table_has_drilldown'] = FALSE;
$config['partner_patient_distribution_table_xaxis_title'] = 'Partner';
$config['partner_patient_distribution_table_view_name'] = 'dsh_patient';
$config['partner_patient_distribution_table_filters'] = array('data_year', 'data_month', 'regimen_category', 'regimen');
$config['partner_patient_distribution_table_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month
);

/*regimen_patient_chart*/
$config['regimen_patient_chart_chartview'] = 'charts/basic_column_view';
$config['regimen_patient_chart_title'] = 'Patients on Regimens';
$config['regimen_patient_chart_yaxis_title'] = 'No. of Patients';
$config['regimen_patient_chart_source'] = 'Source: www.nascop.org';
$config['regimen_patient_chart_has_drilldown'] = FALSE;
$config['regimen_patient_chart_xaxis_title'] = 'Drugs';
$config['regimen_patient_chart_view_name'] = 'commodities';
$config['regimen_patient_chart_filters'] = array('data_date', 'county');
$config['regimen_patient_chart_filters_default'] = array(
	'data_year' => $data_year, 
	'data_month' => $data_month,
	'county' => $counties
);

// drug_regimen_consumption_chart
$config['drug_regimen_consumption_chart_chartview'] = 'charts/basic_stacked_view';
$config['drug_regimen_consumption_chart_title'] = 'Drugs used in regimen';
$config['drug_regimen_consumption_chart_yaxis_title'] = 'Consumption';
$config['drug_regimen_consumption_chart_source'] = 'Source: www.nascop.org';
$config['drug_regimen_consumption_chart_has_drilldown'] = FALSE;
$config['drug_regimen_consumption_chart_xaxis_title'] = 'Drugs';
$config['drug_regimen_consumption_chart_view_name'] = 'commodities';
$config['drug_regimen_consumption_chart_filters'] = array('period_year', 'period_month', 'county', 'regimen');
$config['drug_regimen_consumption_chart_filters_default'] = array(
	'data_date'=> $data_date,
	'regimen'=> ''
);

// regimen_patients_counties_chart
$config['regimen_patients_counties_chart_chartview'] = 'charts/basic_column_view';
$config['regimen_patients_counties_chart_title'] = 'Patients on regimen by County';
$config['regimen_patients_counties_chart_yaxis_title'] = 'Patients';
$config['regimen_patients_counties_chart_source'] = 'Source: www.nascop.org';
$config['regimen_patients_counties_chart_has_drilldown'] = FALSE;
$config['regimen_patients_counties_chart_xaxis_title'] = 'Drugs';
$config['regimen_patients_counties_chart_view_name'] = 'commodities';
$config['regimen_patients_counties_chart_filters'] = array('data_date','county', 'regimen');
$config['regimen_patients_counties_chart_filters_default'] = array(
	'county' => $counties, 
	'data_date' => $data_date,
	'regimen' => ''
);

// drug_consumption_chart
$config['drug_consumption_chart_chartview'] = 'charts/basic_stacked_view';
$config['drug_consumption_chart_title'] = 'Regimen Drugs Consumption';
$config['drug_consumption_chart_yaxis_title'] = 'Consumption';
$config['drug_consumption_chart_source'] = 'Source: www.nascop.org';
$config['drug_consumption_chart_has_drilldown'] = FALSE;
$config['drug_consumption_chart_xaxis_title'] = 'Drugs';
$config['drug_consumption_chart_view_name'] = 'commodities';
$config['drug_consumption_chart_filters'] = array('period_year','regimen ', 'period_month', 'sub_county');
$config['drug_consumption_chart_filters_default'] = array(
	'regimen' => ''

);
/*adt_version_distribution_chart*/
$config['adt_version_distribution_chart_chartview'] = 'charts/stacked_column_view';
$config['adt_version_distribution_chart_title'] = 'ADT Versions intalled';
$config['adt_version_distribution_chart_yaxis_title'] = 'No. of installs';
$config['adt_version_distribution_chart_source'] = 'Source: www.nascop.org';
$config['adt_version_distribution_chart_has_drilldown'] = FALSE;
$config['adt_version_distribution_chart_xaxis_title'] = 'Sites';
$config['adt_version_distribution_chart_view_name'] = 'dsh_site';
$config['adt_version_distribution_chart_filters'] = array('partner', 'facility', 'internet', 'backup');
$config['adt_version_distribution_chart_filters_default'] = array();


/*adt_site_distribution_chart*/
$config['adt_site_distribution_chart_chartview'] = 'charts/stacked_column_view';
$config['adt_site_distribution_chart_title'] = 'ADT Site Numbers';
$config['adt_site_distribution_chart_yaxis_title'] = '% of Sites';
$config['adt_site_distribution_chart_source'] = 'Source: www.nascop.org';
$config['adt_site_distribution_chart_has_drilldown'] = FALSE;
$config['adt_site_distribution_chart_xaxis_title'] = 'Sites';
$config['adt_site_distribution_chart_view_name'] = 'dsh_site';
$config['adt_site_distribution_chart_filters'] = array('partner', 'facility', 'internet', 'backup');
$config['adt_site_distribution_chart_filters_default'] = array();

/*adt_site_distribution_table*/
$config['adt_site_distribution_table_chartview'] = 'charts/table_view';
$config['adt_site_distribution_table_title'] = 'ADT Site Numbers';
$config['adt_site_distribution_table_yaxis_title'] = 'No. of Sites';
$config['adt_site_distribution_table_source'] = 'Source: www.nascop.org';
$config['adt_site_distribution_table_has_drilldown'] = FALSE;
$config['adt_site_distribution_table_xaxis_title'] = 'Sites';
$config['adt_site_distribution_table_view_name'] = 'dsh_site';
$config['adt_site_distribution_table_filters'] = array('partner', 'facility', 'internet', 'backup');
$config['adt_site_distribution_table_filters_default'] = array();

// adt_sites_overview_chart

$config['adt_sites_overview_chart_chartview'] = 'charts/activitygauge_view';
$config['adt_sites_overview_chart_title'] = 'ADT Installs Overview';
$config['adt_sites_overview_chart_yaxis_title'] = 'Consumption';
$config['adt_sites_overview_chart_source'] = 'Source: www.nascop.org';
$config['adt_sites_overview_chart_has_drilldown'] = FALSE;
$config['adt_sites_overview_chart_xaxis_title'] = '';
$config['adt_sites_overview_chart_view_name'] = '';
$config['adt_sites_overview_chart_filters'] = array();
$config['adt_sites_overview_chart_filters_default'] = array();
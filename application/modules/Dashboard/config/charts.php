<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Default values
$config['data_year'] = date('Y', strtotime('-1 month'));
$config['data_month'] = date('M', strtotime('-1 month'));
$config['data_date'] = date('Y-m-01', strtotime('-1 month'));

//patient_scaleup_chart
$config['patient_scaleup_chart_chartview'] = 'charts/combined_column_line_view';
$config['patient_scaleup_chart_title'] = 'Patient (ART) Scaleup Trend';
$config['patient_scaleup_chart_yaxis_title'] = 'No. of Patients';
$config['patient_scaleup_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patient_scaleup_chart_has_drilldown'] = FALSE;
$config['patient_scaleup_chart_filters'] = array('data_date', 'county', 'regimen_service');
$config['patient_scaleup_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'regimen_service' => 'ART'
);

//patient_services_chart
$config['patient_services_chart_chartview'] = 'charts/stacked_column_view';
$config['patient_services_chart_title'] = 'Patient Services by County';
$config['patient_services_chart_yaxis_title'] = 'No. of Patients';
$config['patient_services_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patient_services_chart_has_drilldown'] = FALSE;
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

//commodity_consumption_chart
$config['commodity_consumption_chart_chartview'] = 'charts/line_view';
$config['commodity_consumption_chart_title'] = 'Commodity Consumption Trend';
$config['commodity_consumption_chart_yaxis_title'] = 'No. of Packs';
$config['commodity_consumption_chart_source'] = 'Source: www.commodities.nascop.org';
$config['commodity_consumption_chart_has_drilldown'] = FALSE;
$config['commodity_consumption_chart_filters'] = array('data_date', 'county', 'drug');
$config['commodity_consumption_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
	'drug' => array(
        'Efavirenz (EFV) 600mg Tabs',
        'Dolutegravir (DTG) 50mg Tabs'
    )
);

//patients_regimen_chart
$config['patients_regimen_chart_chartview'] = 'charts/column_rotated_label_view';
$config['patients_regimen_chart_title'] = 'Patients on Regimen';
$config['patients_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['patients_regimen_chart_source'] = 'Source: www.commodities.nascop.org';
$config['patients_regimen_chart_has_drilldown'] = FALSE;
$config['patients_regimen_chart_filters'] = array('data_date', 'county', 'regimen');
$config['patients_regimen_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
	'regimen' => 'AF2B | TDF + 3TC + EFV'
);

//commodity_month_stock_chart
$config['commodity_month_stock_chart_chartview'] = 'charts/stacked_column_percent_mos_view';
$config['commodity_month_stock_chart_title'] = 'Commodity Month of Stock';
$config['commodity_month_stock_chart_yaxis_title'] = 'Months of Stock';
$config['commodity_month_stock_chart_source'] = 'Source: www.commodities.nascop.org';
$config['commodity_month_stock_chart_has_drilldown'] = FALSE;
$config['commodity_month_stock_chart_filters'] = array('data_date', 'drug');
$config['commodity_month_stock_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
	'drug' => 'Tenofovir/Lamivudine/Efavirenz (TDF/3TC/EFV) 300/300/600mg FDC Tabs'
);

//county_patient_distribution_chart
$config['county_patient_distribution_chart_chartview'] = 'charts/column_view';
$config['county_patient_distribution_chart_title'] = 'County Patient (ART) Numbers';
$config['county_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['county_patient_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['county_patient_distribution_chart_has_drilldown'] = FALSE;
$config['county_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'county', 'regimen_service');
$config['county_patient_distribution_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'regimen_service' => 'ART' 
);

//county_commodity_soh_chart
$config['county_commodity_soh_chart_chartview'] = 'charts/line_view';
$config['county_commodity_soh_chart_title'] = 'County Commodity SOH Trend';
$config['county_commodity_soh_chart_yaxis_title'] = 'No. of Packs';
$config['county_commodity_soh_chart_source'] = 'Source: www.commodities.nascop.org';
$config['county_commodity_soh_chart_has_drilldown'] = FALSE;
$config['county_commodity_soh_chart_filters'] = array('data_date', 'county', 'drug');
$config['county_commodity_soh_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Efavirenz (EFV) 600mg Tabs',
        'Dolutegravir (DTG) 50mg Tabs'
    )
);

//county_commodity_stock_movement_table
$config['county_commodity_stock_movement_table_chartview'] = 'charts/table_no_percent_view';
$config['county_commodity_stock_movement_table_title'] = 'County Commodity Stock Movement';
$config['county_commodity_stock_movement_table_yaxis_title'] = 'No. of Patients';
$config['county_commodity_stock_movement_table_source'] = 'Source: www.commodities.nascop.org';
$config['county_commodity_stock_movement_table_has_drilldown'] = FALSE;
$config['county_commodity_stock_movement_table_filters'] = array('data_year', 'data_month', 'county');
$config['county_commodity_stock_movement_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//county_patient_distribution_table
$config['county_patient_distribution_table_chartview'] = 'charts/table_view';
$config['county_patient_distribution_table_title'] = 'County Patient Distibution (By Facilties and AgeGroup)';
$config['county_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['county_patient_distribution_table_source'] = 'Source: www.commodities.nascop.org';
$config['county_patient_distribution_table_has_drilldown'] = FALSE;
$config['county_patient_distribution_table_filters'] = array('data_year', 'data_month', 'county', 'regimen_service');
$config['county_patient_distribution_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'regimen_service' => 'ART'  
);

//subcounty_patient_distribution_chart
$config['subcounty_patient_distribution_chart_chartview'] = 'charts/column_view';
$config['subcounty_patient_distribution_chart_title'] = 'Subcounty Patient (ART) Numbers';
$config['subcounty_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['subcounty_patient_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['subcounty_patient_distribution_chart_has_drilldown'] = FALSE;
$config['subcounty_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'sub_county', 'regimen_service');
$config['subcounty_patient_distribution_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'regimen_service' => 'ART'  
);

//subcounty_commodity_soh_chart
$config['subcounty_commodity_soh_chart_chartview'] = 'charts/line_view';
$config['subcounty_commodity_soh_chart_title'] = 'Subcounty Commodity SOH Trend';
$config['subcounty_commodity_soh_chart_yaxis_title'] = 'No. of Packs';
$config['subcounty_commodity_soh_chart_source'] = 'Source: www.commodities.nascop.org';
$config['subcounty_commodity_soh_chart_has_drilldown'] = FALSE;
$config['subcounty_commodity_soh_chart_filters'] = array('data_date', 'sub_county', 'drug');
$config['subcounty_commodity_soh_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Efavirenz (EFV) 600mg Tabs',
        'Dolutegravir (DTG) 50mg Tabs'
    )
);

//subcounty_commodity_stock_movement_table
$config['subcounty_commodity_stock_movement_table_chartview'] = 'charts/table_no_percent_view';
$config['subcounty_commodity_stock_movement_table_title'] = 'Subcounty Commodity Stock Movement';
$config['subcounty_commodity_stock_movement_table_yaxis_title'] = 'No. of Patients';
$config['subcounty_commodity_stock_movement_table_source'] = 'Source: www.commodities.nascop.org';
$config['subcounty_commodity_stock_movement_table_has_drilldown'] = FALSE;
$config['subcounty_commodity_stock_movement_table_filters'] = array('data_year', 'data_month', 'sub_county');
$config['subcounty_commodity_stock_movement_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']  
);

//subcounty_patient_distribution_table
$config['subcounty_patient_distribution_table_chartview'] = 'charts/table_view';
$config['subcounty_patient_distribution_table_title'] = 'Subcounty Patient Distibution (By Facilties and AgeGroup)';
$config['subcounty_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['subcounty_patient_distribution_table_source'] = 'Source: www.commodities.nascop.org';
$config['subcounty_patient_distribution_table_has_drilldown'] = FALSE;
$config['subcounty_patient_distribution_table_filters'] = array('data_year', 'data_month', 'sub_county', 'regimen_service');
$config['subcounty_patient_distribution_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month'],
    'regimen_service' => 'ART'   
);

//facility_patient_distribution_chart
$config['facility_patient_distribution_chart_chartview'] = 'charts/stacked_column_view';
$config['facility_patient_distribution_chart_title'] = 'Facility Patient Numbers';
$config['facility_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['facility_patient_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['facility_patient_distribution_chart_has_drilldown'] = FALSE;
$config['facility_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'facility');
$config['facility_patient_distribution_chart_filters_default'] = array(
	'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//facility_commodity_soh_chart
$config['facility_commodity_soh_chart_chartview'] = 'charts/line_view';
$config['facility_commodity_soh_chart_title'] = 'Facility Commodity SOH Trend';
$config['facility_commodity_soh_chart_yaxis_title'] = 'No. of Packs';
$config['facility_commodity_soh_chart_source'] = 'Source: www.commodities.nascop.org';
$config['facility_commodity_soh_chart_has_drilldown'] = FALSE;
$config['facility_commodity_soh_chart_filters'] = array('data_date', 'facility', 'drug');
$config['facility_commodity_soh_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Efavirenz (EFV) 600mg Tabs',
        'Dolutegravir (DTG) 50mg Tabs'
    )
);

//facility_commodity_stock_movement_table
$config['facility_commodity_stock_movement_table_chartview'] = 'charts/table_no_percent_view';
$config['facility_commodity_stock_movement_table_title'] = 'Facility Commodity Stock Movement';
$config['facility_commodity_stock_movement_table_yaxis_title'] = 'No. of Patients';
$config['facility_commodity_stock_movement_table_source'] = 'Source: www.commodities.nascop.org';
$config['facility_commodity_stock_movement_table_has_drilldown'] = FALSE;
$config['facility_commodity_stock_movement_table_filters'] = array('data_year', 'data_month', 'facility');
$config['facility_commodity_stock_movement_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']  
);

//facility_patient_distribution_table
$config['facility_patient_distribution_table_chartview'] = 'charts/table_view';
$config['facility_patient_distribution_table_title'] = 'Facility Patient Distibution (By Services)';
$config['facility_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['facility_patient_distribution_table_source'] = 'Source: www.commodities.nascop.org';
$config['facility_patient_distribution_table_has_drilldown'] = FALSE;
$config['facility_patient_distribution_table_filters'] = array('data_year', 'data_month', 'facility');
$config['facility_patient_distribution_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//partner_patient_distribution_chart
$config['partner_patient_distribution_chart_chartview'] = 'charts/stacked_column_view';
$config['partner_patient_distribution_chart_title'] = 'Partner Patient Numbers';
$config['partner_patient_distribution_chart_yaxis_title'] = 'No. of Patients';
$config['partner_patient_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['partner_patient_distribution_chart_has_drilldown'] = FALSE;
$config['partner_patient_distribution_chart_filters'] = array('data_year', 'data_month', 'partner');
$config['partner_patient_distribution_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//partner_patient_distribution_table
$config['partner_patient_distribution_table_chartview'] = 'charts/table_view';
$config['partner_patient_distribution_table_title'] = 'Partner Patient Distibution (By Facilties and Services)';
$config['partner_patient_distribution_table_yaxis_title'] = 'No. of Patients';
$config['partner_patient_distribution_table_source'] = 'Source: www.commodities.nascop.org';
$config['partner_patient_distribution_table_has_drilldown'] = FALSE;
$config['partner_patient_distribution_table_filters'] = array('data_year', 'data_month', 'partner');
$config['partner_patient_distribution_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//regimen_patient_chart
$config['regimen_patient_chart_chartview'] = 'charts/bar_drilldown_view';
$config['regimen_patient_chart_title'] = 'Regimen Patient Numbers';
$config['regimen_patient_chart_yaxis_title'] = 'No. of Patients';
$config['regimen_patient_chart_source'] = 'Source: www.commodities.nascop.org';
$config['regimen_patient_chart_has_drilldown'] = TRUE;
$config['regimen_patient_chart_filters'] = array('data_year', 'data_month', 'regimen');
$config['regimen_patient_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//regimen_nrti_drugs_chart
$config['regimen_nrti_drugs_chart_chartview'] = 'charts/pie_drilldown_view';
$config['regimen_nrti_drugs_chart_title'] = 'NRTI Drugs in Regimen';
$config['regimen_nrti_drugs_chart_yaxis_title'] = 'No. of Patients';
$config['regimen_nrti_drugs_chart_source'] = 'Source: www.commodities.nascop.org';
$config['regimen_nrti_drugs_chart_has_drilldown'] = TRUE;
$config['regimen_nrti_drugs_chart_filters'] = array('data_year', 'data_month', 'regimen');
$config['regimen_nrti_drugs_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//regimen_nnrti_drugs_chart
$config['regimen_nnrti_drugs_chart_chartview'] = 'charts/pie_drilldown_view';
$config['regimen_nnrti_drugs_chart_title'] = 'NNRTI/PI/INSTI Drugs in Regimen';
$config['regimen_nnrti_drugs_chart_yaxis_title'] = 'No. of Patients';
$config['regimen_nnrti_drugs_chart_source'] = 'Source: www.commodities.nascop.org';
$config['regimen_nnrti_drugs_chart_has_drilldown'] = TRUE;
$config['regimen_nnrti_drugs_chart_filters'] = array('data_year', 'data_month', 'regimen');
$config['regimen_nnrti_drugs_chart_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//regimen_drug_table
$config['regimen_drug_table_chartview'] = 'charts/table_view';
$config['regimen_drug_table_title'] = 'Regimen Drug Consumption';
$config['regimen_drug_table_yaxis_title'] = 'No. of Patients';
$config['regimen_drug_table_source'] = 'Source: www.commodities.nascop.org';
$config['regimen_drug_table_has_drilldown'] = FALSE;
$config['regimen_drug_table_filters'] = array('data_year', 'data_month', 'regimen');
$config['regimen_drug_table_filters_default'] = array(
    'data_year' => $config['data_year'], 
    'data_month' => $config['data_month']
);

//adt_sites_version_chart
$config['adt_sites_version_chart_chartview'] = 'charts/column_view';
$config['adt_sites_version_chart_title'] = 'ADT Site(s) Installation (By Version)';
$config['adt_sites_version_chart_yaxis_title'] = 'No. of installations';
$config['adt_sites_version_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_sites_version_chart_has_drilldown'] = FALSE;
$config['adt_sites_version_chart_filters'] = array('county');
$config['adt_sites_version_chart_filters_default'] = array();

//adt_sites_internet_chart
$config['adt_sites_internet_chart_chartview'] = 'charts/pie_view';
$config['adt_sites_internet_chart_title'] = 'Internet Availability';
$config['adt_sites_internet_chart_yaxis_title'] = '% of Internet Available';
$config['adt_sites_internet_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_sites_internet_chart_has_drilldown'] = FALSE;
$config['adt_sites_internet_chart_filters'] = array('county');
$config['adt_sites_internet_chart_filters_default'] = array();

//adt_sites_backup_chart
$config['adt_sites_backup_chart_chartview'] = 'charts/pie_view';
$config['adt_sites_backup_chart_title'] = 'Backup Availability';
$config['adt_sites_backup_chart_yaxis_title'] = '% of Backup Available';
$config['adt_sites_backup_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_sites_backup_chart_has_drilldown'] = FALSE;
$config['adt_sites_backup_chart_filters'] = array('county');
$config['adt_sites_backup_chart_filters_default'] = array();

//adt_sites_distribution_chart
$config['adt_sites_distribution_chart_chartview'] = 'charts/stacked_column_percent_view';
$config['adt_sites_distribution_chart_title'] = 'ADT Central Site(s) Installation (By County)';
$config['adt_sites_distribution_chart_yaxis_title'] = '% of Site Installations';
$config['adt_sites_distribution_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_sites_distribution_chart_has_drilldown'] = FALSE;
$config['adt_sites_distribution_chart_filters'] = array('county');
$config['adt_sites_distribution_chart_filters_default'] = array();

//adt_sites_distribution_table
$config['adt_sites_distribution_table_chartview'] = 'charts/table_view';
$config['adt_sites_distribution_table_title'] = 'ADT Site(s) Installation Numbers';
$config['adt_sites_distribution_table_yaxis_title'] = 'No. of Installations';
$config['adt_sites_distribution_table_source'] = 'Source: www.commodities.nascop.org';
$config['adt_sites_distribution_table_has_drilldown'] = FALSE;
$config['adt_sites_distribution_table_filters'] = array('county');
$config['adt_sites_distribution_table_filters_default'] = array();

//adt_reports_patients_started_on_art
$config['adt_reports_patients_started_art_chart_chartview'] = 'charts/stacked_bar_view_without_plotlines';
$config['adt_reports_patients_started_art_chart_title'] = 'PATIENT(S) STARTED ON ART';
$config['adt_reports_patients_started_art_chart_yaxis_title'] = 'No. of Patients';
$config['adt_reports_patients_started_art_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_patients_started_art_chart_has_drilldown'] = FALSE;
$config['adt_reports_patients_started_art_chart_filters'] = array('data_year', 'data_month', 'start_regimen');
$config['adt_reports_patients_started_art_chart_filters_default'] = array(
    'data_year' => $config['data_year'],
    'data_month' => $config['data_month'],
    'start_regimen' => array(
        'AF1A | AZT + 3TC + NVP',
        'AF2A | TDF + 3TC + NVP',
        'AF1B | AZT + 3TC + EFV',
        'AF2B | TDF + 3TC + EFV',
        'CF1A | AZT + 3TC + NVP',
        'CF2A | ABC + 3TC + NVP'
    )
);

//adt_reports_active_patients_regimen_chart
$config['adt_reports_active_patients_regimen_chart_chartview'] = 'charts/stacked_bar_view_without_plotlines';
$config['adt_reports_active_patients_regimen_chart_title'] = 'ACTIVE PATIENT(S) BY REGIMEN';
$config['adt_reports_active_patients_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['adt_reports_active_patients_regimen_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_active_patients_regimen_chart_has_drilldown'] = FALSE;
$config['adt_reports_active_patients_regimen_chart_filters'] = array('data_year', 'data_month', 'current_regimen');
$config['adt_reports_active_patients_regimen_chart_filters_default'] = array(
    'data_year' => $config['data_year'],
    'data_month' => $config['data_month'],
    'current_regimen' => array(
        'AF1A | AZT + 3TC + NVP',
        'AF2A | TDF + 3TC + NVP',
        'AF1B | AZT + 3TC + EFV',
        'AF2B | TDF + 3TC + EFV',
        'CF1A | AZT + 3TC + NVP',
        'CF2A | ABC + 3TC + NVP'
    )
);

//adt_reports_commodity_consumption_regimen_chart
$config['adt_reports_commodity_consumption_regimen_chart_chartview'] = 'charts/line_view';
$config['adt_reports_commodity_consumption_regimen_chart_title'] = 'COMMODITY CONSUMPTION BY REGIMEN';
$config['adt_reports_commodity_consumption_regimen_chart_yaxis_title'] = 'No. of Patients';
$config['adt_reports_commodity_consumption_regimen_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_commodity_consumption_regimen_chart_has_drilldown'] = FALSE;
$config['adt_reports_commodity_consumption_regimen_chart_filters'] = array('data_date', 'drug');
$config['adt_reports_commodity_consumption_regimen_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Efavirenz (EFV) 600mg Tabs'
    )
);

//adt_reports_commodity_consumption_drug_chart
$config['adt_reports_commodity_consumption_drug_chart_chartview'] = 'charts/line_view';
$config['adt_reports_commodity_consumption_drug_chart_title'] = 'COMMODITY CONSUMPTION BY DRUG';
$config['adt_reports_commodity_consumption_drug_chart_yaxis_title'] = 'No. of Patients';
$config['adt_reports_commodity_consumption_drug_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_commodity_consumption_drug_chart_has_drilldown'] = FALSE;
$config['adt_reports_commodity_consumption_drug_chart_filters'] = array( 'data_date', 'current_regimen');
$config['adt_reports_commodity_consumption_drug_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'current_regimen' => array(
        'AF2B | TDF + 3TC + EFV'
    )
);

//adt_reports_commodity_consumption_dose_chart
$config['adt_reports_commodity_consumption_dose_chart_chartview'] = 'charts/combined_column_line_view';
$config['adt_reports_commodity_consumption_dose_chart_title'] = 'COMMODITY CONSUMPTION BY DOSE';
$config['adt_reports_commodity_consumption_dose_chart_yaxis_title'] = 'No. of Patients';
$config['adt_reports_commodity_consumption_dose_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_commodity_consumption_dose_chart_has_drilldown'] = FALSE;
$config['adt_reports_commodity_consumption_dose_chart_filters'] = array('data_date', 'drug');
$config['adt_reports_commodity_consumption_dose_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Nevirapine (NVP) 200mg Tabs'
    )
);

//adt_reports_paediatric_weight_age_chart
$config['adt_reports_paediatric_weight_age_chart_chartview'] = 'charts/scatter_plot_view';
$config['adt_reports_paediatric_weight_age_chart_title'] = 'PAEDIATRIC PATIENTS BY WEIGHT AND AGE';
$config['adt_reports_paediatric_weight_age_chart_yaxis_title'] = 'Age';
$config['adt_reports_paediatric_weight_age_chart_xaxis_title'] = 'Weight (KG)';
$config['adt_reports_paediatric_weight_age_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_paediatric_weight_age_chart_has_drilldown'] = FALSE;
$config['adt_reports_paediatric_weight_age_chart_filters'] = array('data_year', 'data_month', 'drug');
$config['adt_reports_paediatric_weight_age_chart_filters_default'] = array(
    'data_year' => $config['data_year'],
    'data_month' => $config['data_month'],
    'drug' => array(
        'Abacavir/Lamivudine (ABC/3TC) 60/30mg FDC Tabs',
        'Zidovudine/Lamivudine (AZT/3TC) 60/30mg FDC Tabs',
        'Zidovudine/Lamivudine/Nevirapine (AZT/3TC/NVP) 60/30/50mg FDC Tabs',
        'Efavirenz (EFV) 200mg Tabs',
        'Nevirapine (NVP) 200mg Tabs',
        'Lopinavir/Ritonavir (LPV/r) 80/20mg/ml Liquid',
        'Lopinavir/Ritonavir (LPV/r) 200/50mg Tabs'
    )
);

//adt_reports_commodity_consumption_chart
$config['adt_reports_commodity_consumption_chart_chartview'] = 'charts/line_view';
$config['adt_reports_commodity_consumption_chart_title'] = 'COMMODITY CONSUMPTION TREND';
$config['adt_reports_commodity_consumption_chart_yaxis_title'] = 'No. of Packs';
$config['adt_reports_commodity_consumption_chart_source'] = 'Source: www.commodities.nascop.org';
$config['adt_reports_commodity_consumption_chart_has_drilldown'] = FALSE;
$config['adt_reports_commodity_consumption_chart_filters'] = array('data_date', 'drug');
$config['adt_reports_commodity_consumption_chart_filters_default'] = array(
    'data_date' => $config['data_date'],
    'drug' => array(
        'Efavirenz (EFV) 600mg Tabs',
        'Dolutegravir (DTG) 50mg Tabs'
    )
);

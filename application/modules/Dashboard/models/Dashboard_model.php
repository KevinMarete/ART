<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_patient_scaleup($filters){
		$columns = array();
		$scaleup_data = array(
			array('type' => 'column', 'name' => 'Paediatric', 'data' => array()),
			array('type' => 'column', 'name' => 'Adult', 'data' => array()),
			array('type' => 'spline', 'name' => 'Forecast', 'data' => array())
		);

		$this->db->select("CONCAT_WS('/', data_month, data_year) period,
			SUM(IF(age_category = 'paed', total, NULL)) paed_total, 
			SUM(IF(age_category = 'adult', total, NULL)) adult_total,
			round(RAND()*150000)+650000  forecast 
			", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['period'];
				foreach ($scaleup_data as $index => $scaleup) {
					if($scaleup['name'] == 'Adult'){
						array_push($scaleup_data[$index]['data'], $result['adult_total']);
					}else if($scaleup['name'] == 'Paediatric'){
						array_push($scaleup_data[$index]['data'], $result['paed_total']);
					}else if($scaleup['name'] == 'Forecast'){
						array_push($scaleup_data[$index]['data'], $result['forecast']);
					}
				}
			}
		}

		// get forecast data
		// $this->db->select("CONCAT_WS('/', data_month, data_year) period, avg(forecast) forecast", FALSE);
		// if(!empty($filters)){
		// 	foreach ($filters as $category => $filter) {
		// 		if ($category == 'data_date'){
		// 			$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
		// 			continue;
		// 		}
		// 		$this->db->where_in($category, $filter);
		// 	}
		// }
		// $this->db->group_by('period');
		// $this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		// $query = $this->db->get('dsh_forecast');
		// $results = $query->result_array();

		// if($results){
		// 	foreach ($results as $result) {
		// 		foreach ($scaleup_data as $index => $scaleup) {
		// 			if($scaleup['name'] == 'Forecast'){
		// 				array_push($scaleup_data[$index]['data'], $result['forecast']);
		// 			}
		// 		}
		// 	}
		// }

		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_patient_services($filters){
		$columns = array();
		$patient_services_data = array(
			array('type' => 'column',  'name' => 'ART' , 'data' =>array()),
			array('type' => 'column',  'name' => 'HepB' , 'data' =>array()),
			array('type' => 'column',  'name' => 'OI Only' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PEP' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PrEP' , 'data' =>array())
		);

		$this->db->select("county, 
			count(regimen_service),
			COUNT(IF(regimen_service= 'ART', total, NULL)) art,
			COUNT(IF(regimen_service= 'PMTCT', total, NULL)) pmtct,
			COUNT(IF(regimen_service= 'OI Only', total, NULL)) oi,
			COUNT(IF(regimen_service= 'HepB', total, NULL)) hepb,
			COUNT(IF(regimen_service= 'PrEP', total, NULL)) prep,
			COUNT(IF(regimen_service= 'PEP', total, NULL)) pep", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('county');
		$this->db->order_by("county , regimen_service asc");
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();


		if($results){
			foreach ($results as $result) {
				$columns[] = $result['county'];
				foreach ($patient_services_data as $index => $scaleup) {
					if($scaleup['name'] == 'ART'){
						array_push($patient_services_data[$index]['data'], $result['art']);
					}else if($scaleup['name'] == 'HepB'){
						array_push($patient_services_data[$index]['data'], $result['hepb']);
					}else if($scaleup['name'] == 'OI Only'){
						array_push($patient_services_data[$index]['data'], $result['oi']);	
					}else if($scaleup['name'] == 'PEP'){
						array_push($patient_services_data[$index]['data'], $result['pep']);	
					}else if($scaleup['name'] == 'PMTCT'){
						array_push($patient_services_data[$index]['data'], $result['pmtct']);	
					}else if($scaleup['name'] == 'PrEP'){
						array_push($patient_services_data[$index]['data'], $result['prep']);	
					}
				}
			}
		}
		return array('main' => $patient_services_data, 'columns' => $columns);
	}


	public function get_national_mos($filters){
		$columns = array();
		$scaleup_data = array(
			array('name' => 'Pending Orders', 'data' => array()),
			array('name' => 'KEMSA', 'data' => array()),
			array('name' => 'Facilities', 'data' => array())
		);

		$this->db->select('drug, facility_mos, cms_mos, supplier_mos');
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug');
		$this->db->order_by('drug', 'DESC');
		$query = $this->db->get('dsh_mos');
		$results = $query->result_array();

		foreach ($results as $result) {
			$columns[] = $result['drug'];
			foreach ($scaleup_data as $index => $scaleup) {
				if($scaleup['name'] == 'Facilities'){
					array_push($scaleup_data[$index]['data'], $result['facility_mos']);
				}else if($scaleup['name'] == 'KEMSA'){
					array_push($scaleup_data[$index]['data'], $result['cms_mos']);
				}else if($scaleup['name'] == 'Pending Orders'){
					array_push($scaleup_data[$index]['data'], $result['supplier_mos']);	
				}
			}
		}
		return array('main' => $scaleup_data, 'columns' => $columns);
	}

	public function get_commodity_consumption($filters){
		$columns = array();
		$tmp_data = array();
		$consumption_data = array();
             
		$this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_consumption');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data[$result['drug']]['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$consumption_data[$counter]['name'] = $name;
			$consumption_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $consumption_data, 'columns' => array_values(array_unique($columns)));
	}

	public function get_patients_regimen($filters){
		$columns = array();
		$tmp_data = array();
		$patient_regm_data = array();
             
		$this->db->select("regimen, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				if($category == 'patient_regimen') {
					$category = 'regimen';
					$this->db->where_in($category, $filter);
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('regimen, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data[$result['regimen']]['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$patient_regm_data[$counter]['name'] = $name;
			$patient_regm_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $patient_regm_data, 'columns' => array_values(array_unique($columns)));
	}

	public function get_commodity_month_stock($filters){
		$columns = array();

		$comm_month_data = array(
			array('name' => 'Pending Orders', 'data' => array()),
			array('name' => 'KEMSA', 'data' => array()),
			array('name' => 'Facilities', 'data' => array())
		);

		$this->db->select("drug, facility_mos, cms_mos, supplier_mos, data_month, data_year, CONCAT_WS('/', data_month, data_year) period", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$category = 'drug';		
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_mos');
		$results = $query->result_array();
		
		foreach ($results as $result) {
			$columns[] = $result['period'];
			foreach ($comm_month_data as $index => $comm_month) {
				if($comm_month['name'] == 'Pending Orders'){
					array_push($comm_month_data[$index]['data'], $result['supplier_mos']);
				}
				else if($comm_month['name'] == 'Facilities'){
					array_push($comm_month_data[$index]['data'], $result['facility_mos']);
				}else if($comm_month['name'] == 'KEMSA'){
					array_push($comm_month_data[$index]['data'], $result['cms_mos']);
				}
			}
		}
		
		return array('main' => $comm_month_data, 'columns' => $columns);
	}
	
	public function get_county_patient_distribution($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(county, 1, 1)),LOWER(SUBSTRING(county, 2))) name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_county_patient_distribution_numbers($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(county, 1, 1)),LOWER(SUBSTRING(county, 2))) name, COUNT(facility) sites, SUM(IF(age_category='adult', total, NULL)) adult, SUM(IF(age_category='paed', total, NULL)) paed, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('sites, total', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

	public function get_subcounty_patient_distribution($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(sub_county, 1, 1)),LOWER(SUBSTRING(sub_county, 2))) name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$this->db->limit(30);
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_subcounty_patient_distribution_numbers($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(sub_county, 1, 1)),LOWER(SUBSTRING(sub_county, 2))) name, COUNT(facility) sites, SUM(IF(age_category='adult', total, NULL)) adult, SUM(IF(age_category='paed', total, NULL)) paed, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('sites, total', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

	public function get_facility_patient_distribution($filters){
		$columns = array();

   		$patient_services_data = array(
			array('type' => 'column',  'name' => 'ART' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PEP' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT MOTHER' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PMTCT CHILD' , 'data' =>array()),
			array('type' => 'column',  'name' => 'PrEP' , 'data' =>array())
		);

		$this->db->select("CONCAT(UCASE(SUBSTRING(facility, 1, 1)),LOWER(SUBSTRING(facility, 2))) name,
			SUM(CASE WHEN regimen_service = 'ART' THEN total ELSE 0 END) art,
			SUM(CASE WHEN regimen_service = 'PMTCT' AND age_category = 'adult' THEN total ELSE 0 END) pmtct_mother,
			SUM(CASE WHEN regimen_service = 'PMTCT' AND age_category = 'paed' THEN total ELSE 0 END) pmtct_paed,
			SUM(CASE WHEN regimen_service= 'PrEP' THEN total ELSE 0 END) prep,
			SUM(CASE WHEN regimen_service= 'PEP' THEN total ELSE 0 END) pep", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		// $this->db->order_by('y', 'DESC');
		$this->db->limit(30);
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				$columns[] = $result['name'];
				foreach ($patient_services_data as $index => $scaleup) {
					if($scaleup['name'] == 'ART'){
						array_push($patient_services_data[$index]['data'], $result['art']);
					}else if($scaleup['name'] == 'PEP'){
						array_push($patient_services_data[$index]['data'], $result['pep']);	
					}else if($scaleup['name'] == 'PMTCT MOTHER'){
						array_push($patient_services_data[$index]['data'], $result['pmtct_mother']);	
					}else if($scaleup['name'] == 'PMTCT CHILD'){
						array_push($patient_services_data[$index]['data'], $result['pmtct_paed']);	
					}else if($scaleup['name'] == 'PrEP'){
						array_push($patient_services_data[$index]['data'], $result['prep']);	
					}
				}
			}
		}
		return array('main' => $patient_services_data, 'columns' => $columns);
	}

	public function get_facility_regimen_distribution($filters) {
		//level 1 data..regimen services
		$columns = array();
		$patient_services_data = array(
			array('name' => 'ART', 'drilldown' => 'art' , 'y' =>array()),
			array('name' => 'OI Only', 'drilldown' => 'oi_only', 'y' =>array()),
			array('name' => 'PMTCT', 'drilldown' => 'pmtct', 'y' =>array()),
			array('name' => 'PrEP', 'drilldown' => 'prep', 'y' =>array()),
			array('name' => 'PEP', 'drilldown' => 'pep', 'y' =>array()),
			array('name' => 'HepB' ,'drilldown' => 'hepb', 'y' =>array())
		);

		$this->db->select("regimen_service,
			SUM(IF(regimen_service= 'ART', total, 0)) art,
			SUM(IF(regimen_service= 'PMTCT', total, 0)) pmtct,
			SUM(IF(regimen_service= 'OI Only', total, 0)) oi,
			SUM(IF(regimen_service= 'HepB', total, 0)) hepb,
			SUM(IF(regimen_service= 'PrEP', total, 0)) prep,
			SUM(IF(regimen_service= 'PEP', total, 0)) pep", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}

		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				foreach ($patient_services_data as $index => $scaleup) {
					if($scaleup['name'] == 'ART'){
						$patient_services_data[$index]['y'] = $result['art'];
					}else if($scaleup['name'] == 'HepB'){
						$patient_services_data[$index]['y'] = $result['hepb'];
					}else if($scaleup['name'] == 'OI Only'){
						$patient_services_data[$index]['y'] = $result['oi'];	
					}else if($scaleup['name'] == 'PEP'){
						$patient_services_data[$index]['y'] = $result['pep'];	
					}else if($scaleup['name'] == 'PMTCT'){
						$patient_services_data[$index]['y'] = $result['pmtct'];	
					}else if($scaleup['name'] == 'PrEP'){
						$patient_services_data[$index]['y'] = $result['prep'];	
					}
				}
			}
		}
		// level 2 ..regimen category

		// art drilldown data
		$art_level2 = array('id' => 'art', 'name' => 'art', 'data' => array());
		$level_two_art = array(
			array('name' => 'Adult First Line', 'drilldown' => 'art_adult_first_line' , 'y' =>array()),
			array('name' => 'Paediatric First Line', 'drilldown' => 'art_paediatric_first_line', 'y' =>array()),
			array('name' => 'Adult Second Line','drilldown' => 'art_adult_second_line', 'y' =>array()),
			array('name' => 'Paediatric Second Line', 'drilldown' => 'art_paediatric_second_line', 'y' =>array()),
			array('name' => 'Adult Third Line', 'drilldown' => 'art_adult_third_line', 'y' =>array()),
			array('name' => 'Paediatric Third Line', 'drilldown' => 'art_paediatric_third_line', 'y' =>array())
		);

		// oi_only drilldown data
		$oi_level2 = array('id' => 'oi_only', 'name' => 'Oi_only', 'data' => array());
		$level_two_oi = array(
			array('name' => 'OIs Medicines [1. Universal Prophylaxis]', 'drilldown' => 'oi_only_ois_medicines_[1._universal_prophylaxis]', 'y' =>array()),
			array('name' => 'OIs Medicines [2. IPT]', 'drilldown' => 'oi_only_ois_medicines_[2._ipt]', 'y' =>array()),
			array('name' => 'OIs Medicines {CM} and {OC} For Diflucan Donation', 'drilldown' => 'oi_only_ois_medicines_{cm}_and_{oc}_for_diflucan_donation', 'y' =>array())
		);

		// pmtct drilldown data
		$pmtct_level2 = array('id' => 'pmtct', 'name' => 'Pmtct', 'data' => array());
		$level_two_pmtct = array(
			array('name' => 'PMTCT Mother', 'drilldown' => 'pmtct_pmtct_mother', 'y' =>array()),
			array('name' => 'PMTCT Child', 'drilldown' => 'pmtct_pmtct_child', 'y' =>array())
		);

		// pep drilldown data
		$pep_level2 = array('id' => 'pep', 'name' => 'Pep', 'data' => array());
		$level_two_pep = array(
			array('name' => 'PEP Adult', 'drilldown' => 'pep_pep_adult', 'y' =>array()),
			array('name' => 'PEP Child', 'drilldown' => 'pep_pep_child', 'y' =>array())
		);

		// prep drilldown data
		$prep_level2 = array('id' => 'prep', 'name' => 'Prep', 'data' => array());
		$level_two_prep = array(
			array('name' => 'PrEP', 'drilldown' => 'prep_prep', 'y' =>array())
		);

		// hepb drilldown data
		$hepb_level2 = array('id' => 'hepb', 'name' => 'Hepb', 'data' => array());
		$level_two_hepb = array(
			array('name' => 'Hepatitis B Patients who are HIV-ve', 'drilldown' => 'hepb_hepatitis_b_patients_who_are_hiv-ve', 'y' =>array())
		);

		$this->db->select("regimen_category,
			SUM(IF(regimen_category= 'Adult First Line', total, 0)) adult_first,
			SUM(IF(regimen_category= 'Adult Second Line', total, 0)) adult_sec,
			SUM(IF(regimen_category= 'Adult Third Line', total, 0)) adult_third,
			SUM(IF(regimen_category= 'Paediatric First Line', total, 0)) paed_first,
			SUM(IF(regimen_category= 'Paediatric Second Line', total, 0)) paed_sec,
			SUM(IF(regimen_category= 'Paediatric Third Line', total, 0)) paed_third,
			SUM(IF(regimen_category= 'OIs Medicines [1. Universal Prophylaxis]', total, 0)) oi_1_universal,
			SUM(IF(regimen_category= 'OIs Medicines [2. IPT]', total, 0)) oi_2_ipt,
			SUM(IF(regimen_category= 'OIs Medicines {CM} and {OC} For Diflucan Donation', total, 0)) oi_cm_oc,
			SUM(IF(regimen_category= 'PMTCT Mother', total, 0)) pmtct_mother,
			SUM(IF(regimen_category= 'PMTCT Child', total, 0)) pmtct_child,
			SUM(IF(regimen_category= 'PEP Adult', total, 0)) pep_adult,
			SUM(IF(regimen_category= 'PEP Child', total, 0)) pep_child,
			SUM(IF(regimen_category= 'PrEP', total, 0)) prep,
			SUM(IF(regimen_category= 'Hepatitis B Patients who are HIV-ve', total, 0)) hepb,
			", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}

		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				// art results
				foreach ($level_two_art as $index => $scaleup) {
					if($scaleup['name'] == 'Adult First Line'){
						$level_two_art[$index]['y'] = $result['adult_first'];
					}else if($scaleup['name'] == 'Adult Second Line'){
						$level_two_art[$index]['y'] = $result['adult_sec'];
					}else if($scaleup['name'] == 'Adult Third Line'){
						$level_two_art[$index]['y'] = $result['adult_third'];	
					}else if($scaleup['name'] == 'Paediatric First Line'){
						$level_two_art[$index]['y'] = $result['paed_first'];	
					}else if($scaleup['name'] == 'Paediatric Second Line'){
						$level_two_art[$index]['y'] = $result['paed_sec'];	
					}else if($scaleup['name'] == 'Paediatric Third Line'){
						$level_two_art[$index]['y'] = $result['paed_third'];	
					}
					$art_level2['data'] = $level_two_art;
				}
				// oi results
				foreach ($level_two_oi as $index => $scaleup) {
					if($scaleup['name'] == 'OIs Medicines [1. Universal Prophylaxis]'){
						$level_two_oi[$index]['y'] = $result['oi_1_universal'];
					}else if($scaleup['name'] == 'OIs Medicines [2. IPT]'){
						$level_two_oi[$index]['y'] = $result['oi_2_ipt'];
					}else if($scaleup['name'] == 'OIs Medicines {CM} and {OC} For Diflucan Donation'){
						$level_two_oi[$index]['y'] = $result['oi_cm_oc'];	
					}
					$oi_level2['data'] = $level_two_oi;
				}
				// pmtct results
				foreach ($level_two_pmtct as $index => $scaleup) {
					if($scaleup['name'] == 'PMTCT Mother'){
						$level_two_pmtct[$index]['y'] = $result['pmtct_mother'];
					}else if($scaleup['name'] == 'PMTCT Child'){
						$level_two_pmtct[$index]['y'] = $result['pmtct_child'];
					}
					$pmtct_level2['data'] = $level_two_pmtct;
				}
				// pep results
				foreach ($level_two_pep as $index => $scaleup) {
					if($scaleup['name'] == 'PEP Adult'){
						$level_two_pep[$index]['y'] = $result['pep_adult'];
					}else if($scaleup['name'] == 'PEP Child'){
						$level_two_pep[$index]['y'] = $result['pep_child'];
					}
					$pep_level2['data'] = $level_two_pep;
				}
				// prep results
				foreach ($level_two_prep as $index => $scaleup) {
					if($scaleup['name'] == 'PrEP'){
						$level_two_prep[$index]['y'] = $result['prep'];
					}
					$prep_level2['data'] = $level_two_prep;
				}
				// hepb results
				foreach ($level_two_hepb as $index => $scaleup) {
					if($scaleup['name'] == 'Hepatitis B Patients who are HIV-ve'){
						$level_two_hepb[$index]['y'] = $result['hepb'];
					}
					$hepb_level2['data'] = $level_two_hepb;
				}
			}
			$drilldown[] = $art_level2;
			$drilldown[] = array_merge($oi_level2);
			$drilldown[] = array_merge($pmtct_level2);
			$drilldown[] = array_merge($pep_level2);
			$drilldown[] = array_merge($prep_level2);
			$drilldown[] = array_merge($hepb_level2);
		}
		// level 3 -- regimen
		// hepb regimen data
		$hepb_level3 = array('id' => 'hepb_hepatitis_b_patients_who_are_hiv-ve', 'name' => 'Hepb_hepatitis_b_patients_who_are_hiv-ve', 'data' => array());
		$level_three_hepb = array(
			array('name' => 'HPB1A | TDF + 3TC (HIV-ve HepB patients)', 'y' =>array()),
			array('name' => 'HPB1B | TDF + FTC (HIV-ve HepB patients)', 'y' =>array())
		);

		// prep regimen data
		$prep_level3 = array('id' => 'prep_prep', 'name' => 'Prep_prep', 'data' => array());
		$level_three_prep = array(
			array('name' => 'PRP1A | TDF + FTC (PrEP)', 'y' =>array()),
			array('name' => 'PRP1B | TDF + 3TC (PrEP)', 'y' =>array()),
			array('name' => 'PRP1C | TDF (PrEP)', 'y' =>array())
		);

		// pep adult regimen data
		$pep_level3 = array('id' => 'pep_pep_adult', 'name' => 'Pep_pep_adult', 'data' => array());
		$level_three_pep = array(
			array('name' => 'PA3C | TDF + 3TC + ATV/r (Adult PEP)', 'y' =>array()),
			array('name' => 'PA1C | AZT + 3TC + ATV/r (Adult PEP)', 'y' =>array()),
			array('name' => 'PA4X | All other PEP regimens for Adults', 'y' =>array()),
			array('name' => 'PA3B | TDF + 3TC + LPV/r (Adult PEP)', 'y' =>array()),
			array('name' => 'PA1B | AZT + 3TC + LPV/r (Adult PEP)', 'y' =>array())
		);

		// pep child regimen data
		$pepc_level3 = array('id' => 'pep_pep_child', 'name' => 'Pep_pep_child', 'data' => array());
		$level_three_pepc = array(
			array('name' => 'PC4X | All other PEP regimens for Children', 'y' =>array()),
			array('name' => 'PC1A | AZT + 3TC + LPV/r (Paed PEP)', 'y' =>array()),
			array('name' => 'PC2A | d4T + 3TC + LPV/r (Paed PEP Option 2)', 'y' =>array())
		);

		// oi only 1 universal regimen data
		$oiuni_level3 = array('id' => 'oi_only_ois_medicines_[1._universal_prophylaxis]', 'name' => 'Oi_only_ois_medicines_[1._universal_prophylaxis]', 'data' => array());
		$level_three_oiuni = array(
			array('name' => 'OI1A | Adult patients (=>15 Yrs) on Cotrimoxazole prophylaxis', 'y' =>array()),
			array('name' => 'OI1C | Paediatric patients (<15 Yrs) on Cotrimoxazole prophylaxis', 'y' =>array()),
			array('name' => 'OI2A | Adult patients (=>15 Yrs) on Dapsone prophylaxis', 'y' =>array()),
			array('name' => 'OI2C | Paediatric patients (<15 Yrs) on Dapsone prophylaxis', 'y' =>array())
		);

		// oi only 1 {cm} and {oc} regimen data
		$oicmoc_level3 = array('id' => 'oi_only_ois_medicines_{cm}_and_{oc}_for_diflucan_donation', 'name' => 'Oi_only_ois_medicines_{cm}_and_{oc}_for_diflucan_donation', 'data' => array());
		$level_three_oicmoc = array(
			array('name' => 'OC3N | New patients with OC on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array()),
			array('name' => 'OI3A | Adult patients on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array()),
			array('name' => 'OI3C | Paed patients on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array()),
			array('name' => 'OC3R | Revisit patients with OC on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array()),
			array('name' => 'CM3R | Revisit patients with CM on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array()),
			array('name' => 'CM3N | New patients with CM on Diflucan (For Diflucan Donation Program ONLY)', 'y' =>array())
		);

		// oi only 2 ipt regimen data
		$oi2ipt_level3 = array('id' => 'oi_only_ois_medicines_[2._ipt]', 'name' => 'Oi_only_ois_medicines_[2._ipt]', 'data' => array());
		$level_three_oi2ipt = array(
			array('name' => 'OI4A | Adult patients (=>15 Yrs) on Isoniazid prophylaxis', 'y' =>array()),
			array('name' => 'OI4C | Paediatric patients (<15 Yrs) on Isoniazid prophylaxis', 'y' =>array())
		);

		// pmtct mother regimen data
		$pmtctm_level3 = array('id' => 'pmtct_pmtct_mother', 'name' => 'Pmtct_pmtct_mother', 'data' => array());
		$level_three_pmtctm = array(
			array('name' => 'PM9 | PMTCT HAART: TDF + 3TC + EFV', 'y' =>array()),
			array('name' => 'PM6 | PMTCT HAART: TDF + 3TC + NVP', 'y' =>array()),
			array('name' => 'PM3 | PMTCT HAART: AZT + 3TC + NVP', 'y' =>array()),
			array('name' => 'PM4 | PMTCT HAART: AZT + 3TC + EFV', 'y' =>array()),
			array('name' => 'PM7 | PMTCT HAART: TDF + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'PM5 | PMTCT HAART: AZT + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'PM11 | PMTCT HAART: TDF + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'PM10 | PMTCT HAART: AZT + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'PM1X | All other PMTCT regimens for Women', 'y' =>array()),
			array('name' => 'PM1 | AZT 300mg BD (from week 14 to Delivery); then NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/', 'y' =>array()),
			array('name' => 'PM2 | NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/150mg BD for one week post-partum', 'y' =>array()),
		);

		// pmtct child regimen data
		$pmtctc_level3 = array('id' => 'pmtct_pmtct_child', 'name' => 'Pmtct_pmtct_child', 'data' => array());
		$level_three_pmtctc = array(
			array('name' => 'PC6 | NVP Liquid OD for 12 weeks', 'y' =>array()),
			array('name' => 'PC7 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD for 6 weeks', 'y' =>array()),
			array('name' => 'PC5 | 3TC Liquid BD', 'y' =>array()),
			array('name' => 'PC9 | AZT liquid BID for 12 weeks', 'y' =>array()),
			array('name' => 'PC8 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD until 6 weeks after complete cessation of Breastfeeding (mother NOT on ART)', 'y' =>array()),
			array('name' => 'PC1X | All other PMTCT regimens for Infants', 'y' =>array()),
			array('name' => 'PC1 | NVP OD up to 6 weeks of age for: (i) Infants born of mothers on HAART (Breastfeeding or not); (ii) ALL Non-Breastfeeding infants born of mothers not o', 'y' =>array()),
			array('name' => 'PC2 | NVP OD for Breastfeeding Infants until 1 week after complete cessation of Breastfeeding', 'y' =>array()),
			array('name' => 'PC4 | AZT Liquid BD for 6 weeks', 'y' =>array())
		);

		// adult first line regimen data
		$firstlna_level3 = array('id' => 'art_adult_first_line', 'name' => 'Art_adult_first_line', 'data' => array());
		$level_three_firstlna = array(
			array('name' => 'AF2B | TDF + 3TC + EFV', 'y' =>array()),
			array('name' => 'AF1A | AZT + 3TC + NVP', 'y' =>array()),
			array('name' => 'AF2A | TDF + 3TC + NVP', 'y' =>array()),
			array('name' => 'AF1B | AZT + 3TC + EFV', 'y' =>array()),
			array('name' => 'AF4B | ABC + 3TC + EFV', 'y' =>array()),
			array('name' => 'AF4A | ABC + 3TC + NVP', 'y' =>array()),
			array('name' => 'AF5X | All other 1st line Adult regimens', 'y' =>array()),
			array('name' => 'AF1D | AZT + 3TC + DTG', 'y' =>array()),
			array('name' => 'AF2F | TDF + 3TC + LPV/r (1L Adults <40kg)', 'y' =>array()),
			array('name' => 'AF3A | d4T + 3TC + NVP', 'y' =>array()),
			array('name' => 'AF2E | TDF + 3TC + DTG', 'y' =>array()),
			array('name' => 'AF2G | TDF + 3TC + RAL (PWIDs intoIerant to ATV)', 'y' =>array()),
			array('name' => 'AF4C | ABC + 3TC + DTG', 'y' =>array()),
			array('name' => 'AF2H | TDF + FTC + ATV/r', 'y' =>array()),
			array('name' => 'AF3B | d4T + 3TC + EFV', 'y' =>array()),
			array('name' => 'AF3C | d4T + 3TC + ABC', 'y' =>array())
		);

		// paediatric first line regimen data
		$firstlnp_level3 = array('id' => 'art_paediatric_first_line', 'name' => 'Art_paediatric_first_line', 'data' => array());
		$level_three_firstlnp = array(
			array('name' => 'CF2B | ABC + 3TC + EFV', 'y' =>array()),
			array('name' => 'CF1A | AZT + 3TC + NVP', 'y' =>array()),
			array('name' => 'CF2A | ABC + 3TC + NVP', 'y' =>array()),
			array('name' => 'CF2D | ABC + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'CF1B | AZT + 3TC + EFV', 'y' =>array()),
			array('name' => 'CF1C | AZT + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'CF4B | TDF + 3TC + EFV', 'y' =>array()),
			array('name' => 'CF1D | AZT + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'CF4A | TDF + 3TC + NVP', 'y' =>array()),
			array('name' => 'CF4C | TDF + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'CF4D | TDF + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'CF2E | ABC + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'CF5X | All other 1st line Paediatric regimens', 'y' =>array()),
			array('name' => 'CF1E | AZT + 3TC + RAL', 'y' =>array()),
			array('name' => 'CF3B | d4T + 3TC + EFV for children weighing >= 25kg', 'y' =>array()),
			array('name' => 'CF2F | ABC + 3TC + RAL', 'y' =>array()),
			array('name' => 'CF3A | d4T + 3TC + NVP for children weighing >= 25kg', 'y' =>array())
		);

		// adult second line regimen data
		$seclna_level3 = array('id' => 'art_adult_second_line', 'name' => 'Art_adult_second_line', 'data' => array());
		$level_three_seclna = array(
			array('name' => 'AS2A | TDF + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'AS2C | TDF + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'AS1B | AZT + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'AS1A | AZT + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'AS5A | ABC + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'AS5B | ABC + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'AS6X | All other 2nd line Adult regimens', 'y' =>array())
		);

		// paediatric 2nd line regimen data
		$seclnp_level3 = array('id' => 'art_paediatric_second_line', 'name' => 'Art_paediatric_second_line', 'data' => array());
		$level_three_seclnp = array(
			array('name' => 'CS2A | ABC + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'CS1A | AZT + 3TC + LPV/r', 'y' =>array()),
			array('name' => 'CS2B | ABC + ddI + LPV/r', 'y' =>array()),
			array('name' => 'CS1B | AZT + 3TC + ATV/r', 'y' =>array()),
			array('name' => 'CS4X | All other 2nd line Paediatric regimens', 'y' =>array())
		);

		// adult 3rd line regimen data
		$thrdlna_level3 = array('id' => 'art_adult_third_line', 'name' => 'Art_adult_third_line', 'data' => array());
		$level_three_thrdlna = array(
			array('name' => 'AT3A | DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT1F | RAL + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT4C | DTG + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT1G | RAL + other backbone ARVs (2nd Line patients failing treatment)', 'y' =>array()),
			array('name' => 'AT4A | DTG + DRV + RTV + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT4B | DTG + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT1C | RAL + 3TC + DRV + RTV + TDF', 'y' =>array()),
			array('name' => 'AT2B | ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT2X | All other 3rd line Adult regimens', 'y' =>array()),
			array('name' => 'AT1B | RAL + 3TC + DRV + RTV + AZT', 'y' =>array()),
			array('name' => 'AT2C | ETV + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT1A | RAL + 3TC + DRV + RTV', 'y' =>array()),
			array('name' => 'AT1D | RAL + DRV + RTV + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT1E | RAL + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'AT2A | ETV + 3TC + DRV + RTV', 'y' =>array())
		);

		// paediatric 3rd line regimen data
		$thrdlnp_level3 = array('id' => 'art_paediatric_third_line', 'name' => 'Art_paediatric_third_line', 'data' => array());
		$level_three_thrdlnp = array(
			array('name' => 'CT1F | RAL + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT3X | All other 3rd line Paediatric regimens', 'y' =>array()),
			array('name' => 'CT4A | DTG + DRV + RTV + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1C | RAL + 3TC + DRV + RTV + ABC', 'y' =>array()),
			array('name' => 'CT4C | DTG + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1D | RAL + DRV + RTV + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT4D | DTG + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1G | RAL + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT2B | ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT3A | DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1B | RAL + 3TC + DRV + RTV + AZT', 'y' =>array()),
			array('name' => 'CT4B | DTG + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1E | RAL + ETV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT2A | ETV + 3TC + DRV + RTV', 'y' =>array()),
			array('name' => 'CT2C | ETV + DRV + RTV + other backbone ARVs', 'y' =>array()),
			array('name' => 'CT1A | RAL + 3TC + DRV + RTV', 'y' =>array())
		);

		$this->db->select("
		SUM(IF(regimen= 'HPB1A | TDF + 3TC (HIV-ve HepB patients)', total, 0)) hpb1a,
		SUM(IF(regimen= 'HPB1B | TDF + FTC (HIV-ve HepB patients)', total, 0)) hpb1b,
		SUM(IF(regimen= 'PRP1A | TDF + FTC (PrEP)', total, 0)) prp1a,
		SUM(IF(regimen= 'PRP1B | TDF + 3TC (PrEP)', total, 0)) prp1b,
		SUM(IF(regimen= 'PRP1C | TDF (PrEP)', total, 0)) prp1c,
		SUM(IF(regimen= 'PA3C | TDF + 3TC + ATV/r (Adult PEP)', total, 0)) pa3c,
		SUM(IF(regimen= 'PA1C | AZT + 3TC + ATV/r (Adult PEP)', total, 0)) pa1c,
		SUM(IF(regimen= 'PA4X | All other PEP regimens for Adults', total, 0)) pa4x,
		SUM(IF(regimen= 'PA3B | TDF + 3TC + LPV/r (Adult PEP)', total, 0)) pa3b,
		SUM(IF(regimen= 'PA1B | AZT + 3TC + LPV/r (Adult PEP)', total, 0)) pa1b,
		SUM(IF(regimen= 'PC4X | All other PEP regimens for Children', total, 0)) pc4x,
		SUM(IF(regimen= 'PC1A | AZT + 3TC + LPV/r (Paed PEP)', total, 0)) pc1a,
		SUM(IF(regimen= 'PC2A | d4T + 3TC + LPV/r (Paed PEP Option 2)', total, 0)) pc2a,
		SUM(IF(regimen= 'OI1A | Adult patients (=>15 Yrs) on Cotrimoxazole prophylaxis', total, 0)) oi1a,
		SUM(IF(regimen= 'OI1C | Paediatric patients (<15 Yrs) on Cotrimoxazole prophylaxis', total, 0)) oi1c,
		SUM(IF(regimen= 'OI2A | Adult patients (=>15 Yrs) on Dapsone prophylaxis', total, 0)) oi2a,
		SUM(IF(regimen= 'OI2C | Paediatric patients (<15 Yrs) on Dapsone prophylaxis', total, 0)) oi2c,
		SUM(IF(regimen= 'OC3N | New patients with OC on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) oc3n,
		SUM(IF(regimen= 'OI3A | Adult patients on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) oi3a,
		SUM(IF(regimen= 'OI3C | Paed patients on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) oi3c,
		SUM(IF(regimen= 'OC3R | Revisit patients with OC on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) oc3r,
		SUM(IF(regimen= 'CM3R | Revisit patients with CM on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) cm3r,
		SUM(IF(regimen= 'CM3N | New patients with CM on Diflucan (For Diflucan Donation Program ONLY)', total, 0)) cm3n,
		SUM(IF(regimen= 'OI4A | Adult patients (=>15 Yrs) on Isoniazid prophylaxis', total, 0)) oi4a,
		SUM(IF(regimen= 'OI4C | Paediatric patients (<15 Yrs) on Isoniazid prophylaxis', total, 0)) oi4c,
		SUM(IF(regimen= 'PM9 | PMTCT HAART: TDF + 3TC + EFV', total, 0)) pm9,
		SUM(IF(regimen= 'PM6 | PMTCT HAART: TDF + 3TC + NVP', total, 0)) pm6,
		SUM(IF(regimen= 'PM3 | PMTCT HAART: AZT + 3TC + NVP', total, 0)) pm3,
		SUM(IF(regimen= 'PM4 | PMTCT HAART: AZT + 3TC + EFV', total, 0)) pm4,
		SUM(IF(regimen= 'PM7 | PMTCT HAART: TDF + 3TC + LPV/r', total, 0)) pm7,
		SUM(IF(regimen= 'PM5 | PMTCT HAART: AZT + 3TC + LPV/r', total, 0)) pm5,
		SUM(IF(regimen= 'PM11 | PMTCT HAART: TDF + 3TC + ATV/r', total, 0)) pm11,
		SUM(IF(regimen= 'PM10 | PMTCT HAART: AZT + 3TC + ATV/r', total, 0)) pm10,
		SUM(IF(regimen= 'PM1X | All other PMTCT regimens for Women', total, 0)) pm1x,
		SUM(IF(regimen= 'PM1 | AZT 300mg BD (from week 14 to Delivery); then NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/', total, 0)) pm1,
		SUM(IF(regimen= 'PM2 | NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/150mg BD for one week post-partum', total, 0)) pm2,
		SUM(IF(regimen= 'PC6 | NVP Liquid OD for 12 weeks', total, 0)) pc6,
		SUM(IF(regimen= 'PC7 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD for 6 weeks', total, 0)) pc7,
		SUM(IF(regimen= 'PC5 | 3TC Liquid BD', total, 0)) pc5,
		SUM(IF(regimen= 'PC9 | AZT liquid BID for 12 weeks', total, 0)) pc9,
		SUM(IF(regimen= 'PC8 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD until 6 weeks after complete cessation of Breastfeeding (mother NOT on ART)', total, 0)) pc8,
		SUM(IF(regimen= 'PC1X | All other PMTCT regimens for Infants', total, 0)) pc1x,
		SUM(IF(regimen= 'PC1 | NVP OD up to 6 weeks of age for: (i) Infants born of mothers on HAART (Breastfeeding or not); (ii) ALL Non-Breastfeeding infants born of mothers not o', total, 0)) pc1,
		SUM(IF(regimen= 'PC2 | NVP OD for Breastfeeding Infants until 1 week after complete cessation of Breastfeeding', total, 0)) pc2,
		SUM(IF(regimen= 'PC4 | AZT Liquid BD for 6 weeks', total, 0)) pc4,
		SUM(IF(regimen= 'AF2B | TDF + 3TC + EFV', total, 0)) af2b,
		SUM(IF(regimen= 'AF1A | AZT + 3TC + NVP', total, 0)) af1a,
		SUM(IF(regimen= 'AF2A | TDF + 3TC + NVP', total, 0)) af2a,
		SUM(IF(regimen= 'AF1B | AZT + 3TC + EFV', total, 0)) af1b,
		SUM(IF(regimen= 'AF4B | ABC + 3TC + EFV', total, 0)) af4b,
		SUM(IF(regimen= 'AF4A | ABC + 3TC + NVP', total, 0)) af4a,
		SUM(IF(regimen= 'AF5X | All other 1st line Adult regimens', total, 0)) af5x,
		SUM(IF(regimen= 'AF1D | AZT + 3TC + DTG', total, 0)) af1d,
		SUM(IF(regimen= 'AF2F | TDF + 3TC + LPV/r (1L Adults <40kg)', total, 0)) af2f,
		SUM(IF(regimen= 'AF3A | d4T + 3TC + NVP', total, 0)) af3a,
		SUM(IF(regimen= 'AF2E | TDF + 3TC + DTG', total, 0)) af2e,
		SUM(IF(regimen= 'AF2G | TDF + 3TC + RAL (PWIDs intoIerant to ATV)', total, 0)) af2g,
		SUM(IF(regimen= 'AF4C | ABC + 3TC + DTG', total, 0)) af4c,
		SUM(IF(regimen= 'AF2H | TDF + FTC + ATV/r', total, 0)) af2h,
		SUM(IF(regimen= 'AF3B | d4T + 3TC + EFV', total, 0)) af3b,
		SUM(IF(regimen= 'AF3C | d4T + 3TC + ABC', total, 0)) af3c,
		SUM(IF(regimen= 'CF2B | ABC + 3TC + EFV', total, 0)) cf2b,
		SUM(IF(regimen= 'CF1A | AZT + 3TC + NVP', total, 0)) cf1a,
		SUM(IF(regimen= 'CF2A | ABC + 3TC + NVP', total, 0)) cf2a,
		SUM(IF(regimen= 'CF2D | ABC + 3TC + LPV/r', total, 0)) cf2d,
		SUM(IF(regimen= 'CF1B | AZT + 3TC + EFV', total, 0)) cf1b,
		SUM(IF(regimen= 'CF1C | AZT + 3TC + LPV/r', total, 0)) cf1c,
		SUM(IF(regimen= 'CF4B | TDF + 3TC + EFV', total, 0)) cf4b,
		SUM(IF(regimen= 'CF1D | AZT + 3TC + ATV/r', total, 0)) cf1d,
		SUM(IF(regimen= 'CF4A | TDF + 3TC + NVP', total, 0)) cf4a,
		SUM(IF(regimen= 'CF4C | TDF + 3TC + LPV/r', total, 0)) cf4c,
		SUM(IF(regimen= 'CF4D | TDF + 3TC + ATV/r', total, 0)) cf4d,
		SUM(IF(regimen= 'CF2E | ABC + 3TC + ATV/r', total, 0)) cf2e,
		SUM(IF(regimen= 'CF5X | All other 1st line Paediatric regimens', total, 0)) cf5x,
		SUM(IF(regimen= 'CF1E | AZT + 3TC + RAL', total, 0)) cf1e,
		SUM(IF(regimen= 'CF3B | d4T + 3TC + EFV for children weighing >= 25kg', total, 0)) cf3b,
		SUM(IF(regimen= 'CF2F | ABC + 3TC + RAL', total, 0)) cf2f,
		SUM(IF(regimen= 'CF3A | d4T + 3TC + NVP for children weighing >= 25kg', total, 0)) cf3a,
		SUM(IF(regimen= 'AS2A | TDF + 3TC + LPV/r', total, 0)) as2a,
		SUM(IF(regimen= 'AS2C | TDF + 3TC + ATV/r', total, 0)) as2c,
		SUM(IF(regimen= 'AS1B | AZT + 3TC + ATV/r', total, 0)) as1b,
		SUM(IF(regimen= 'AS1A | AZT + 3TC + LPV/r', total, 0)) as1a,
		SUM(IF(regimen= 'AS5A | ABC + 3TC + LPV/r', total, 0)) as5a,
		SUM(IF(regimen= 'AS5B | ABC + 3TC + ATV/r', total, 0)) as5b,
		SUM(IF(regimen= 'AS6X | All other 2nd line Adult regimens', total, 0)) as6x,
		SUM(IF(regimen= 'CS2A | ABC + 3TC + LPV/r', total, 0)) cs2a,
		SUM(IF(regimen= 'CS1A | AZT + 3TC + LPV/r', total, 0)) cs1a,
		SUM(IF(regimen= 'CS2B | ABC + ddI + LPV/r', total, 0)) cs2b,
		SUM(IF(regimen= 'CS1B | AZT + 3TC + ATV/r', total, 0)) cs1b,
		SUM(IF(regimen= 'CS4X | All other 2nd line Paediatric regimens', total, 0)) cs4x,
		SUM(IF(regimen= 'AT3A | DRV + RTV + other backbone ARVs', total, 0)) at3a,
		SUM(IF(regimen= 'AT1F | RAL + DRV + RTV + other backbone ARVs', total, 0)) at1f,
		SUM(IF(regimen= 'AT4C | DTG + DRV + RTV + other backbone ARVs', total, 0)) at4c,
		SUM(IF(regimen= 'AT1G | RAL + other backbone ARVs (2nd Line patients failing treatment)', total, 0)) at1g,
		SUM(IF(regimen= 'AT4A | DTG + DRV + RTV + ETV + other backbone ARVs', total, 0)) at4a,
		SUM(IF(regimen= 'AT4B | DTG + ETV + other backbone ARVs', total, 0)) at4b,
		SUM(IF(regimen= 'AT1C | RAL + 3TC + DRV + RTV + TDF', total, 0)) at1c,
		SUM(IF(regimen= 'AT2B | ETV + other backbone ARVs', total, 0)) at2b,
		SUM(IF(regimen= 'AT2X | All other 3rd line Adult regimens', total, 0)) at2x,
		SUM(IF(regimen= 'AT1B | RAL + 3TC + DRV + RTV + AZT', total, 0)) at1b,
		SUM(IF(regimen= 'AT2C | ETV + DRV + RTV + other backbone ARVs', total, 0)) at2c,
		SUM(IF(regimen= 'AT1A | RAL + 3TC + DRV + RTV', total, 0)) at1a,
		SUM(IF(regimen= 'AT1D | RAL + DRV + RTV + ETV + other backbone ARVs', total, 0)) at1d,
		SUM(IF(regimen= 'AT1E | RAL + ETV + other backbone ARVs', total, 0)) at1e,
		SUM(IF(regimen= 'AT2A | ETV + 3TC + DRV + RTV', total, 0)) at2a,
		SUM(IF(regimen= 'CT1F | RAL + DRV + RTV + other backbone ARVs', total, 0)) ct1f,
		SUM(IF(regimen= 'CT3X | All other 3rd line Paediatric regimens', total, 0)) ct3x,
		SUM(IF(regimen= 'CT4A | DTG + DRV + RTV + ETV + other backbone ARVs', total, 0)) ct4a,
		SUM(IF(regimen= 'CT1C | RAL + 3TC + DRV + RTV + ABC', total, 0)) ct1c,
		SUM(IF(regimen= 'CT4C | DTG + DRV + RTV + other backbone ARVs', total, 0)) ct4c,
		SUM(IF(regimen= 'CT1D | RAL + DRV + RTV + ETV + other backbone ARVs', total, 0)) ct1d,
		SUM(IF(regimen= 'CT4D | DTG + other backbone ARVs', total, 0)) ct4d,
		SUM(IF(regimen= 'CT1G | RAL + other backbone ARVs', total, 0)) ct1g,
		SUM(IF(regimen= 'CT2B | ETV + other backbone ARVs', total, 0)) ct2b,
		SUM(IF(regimen= 'CT3A | DRV + RTV + other backbone ARVs', total, 0)) ct3a,
		SUM(IF(regimen= 'CT1B | RAL + 3TC + DRV + RTV + AZT', total, 0)) ct1b,
		SUM(IF(regimen= 'CT4B | DTG + ETV + other backbone ARVs', total, 0)) ct4b,
		SUM(IF(regimen= 'CT1E | RAL + ETV + other backbone ARVs', total, 0)) ct1e,
		SUM(IF(regimen= 'CT2A | ETV + 3TC + DRV + RTV', total, 0)) ct2a,
		SUM(IF(regimen= 'CT2C | ETV + DRV + RTV + other backbone ARVs', total, 0)) ct2c,
		SUM(IF(regimen= 'CT1A | RAL + 3TC + DRV + RTV', total, 0)) ct1a
		", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		if($results){
			foreach ($results as $result) {
				// hepb regimen results
				foreach ($level_three_hepb as $index => $scaleup) {
					if($scaleup['name'] == 'HPB1A | TDF + 3TC (HIV-ve HepB patients)'){
						$level_three_hepb[$index]['y'] = $result['hpb1a'];
					}else if($scaleup['name'] == 'HPB1B | TDF + FTC (HIV-ve HepB patients)'){
						$level_three_hepb[$index]['y'] = $result['hpb1b'];
					}
					$hepb_level3['data'] = $level_three_hepb;
				}
				// prep regimen results
				foreach ($level_three_prep as $index => $scaleup) {
					if($scaleup['name'] == 'PRP1A | TDF + FTC (PrEP)'){
						$level_three_prep[$index]['y'] = $result['prp1a'];
					}else if($scaleup['name'] == 'PRP1B | TDF + 3TC (PrEP)'){
						$level_three_prep[$index]['y'] = $result['prp1b'];
					}else if($scaleup['name'] == 'PRP1C | TDF (PrEP)'){
						$level_three_prep[$index]['y'] = $result['prp1c'];
					}
					$prep_level3['data'] = $level_three_prep;
				}
				// pep adult regimen results
				foreach ($level_three_pep as $index => $scaleup) {
					if($scaleup['name'] == 'PA3C | TDF + 3TC + ATV/r (Adult PEP)'){
						$level_three_pep[$index]['y'] = $result['pa3c'];
					}else if($scaleup['name'] == 'PA1C | AZT + 3TC + ATV/r (Adult PEP)'){
						$level_three_pep[$index]['y'] = $result['pa1c'];
					}else if($scaleup['name'] == 'PA4X | All other PEP regimens for Adults'){
						$level_three_pep[$index]['y'] = $result['pa4x'];
					}else if($scaleup['name'] == 'PA3B | TDF + 3TC + LPV/r (Adult PEP)'){
						$level_three_pep[$index]['y'] = $result['pa3b'];
					}else if($scaleup['name'] == 'PA1B | AZT + 3TC + LPV/r (Adult PEP)'){
						$level_three_pep[$index]['y'] = $result['pa1b'];
					}
					$pep_level3['data'] = $level_three_pep;
				}
				// pep child regimen results
				foreach ($level_three_pepc as $index => $scaleup) {
					if($scaleup['name'] == 'PC4X | All other PEP regimens for Children'){
						$level_three_pepc[$index]['y'] = $result['pc4x'];
					}else if($scaleup['name'] == 'PC1A | AZT + 3TC + LPV/r (Paed PEP)'){
						$level_three_pepc[$index]['y'] = $result['pc1a'];
					}else if($scaleup['name'] == 'PC2A | d4T + 3TC + LPV/r (Paed PEP Option 2)'){
						$level_three_pepc[$index]['y'] = $result['pc2a'];
					}
					$pepc_level3['data'] = $level_three_pepc;
				}
				// oi only universal regimen results
				foreach ($level_three_oiuni as $index => $scaleup) {
					if($scaleup['name'] == 'OI1A | Adult patients (=>15 Yrs) on Cotrimoxazole prophylaxis'){
						$level_three_oiuni[$index]['y'] = $result['oi1a'];
					}else if($scaleup['name'] == 'OI1C | Paediatric patients (<15 Yrs) on Cotrimoxazole prophylaxis'){
						$level_three_oiuni[$index]['y'] = $result['oi1c'];
					}else if($scaleup['name'] == 'OI2A | Adult patients (=>15 Yrs) on Dapsone prophylaxis'){
						$level_three_oiuni[$index]['y'] = $result['oi2a'];
					}else if($scaleup['name'] == 'OI2C | Paediatric patients (<15 Yrs) on Dapsone prophylaxis'){
						$level_three_oiuni[$index]['y'] = $result['oi2c'];
					}
					$oiuni_level3['data'] = $level_three_oiuni;
				}
				// oi {oc} and {cm} regimen results
				foreach ($level_three_oicmoc as $index => $scaleup) {
					if($scaleup['name'] == 'OC3N | New patients with OC on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['oc3n'];
					}else if($scaleup['name'] == 'OI3A | Adult patients on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['oi3a'];
					}else if($scaleup['name'] == 'OI3C | Paed patients on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['oi3c'];
					}else if($scaleup['name'] == 'OC3R | Revisit patients with OC on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['oc3r'];
					}else if($scaleup['name'] == 'CM3R | Revisit patients with CM on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['cm3r'];
					}else if($scaleup['name'] == 'CM3N | New patients with CM on Diflucan (For Diflucan Donation Program ONLY)'){
						$level_three_oicmoc[$index]['y'] = $result['cm3n'];
					}
					$oicmoc_level3['data'] = $level_three_oicmoc;
				}
				// oi 2 ipt regimen results
				foreach ($level_three_oi2ipt as $index => $scaleup) {
					if($scaleup['name'] == 'OI4A | Adult patients (=>15 Yrs) on Isoniazid prophylaxis'){
						$level_three_oi2ipt[$index]['y'] = $result['oi4a'];
					}else if($scaleup['name'] == 'OI4C | Paediatric patients (<15 Yrs) on Isoniazid prophylaxis'){
						$level_three_oi2ipt[$index]['y'] = $result['oi4c'];
					}
					$oi2ipt_level3['data'] = $level_three_oi2ipt;
				}
				// pmtct mother regimen results
				foreach ($level_three_pmtctm as $index => $scaleup) {
					if($scaleup['name'] == 'PM9 | PMTCT HAART: TDF + 3TC + EFV'){
						$level_three_pmtctm[$index]['y'] = $result['pm9'];
					}else if($scaleup['name'] == 'PM6 | PMTCT HAART: TDF + 3TC + NVP'){
						$level_three_pmtctm[$index]['y'] = $result['pm6'];
					}else if($scaleup['name'] == 'PM3 | PMTCT HAART: AZT + 3TC + NVP'){
						$level_three_pmtctm[$index]['y'] = $result['pm3'];
					}else if($scaleup['name'] == 'PM4 | PMTCT HAART: AZT + 3TC + EFV'){
						$level_three_pmtctm[$index]['y'] = $result['pm4'];
					}else if($scaleup['name'] == 'PM7 | PMTCT HAART: TDF + 3TC + LPV/r'){
						$level_three_pmtctm[$index]['y'] = $result['pm7'];
					}else if($scaleup['name'] == 'PM5 | PMTCT HAART: AZT + 3TC + LPV/r'){
						$level_three_pmtctm[$index]['y'] = $result['pm5'];
					}else if($scaleup['name'] == 'PM11 | PMTCT HAART: TDF + 3TC + ATV/r'){
						$level_three_pmtctm[$index]['y'] = $result['pm11'];
					}else if($scaleup['name'] == 'PM10 | PMTCT HAART: AZT + 3TC + ATV/r'){
						$level_three_pmtctm[$index]['y'] = $result['pm10'];
					}else if($scaleup['name'] == 'PM1X | All other PMTCT regimens for Women'){
						$level_three_pmtctm[$index]['y'] = $result['pm1x'];
					}else if($scaleup['name'] == 'PM1 | AZT 300mg BD (from week 14 to Delivery); then NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/'){
						$level_three_pmtctm[$index]['y'] = $result['pm1'];
					}else if($scaleup['name'] == 'PM2 | NVP 200mg stat + AZT 600mg stat (or 300mg BD) + 3TC 150mg BD during labour; then 1 tab of AZT/3TC 300mg/150mg BD for one week post-partum'){
						$level_three_pmtctm[$index]['y'] = $result['pm2'];
					}
					$pmtctm_level3['data'] = $level_three_pmtctm;
				}
				// pmtct child regimen results
				foreach ($level_three_pmtctc as $index => $scaleup) {
					if($scaleup['name'] == 'PC6 | NVP Liquid OD for 12 weeks'){
						$level_three_pmtctc[$index]['y'] = $result['pc6'];
					}else if($scaleup['name'] == 'PC7 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD for 6 weeks'){
						$level_three_pmtctc[$index]['y'] = $result['pc7'];
					}else if($scaleup['name'] == 'PC5 | 3TC Liquid BD'){
						$level_three_pmtctc[$index]['y'] = $result['pc5'];
					}else if($scaleup['name'] == 'PC9 | AZT liquid BID for 12 weeks'){
						$level_three_pmtctc[$index]['y'] = $result['pc9'];
					}else if($scaleup['name'] == 'PC8 | AZT liquid BID + NVP liquid OD for 6 weeks then NVP liquid OD until 6 weeks after complete cessation of Breastfeeding (mother NOT on ART)'){
						$level_three_pmtctc[$index]['y'] = $result['pc8'];
					}else if($scaleup['name'] == 'PC1X | All other PMTCT regimens for Infants'){
						$level_three_pmtctc[$index]['y'] = $result['pc1x'];
					}else if($scaleup['name'] == 'PC1 | NVP OD up to 6 weeks of age for: (i) Infants born of mothers on HAART (Breastfeeding or not); (ii) ALL Non-Breastfeeding infants born of mothers not o'){
						$level_three_pmtctc[$index]['y'] = $result['pc1'];
					}else if($scaleup['name'] == 'PC2 | NVP OD for Breastfeeding Infants until 1 week after complete cessation of Breastfeeding'){
						$level_three_pmtctc[$index]['y'] = $result['pc2'];
					}else if($scaleup['name'] == 'PC4 | AZT Liquid BD for 6 weeks'){
						$level_three_pmtctc[$index]['y'] = $result['pc4'];
					}
					$pmtctc_level3['data'] = $level_three_pmtctc;
				}
				//adult first line regimen results
				foreach ($level_three_firstlna as $index => $scaleup) {
					if($scaleup['name'] == 'AF2B | TDF + 3TC + EFV'){
						$level_three_firstlna[$index]['y'] = $result['af2b'];
					}else if($scaleup['name'] == 'AF1A | AZT + 3TC + NVP'){
						$level_three_firstlna[$index]['y'] = $result['af1a'];
					}else if($scaleup['name'] == 'AF2A | TDF + 3TC + NVP'){
						$level_three_firstlna[$index]['y'] = $result['af2a'];
					}else if($scaleup['name'] == 'AF1B | AZT + 3TC + EFV'){
						$level_three_firstlna[$index]['y'] = $result['af1b'];
					}else if($scaleup['name'] == 'AF4B | ABC + 3TC + EFV'){
						$level_three_firstlna[$index]['y'] = $result['af4b'];
					}else if($scaleup['name'] == 'AF4A | ABC + 3TC + NVP'){
						$level_three_firstlna[$index]['y'] = $result['af4a'];
					}else if($scaleup['name'] == 'AF5X | All other 1st line Adult regimens'){
						$level_three_firstlna[$index]['y'] = $result['af5x'];
					}else if($scaleup['name'] == 'AF1D | AZT + 3TC + DTG'){
						$level_three_firstlna[$index]['y'] = $result['af1d'];
					}else if($scaleup['name'] == 'AF2F | TDF + 3TC + LPV/r (1L Adults <40kg)'){
						$level_three_firstlna[$index]['y'] = $result['af2f'];
					}else if($scaleup['name'] == 'AF3A | d4T + 3TC + NVP'){
						$level_three_firstlna[$index]['y'] = $result['af3a'];
					}else if($scaleup['name'] == 'AF2E | TDF + 3TC + DTG'){
						$level_three_firstlna[$index]['y'] = $result['af2e'];
					}else if($scaleup['name'] == 'AF2G | TDF + 3TC + RAL (PWIDs intoIerant to ATV)'){
						$level_three_firstlna[$index]['y'] = $result['af2g'];
					}else if($scaleup['name'] == 'AF4C | ABC + 3TC + DTG'){
						$level_three_firstlna[$index]['y'] = $result['af4c'];
					}else if($scaleup['name'] == 'AF2H | TDF + FTC + ATV/r'){
						$level_three_firstlna[$index]['y'] = $result['af2h'];
					}else if($scaleup['name'] == 'AF3B | d4T + 3TC + EFV'){
						$level_three_firstlna[$index]['y'] = $result['af3b'];
					}else if($scaleup['name'] == 'AF3C | d4T + 3TC + ABC'){
						$level_three_firstlna[$index]['y'] = $result['af3c'];
					}
					$firstlna_level3['data'] = $level_three_firstlna;
				}
				//paediatric first line regimen results
				foreach ($level_three_firstlnp as $index => $scaleup) {
					if($scaleup['name'] == 'CF2B | ABC + 3TC + EFV'){
						$level_three_firstlnp[$index]['y'] = $result['cf2b'];
					}else if($scaleup['name'] == 'CF1A | AZT + 3TC + NVP'){
						$level_three_firstlnp[$index]['y'] = $result['cf1a'];
					}else if($scaleup['name'] == 'CF2A | ABC + 3TC + NVP'){
						$level_three_firstlnp[$index]['y'] = $result['cf2a'];
					}else if($scaleup['name'] == 'CF2D | ABC + 3TC + LPV/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf2d'];
					}else if($scaleup['name'] == 'CF1B | AZT + 3TC + EFV'){
						$level_three_firstlnp[$index]['y'] = $result['cf1b'];
					}else if($scaleup['name'] == 'CF1C | AZT + 3TC + LPV/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf1c'];
					}else if($scaleup['name'] == 'CF4B | TDF + 3TC + EFV'){
						$level_three_firstlnp[$index]['y'] = $result['cf4b'];
					}else if($scaleup['name'] == 'CF1D | AZT + 3TC + ATV\/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf1d'];
					}else if($scaleup['name'] == 'CF4A | TDF + 3TC + NVP'){
						$level_three_firstlnp[$index]['y'] = $result['cf4a'];
					}else if($scaleup['name'] == 'CF4C | TDF + 3TC + LPV/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf4c'];
					}else if($scaleup['name'] == 'CF4D | TDF + 3TC + ATV/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf4d'];
					}else if($scaleup['name'] == 'CF2E | ABC + 3TC + ATV/r'){
						$level_three_firstlnp[$index]['y'] = $result['cf2e'];
					}else if($scaleup['name'] == 'CF5X | All other 1st line Paediatric regimens'){
						$level_three_firstlnp[$index]['y'] = $result['cf5x'];
					}else if($scaleup['name'] == 'CF1E | AZT + 3TC + RAL'){
						$level_three_firstlnp[$index]['y'] = $result['cf1e'];
					}else if($scaleup['name'] == 'CF3B | d4T + 3TC + EFV for children weighing >= 25kg'){
						$level_three_firstlnp[$index]['y'] = $result['cf3b'];
					}else if($scaleup['name'] == 'CF2F | ABC + 3TC + RAL'){
						$level_three_firstlnp[$index]['y'] = $result['cf2f'];
					}else if($scaleup['name'] == 'CF3A | d4T + 3TC + NVP for children weighing >= 25kg'){
						$level_three_firstlnp[$index]['y'] = $result['cf3a'];
					}
					$firstlnp_level3['data'] = $level_three_firstlnp;
				}
				//adult 2nd line regimen results
				foreach ($level_three_seclna as $index => $scaleup) {
					if($scaleup['name'] == 'AS2A | TDF + 3TC + LPV/r'){
						$level_three_seclna[$index]['y'] = $result['as2a'];
					}else if($scaleup['name'] == 'AS2C | TDF + 3TC + ATV/r'){
						$level_three_seclna[$index]['y'] = $result['as2c'];
					}else if($scaleup['name'] == 'AS1B | AZT + 3TC + ATV/r'){
						$level_three_seclna[$index]['y'] = $result['as1b'];
					}else if($scaleup['name'] == 'AS1A | AZT + 3TC + LPV/r'){
						$level_three_seclna[$index]['y'] = $result['as1a'];
					}else if($scaleup['name'] == 'AS5A | ABC + 3TC + LPV/r'){
						$level_three_seclna[$index]['y'] = $result['as5a'];
					}else if($scaleup['name'] == 'AS5B | ABC + 3TC + ATV/r'){
						$level_three_seclna[$index]['y'] = $result['as5b'];
					}else if($scaleup['name'] == 'AS6X | All other 2nd line Adult regimens'){
						$level_three_seclna[$index]['y'] = $result['as6x'];
					}
					$seclna_level3['data'] = $level_three_seclna;
				}
				//paediatric 2nd line regimen results
				foreach ($level_three_seclnp as $index => $scaleup) {
					if($scaleup['name'] == 'CS2A | ABC + 3TC + LPV/r'){
						$level_three_seclnp[$index]['y'] = $result['cs2a'];
					}else if($scaleup['name'] == 'CS1A | AZT + 3TC + LPV/r'){
						$level_three_seclnp[$index]['y'] = $result['cs1a'];
					}else if($scaleup['name'] == 'CS2B | ABC + ddI + LPV/r'){
						$level_three_seclnp[$index]['y'] = $result['cs2b'];
					}else if($scaleup['name'] == 'CS1B | AZT + 3TC + ATV/r'){
						$level_three_seclnp[$index]['y'] = $result['cs1b'];
					}else if($scaleup['name'] == 'CS4X | All other 2nd line Paediatric regimens'){
						$level_three_seclnp[$index]['y'] = $result['cs4x'];
					}
					$seclnp_level3['data'] = $level_three_seclnp;
				}
				//adult 3rd line regimen results
				foreach ($level_three_thrdlna as $index => $scaleup) {
					if($scaleup['name'] == 'AT3A | DRV + RTV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at3a'];
					}else if($scaleup['name'] == 'AT1F | RAL + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at1f'];
					}else if($scaleup['name'] == 'AT4C | DTG + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at4c'];
					}else if($scaleup['name'] == 'AT1G | RAL + other backbone ARVs (2nd Line patients failing treatment)'){
						$level_three_thrdlna[$index]['y'] = $result['at1g'];
					}else if($scaleup['name'] == 'AT4A | DTG + DRV + RTV + ETV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at4a'];
					}else if($scaleup['name'] == 'AT4B | DTG + ETV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at4b'];
					}else if($scaleup['name'] == 'AT1C | RAL + 3TC + DRV + RTV + TDF'){
						$level_three_thrdlna[$index]['y'] = $result['at1c'];
					}else if($scaleup['name'] == 'AT2B | ETV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at2b'];
					}else if($scaleup['name'] == 'AT2X | All other 3rd line Adult regimens'){
						$level_three_thrdlna[$index]['y'] = $result['at2x'];
					}else if($scaleup['name'] == 'AT1B | RAL + 3TC + DRV + RTV + AZT'){
						$level_three_thrdlna[$index]['y'] = $result['at1b'];
					}else if($scaleup['name'] == 'AT2C | ETV + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at2c'];
					}else if($scaleup['name'] == 'AT1A | RAL + 3TC + DRV + RTV'){
						$level_three_thrdlna[$index]['y'] = $result['at1a'];
					}else if($scaleup['name'] == 'AT1D | RAL + DRV + RTV + ETV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at1d'];
					}else if($scaleup['name'] == 'AT1E | RAL + ETV + other backbone ARVs'){
						$level_three_thrdlna[$index]['y'] = $result['at1e'];
					}else if($scaleup['name'] == 'AT2A | ETV + 3TC + DRV + RTV'){
						$level_three_thrdlna[$index]['y'] = $result['at2a'];
					}
					$thrdlna_level3['data'] = $level_three_thrdlna;
				}
				//paediatric 3rd line regimen results
				foreach ($level_three_thrdlnp as $index => $scaleup) {
					if($scaleup['name'] == 'CT1F | RAL + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1f'];
					}else if($scaleup['name'] == 'CT3X | All other 3rd line Paediatric regimens'){
						$level_three_thrdlnp[$index]['y'] = $result['ct3x'];
					}else if($scaleup['name'] == 'CT4A | DTG + DRV + RTV + ETV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct4a'];
					}else if($scaleup['name'] == 'CT1C | RAL + 3TC + DRV + RTV + ABC'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1c'];
					}else if($scaleup['name'] == 'CT4C | DTG + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct4c'];
					}else if($scaleup['name'] == 'CT1D | RAL + DRV + RTV + ETV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1d'];
					}else if($scaleup['name'] == 'CT4D | DTG + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct4d'];
					}else if($scaleup['name'] == 'CT1G | RAL + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1g'];
					}else if($scaleup['name'] == 'CT2B | ETV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct2b'];
					}else if($scaleup['name'] == 'CT3A | DRV + RTV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct3a'];
					}else if($scaleup['name'] == 'CT1B | RAL + 3TC + DRV + RTV + AZT'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1b'];
					}else if($scaleup['name'] == 'CT4B | DTG + ETV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct4b'];
					}else if($scaleup['name'] == 'CT1E | RAL + ETV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1e'];
					}else if($scaleup['name'] == 'CT2A | ETV + 3TC + DRV + RTV'){
						$level_three_thrdlnp[$index]['y'] = $result['ct2a'];
					}else if($scaleup['name'] == 'CT2C | ETV + DRV + RTV + other backbone ARVs'){
						$level_three_thrdlnp[$index]['y'] = $result['ct2c'];
					}else if($scaleup['name'] == 'CT1A | RAL + 3TC + DRV + RTV'){
						$level_three_thrdlnp[$index]['y'] = $result['ct1a'];
					}
					$thrdlnp_level3['data'] = $level_three_thrdlnp;
				}
			}
		$drilldown[] = array_merge($hepb_level3);
		$drilldown[] = array_merge($prep_level3);
		$drilldown[] = array_merge($pep_level3);
		$drilldown[] = array_merge($pepc_level3);
		$drilldown[] = array_merge($oiuni_level3);
		$drilldown[] = array_merge($oicmoc_level3);
		$drilldown[] = array_merge($oi2ipt_level3);
		$drilldown[] = array_merge($pmtctm_level3);
		$drilldown[] = array_merge($pmtctc_level3);
		$drilldown[] = array_merge($firstlna_level3);
		$drilldown[] = array_merge($firstlnp_level3);
		$drilldown[] = array_merge($seclna_level3);
		$drilldown[] = array_merge($seclnp_level3);
		$drilldown[] = array_merge($thrdlna_level3);
		$drilldown[] = array_merge($thrdlnp_level3);

		}
		return array('main' => $patient_services_data, 'drilldown' => $drilldown, 'columns' => $columns);
	}

	public function get_facility_commodity_consumption($filters) {
		$columns = array();
		$tmp_data = array();
		$consumption_data = array();
             
		$this->db->select("drug, CONCAT_WS('/', data_month, data_year) period, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('drug, period');
		$this->db->order_by("data_year ASC, FIELD( data_month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' )");
		$query = $this->db->get('dsh_consumption');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['period']);
			$tmp_data[$result['drug']]['data'][] = $result['total'];
		}

		$counter = 0;
		foreach ($tmp_data as $name => $item) {
			$consumption_data[$counter]['name'] = $name;
			$consumption_data[$counter]['data'] = $item['data'];
			$counter++;
		}
		return array('main' => $consumption_data, 'columns' => array_values(array_unique($columns)));
	}

	public function get_facility_patient_distribution_numbers($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(facility, 1, 1)),LOWER(SUBSTRING(facility, 2))) name, FORMAT(SUM(IF(regimen_service = 'ART', total, 0)), 0) ART, FORMAT(SUM(IF(regimen_service = 'PrEP', total, 0)), 0) PREP, FORMAT(SUM(IF(regimen_service = 'PEP', total, 0)), 0) PEP, FORMAT(SUM(CASE WHEN regimen_service = 'PMTCT' AND age_category = 'adult' THEN total ELSE 0 END), 0) 'PMTCT MOTHER', FORMAT(SUM(CASE WHEN regimen_service = 'PMTCT' AND age_category = 'paed' THEN total ELSE 0 END), 0) 'PMTCT CHILD', county as COUNTY, sub_county as 'SUB COUNTY'", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('total', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

	public function get_partner_patient_distribution($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(partner, 1, 1)),LOWER(SUBSTRING(partner, 2))) name, SUM(total) y", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('y', 'DESC');
		$this->db->limit(30);
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' => $results, 'columns' => $columns);
	}

	public function get_partner_patient_distribution_numbers($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(partner, 1, 1)),LOWER(SUBSTRING(partner, 2))) name, 1 sites, SUM(IF(age_category='adult', total, NULL)) adult, SUM(IF(age_category='paed', total, NULL)) paed, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by('total', 'DESC');
		$query = $this->db->get('dsh_patient');
		return array('main' => $query->result_array(), 'columns' => $columns);
	}

	public function get_adt_site_distribution($filters){
		$columns = array();

		$this->db->select("CONCAT(UCASE(SUBSTRING(county, 1, 1)),
		LOWER(SUBSTRING(county, 2))) name,
		count(county) total_sites,
		ROUND(SUM(case when installed = 'yes' then 1 else 0 end)/count(county)*100)  installed_percentage, 
		(100 - (ROUND(SUM(case when installed = 'yes' then 1 else 0 end)/count(county)*100))) not_yet_percentage,
		CONCAT('No. of Sites installed : ',SUM(case when installed = 'yes' then 1 else 0 end)) installed,
		CONCAT('No. of Not installed sites : ',count(county) -SUM(case when installed = 'yes' then 1 else 0 end)) not_yet", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('county');
		$this->db->order_by('installed_percentage', 'DESC');
		$query = $this->db->get('vw_facility');
		$results = $query->result_array();

		$data = array();
		$installed = array();
		$not_yet = array();
		foreach ($results as $result) {
			array_push($columns, $result['name']);
			foreach ($result as $key => $value) {
				// var_dump($result);die;
				if($key == 'installed_percentage'){
			array_push($installed, array('y'=>$value,'otherdata'=>$result['installed']));
				}else if($key == 'not_yet_percentage'){
			array_push($not_yet, array('y'=>$value,'otherdata'=>$result['not_yet']));

				}
			}
		}
		$data[] = array('name' => 'Percentage Installed sites', 'data' => $installed);
		$data[] = array('name' => 'Percentage not installed', 'data' => $not_yet);

		return array('main' => $data, 'columns' => $columns);
	}



	public function get_adt_site_overview(){
		$columns = array();

		$this->db->select("
			count(*) as total_facilities,
			round(SUM(case when category = 'central' then 1 else 0 end)) ordering_sites, 
			SUM(case when category = 'satellite' then 1 else 0 end) satellite,
			round(SUM(case when category = 'central' then 1 else 0 end)/count(*) * 100) ordering_sites_percentage,
			round(SUM(case when category = 'satellite' then 1 else 0 end)/count(*) * 100) satellite_sites_percentage
			", FALSE);
		$query = $this->db->get('tbl_facility');
		$result =  $query->result_array();
		return $result[0];
	}



	public function get_adt_site_distribution_numbers($filters){
		$columns = array();

		$this->db->select("facility, county, subcounty, partner, installed, version, internet, backup, active_patients", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->order_by('active_patients', 'DESC');
		$query = $this->db->get('dsh_site');
		return array('main' => $query->result_array(), 'columns' => $columns);

	}

	public function get_adt_site_summary_numbers($filters){
		$columns = array();

		$this->db->select("facility, county, subcounty, partner, installed, version, internet, backup, active_patients", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->order_by('active_patients', 'DESC');
		$query = $this->db->get('dsh_site');
		return array('main' => $query->result_array(), 'columns' => $columns);

	}


	public function get_regimen_patients($filters){
		$columns = array();
		$data = array();

		$this->db->select("regimen, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('regimen');
		$this->db->order_by("total DESC");
		$this->db->limit("20");
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($data, $result['total']);
		}

		foreach ($results as $result) {
			array_push($columns, $result['regimen']);
		}

		return array('main' =>  array(
			array(
				'type' => 'column', 
				'name' => 'Regimen',
				'data' => $data
			))
		, 'columns' => $columns);

	}

	public function get_regimen_top_commodities($filters){
		$columns = array();
		$data = array();

		$this->db->select("drug, sum(total) as total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if((!is_array($filter)) && strlen($filter)<2){
					continue;
				}
				if ($category == 'data_date' && (strlen($filter)>3)){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}

				$this->db->where_in($category, $filter);
			}
		}

		$this->db->group_by('drug');
		$this->db->order_by("total DESC");
		$this->db->limit("20");
		$query = $this->db->get('vw_regimen_drug');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($data, $result['total']);
		}

		foreach ($results as $result) {
			array_push($columns, $result['drug']);
		}

		return array('main' =>  array(
			array(
				'type' => 'column', 
				'name' => 'Drug',
				'data' => $data
			))
		, 'columns' => $columns);

	} 

	public function get_regimen_consumption($filters){

		$columns = array();
		$data = array();

		$this->db->select("CONCAT_WS('/', data_month, data_year) period,drug, sum(total) as total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('period');
		$this->db->order_by("data_date ASC");
		$query = $this->db->get('vw_regimen_drug');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($data, $result['total']);
		}

		foreach ($results as $result) {
			array_push($columns, $result['period']);
		}
		foreach ($results as $result) {
			array_push($columns, $result['drug']);
		}

		return array('main' =>  array(
			array(
				'type' => 'column', 
				'name' => 'period',
				'data' => $data
			))
		, 'columns' => $columns);

	}

	public function get_regimen_patients_by_county($filters){
		$columns = array();
		$data = array();

		$this->db->select("county, SUM(total) total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				if ($category == 'data_date'){
					$this->db->where("data_date <=",date('Y-m',strtotime($filter)).'-01');
					continue;
				}
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('county');
		$this->db->order_by("total DESC");
		$query = $this->db->get('dsh_patient');
		$results = $query->result_array();

		foreach ($results as $result) {
			array_push($data, $result['total']);
		}

		foreach ($results as $result) {
			array_push($columns, $result['county']);
		}

		return array('main' =>  array(
			array(
				'type' => 'column', 
				'name' => 'County',
				'data' => $data
			))
		, 'columns' => $columns);

	}

	public function get_adt_sites_summary(){
		$columns = array();
		$data = array();

		$this->db->select("count(county) total_sites, 
			round(SUM(case when installed = 'yes' then 1 else 0 end)) installed, 
			round(SUM(case when installed = 'no' then 1 else 0 end)) not_yet,
			SUM(case when backup = 'yes' then 1 else 0 end) backup_sites,
			SUM(case when backup = 'no' then 1 else 0 end) no_backup_sites,
			SUM(case when internet = 'yes' then 1 else 0 end) internet_sites,
			SUM(case when internet = 'no' then 1 else 0 end) no_internet_sites,
			
			round(SUM(case when internet = 'yes' then 1 else 0 end)/count(county) * 100) internet_percentage, 
			round(SUM(case when backup = 'yes' then 1 else 0 end)/count(county) * 100) backup_percentage
			


			", FALSE);
		$query = $this->db->get('dsh_site');
		$results = $query->result_array()[0];
		return $results;
	}

	public function get_adt_versions_summary(){	

		$columns = array();
		$data = array();

		$this->db->select("version as name,count(version) as total", FALSE);
		if(!empty($filters)){
			foreach ($filters as $category => $filter) {
				$this->db->where_in($category, $filter);
			}
		}
		$this->db->group_by('name');
		$this->db->order_by("total DESC");
		$query = $this->db->get('dsh_site');
		$results = $query->result_array();
		// return array('main'=>$results);

		foreach ($results as $result) {
			array_push($data, $result['total']);
		}

		foreach ($results as $result) {
			array_push($columns, $result['name']);
		}

		return array('main' =>  array(
			array(
				'type' => 'column', 
				'name' => 'Version',
				'data' => $data
			))
		, 'columns' => $columns);

	}
	
	public function get_regimens(){
		$columns = array();
		$data = array();

		$this->db->select("CONCAT(code,' | ',name) as name", FALSE);

		$query = $this->db->get('tbl_regimen');
		$results = $query->result_array();
		return $results;

	}

	public function get_counties(){
		$columns = array();
		$data = array();

		$this->db->select("id, name", FALSE);

		$query = $this->db->get('tbl_county');
		$results = $query->result_array();

		return $results;

	}

	public function get_consmp_drug_dropdowns()
	{
		// get all the drug for trend filter
		return $this->db->select('drug')
			   ->distinct()
               ->from('dsh_consumption')
               ->get()
               ->result();
	}

	public function get_stock_drug_dropdowns()
	{
		// get all the drug for stock consumption filter
		return $this->db->select('drug')
			   ->distinct()
               ->from('dsh_mos')
               ->get()
               ->result();
	}

	public function get_regimen_dropdowns()
	{
		// get regimens
		return $this->db->select('regimen')
			   ->distinct()
               ->from('dsh_patient')
               ->get()
               ->result();
	}	

	public function get_facilities()
	{
		// get regimens
		return $this->db->select('facility')
			   ->distinct()
               ->from('dsh_patient')
               ->get()
               ->result();
	}	
}
<!DOCTYPE html>
<html>
<head>
	<!--title-->
	<title><?php echo $page_title; ?> </title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
	<!--favicon-->
	<link rel="shortcut icon" type="text/css" href="<?php echo base_url().'public/dashboard/img/favicon.ico';?>">
	<!--bootstrap-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/bootstrap/dist/css/bootstrap.min.css';?>" />
	<!--bootstrap-toggle-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/bootstrap-toggle/css/bootstrap-toggle.min.css';?>" />
	<!--keen-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/css/keen-dashboards.css';?>" />
	<!--bootstrap-multiselect-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/bootstrap-multiselect/css/bootstrap-multiselect.css';?>" />
	<!--dashboard-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/css/dashboard.css';?>" />
</head>
<body class="application">
	<!--navbar-->
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid"> 
			<div class="navbar-header"> 
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
		    	</button>
			    <a class="navbar-brand" href="#">
			      	<span class="glyphicon glyphicon-dashboard"></span>
			    </a>
		    	<a class="navbar-brand" href="#">ART DASHBOARD</a>
			</div> 
			<nav class="collapse navbar-collapse" id="filter-navbar">
				<ul class="nav navbar-nav navbar-right" id="main_tabs">
					<li class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
		          	<li><a href="#trend" aria-controls="trend" role="tab" data-toggle="tab">Trend</a></li>
		          	<li><a href="#county_subcounty" aria-controls="county_subcounty" role="tab" data-toggle="tab">County/Sub-County</a></li>
		          	<li><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Facility</a></li>
		          	<li><a href="#partner" aria-controls="partner" role="tab" data-toggle="tab">Partner</a></li>
		          	<li><a href="#adt" aria-controls="adt" role="tab" data-toggle="tab">ADT Sites</a></li>
		          	<li><a href="#login" aria-controls="login" role="tab" data-toggle="tab" target="_blank" class="btn btn-success btn-sm">Login</a></li>
				</ul> 
				<!--Tab Links
				<ul class="nav navbar-nav navbar-right" id="main_tabs">
				  <li class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">SUMMARY</a></li>
		          <li><a href="#commodities" aria-controls="commodities" role="tab" data-toggle="tab">ARV/OI DRUGS</a></li>
		          <li><a href="#patients" aria-controls="patients" role="tab" data-toggle="tab">ART PATIENT STATISTICS</a></li>
		        </ul>
		        -->
		        <!--upload_link
				<div class="nav navbar-nav navbar-form navbar-right">
					<a href="<?php //echo base_url().'ftp';?>" target="_blank" class="btn btn-warning btn-md">
						<span class="glyphicon glyphicon-upload"></span>
					</a>
				</div>
				-->
			</nav> 
		</div>
	</div>
	 <!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="summary">
			<div class="container-fluid">
				<!--toprow-->
				<div class="row">
				  	<div class="col-sm-6">
				  		<!--patient_by_regimen_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								ART PATIENTS BY REGIMEN
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="patient_by_regimen_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="patient_by_regimen_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="patient_by_regimen_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="patient_by_regimen_heading"></span>
							</div>
						</div>
				 	</div>
					<div class="col-sm-6">
						<!--stock_status_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								ARV/OI STOCK STATUS
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="stock_status_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="stock_status_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="stock_status_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="stock_status_heading"></span>
							</div>
						</div>
				 	</div>
			    </div>
		    </div>
		</div>
		<div role="tabpanel" class="tab-pane" id="commodities">
			<div class="container-fluid">
				<!--toprow-->
				<div class="row">
				  	<div class="col-sm-12">
				  		<!--national_mos_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								NATIONAL MONTHS OF STOCK (MOS) 
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="national_mos_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="national_mos_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="national_mos_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="national_mos_heading"></span>
							</div>
						</div>
				 	</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
				  		<!--drug_consumption_trend_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								DRUG CONSUMPTION TREND 
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="drug_consumption_trend_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="drug_consumption_trend_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="drug_consumption_trend_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="drug_consumption_trend_heading"></span>
							</div>
						</div>
				 	</div>
			    </div>
		    </div>
		</div>
		<div role="tabpanel" class="tab-pane" id="patients">
			<div class="container-fluid">
				<!--toprow-->
    			<div class="row">
    				<!--top_left-->
					<div class="col-sm-12">
						<!--patient_in_care_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								PATIENTS IN CARE &amp; TREATMENT <span class="label label-warning">Drilldown</span>
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="patient_in_care_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="patient_in_care_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="patient_in_care_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="patient_in_care_heading"></span>
							</div>
						</div>
					</div>
    			</div>
    			<!--middlerow-->
    			<div class="row">
    				<!--middle_left-->
    				<div class="col-sm-6">
    					<!--ntri_drug_in_regimen_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								NRTI DRUGS IN REGIMEN <span class="label label-warning">Drilldown</span>
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="ntri_drugs_in_regimen_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="nrti_drugs_in_regimen_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="nrti_drugs_in_regimen_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="nrti_drugs_in_regimen_heading"></span>
							</div>
						</div>
    				</div>
    				<!--middle_right-->
    				<div class="col-sm-6">
    					<!--nrnti_drug_in_regimen_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								NNRTI/PI/INSTI DRUGS IN REGIMEN <span class="label label-warning">Drilldown</span>
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="nnrti_drugs_in_regimen_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="nnrti_drugs_in_regimen_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="nnrti_drugs_in_regimen_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="nnrti_drugs_in_regimen_heading"></span>
							</div>
						</div>
    				</div>
    			</div>
    			<!--bottomrow-->
    			<div class="row">
    				<!--bottom_left-->
    				<div class="col-sm-6">
    					<!--patient_regimen_category_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								PATIENTS BY AGE &amp; REGIMEN CATEGORY <span class="label label-warning">Drilldown</span>
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="patient_regimen_category_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="patient_regimen_category_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="patient_regimen_category_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="patient_regimen_category_heading"></span>
							</div>
						</div>
    				</div>
    				<!--bottom_right-->
    				<div class="col-sm-6">
						<!--patient_scaleup_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								PATIENT SCALEUP TREND
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="patient_scaleup_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="patient_scaleup_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="patient_scaleup_chart"></div>
							</div>
							<div class="chart-notes">
								Filtered By: <span class="patient_scaleup_heading"></span>
							</div>
						</div>
					</div>
    			</div>
  			</div>
		</div>
	</div>
	<!--footer-->
	<hr>
	<p class="small text-muted">NASCOP &copy; <?php echo date('Y'); ?>. All Rights Reserved</p>
	<!-- filter_modal -->
	<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel">
	  	<div class="modal-dialog modal-md" role="document">
	    	<div class="modal-content">
				<div class="modal-header alert-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="filterModalLabel"><span class="glyphicon glyphicon-filter"></span> Dashboard Filter: <b><span class="filter_text"></span></b></h4>
				</div>
	      		<div class="modal-body">
					<div id="filter_frm" class="form-horizontal">
						<div class="auto_filter"></div><!--auto_filter-->
					</div>
	      		</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="filter_btn" data-filter=""><i class="glyphicon glyphicon-filter" aria-hidden="true"></i> Filter</button>
				</div>
	    	</div>
		</div>
	</div>
	<!--jquery-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/jquery/dist/jquery.min.js';?>"></script>
	<!--highcharts-->
	<script src="<?php echo base_url().'public/dashboard/lib/highcharts/highcharts.js';?>"></script>
	<script src="<?php echo base_url().'public/dashboard/lib/highcharts/exporting.js';?>"></script>
	<script src="<?php echo base_url().'public/dashboard/lib/highcharts/drilldown.js';?>"></script>
	<!--bootstrap-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap/dist/js/bootstrap.min.js';?>"></script>
	<!--bootstrap-toggle-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap-toggle/js/bootstrap-toggle.min.js';?>"></script>
	<!--spin-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/spin.min.js';?>"></script>
	<!--bootstrap-multiselect-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap-multiselect/js/bootstrap-multiselect.js';?>"></script>
	<!--disable_back_button-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/disable_back_button.js';?>"></script>
	<!--dashboard-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/dashboard.js';?>"></script>
</body>
</html>
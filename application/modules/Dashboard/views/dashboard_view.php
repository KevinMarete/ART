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
	<!--select2-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/select2/css/select2.min.css';?>" />
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
				<!--Tab Links-->
				<ul class="nav navbar-nav navbar-left" id="main_tabs">
		          <li class="active"><a href="#commodities" aria-controls="commodities" role="tab" data-toggle="tab">DRUGS</a></li>
		          <li><a href="#patients" aria-controls="patients" role="tab" data-toggle="tab">REGIMENS</a></li>
		        </ul>
		        <!--upload_link-->
				<div class="nav navbar-nav navbar-form navbar-right">
					<a href="<?php echo base_url().'ftp';?>" target="_blank" class="btn btn-warning btn-md">
						<span class="glyphicon glyphicon-upload"></span> UPLOADS
					</a>
				</div>
			</nav> 
		</div>
	</div>
	 <!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="commodities">
			<div class="container-fluid">
				<!--toprow-->
				<div class="row">
				  	<div class="col-sm-12">
				  		<!--pipeline_consumption_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								Total Commodity Consumption at Pipeline
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="pipeline_consumption_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="pipeline_consumption_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="pipeline_consumption_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="pipeline_consumption_heading"></span> Pipeline Consumption
							</div>
						</div>
				 	</div>
				</div>
				<!--bottomrow-->
				<div class="row">
					<div class="col-sm-6">
				  		<!--facility_consumption_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								Total Commodity Consumption at Facility
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="facility_consumption_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="facility_consumption_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="facility_consumption_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="facility_consumption_heading"></span> Facility Consumption
							</div>
						</div>
				 	</div>
				 	<div class="col-sm-6">
				  		<!--facility_soh_chart-->
				    	<div class="chart-wrapper">
							<div class="chart-title">
								Total Commodity Stock on Hand(SOH) at Facility
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="facility_soh_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="facility_soh_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="facility_soh_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="facility_soh_heading"></span> Facility SOH
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
					<div class="col-sm-4">
						<!--adult_art_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								Total Adult ART Patients, By Regimen
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="adult_art_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="adult_art_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="adult_art_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="adult_art_heading"></span> Adult ART Patients
							</div>
						</div>
					</div>
					<div class="col-sm-4">
       					<!--paed_art_chart-->
						<div class="chart-wrapper">
						  	<div class="chart-title">
						    	Total Paediatric ART Patients, By Regimen
						    	<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="paed_art_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="paed_art_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
						  	</div>
						  	<div class="chart-stage">
						    	<div id="paed_art_chart"></div>
						  	</div>
						  	<div class="chart-notes">
						    	<span class="paed_art_heading"></span> Paediatric ART Patients
						  	</div>
						</div>
       				</div>
       				<div class="col-sm-4">
       					<!--oi_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								Total OI Patients, By Regimen
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="oi_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="oi_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="oi_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="oi_heading"></span> OI Patients
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
								Total Patient By Regimen Category
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
								<span class="patient_regimen_category_heading"></span> Patient By Regimen Category
							</div>
						</div>
    				</div>
    				<!--bottom_right-->
    				<div class="col-sm-6">
    					<!--patient_site_chart-->
						<div class="chart-wrapper">
							<div class="chart-title">
								Total Patient By Sites
								<!--filter_frm-->
								<div class="nav navbar-right">
									<!--clear_filter_btn-->
									<button type="button" class="btn btn-danger btn-xs clear_filter_btn" id="patient_site_clear">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								  	<!--filter_modal-->
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#filterModal" id="patient_site_filter">
										<span class="glyphicon glyphicon-filter"></span>
									</button>
								</div>
							</div>
							<div class="chart-stage">
								<div id="patient_site_chart"></div>
							</div>
							<div class="chart-notes">
								<span class="patient_site_heading"></span> Patient By Sites
							</div>
						</div>
    				</div>
    			</div>
  			</div>
		</div>
	</div>
	<!--footer-->
	<hr>
	<p class="small text-muted">Built by <a href="http://www.clintonhealthaccess.org" target="_blank">CHAI</a></p>
	<!-- filter_modal -->
	<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel">
	  	<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content">
				<div class="modal-header alert-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="filterModalLabel"><span class="glyphicon glyphicon-filter"></span> Dashboard Filter: <b><span class="filter_text"></span></b></h4>
				</div>
	      		<div class="modal-body">
					<div id="filter_frm" class="form-horizontal">
						<div class="auto_filter"></div><!--auto_filter-->
						<div class="form-group">
							<label for="metric" class="col-sm-2 control-label">METRIC</label>
							<div class="col-sm-8">
								<select class="form-control metric" id="metric">
		                            <option value="total" selected="selected">Total</option>
		                        </select>
							</div>
						</div>
						<!--common_filters-->
						<div class="form-group">
							<label for="order" class="col-sm-2 control-label">ORDER</label>
							<div class="col-sm-8">
								<select class="order form-control" id="order">
									<option value="desc" selected="selected">Top</option>
									<option value="asc">Bottom</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="limit" class="col-sm-2 control-label">LIMIT</label>
							<div class="col-sm-8">
								<select class="limit form-control" id="limit">
									<option value="5" selected="selected">5</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="">All</option>
								</select>
							</div>
						</div>
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
	<!--bootstrap-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap/dist/js/bootstrap.min.js';?>"></script>
	<!--bootstrap-toggle-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap-toggle/js/bootstrap-toggle.min.js';?>"></script>
	<!--spin-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/spin.min.js';?>"></script>
	<!--select2-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/select2/js/select2.full.min.js';?>"></script>
	<!--disable_back_button-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/disable_back_button.js';?>"></script>
	<!--dashboard-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/dashboard.js';?>"></script>
</body>
</html>
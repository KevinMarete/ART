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
	<!--dataTables-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/dataTables/css/jquery.dataTables.min.css';?>" />
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
		    	<a class="navbar-brand" href="#">ART Dashboard</a>
			</div> 
			<nav class="collapse navbar-collapse" id="filter-navbar"> 
				<!--filter_frm-->
				<div class="nav navbar-nav navbar-form navbar-right">
					<!--clear_filter_btn-->
					<button type="button" class="btn btn-danger btn-md" id="clear_filter_btn">
						<span class="glyphicon glyphicon-refresh"></span> Reset</button>
					</button>
				  	<!--filter_modal-->
					<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#filterModal">
						<span class="glyphicon glyphicon-filter"></span> Filter</button>
					</button>
				</div>
	            
			</nav> 
		</div>
	</div>
	<!--Tab headings-->
	<ul class="nav nav-tabs" role="tablist" id="main_tabs">
		<li role="presentation" class="active"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Products</a></li>
		<li role="presentation"><a href="#premises" aria-controls="premises" role="tab" data-toggle="tab">Premises</a></li>
	</ul>
	 <!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="products">
			<div class="container-fluid">
				<!--toprow-->
				<div class="row">
					<!--atc_code_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								ATC Code(USP)
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="atc_code_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_atc_code" aria-controls="summary_atc_code" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_atc_code" aria-controls="list_atc_code" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_atc_code">
										<div class="container-fluid">
											<div class="row">
												<div id="atc_code_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_atc_code">
										<div class="container-fluid">
											<div class="row">
												<table id="atc_code_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> ATC Codes
							</div>
						</div>
					</div>
					<!--route_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								Route of Admin
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="route_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_route" aria-controls="summary_route" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_route" aria-controls="list_route" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_route">
										<div class="container-fluid">
											<div class="row">
												<div id="route_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_route">
										<div class="container-fluid">
											<div class="row">
												<table id="route_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Routes of Admin
							</div>
						</div>
					</div>
					<!--dosage_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								Dosage Form
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="dosage_form_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_dosage_form" aria-controls="summary_dosage_form" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_dosage_form" aria-controls="list_dosage_form" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_dosage_form">
										<div class="container-fluid">
											<div class="row">
												<div id="dosage_form_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_dosage_form">
										<div class="container-fluid">
											<div class="row">
												<table id="dosage_form_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Dosage Form
							</div>
						</div>
					</div>
				</div>
				<!--bottomrow-->
				<div class="row">
					<!--country_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								Country of Origin
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="country_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_country" aria-controls="summary_country" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_country" aria-controls="list_country" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_country">
										<div class="container-fluid">
											<div class="row">
												<div id="country_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_country">
										<div class="container-fluid">
											<div class="row">
												<table id="country_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Country of Origin
							</div>
						</div>
					</div>
					<!--manufacturer_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								Manufacturer
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="manufacturer_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_manufacturer" aria-controls="summary_manufacturer" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_manufacturer" aria-controls="list_manufacturer" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_manufacturer">
										<div class="container-fluid">
											<div class="row">
												<div id="manufacturer_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_manufacturer">
										<div class="container-fluid">
											<div class="row">
												<table id="manufacturer_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Manufacturers
							</div>
						</div>
					</div>
					<!--importer_chart-->
					<div class="col-sm-4">
						<div class="chart-wrapper">
							<div class="chart-title">
								Importer
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="importer_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_importer" aria-controls="summary_importer" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_importer" aria-controls="list_importer" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_importer">
										<div class="container-fluid">
											<div class="row">
												<div id="importer_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_importer">
										<div class="container-fluid">
											<div class="row">
												<table id="importer_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Importers
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="premises">
			<div class="container-fluid">
				<!--toprow-->
				<div class="row">
					<!--county_chart-->
					<div class="col-sm-6">
						<div class="chart-wrapper">
							<div class="chart-title">
								County
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="county_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_county" aria-controls="summary_county" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_county" aria-controls="list_county" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_county">
										<div class="container-fluid">
											<div class="row">
												<div id="county_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_county">
										<div class="container-fluid">
											<div class="row">
												<table id="county_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Counties
							</div>
						</div>
					</div>
					<!--cadre_chart-->
					<div class="col-sm-6">
						<div class="chart-wrapper">
							<div class="chart-title">
								Cadre
							</div>
							<div class="chart-stage">
								<ul class="nav nav-tabs navbar-right" role="tablist" id="cadre_tabs">
								    <li role="presentation" class="active">
								    	<a href="#summary_cadre" aria-controls="summary_cadre" role="tab" data-toggle="tab">Summary</a>
								    </li>
								    <li role="presentation">
								    	<a href="#list_cadre" aria-controls="list_cadre" role="tab" data-toggle="tab">Data List</a>
								    </li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="summary_cadre">
										<div class="container-fluid">
											<div class="row">
												<div id="cadre_chart"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="list_cadre">
										<div class="container-fluid">
											<div class="row">
												<table id="cadre_table" class="display" cellspacing="0" width="100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="chart-notes">
								<span class="heading"></span> Cadres
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
					<h4 class="modal-title" id="filterModalLabel"><span class="glyphicon glyphicon-filter"></span> Dashboard Filter</h4>
				</div>
	      		<div class="modal-body">
					<div id="filter_frm" class="form-horizontal">
						<div class="auto_filter"></div><!--auto_filter-->
						<div class="form-group">
							<label for="metric" class="col-sm-2 control-label">METRIC</label>
							<div class="col-sm-10">
								<select class="form-control metric" id="metric">
		                            <option value="quantity" selected="selected">Quantity</option>
		                        </select>
							</div>
						</div>
						<!--common_filters-->
						<div class="form-group">
							<label for="order" class="col-sm-2 control-label">ORDER</label>
							<div class="col-sm-10">
								<select class="order form-control" id="order">
									<option value="desc" selected="selected">Top</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="limit" class="col-sm-2 control-label">LIMIT</label>
							<div class="col-sm-10">
								<select class="limit form-control" id="limit">
									<option value="5" selected="selected">5</option>
								</select>
							</div>
						</div>
					</div>
	      		</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="filter_btn"><i class="glyphicon glyphicon-filter" aria-hidden="true"></i> Filter</button>
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
	<!--dataTables-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/dataTables/js/jquery.dataTables.min.js';?>"></script>
	<!--disable_back_button-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/disable_back_button.js';?>"></script>
	<!--dashboard-->
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/dashboard.js';?>"></script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
	<!--title-->
	<title><?php echo $page_title; ?></title>
	<!--styles-->
	<?php $this->load->view('template/style_view'); ?>
</head>
<body class="application">
	<!--navbar-->
	<?php $this->load->view('template/menu_view'); ?>
	<!--filter-->
	<?php $this->load->view('template/filter_view'); ?>
	<!--tabbed-panes-->
	<div class="tab-content">
		<!--summary-tab-->
		<?php $this->load->view('tabs/summary_view'); ?>
		<!--trend-tab-->
		<?php $this->load->view('tabs/trend_view'); ?>
		<!--procurement-tab-->
		<?php $this->load->view('tabs/procurement_view'); ?>
		<!--county-tab-->
		<?php $this->load->view('tabs/county_view'); ?>
		<!--subcounty-tab-->
		<?php $this->load->view('tabs/subcounty_view'); ?>
		<!--facility-tab-->
		<?php $this->load->view('tabs/facility_view'); ?>
		<!--partner-tab-->
		<?php $this->load->view('tabs/partner_view'); ?>
		<!--regimen-tab-->
		<?php $this->load->view('tabs/regimen_view'); ?>
		<!--adt_sites-tab-->
		<?php $this->load->view('tabs/adt_sites_view'); ?>
		<!--adt_reports-tab-->
		<?php $this->load->view('tabs/adt_reports_view'); ?>
		<!--adt_data_warehouse-tab-->
		<?php $this->load->view('tabs/adt_data_warehouse_view'); ?>
	</div>
	<!--footer-->
	<hr>
	<p class="small text-muted">NASCOP &copy; 2017-<?php echo date('Y'); ?>. All Rights Reserved</p>
	<!--scripts-->
	<?php $this->load->view('template/script_view'); ?>
</body>
</html>
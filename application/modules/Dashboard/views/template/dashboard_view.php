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
		<!--county-tab-->
		<?php $this->load->view('tabs/county_view'); ?>
		<!--subcounty-tab-->
		<?php $this->load->view('tabs/subcounty_view'); ?>
		<!--facility-tab-->
		<?php $this->load->view('tabs/facility_view'); ?>
		<!--partner_summary-tab-->
		<?php $this->load->view('tabs/partner_view'); ?>
		<!-- commodities tab -->
		<?php //$this->load->view('tabs/commodities_view'); ?>
		<!-- Drug tab -->
		<?php //$this->load->view('tabs/drug_view'); ?>
		<!--site-tab-->
		<?php //$this->load->view('tabs/adt_site_view'); ?>
	</div>
	<!--footer-->
	<hr>
	<p class="small text-muted">NASCOP &copy; 2017-<?php echo date('Y'); ?>. All Rights Reserved</p>
	<!--scripts-->
	<?php $this->load->view('template/script_view'); ?>
</body>
</html>
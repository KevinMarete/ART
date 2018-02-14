<!DOCTYPE>
<html lang="html">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Commodities | FTP</title>
    <!--favicon-->
    <link rel="shortcut icon" type="text/css" href="<?php echo base_url().'public/ftpservice/img/favicon.ico';?>">
	<!-- Google Fonts -->
	<link href="<?php echo base_url().'public/ftpservice/css/google-fonts.css';?>" rel="stylesheet">
	<!-- Styles -->
	<link href="<?php echo base_url().'public/ftpservice/css/jquery.filer.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/dashboard/lib/bootstrap/dist/css/bootstrap.min.css';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/ftpservice/lib/dataTables/css/jquery.dataTables.min.css';?>" />
    <link href="<?php echo base_url().'public/ftpservice/css/custom.css';?>" rel="stylesheet">

	<!-- Javascript -->
	<script src="<?php echo base_url().'public/ftpservice/js/jquery-3.1.0.min.js';?>" crossorigin="anonymous"></script>
	<script src="<?php echo base_url().'public/ftpservice/js/jquery.filer.min.js';?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/lib/bootstrap/dist/js/bootstrap.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'public/ftpservice/lib/dataTables/js/jquery.dataTables.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'public/dashboard/js/spin.min.js';?>"></script>
	<script src="<?php echo base_url().'public/ftpservice/js/custom.js';?>" type="text/javascript"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div id="content">
					<div class="alert alert-info" role="alert"><h3>FTP File Uploader</h3></div>
        			<p><?php echo $this->session->flashdata('ftp_upload_message'); ?></p>
					<form action="<?php echo base_url().'upload';?>" method="post" enctype="multipart/form-data">
					    <input type="file" name="files[]" id="filer_input" multiple="multiple">
					    <button class="btn btn-md btn-success" type="submit"><span class="glyphicon glyphicon-upload"></span> Upload Files</button> 
					    <a class="btn btn-md btn-warning" href="<?php echo base_url().'analysis';?>" id="analyze_files" role="button"><span class="glyphicon glyphicon-refresh"></span> Analyze Files</a> 
					</form>
			    </div>
			</div>
			<div class="col-sm-6">
				<div class="alert alert-success" role="alert"><h3>Completed Files on FTP</h3></div>
				<div class="table-responsive">
					<table id="ftp_completed" class="table table-condensed table-hover table table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Filename</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="alert alert-danger" role="alert"><h3>Pending Files on FTP</h3></div>
				<div class="table-responsive">
					<table id="ftp_pending" class="table table-condensed table-hover table table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Filename</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-6">
		    	<div class="alert alert-warning" role="alert"><h3>File Analysis Progress on FTP</h3></div>
		    	<div id="analysis_progress"></div>
		    </div>
		</div>
	</div>
</body>
</html>
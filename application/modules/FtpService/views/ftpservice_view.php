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
    <link href="<?php echo base_url().'public/ftpservice/css/custom.css';?>" rel="stylesheet">
	<!-- Javascript -->
	<script src="<?php echo base_url().'public/ftpservice/js/jquery-3.1.0.min.js';?>" crossorigin="anonymous"></script>
	<script src="<?php echo base_url().'public/ftpservice/js/jquery.filer.min.js';?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'public/ftpservice/js/custom.js';?>" type="text/javascript"></script>
</head>
<body>
    <div>
        <h1>Commodities - FTP Uploader</h1>
        <p><?php echo $this->session->flashdata('ftp_upload_message'); ?></p>
    </div>
    <hr>
    <div id="content">
		<form action="<?php echo base_url().'upload';?>" method="post" enctype="multipart/form-data">
		    <input type="file" name="files[]" id="filer_input" multiple="multiple">
		    <input type="submit" value="Submit">
		</form>
    </div>
</body>
</html>
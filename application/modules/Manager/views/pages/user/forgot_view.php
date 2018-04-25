<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="NASCOP">

    <title><?php echo $page_title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css';?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.css';?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url().'public/manager/lib/sbadmin2/dist/css/sb-admin-2.css';?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">

    <!--favicon-->
    <link href="<?php echo base_url().'public/dashboard/img/favicon.ico';?>" rel="shortcut icon" type="text/css" >

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading text-center">
                        <img src="<?php echo base_url().'public/manager/img/nascop_logo.png';?>" class="img-responsive center-block" alt="nascop">
                        <h3 class="panel-title"><b>Commodity Manager</b></h3>
                        <?php echo $this->session->flashdata('user_msg'); ?>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo base_url().'user/reset_account';?>" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email_address" type="email" autofocus required>
                                </div>
                                <button type="submit" class="btn btn-lg btn-danger btn-block"> <i class="fa fa-refresh"></i> Reset Account</button>
                            </fieldset>
                            <hr/>
                            <center>
                                <b>Remembered your Password?</b> <a href="<?php echo base_url().'manager';?>">Login Here</a> <br/>
                                <a href="<?php echo base_url().'manager/register_account';?>">Create new Account?</a>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/jquery/jquery.min.js';?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js';?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url().'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js';?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url().'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js';?>"></script>

</body>

</html>

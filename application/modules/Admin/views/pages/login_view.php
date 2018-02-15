<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="NASCOP">
    <meta name="author" content="NASCOP">
    <title>ART Dashboard | Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css';?>" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/metisMenu/metisMenu.min.css';?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'public/admin/lib/sbadmin2/dist/css/sb-admin-2.css';?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">
    <!--favicon-->
    <link rel="shortcut icon" type="text/css" href="<?php echo base_url().'public/dashboard/img/favicon.ico';?>">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="<?php echo base_url().'Admin/home'; ?>" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/jquery/jquery.min.js';?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js';?>"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url().'public/admin/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js';?>"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url().'public/admin/lib/sbadmin2/dist/js/sb-admin-2.js';?>"></script>
</body>
</html>
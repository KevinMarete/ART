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
        <link href="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/metisMenu/metisMenu.min.css'; ?>" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url() . 'public/admin/lib/sbadmin2/dist/css/sb-admin-2.css'; ?>" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css">
        <!--favicon-->
        <link rel="shortcut icon" type="text/css" href="<?php echo base_url() . 'public/dashboard/img/favicon.ico'; ?>">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading text-center">
                            <img src="<?php echo base_url() . 'public/login/img/user_favicon.ico'; ?>" class="img-responsive center-block" alt="USER">
                            <h1>ART</h1>
                            <h3 class="panel-title"><b>Please Sign In</b></h3>
                        </div>
                        <?php
                        $success_msg = $this->session->flashdata('success_msg');
                        $error_msg = $this->session->flashdata('error_msg');

                        if ($success_msg) {
                            ?>
                            <div class="alert alert-success">
                                <?php echo $success_msg; ?>
                            </div>
                            <?php
                        }
                        if ($error_msg) {
                            ?>
                            <div class="alert alert-danger">
                                <?php echo $error_msg; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="panel-body">
                            <form role="form" action="<?php echo base_url() . 'Admin/Auth/Auth_login/loginMe'; ?>" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" id="email" type="email" autofocus required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" id="password" type="password" autofocus required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" name="login" id="login_button">
                                </fieldset>
                            </form>
                            <center><b>Not yet registered ?</b> 
                                <br>
                                </b>
                                <a href="<?php echo base_url('Admin/register'); ?>">Register here <i class="fa fa-arrow-circle-o-right"></i></a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/jquery/jquery.min.js'; ?>"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js'; ?>"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() . 'public/admin/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() . 'public/admin/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url() . 'public/admin/js/auth.js'; ?>"></script>
    </body>
</html>
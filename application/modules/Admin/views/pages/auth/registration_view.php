<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="NASCOP">
        <meta name="author" content="NASCOP">
        <title>ART Dashboard | Register</title>
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
        <div class="container"><!-- container class is used to centered  the body of the browser with some decent width-->
            <div class="row"><!-- row class is used for grid system in Bootstrap-->
                <div class="col-md-6 col-md-offset-3"><!--col-md-4 is used to create the no of colums in the grid also use for medimum and large devices-->
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading text-center">
                            <img src="<?php echo base_url() . 'public/login/img/user_favicon.ico'; ?>" class="img-responsive center-block" alt="USER">
                            <h1>ART</h1>
                            <h2 class="panel-title"> <b>Please Sign Up</b></h2>
                        </div>
                        <?php
                        $success_msg = $this->session->flashdata('success_msg');
                        $error_msg = $this->session->flashdata('error_msg');

                        if ($success_msg) {
                            ?>
                            <div class="alert alert-success text-center">
                                <?php echo $success_msg; ?>
                            </div>
                            <?php
                        }
                        if ($error_msg) {
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $error_msg; ?>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="panel-body">
                            <form role="form" action="<?php echo base_url() . 'Admin/Auth/Auth_user'; ?>" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">First Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus required="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Last Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus required="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">E-mail</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="E-mail" name="user_email" type="email" autofocus required="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Mobile Number</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Mobile Number" name="user_mobile" type="text" required="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Password</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Password" name="user_password" id="user_password" type="password" required="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Confirm Password</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" type="password" onkeyup="checkPasswordMatch();">
                                            <span class="help-block msg"></span>
                                        </div>
                                    </div>
                                    <!--hidden input for roleId-->
                                    <div class="form-group">
                                        <input name="roleId" type="hidden" value="3">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Register" name="register" id="submit_button" >

                                </fieldset>
                            </form>
                            <center>
                                <b>Already registered ?</b> 
                                <br>
                                </b>
                                <a href="<?php echo base_url('Admin'); ?>">Login here <i class="fa fa-arrow-circle-o-right"></i></a>
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
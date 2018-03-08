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
                <div class="col-md-4 col-md-offset-4"><!--col-md-4 is used to create the no of colums in the grid also use for medimum and large devices-->
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">PLEASE SIGN UP</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="<?php echo base_url('#'); ?>">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="user_email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Mobile Number" name="user_mobile" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="user_password" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Confirm Password" name="confirm_password" type="password" value="">
                                    </div>

                                    <input class="btn btn-lg btn-success btn-block" type="submit" value="Register" name="register" >

                                </fieldset>
                            </form>
                            <center>
                                <b>Already registered ?</b> 
                                <br>
                                </b>
                                <a href="<?php echo base_url('Admin/index'); ?>">Login here</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

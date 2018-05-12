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
                        <form class="form-horizontal" action="<?php echo base_url().'user/create_account';?>" method="POST">
                            <div class="form-group">
                                <label for="inputfirstname" class="col-sm-2 control-label">Firstname</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputfirstname" placeholder="Firstname" name="firstname" required>
                                </div>
                                <label for="inputlastname" class="col-sm-2 control-label">Lastname</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlastname" placeholder="Lastname" name="lastname" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputemail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputemail" placeholder="Email Address" name="email_address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputphonenumber" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputphonenumber" placeholder="2547XXXXXXXX" name="phone_number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputrole" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="inputrole" name="role_id" required> 
                                        <option value=''>Select Role</option>
                                        <?php foreach ($roles as $role) {
                                            echo "<option value='".$role["id"]."'>".$role["name"]."</option>";
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label for="inputpassword" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputpassword" placeholder="Password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputcpassword" class="col-sm-2 control-label"> Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputcpassword" placeholder="Confirm Password" name="cpassword" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-md btn-warning btn-block"> <i class="fa fa-save"></i> Create</button>
                                </div>
                            </div>
                            <hr/>
                            <center>
                                <b>Already registered ?</b> <a href="<?php echo base_url().'manager';?>">Login here</a>
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

    <script type="text/javascript">
        $(function(){
            $("#inputpassword").on("change", validatePassword)
            $("#inputcpassword").on("change", validatePassword)

            function validatePassword(){
                var password = $("#inputpassword").val()
                var confirm_password = $("#inputcpassword").val()
                if(password != confirm_password && confirm_password !=='') {
                    alert("Passwords Don't Match");
                }
            }
        });
    </script>

</body>

</html>
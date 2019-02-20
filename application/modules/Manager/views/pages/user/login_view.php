<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="NASCOP">

        <title><?php echo $page_title; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.css'; ?>" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/css/sb-admin-2.css'; ?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css">

        <!--favicon-->
        <link href="<?php echo base_url() . 'public/dashboard/img/favicon.ico'; ?>" rel="shortcut icon" type="text/css" >

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
                            <img src="<?php echo base_url() . 'public/manager/img/nascop_logo.png'; ?>" class="img-responsive center-block" alt="nascop">
                            <h3 class="panel-title"><b>Commodity Manager</b></h3>
                            <?php echo $this->session->flashdata('user_msg'); ?>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="<?php echo base_url() . 'user/authenticate'; ?>" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email_address" type="email" value="<?php echo isset($_POST['email_address']) ? $_POST['email_address'] : '' ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-primary btn-block"> <i class="fa fa-arrow-circle-o-right"></i> Login</button>
                                </fieldset>
                                <hr/>
                                <center>
                                    <a href="<?php echo base_url() . 'manager/forgot_pass'; ?>">Forgot your Password?</a><br/>
                                    <a href="#Request-Account" data-toggle="modal" data-target="#RequestAccount">Request an Account from NASCOP Commodity Manager</a><br/>
                                    <!--<a href="<?php //echo base_url().'manager/register_account';                         ?>">Create an Account</a>-->
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <div id="RequestAccount" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Request Account</h4>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label for="email">Your Name:</label>
                                <input type="text" class="form-control" id="NAME" placeholder="Enter your name">
                            </div>
                            <div class="form-group">
                                <label for="email">Phone:</label>
                                <input type="text" class="form-control" id="TPhone" placeholder="Enter Your Phone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" id="yemail" placeholder="Enter Your Email">
                            </div>
                            <div class="form-group">
                                <label for="reason">Reason for requesting:</label>
                                <textarea id="yreason" class="form-control" placeholder="State why you need this account"></textarea>
                            </div>


                        </form> 

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default btn-primary" id="sendEmail">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <p></p>

        <!-- jQuery -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/jquery/jquery.min.js'; ?>"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js'; ?>"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>

        <script>
            $(function () {

                $('#sendEmail').click(function () {

                    email = $('#yemail').val();
                    message = $('#yreason').val();
                    name = $('#NAME').val();
                    phone = $('#TPhone').val();

                    if (email == '' || message == '' || name == '' || phone == '') {
                        alert('Please fill all fields');
                    } else {

                        data = {
                            email: email,
                            message: message,
                            name: name,
                            phone: phone
                        };
                        $(this).prop('disabled', true);
                        $(this).prop('value', 'Please Wait...');
                        $.post("<?= base_url(); ?>Manager/sendEmail/", data, function (resp) {
                            if (resp.status == 'success') {
                                alert('Thank You, We have received your request and will get back to you as soow as possible');
                                window.location.href = "";
                            } else {
                                alert('Error: An error occured while submitting your request. Please try again later');
                            }

                        }, 'json');
                    }
                });

            });
        </script>

    </body>

</html>

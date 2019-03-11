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
<!--                                    <a href="#Register Account" data-toggle="modal" data-target="#modal_register">Register Account</a><br/>-->
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


        <!-- Add or Edit modal -->
        <div class="modal fade" id="modal_register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Register New Account</h4>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id" id="user_id"/> 
                            <div class="form-group">
                                <label for="inputfirstname" class="col-sm-2 control-label">Firstname</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputfirstname" placeholder="Firstname" name="firstname" required>
                                    <span class="help-block"></span>
                                </div>
                                <label for="inputlastname" class="col-sm-2 control-label">Lastname</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlastname" placeholder="Lastname" name="lastname" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputemail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputemail" placeholder="Email Address" name="email_address" required>
                                    <span class="emailerror" style="color: red; font-weight: bold; display: none;">Invalid email address!</span>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputphonenumber" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputphonenumber" placeholder="2547XXXXXXXX" name="phone_number" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputrole" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">                          
                                    <select name="role" id="role" class="form-control select2"></select>
                                    <span class="help-block"></span>
                                </div>
                            </div> 

                            <span id="scope_section"></span>
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

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-default">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->





        <!-- jQuery -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/jquery/jquery.min.js'; ?>"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js'; ?>"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>

        <script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/sweetalert.min.js'; ?>"></script>


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
                                        $.post("<?= base_url(); ?>Manager/newAccountRequestForOpening/", data, function (resp) {
                                            if (resp.status == 'success') {
                                                alert('We have received your request and will respond as soon as possible. \nThank you.');
                                                window.location.href = "";
                                            } else {
                                                alert('Error: An error occured while submitting your request. Please try again later');
                                            }

                                        }, 'json');
                                    }
                                });

                            });

                            //////////////////////////////////////////////////////////////////
                            //  ****************************************************************



                            $(function () {

                                var roleURL = '<?php echo base_url(); ?>API/Role';
                                $("#role").empty();
                                $.getJSON(roleURL, function (role) {
                                    $("#role").append($("<option value=''>Select Role</option>"));
                                    $.each(role, function (index, role) {
                                        $("#role").append($("<option value='" + role.id + "'>" + role.name.toUpperCase() + "</option>"));
                                    });
                                    $("#role option[value='1']").remove();
                                    $("#role option[value='5']").remove();
                                    $("#role option[value='4']").remove();
                                    $("#role option[value='6']").remove();

                                });



                                $("#inputemail").keyup("click", validate);
                                $("#inputcpassword").on("keyup", validatePassword);

                                $('#inputemail').focusout(function () {
                                    check('email_address', $('#inputemail').val());
                                });
                                $('#inputphonenumber').focusout(function () {
                                    check('phone_number', $('#inputphonenumber').val());
                                });





                                function check(c, d) {
                                    $.post('<?php echo base_url(); ?>Manager/User/checkDuplicateEmail/', {c: c, d: d}, function (resp) {
                                        if (resp == '1') {
                                            alert('Record already Exists')
                                            $('#inputemail').val('');
                                            $('#inputphonenumber').val('')
                                        } else {

                                        }
                                    });
                                }

                                //Add scopes after role is choosen
                                $('#role').on('change', function () {
                                    var role = $('#role :selected').text()
                                    $('#scope_section').empty();
                                    $.getJSON("<?= base_url(); ?>Manager/User/get_role_scope/" + role, function (data) {
                                        if (data.length > 0) {
                                            //Ensure scope is required when role is selected
                                            $('#scope_section').html('<div class="form-group"><label for="inputscope" class="col-sm-2 control-label">Scope</label><div class="col-sm-10"><select class="form-control" id="inputscope" name="scope_id" required><option value="">Select Scope</option></select></div></div>');
                                            $.each(data, function (i, v) {
                                                $('#inputscope').append($("<option value='" + v.id + "'>" + v.name.toUpperCase() + "</option>"));
                                            });
                                        }
                                        $('#inputscope').select2();
                                    });
                                });
                            });

                            function validatePassword() {
                                var password = $("#inputpassword").val()
                                var confirm_password = $("#inputcpassword").val()
                                if (password != confirm_password && confirm_password !== '') {
                                    $('.passerror').show();
                                } else {
                                    $('.passerror').hide();
                                }
                            }

                            function validateEmail(email) {
                                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                return re.test(email);
                            }

                            function validate() {
                                var email = $("#inputemail").val();

                                if (validateEmail(email)) {
                                    // $('#btnSave').prop('disabled','disabled');
                                    $('.emailerror').hide();
                                } else {
                                    // $('#btnSave').prop('disabled',false);                
                                    $('.emailerror').show();
                                }
                                return false;
                            }

                            function save() {
                                $('#btnSave').text('Saving,Please Wait...');
                                $('#btnSave').attr('disabled', true);
                                var url;


                                url = "<?php echo base_url('Manager/Admin/add_data/tbl_user'); ?>";

                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data: $('#form').serialize(),
                                    dataType: "JSON",
                                    success: function (data)
                                    {
                                        if (data.status == true) {
                                            $('#modal_register').modal('hide');
                                            swal('<?php echo ucwords(str_replace('_', ' ', $page_name)); ?>', 'Account Creation success!', 'success');
                                            $('#btnSave').attr('disabled', false);
                                        } else {
                                            if (data.message) {
                                                swal('Error', data.message, 'error');
                                            } else {
                                                for (var i = 0; i < data.inputerror.length; i++)
                                                {
                                                    $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                                                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                                                }
                                                //Show required labels in select2
                                                $('.select2').removeClass('select2-hidden-accessible');
                                                $('span.select2-container').css('color', '#a94442');//red color for required
                                            }
                                        }
                                        $('#btnSave').text('Save');
                                        //$('#btnSave').attr('disabled', false);
                                    },
                                    error: function (data)
                                    {
                                        swal('Error', 'Error adding / updating <?php echo str_replace('_', ' ', $page_name); ?>', 'error');
                                        $('#btnSave').text('save');
                                        $('#btnSave').attr('disabled', false);

                                    }
                                });
                            }

        </script>

    </body>

</html>

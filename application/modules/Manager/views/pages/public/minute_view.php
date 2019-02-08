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
        <link href="<?php echo base_url() . 'public/manager/lib/bootstrap-sweetalert/css/sweetalert.min.css'; ?>" rel="stylesheet">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body >
        <style>
            #panel-header{
                -webkit-filter: blur(10px); /* Chrome, Opera, etc. */
                filter: url('blur.svg#blur'); /* Older FF and others - http://jordanhollinger.com/media/blur.svg */
                filter: blur(10px); /* Firefox 35+, eventually all */
            }
        </style>

        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class=" panel panel-default">
                        <div class="panel-heading text-center">
                            <img src="<?php echo base_url() . 'public/manager/img/nascop_logo.png'; ?>" class="img-responsive center-block" alt="nascop">
                            <h3 class="panel-title"><b>PROCUREMENT PLANNING MEETING MINUTE</b></h3>
                            <?php echo $this->session->flashdata('user_msg'); ?>
                        </div>
                        <div class="panel-body" id="panel-head" >
                            <div id="step-5" class="">
<!--                                <a href="#dispatch" class="btn btn-primary btn-sm pull-right DISPATCH">Dispatch Emails</a> -->
                                <?php echo html_entity_decode($minutes[0]->minute); ?>
<!--                                <a href="#dispatch" class="btn btn-primary btn-sm pull-right DISPATCH">Dispatch Emails</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/jquery/jquery.min.js'; ?>"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js'; ?>"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>
        <script src="<?php echo base_url() . 'public/manager/lib/bootstrap-sweetalert/js/sweetalert.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'public/manager/js/loadingOverlay.js'; ?>"></script>
    </body>
    <script>
        $(function () {
            var id = "<?php echo $this->uri->segment(4); ?>";

            $('.DISPATCH').click(function () {
                var spinHandle = loadingOverlay.activate();
                $.getJSON('<?php echo base_url(); ?>Manager/Procurement/generateMinute/' + id, function (resp) {
                    if (resp.status == 'success') {
                        loadingOverlay.cancel(spinHandle);
                        swal("Meeting Minutes Saved and emails dispatched to all members", {
                            icon: "success",
                        });
                    } else {

                    }

                });
            });


        });
    </script>

</html>

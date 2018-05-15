<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Profile</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Details
                    <?php echo $this->session->flashdata('user_msg'); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" action="<?php echo base_url().'manager/update_profile';?>" method="POST">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" value="<?php echo $this->session->userdata("firstname");?>" name="firstname" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" value="<?php echo $this->session->userdata("lastname");?>" name="lastname" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" value="<?php echo $this->session->userdata("email_address");?>" name="email_address" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" value="<?php echo $this->session->userdata("phone_number");?>" name="phone_number" required>
                                </div>
                                <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Update Profile</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <h1>Change Password</h1>
                            <form role="form" action="<?php echo base_url().'manager/update_password';?>" method="POST">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess">Old Password</label>
                                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="inputWarning">New Password</label>
                                    <input type="password" class="form-control" id="newpassword" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="inputError">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmpassword" required>
                                </div>
                                <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save Password</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(function(){
        $("#newpassword").on("change", validatePassword)
        $("#confirmpassword").on("change", validatePassword)

        function validatePassword(){
            var password = $("#newpassword").val()
            var confirm_password = $("#confirmpassword").val()
            if(password != confirm_password && confirm_password !=='') {
                alert("Passwords Don't Match");
            }
        }
    });
</script>
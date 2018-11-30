<!-- Add or Edit modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
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
                            <span class="emailerror" style="color: red; font-weight: bold; display: none;">Invalid email address!</span>
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
                            <select name="role" id="role" class="form-control select2">
                            </select>
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
                            <span class="passerror" style="color: red; font-weight: bold; display: none;">Passwords do not match!</span>
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



<script type="text/javascript">
    $(function () {
        //   $('#btnSave').prop('disabled','disabled');

        var roleURL = '../../API/Role';
        $("#role").empty();
        $.getJSON(roleURL, function (role) {
            $("#role").append($("<option value=''>Select Role</option>"));
            $.each(role, function (index, role) {
                $("#role").append($("<option value='" + role.id + "'>" + role.name.toUpperCase() + "</option>"));
            });
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
            //Ensure scope is required when role is selected
            $('#scope_section').html('<div class="form-group"><label for="inputscope" class="col-sm-2 control-label">Scope</label><div class="col-sm-10"><select class="form-control" id="inputscope" name="scope_id" required><option value="">Select Scope</option></select></div></div>');
            $.getJSON("<?= base_url(); ?>Manager/User/get_role_scope/" + role, function (data) {
                if (data.length > 0) {
                    $.each(data, function (i, v) {
                        $('#inputscope').append($("<option value='" + v.id + "'>" + v.name.toUpperCase() + "</option>"));
                    });
                }
            });
        });
    });

    function validatePassword() {
        var password = $("#inputpassword").val()
        var confirm_password = $("#inputcpassword").val()
        if (password != confirm_password && confirm_password !== '') {
            $('.passerror').show();
            //  $('#btnSave').prop('disabled',false);
        } else {
            $('.passerror').hide();
            // $('#btnSave').prop('disabled','disabled');
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
</script>

</body>

</html>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>USER LISTING</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> User Listing</li>
            </ol>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-body">
            <button class="btn btn-primary" onclick="add_user_listing()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
            <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            <br/>
            <br/>
            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Role</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Role</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table> 
        </div>
    </div>       

</div>

<script src="<?php echo base_url() . 'public/admin/js/user_listing.js'; ?>"></script>

<!-- Add or Edit User Listing modal -->
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
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus>
                                <span class="help-block"></span>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">E-mail</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="E-mail" name="user_email" id="user_email" type="email" autofocus>
                                <span class="help-block" id="error"></span>
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
                                <input class="form-control" placeholder="Password" name="user_password" id="user_password" type="password">
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
                        <div class="form-group">
                            <label class="control-label col-md-3">User Role</label>
                            <div class="col-md-9">
                                <select name="roleId" id="roleId" class="form-control">
                                    <option value="">---Select User Role----</option>
                                    <?php foreach ($get_roles as $row) { ?>
                                        <option value="<?= $row->roleId ?>"><?= $row->role ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
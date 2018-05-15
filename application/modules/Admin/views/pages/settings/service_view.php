<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>SERVICE</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> Service</li>
            </ol>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-body">
            <button class="btn btn-primary" onclick="add_service()"><i class="glyphicon glyphicon-plus"></i> Add Service</button>
            <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            <br/>
            <br/>
            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th class="col-ld-11 col-md-8 col-xs-6">Service Name</th>
                        <th class="col-lg-1 col-md-4 col-xs-6">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th class="col-ld-11 col-md-8 col-xs-6">Service Name</th>
                        <th class="col-lg-1 col-md-4 col-xs-6">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<script src="<?php echo base_url() . 'public/admin/js/settings_service.js'; ?>"></script>

<!-- Add or Edit County modal -->
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
                            <label class="control-label col-md-3">Service Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Service Name" class="form-control" type="text">
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
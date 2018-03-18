<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>REGIMEN</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> Regimen</li>
            </ol>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-body">
            <button class="btn btn-primary" onclick="add_regimen()"><i class="glyphicon glyphicon-plus"></i> Add Regimen</button>
            <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            <br/>
            <br/>
            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Service</th>
                        <th>Line</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Service</th>
                        <th>Line</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table> 
        </div>
    </div> 

</div>

<script src="<?php echo base_url() . 'public/admin/js/settings_regimen.js'; ?>"></script>

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
                            <label class="control-label col-md-3">Regimen Code</label>
                            <div class="col-md-9">
                                <input name="code" placeholder="Regimen Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Regimen Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Regimen Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Regimen Description</label>
                            <div class="col-md-9">
                                <input name="description" placeholder="Regimen Description" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category Name</label>
                            <div class="col-md-9">
                                <select name="category_id" id="category_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Category----</option>
                                    <?php foreach ($get_category as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Service Name</label>
                            <div class="col-md-9">
                                <select name="service_id" id="service_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Service----</option>
                                    <?php foreach ($get_service as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Line Name</label>
                            <div class="col-md-9">
                                <select name="line_id" id="line_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Line----</option>
                                    <?php foreach ($get_line as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
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
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>BACKUPS</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> Backup</li>
            </ol>
        </div>
    </div>
    <button class="btn btn-primary" onclick="add_backup()"><i class="glyphicon glyphicon-plus"></i> Add Backup</button>
    <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
    <br/>
    <br/>
    <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
        <thead>
            <tr>
                <th>Facility Name</th>
                <th>File Uploaded</th>
                <th>ADT Version</th>
                <th>Run Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <th>Facility Name</th>
                <th>File Uploaded</th>
                <th>ADT Version</th>
                <th>Run Time</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>        

</div>

<script src="<?php echo base_url() . 'public/admin/js/backup.js'; ?>"></script>

<!-- Add or Edit Backup modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
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
                            <label class="control-label col-md-3">Facility Name</label>
                            <div class="col-md-9">
                                <select name="name" id="name" class="form-control">
                                    <option value="">---Select Facility----</option>
                                    <?php foreach ($get_facility as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Select File</label>
                            <div class="col-md-9">
                                <input name="filename" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">ADT  Version</label>
                            <div class="col-md-9">
                                <input name="adt_version" placeholder="ADT Version" class="form-control" type="text">
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
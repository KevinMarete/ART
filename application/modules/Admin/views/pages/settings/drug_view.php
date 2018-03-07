<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>DRUG</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active ">Drug</li>
            </ol>
        </div>
    </div>
    <button class="btn btn-primary" onclick="add_drug()"><i class="glyphicon glyphicon-plus"></i> Add Drug</button>
    <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
    <br/>
    <br/>
    <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
        <thead>
            <tr>
                <th class="col-md-3">Strength</th>
                <th class="col-md-3">Pack Size</th>
                <th class="col-md-3">Generic Name</th>
                <th class="col-md-2">Formulation</th>
                <th class="col-md-1">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <th class="col-md-3">Strength</th>
                <th class="col-md-3">Pack Size</th>
                <th class="col-md-3">Generic Name</th>
                <th class="col-md-2">Formulation</th>
                <th class="col-md-1">Action</th>
            </tr>
        </tfoot>
    </table> 

</div>

<script src="<?php echo base_url() . 'public/admin/js/settings_drug.js'; ?>"></script>

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
                            <label class="control-label col-md-3">Strength</label>
                            <div class="col-md-9">
                                <input name="strength" placeholder="Strength" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pack Size</label>
                            <div class="col-md-9">
                                <input name="packsize" placeholder="Pack Size" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Generic</label>
                            <div class="col-md-9">
                                <select name="generic_id" id="generic_id" class="form-control">
                                    <option value="">---Select Generic----</option>
                                    <?php foreach ($get_generic as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Formulation</label>
                            <div class="col-md-9">
                                <select name="formulation_id" id="formulation_id" class="form-control">
                                    <option value="">---Select Formulation----</option>
                                    <?php foreach ($get_formulation as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
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
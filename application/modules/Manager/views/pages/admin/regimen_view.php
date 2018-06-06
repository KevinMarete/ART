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
                                <textarea name="description" placeholder="Regimen Description" class="form-control" type="text"></textarea>
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
                    </div>
                    <input name="_table_" type="hidden" value="tbl_regimen" >
                </form>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
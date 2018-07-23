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
                        <!--regimen_drug_add-->
                        <div class="form-group regimen_drug_add">
                            <label class="control-label col-md-3">Regimen</label>
                            <div class="col-md-9">
                                <select name="regimen_id" id="regimen_add" class="form-control select" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group regimen_drug_add">
                            <label class="control-label col-md-3">Drug Strength</label>
                            <div class="col-md-9">
                                <select name="drug_id" id="drug_add" class="form-control select" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--regimen_drug_edit-->
                        <div class="form-group regimen_drug_edit">
                            <label class="control-label col-md-3">Regimen</label>
                            <div class="col-md-9">
                                <select name="regimen_id" id="regimen_edit" class="form-control select2" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>                       
                        <div class="form-group regimen_drug_edit">
                            <label class="control-label col-md-3">Drug Strength</label>
                            <div class="col-md-9">
                                <select name="drug_id" id="drug_edit" class="form-control select2" type="text"></select>
                                <span class="help-block"></span>
                            </div>
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
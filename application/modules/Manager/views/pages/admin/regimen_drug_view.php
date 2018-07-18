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
                            <label class="control-label col-md-3">Regimen</label>
                            <div class="col-md-9">
                                <select name="regimen_id" id="regimen_id" class="form-control select2" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Drug Strength</label>
                            <div class="col-md-9">
                                <select name="drug_id" id="drug_id" class="form-control select2" type="text"></select>
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

<script type="text/javascript">
    $(function () {
        var regimenURL = '../../API/regimen';
        var drugURL = '../../API/drug';
        $("#regimen_id").empty()
        $.getJSON(regimenURL, function (regimens) {
            //$("#role_id").empty()
            $("#regimen_id").append($("<option value=''>Select Regimen</option>"));
            $.each(regimens, function (index, regimen) {
                $("#regimen_id").append($("<option value='" + regimen.id + "'>" + regimen.name.toUpperCase() + "</option>"));
            });
        });
        $("#drug_id").empty()
        $.getJSON(drugURL, function (drugs) {
            //$("#submodule_id").empty()
            $("#drug_id").append($("<option value=''>Select Drug</option>"));
            $.each(drugs, function (index, drug) {
                $("#drug_id").append($("<option value='" + drug.id + "'>" + drug.strength.toUpperCase() + "</option>"));
            });
        });
    });
</script>
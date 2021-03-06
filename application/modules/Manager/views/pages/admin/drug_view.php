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
                            <label class="control-label col-md-3">Strength</label>
                            <div class="col-md-9">
                                <input name="strength" placeholder="50mg" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pack Size</label>
                            <div class="col-md-9">
                                <input name="packsize" placeholder="1*100ml" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Generic</label>
                            <div class="col-md-9">
                                <select name="generic_id" id="generic_id" class="form-control select2"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Formulation</label>
                            <div class="col-md-9">
                                <select name="formulation_id" id="formulation_id" class="form-control select2">
                                </select>
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
</div><!-- /End modal -->

<script type="text/javascript">
    $(function () {
        var genericURL = '../../API/generic';
        var formulationURL = '../../API/formulation';
        $("#generic_id").empty()
        $.getJSON(genericURL, function (generics) {
            $("#generic_id").append($("<option value=''>Select Generic</option>"));
            $.each(generics, function (index, generic) {
                $("#generic_id").append($("<option value='" + generic.id + "'>" + generic.name.toUpperCase() + "</option>"));
            });
        });
        $("#formulation_id").empty()
        $.getJSON(formulationURL, function (formulations) {
            $("#formulation_id").append($("<option value=''>Select Formulation</option>"));
            $.each(formulations, function (index, formulation) {
                $("#formulation_id").append($("<option value='" + formulation.id + "'>" + formulation.name.toUpperCase() + "</option>"));
            });
        });
    });
</script>
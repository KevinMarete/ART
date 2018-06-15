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
                    <input type="hidden" value="" name="dhis_code"/>  
                   <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Code</label>
                            <div class="col-md-9">
                                <input name="dhis_code" placeholder="Dhis Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="dhis_name" placeholder="Dhis Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Report</label>
                            <div class="col-md-9">
                                <input name="dhis_report" placeholder="Dhis Report" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Target Report</label>
                            <div class="col-md-9">
                                <input name="target_report" placeholder="Dhis Target Report" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Target Name</label>
                            <div class="col-md-9">
                                <input name="target_name" placeholder="Target Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Target Category</label>
                            <div class="col-md-9">
                                <select name="target_category" id="target_category" class="form-control select2" type="text">
                                    <option value="">--Select category--</option>
                                    <option value="drug">Drug</option>
                                    <option value="regimen">Regimen</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Target Element</label>
                            <div class="col-md-9">
                                <select name="target_id" id="target_id" class="form-control select2" type="text">
                                    <option>Select Element</option>
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
</div><!-- /.modal -->

<script type="text/javascript">
    var categoryURL = '../../API/category';
    var regimenURL = '../../API/regimen';

    $('#target_category').on('change', function () {
        if (this.value == 'drug')
        {
            $("#target_id").empty()
            $.getJSON(categoryURL, function (drugs) {
                $("#target_id").append($("<option value=''>--Select Drug--</option>"));
                $.each(drugs, function (index, category) {
                    $("#target_id").append($("<option value='" + category.id + "'>" + category.name.toUpperCase() + "</option>"));
                });
            });
        } else
        {
            $("#target_id").empty()
            $.getJSON(regimenURL, function (regimens) {
                $("#target_id").append($("<option value=''>--Select Regimen--</option>"));
                $.each(regimens, function (index, regimen) {
                    $("#target_id").append($("<option value='" + regimen.id + "'>" + regimen.name.toUpperCase() + "</option>"));
                });
            });
        }

    });
</script>
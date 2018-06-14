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
                            <label class="control-label col-md-3">Submodule</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="SubModule Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Module</label>
                            <div class="col-md-9">
                                <select name="module_id" id="module_id" placeholder="Module Name" class="form-control select2" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <input name="_table_" type="hidden" value="tbl_submodule">
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
        var moduleURL = '../../API/module';
        $("#module_id").empty()
        $.getJSON(moduleURL, function (modules) {
            $("#module_id").append($("<option value=''>Select Module</option>"));
            $.each(modules, function (index, module) {
                $("#module_id").append($("<option value='" + module.id + "'>" + module.name.toUpperCase() + "</option>"));
            });
        });
    });
</script>
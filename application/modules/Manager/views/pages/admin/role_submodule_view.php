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
                            <label class="control-label col-md-3">Role</label>
                            <div class="col-md-9">
                                <select name="role_id" id="role_id" class="form-control select2" type="text"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Submodule</label>
                            <div class="col-md-9">
                                <select name="submodule_id" id="submodule_id" class="form-control select2" type="text"></select>
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
        var roleURL = '../../API/role';
        var submoduleURL = '../../API/submodule';
        $("#role_id").empty()
        $.getJSON(roleURL, function (roles) {
           //$("#role_id").empty()
            $("#role_id").append($("<option value=''>Select Role</option>"));
            $.each(roles, function (index, role) {
                $("#role_id").append($("<option value='" + role.id + "'>" + role.name.toUpperCase() + "</option>"));
            });
        });
        $("#submodule_id").empty()
        $.getJSON(submoduleURL, function (submodules) {
            //$("#submodule_id").empty()
            $("#submodule_id").append($("<option value=''>Select Submodule</option>"));
            $.each(submodules, function (index, submodule) {
                $("#submodule_id").append($("<option value='" + submodule.id + "'>" + submodule.name.toUpperCase() + "</option>"));
            });
        });
    });
</script>
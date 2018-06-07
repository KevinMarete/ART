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
                            <label class="control-label col-md-3">Code</label>
                            <div class="col-md-9">
                                <input name="code" placeholder="Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <textarea name="description" placeholder="Description" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select name="category_id" id="category" class="form-control"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Service</label>
                            <div class="col-md-9">
                                <select name="service_id" id="service" class="form-control"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Line</label>
                            <div class="col-md-9">
                                <select name="line_id" id="line" class="form-control"></select>
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
</div><!--End bootstrap modal-->

<script type="text/javascript">
    $(function () {
        var categoryURL = '../../API/category';
        var serviceURL = '../../API/service';
        var lineURL = '../../API/line';
        $("#subcounty").empty()
        $.getJSON(categoryURL, function (categories) {
            $("#category").append($("<option value=''>Select Category</option>"));
            $.each(categories, function (index, category) {
                $("#category").append($("<option value='" + category.id + "'>" + category.name.toUpperCase() + "</option>"));
            });
        });
        $("#service").empty()
        $.getJSON(serviceURL, function (services) {
            $("#service").append($("<option value=''>Select Service</option>"));
            $.each(services, function (index, service) {
                $("#service").append($("<option value='" + service.id + "'>" + service.name.toUpperCase() + "</option>"));
            });
        });
        $("#line").empty()
        $.getJSON(lineURL, function (lines) {
            $("#line").append($("<option value=''>Select Line</option>"));
            $.each(lines, function (index, line) {
                $("#line").append($("<option value='" + line.id + "'>" + line.name.toUpperCase() + "</option>"));
            });
        });
    });
</script>

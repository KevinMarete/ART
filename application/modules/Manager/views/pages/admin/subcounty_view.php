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
                            <label class="control-label col-md-3">Sub county</label>
                            <div class="col-md-9">
                                <input name="name" id="name" placeholder="Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">County</label>
                            <div class="col-md-9">
                                <select name="county_id" id="county" class="form-control select2"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <input name="_table_" type="hidden" value="tbl_subcounty">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    $(function(){
        var countyURL = '../../API/county';
        $("#county").empty()
        $.getJSON(countyURL, function(counties){
            $("#county").append($("<option value=''>Select County</option>"));
            $.each(counties, function(index, county) {
                $("#county").append($("<option value='" + county.id + "'>" + county.name.toUpperCase() + "</option>"));
            });
        }); 
    });
</script>
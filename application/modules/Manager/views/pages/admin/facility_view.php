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
                            <label class="control-label col-md-3">Facility</label>
                            <div class="col-md-9">
                                <input id="name" name="name" placeholder="Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">MflCode</label>
                            <div class="col-md-9">
                                <input id="mflcode" name="mflcode" placeholder="MflCode" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select name="category" id="category_id" class="form-control select2" style="width: 100%">
                                    <option value="">Select Category</option>
                                    <option value="central">Central</option>
                                    <option value="satellite">Satellite</option>
                                    <option value="standalone">Standalone</option>
                                </select>
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">DhisCode</label>
                            <div class="col-md-9">
                                <input id="dhiscode" name="dhiscode" placeholder="DhisCode" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Longitude</label>
                            <div class="col-md-9">
                                <input id="longitude" name="longitude" placeholder="Longitude" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Latitude</label>
                            <div class="col-md-9">
                                <input id="latitude" name="latitude" placeholder="Latitude" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub County</label>
                            <div class="col-md-9">
                                <select name="subcounty_id" id="subcounty" class="form-control select2"> </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Partner</label>
                            <div class="col-md-9">
                                <select name="partner_id" id="partner" class="form-control select2"> </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btnSave" onclick="save()">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script type="text/javascript">
    $(function () {
        var subcountyURL = '../../API/subcounty';
        var parnerURL = '../../API/partner';
        $("#subcounty").empty()
        $.getJSON(subcountyURL, function (subcounties) {
            $("#subcounty").append($("<option value=''>Select SubCounty</option>"));
            $.each(subcounties, function (index, subcounty) {
                $("#subcounty").append($("<option value='" + subcounty.id + "'>" + subcounty.name.toUpperCase() + "</option>"));
            });
        });
        $("#partner").empty()
        $.getJSON(parnerURL, function (partners) {
            $("#partner").append($("<option value=''>Select Partner</option>"));
            $.each(partners, function (index, partner) {
                $("#partner").append($("<option value='" + partner.id + "'>" + partner.name.toUpperCase() + "</option>"));
            });
        });
    });
</script>
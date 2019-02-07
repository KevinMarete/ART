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
                                <select name="generic_id" id="generic_id" class="form-control "></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Formulation</label>
                            <div class="col-md-9">
                                <select name="formulation_id" id="formulation_id" class="form-control ">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Drug Category</label>
                            <div class="col-md-9">
                                <select name="drug_category" id="drug_category" class="form-control ">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Regimen Category</label>
                            <div class="col-md-9">
                                <select name="regimen_category" id="regimen_category" class="form-control ">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Min.MOS</label>
                            <div class="col-md-9">
                                <input name="min_mos" id="min_mos" placeholder="0" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Max.MOS</label>
                            <div class="col-md-9">
                                <input name="max_mos" id="max_mos" placeholder="3" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">AMC Months</label>
                            <div class="col-md-9">
                                <input name="amc_months" id="amc_months" placeholder="6" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Facility AMC</label>
                            <div class="col-md-9">
                                <input name="facility_amc" id="facility_amc" placeholder="0 = No AMC" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select name="stock_status" id="stock_status" class="form-control ">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">KEMSA Code</label>
                            <div class="col-md-9">
                                <input name="kemsa_code" id="kemsa_code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Short Expiry</label>
                            <div class="col-md-9">
                                <input name="short_expiry" id="short_expiry" class="form-control" placeholder="No of Months" type="number">
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
        var drug_categoryURL = '../../API/Drug_category';
        var stockStatusURL = '../../API/Stock_status';

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

        $("#drug_category").empty()
        $.getJSON(drug_categoryURL, function (categories) {
            $("#drug_category").append($("<option value=''>Select Drug Category</option>"));
            $.each(categories, function (index, category) {
                $("#drug_category").append($("<option value='" + category.id + "'>" + category.name.toUpperCase() + "</option>"));
            });
        });

        $("#regimen_category").empty()
        $.getJSON("<?=base_url();?>Manager/Orders/regimen_category", function (regimen) {
            $("#regimen_category").append($("<option value=''>Select Regimen Category</option>"));
            $.each(regimen, function (index, category) {
                $("#regimen_category").append($("<option value='" + category.id + "'>" + category.Name.toUpperCase() + "</option>"));
            });
        });


        $("#stock_status").empty()
        $.getJSON(stockStatusURL, function (categories) {
            $("#stock_status").append($("<option value=''>Select Status</option>"));
            $.each(categories, function (index, category) {
                $("#stock_status").append($("<option value='" + category.id + "'>" + category.name.toUpperCase() + "</option>"));
            });
        });

    });
</script>
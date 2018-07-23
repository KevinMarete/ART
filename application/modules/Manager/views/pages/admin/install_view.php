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
                                <select class="form-control select2" id="facility" name="facility_id"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label col-md-3">ADT Version</label>
                            <div class="col-md-9">
                                <input class="form-control" id="version" name="version" placeholder="version">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Setup Date</label>
                            <div class="col-md-9">
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control" id="setup_date" name="setup_date" placeholder="setup date" required="">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Upgrade Date</label>
                            <div class="col-md-9">
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control" id="upgrade_date" name="upgrade_date" placeholder="upgrade date" required="">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Comments</label>
                            <div class="col-md-9">
                                <input class="form-control" id="comments" name="comments" placeholder="comments">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Contact Name</label>
                            <div class="col-md-9">
                                <input class="form-control" id="contact_name" name="contact_name" placeholder="contact name">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Contact Phone</label>
                            <div class="col-md-9">
                                <input class="form-control" id="contact_phone" name="contact_phone" placeholder="700000000">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Is System used?</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="is_usage" id="is_usage_1" value="1" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_usage" id="is_usage_0" value="0">No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Is there Internet?</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="is_internet" id="is_internet_1" value="1">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_internet" id="is_internet_0" value="0" checked>No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">EMRS Used</label>
                            <div class="col-md-9">
                                <select multiple class="form-control" name="emrs_used" id="emrs_used">
                                    <option selected value="" class="emrs_option"></option>
                                    <option value="IQCare">IQCARE</option>
                                    <option value="CPAD">CPAD</option>
                                    <option value="KenyaEMR">KENYAEMR</option>
                                    <option value="OpenMRS">OpenMRS</option>
                                    <option value="MARPS">MARPS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Active Patients</label>
                            <div class="col-md-9">
                                <input class="form-control" name="active_patients" id="active_patients" placeholder="1400">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Assigned To</label>
                            <div class="col-md-9">
                                <select class="form-control select2" id="user" name="user_id"></select>
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
        </div>
    </div>
</div><!--End Modal install Site-->

<script type="text/javascript">
    var userURL = '../../API/user';

    $(function () {
        //Gets all users
        $.getJSON(userURL, function (data) {
            $("#user option").empty();
            $("#user").append($("<option value=''>Select Assignee</option>"));
            $.each(data, function (i, v) {
                $("#user").append($("<option value='" + v.id + "'>" + v.firstname.toUpperCase() + ' ' + v.lastname.toUpperCase() + "</option>"));
            });
        });

        //EMRS Used multiselect
        //$('#emrs_used').multiselect();

        //Deselect on-mouse click
        $('select option').on('mousedown', function (e) {
            this.selected = !this.selected;
            e.preventDefault();
        });

        //Date picker setup_date
        $.fn.datepicker.defaults.format = "yyyy/mm/dd";
        $.fn.datepicker.defaults.endDate = '0d';
        $('#setup_date').datepicker({
        });

        //Date picker upgrade_date
        $.fn.datepicker.defaults.format = "yyyy/mm/dd";
        $.fn.datepicker.defaults.endDate = '0d';
        $('#upgrade_date').datepicker({
        });
        
        $('.emrs_option').hide(true);
    });
</script>
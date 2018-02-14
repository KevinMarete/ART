<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">FACILITY REGISTRATION FORM</h3>
        </div>
        <?php
//      print_r($search_name);
        ?>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    INSTALLATION/UPGRADE DETAILS
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Facility Name</label>
                                    <!--<input class="form-control facility_name">-->
<!--                                    <input class="form-control facility_name" placeholder="Kenyatta National Hospital">-->
                                    <select class="form-control" name="facility_name">
                                        <?php
                                        foreach ($search_name as $fac_name) {
                                            echo '<option value="' . $fac_name->name . '">' . $fac_name->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>MFL Code</label>
                                    <input class="form-control mfl_code" name="mfl_code" placeholder="13023">
                                </div>
                                <div class="form-group">
                                    <label>County</label>
                                    <!--<input class="form-control county" placeholder="Nairobi" onselect="getSubcounties()">-->
                                    <select class="form-control" name="county">
                                        <!--<option value="">Select County-->
                                        <?php
                                        foreach ($get_county as $county) {
                                            echo '<option value="' . $county->name . '">' . $county->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Subcounty</label>
                                    <!--<input class="form-control sub_county" placeholder="Dagoretti South">-->
                                    <select class="form-control" name="subcounty">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Classification</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="classification" id="central" value="Central" checked>Central
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="classification" id="satellite" value="satellite">Satellite
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="classification" id="standalone" value="standalone">Standalone
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Partner</label>
                                    <!--<input class="form-control" placeholder="CHS">-->
                                    <select class="form-control" name="partner">
                                        <!--<option value="">Select County-->
                                        <?php
                                        foreach ($partner as $partner) {
                                            echo '<option value="' . $partner->name . '">' . $partner->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Contact Name</label>
                                    <input class="form-control" name="contactName" placeholder="Dr.Sample">
                                </div>
                                <div class="form-group">
                                    <label>Contact Phone</label>
                                    <input class="form-control" name="contactPhone" placeholder="0722123456">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>ADT Version</label>
                                    <input class="form-control" name="adtVersion" placeholder="3.2.1">
                                </div>
                                <div class="form-group">
                                    <label>Setup Date</label>
                                    <input class="form-control datepicker" name="setDate" type="date" id="set_date" placeholder="2017-02-05">
                                </div>
                                <div class="form-group">
                                    <label>Upgrade Date</label>
                                    <input class="form-control datepicker" name="upgradeDate" type="date" placeholder="2018-02-08">
                                </div>
                                <div class="form-group">
                                    <label>Is System used?</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="in_use" id="in_use_yes" value="1" checked>Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="in_use" id="in_use_no" value="0">No
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Is there Internet?</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="internet" id="internet_yes" value="1">Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="internet" id="internet_no" value="0" checked>No
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>EMRS Used</label>
                                    <select multiple class="form-control" name="emrsUsed">
                                        <option>IQCARE</option>
                                        <option>CPAD</option>
                                        <option>KENYAEMR</option>
                                        <option>OPENMRS</option>
                                        <option>EDITT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Active Patients</label>
                                    <input class="form-control" name="activePatient" placeholder="1400">
                                </div>
                                <div class="form-group">
                                    <label>Assigned To</label>
                                    <input class="form-control" name="assignedTo" placeholder="Alfred">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success"> <i class="fa fa-save fa-fw"></i> Save</button>
                                <button type="reset" class="btn btn-danger"> <i class="fa fa-refresh fa-fw"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<script type="text/javascript">

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    function getSubcounties(id) {
        // get_sub_county(id)
    }
</script>
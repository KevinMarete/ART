<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ADT Installed Sites</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sites Installed Listing

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Add Site
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                INSTALLATION/UPGRADE DETAILS
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Facility Name</label>
                                                                <input class="form-control facility_name" name="facility_name" placeholder="Kenyatta National Hospital">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>MFL Code</label>
                                                                <input class="form-control mfl_code" name="mfl_code" placeholder="13023">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>County</label>
                                                                <input class="form-control county" placeholder="Nairobi">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Subcounty</label>
                                                                <input class="form-control sub_county" placeholder="Dagoretti South">
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
                                                                <input class="form-control" placeholder="CHS">

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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="sites_listing">
                        <thead>
                            <tr>
                                <th>Facility</th>
                                <th>Version</th>
                                <th>Setup Date</th>
                                <th>Active Patients</th>
                                <th>Contact Person</th>
                                <th>Contact Phone</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Facility</th>
                                <th>Version</th>
                                <th>Setup Date</th>
                                <th>Active Patients</th>
                                <th>Contact Person</th>
                                <th>Contact Phone</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script src="<?php echo base_url() . 'public/admin/js/sites.js'; ?>"></script>
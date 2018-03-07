<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-5">
            <h3 class="">ADT INSTALLED SITES</h3>
        </div>
        <div class="col-lg-7">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> Sites</li>
            </ol>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sites Installed Listing
                        <!-- Button trigger modal Add site -->
                        <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"></i> Add Site
                        </button>
                        <!-- Modal Install Site-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        INSTALLATION/UPGRADE DETAILS
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="panel-body">
                                                        <form role="form" action="<?php echo base_url() . 'Admin/Sites/saveSite'; ?>" method="POST">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Facility Name</label>
                                                                        <select class="form-control" id="facility" name="facility_id" required=""></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>MFL Code</label>
                                                                        <input class="form-control" id="mflcode" name="mflcode" placeholder="mflcode" readonly="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>County</label>
                                                                        <select class="form-control" id="county" name="county_id"></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Subcounty</label>
                                                                        <select class="form-control" id="subcounty" name="subcounty_id" required=""></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Category</label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="category" id="central" value="central" checked>Central
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="category" id="satellite" value="satellite">Satellite
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="category" id="standalone" value="standalone">Standalone
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Partner</label>
                                                                        <select class="form-control" id="partner" name="partner_id" required=""></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Contact Name</label>
                                                                        <input class="form-control" id="contact_name" name="contact_name" placeholder="Contact Name" required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Contact Phone</label>
                                                                        <input class="form-control" id="contact_phone" name="contact_phone" placeholder="Contact Phone" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ADT Version</label>
                                                                        <input class="form-control" id="version" name="version" placeholder="version">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Setup Date</label>
                                                                        <div class="input-group date" data-provide="datepicker">
                                                                            <input type="text" class="form-control" id="setup_date" name="setup_date" required="">
                                                                            <div class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-th"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Upgrade Date</label>
                                                                        <div class="input-group date" data-provide="datepicker">
                                                                            <input type="text" class="form-control" id="update_date" name="update_date" required="">
                                                                            <div class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-th"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Is System used?</label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="is_usage" id="is_usage_1" value="1" checked>Yes
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="is_usage" id="is_usage_0" value="0">No
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Is there Internet?</label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="is_internet" id="is_internet_1" value="1">Yes
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="is_internet" id="is_internet_0" value="0" checked>No
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>EMRS Used</label>
                                                                        <select multiple class="form-control" name="emrs_used[]" id="emrs_used">
                                                                            <option>IQCARE</option>
                                                                            <option>CPAD</option>
                                                                            <option>KENYAEMR</option>
                                                                            <option>OPENMRS</option>
                                                                            <option>EDITT</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Active Patients</label>
                                                                        <input class="form-control" name="active_patients" id="active_patients" placeholder="1400">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Assigned To</label>
                                                                        <select class="form-control" id="user" name="user_id" required=""></select>
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
                        </div><!--End Modal install Site-->

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="sites_listing">
                                <thead>
                                <th>Facility Name</th>
                                <th>Version</th>
                                <th>Setup Date</th>
                                <th>Active Patients</th>
                                <th>Contact Person</th>
                                <th>Contact Phone</th>                            
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($Installed_sites as $Inst_sites):
                                        ?>
                                        <tr>
                                            <td><?= $Inst_sites->name ?></td>
                                            <td><?= $Inst_sites->version ?></td>
                                            <td><?= $Inst_sites->setup_date ?></td>
                                            <td><?= $Inst_sites->active_patients ?></td>
                                            <td><?= $Inst_sites->contact_name ?></td>
                                            <td><?= $Inst_sites->contact_phone ?></td>                                        
                                            <td class="center">
                                                <a class="button btn-sm btn-info updateSite" href="<?php echo base_url() . 'Admin/Sites/editSite/' . $Inst_sites->id; ?>"><i class="fa fa-pencil"></i></a>
                                                <a class="button btn-sm btn-danger delete" onclick="deleteSite(<?php echo $Inst_sites->id; ?>)"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Facility Name</th>
                                        <th>Version</th>
                                        <th>Setup Date</th>
                                        <th>Active Patients</th>
                                        <th>Contact Person</th>
                                        <th>Contact Phone</th>                                   
                                        <th>Action</th>
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
    </div>
</div>

<script src="<?php echo base_url() . 'public/admin/js/sites.js'; ?>"></script>
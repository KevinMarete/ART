<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>Facilities Listing</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin/home'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> Facility Listing</li>
            </ol>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" onclick="add_facility()"><i class="fa fa-plus-square-o"></i> Add Facility</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
            <br>
            <br>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">

            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Facility Name</th>
                        <th>MflCode</th>
                        <th>Category</th>
                        <th>DhisCode</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>SubCounty Name</th>
                        <th>Partner Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?php echo base_url() . 'public/admin/js/settings_facility.js'; ?>"></script>

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
                            <label class="control-label col-md-3">Facility Name</label>
                            <div class="col-md-9">
                                <input id="name" name="name" placeholder="Facility Name" class="form-control" type="text">
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
                                <select name="category" id="category_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Category---</option>
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
                                <select name="subcounty_id" id="subcounty" class="form-control" style="width: 100%">
                                    <option value="">----Select SubCounty---</option>
                                    <?php foreach ($get_subcounty as $row) { ?>                                        
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Partner Name</label>
                            <div class="col-md-9">
                                <select name="partner_id" id="partner" class="form-control" style="width: 100%">
                                    <option value="">----Select Partner----</option>
                                    <?php foreach ($get_partner as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()">Save</button>
                <button type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
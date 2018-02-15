<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">ADT Installed Sites</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sites Installed Listing
                    <button class="btn btn-info btn-md"> <i class="fa fa-plus"></i> Add Site</button>
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
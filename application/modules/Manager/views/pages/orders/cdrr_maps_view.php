 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Orders</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> View Orders</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <table cellpadding="4" border="1" width="100%">
                                <tbody>
                                    <tr>
                                        <td><b>Facility Name: </b><span class="facility_name"></span></td>
                                        <td><b>Facility code: </b><span class="mflcode"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>County: </b><span class="county"></span></td>
                                        <td><b>Subcounty: </b><span class="subcounty"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Type of Service provided at the Facility: </b><span class="services"></span></td>
                                        <td><b>Non-ARV: </b><input type="checkbox" class="non_arv" readonly="readonly"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Period of Reporting: </b>
                                            <b>Beginning:</b> <span class="period_begin"></span>
                                            <b>Ending:</b> <span class="period_end"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php foreach ($columns as $column){ echo"<th>".ucwords($column)."</th>"; } ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
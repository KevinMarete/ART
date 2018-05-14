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
                            <div class="col-md-12">
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
                        <div class="row">
                            <div class="col-md-7">
                                <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">Drug Name</th>
                                            <th rowspan="3">Unit Pack Size</th>
                                            <th>Beginning Balance</th>
                                            <th>Quantity <br>Received in this period</th>
                                            <th>Total Qty ISSUED <br>to ARV dispensing sites <br>(Satellite sites plus Central site <br>dispensing point(s) where relevant)</th>
                                            <th>End of Month Physical Count</th>
                                            <th>Reported Aggregated <br>Quantity CONSUMED <br>in the reporting period<br> (Satellite sites plus <br>Central site dispensing point where relevant)</th>
                                            <th>Reported Aggregated <br>Physical Stock on Hand <br>at end of reporting period <br>(Satellite sites plus <br>Central site dispensing point where relevant)</th>
                                            <th >Quantity required for RESUPPLY</th>
                                            <th >Calculated Quantity</th>
                                            <th >Rationalized Quantity</th>
                                        </tr>
                                        <tr>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                            <th>In Packs</th>
                                        </tr>
                                        <tr>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>F</th>
                                            <th>G</th>
                                            <th>H</th>
                                            <th>J</th>
                                            <th>K</th>
                                            <th>L</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> <!--end of cdrr-->
                            <div class="col-md-5">

                            </div><!--end of maps-->
                        </div>
                    </div>
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
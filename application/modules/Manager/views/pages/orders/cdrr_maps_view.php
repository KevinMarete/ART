 <div id="container">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li>Orders</li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> View Orders</li>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    CDRR
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 ">
                                <button type="submit" class="btn btn-success">Approve Order</button>
                                <button type="submit" class="btn btn-warning">Reject Order</button>
                            </div>
                            <div class="col-md-8 ">
                                <span class="label label-info">* 1</span> - <small> Total Qty ISSUED to ARV dispensing sites (Satellite sites plus Central site dispensing point(s) where relevant)</small><br />
                                <span class="label label-info">* 2</span> - <small> End of Month Physical Count</small><br />
                                <span class="label label-info">* 3</span> - <small> Reported Aggregated Quantity CONSUMED in the reporting period (Satellite sites plus Central site dispensing point where relevant)</small> <br />
                                <span class="label label-info">* 4</span> - <small> Reported Aggregated Physical Stock on Hand at end of reporting period (Satellite sites plus Central site dispensing point where relevant)
                                </small>
                                <br />
                                <br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <table cellpadding="4"  width="100%" class="table">
                                    <tbody>
                                        <tr>
                                            <td><b>Facility Name: </b><span class="facility_name"> <?= $columns['cdrrs']['data'][0][43]; ?></span></td>
                                            <td><b>Facility code: </b><span class="mflcode"><?= $columns['cdrrs']['data'][0][34]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>County: </b><span class="county"><?= $columns['cdrrs']['data'][0][44]; ?></span></td>
                                            <td><b>Subcounty: </b><span class="subcounty"><?= $columns['cdrrs']['data'][0][45]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Type of Service provided at the Facility: </b><span class="services"><?= $columns['cdrrs']['data'][0][10]; ?></span></td>
                                            <td><b>Non-ARV: </b> <?= $columns['cdrrs']['data'][0][12]; ?><input type="checkbox" class="non_arv" readonly="readonly"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Period of Reporting: </b>
                                                <b>Beginning:</b> <span class="period_begin"><?= $columns['cdrrs']['data'][0][5]; ?></span>
                                                <b>Ending:</b> <span class="period_end"><?= $columns['cdrrs']['data'][0][6]; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                             

                            </div>
                            <div class="col-md-12">
                                <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">Drug Name</th>
                                            <th rowspan="3">Pack Size</th>
                                            <th>Beginning Balance</th>
                                            <th>Quantity Received</th>
                                            <th>Qty ISSUED  <span class="label label-info">* 1</span></th>
                                            <th>End Month Count <span class="label label-info">* 2</span></th>
                                            <th>Qty Consumed <span class="label label-info">* 3</span></th>
                                            <th>Physical SAH<span class="label label-info">* 4</span></th>
                                            <th >Qty for RESUPPLY</th>
                                            <th >Calculated Qty</th>
                                            <th >Rationalized Qty</th>
                                            <th >Allocated</th>
                                            <th rowspan="3">comments</th>
                                            <th rowspan="3">decision</th>
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
                                            <th>M</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($columns['cdrrs']['data'] as $cdrr ) {?>
                                            <tr>
                                                <td><?= $cdrr[42];?></td>
                                                <td><?= $cdrr[39];?></td>
                                                <td><?= $cdrr[16];?></td>
                                                <td><?= $cdrr[17];?></td>
                                                <td><?= $cdrr[18];?></td>
                                                <td><?= $cdrr[22];?></td>
                                                <td><?= $cdrr[19]; //dispensed?></td>
                                                <td><?= $cdrr[27];?></td>
                                                <td><?= $cdrr[26];?></td>
                                                <td><?= $cdrr[26]* 4 ; // calculated ?></td>
                                                <td><?= ($cdrr[19]) ; // rationalized ?></td>
                                                <td><input type="text" class="form-control" name="Allocated" value="<?= ($cdrr[19]) * 4 ; // rationalized ?>"></td>
                                                <td><input type="text" class="form-control" name="Allocated" value="<?= ($cdrr[19]) * 4 ; // rationalized ?>"></td>
                                                <td>label</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-info">Save Allocation</button>
                                <button type="submit" class="btn btn-success">Complete Allocation</button>

                            </div> <!--end of cdrr-->
                            <div class="col-md-5">

                            </div><!--end of maps-->
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    D-MAP
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="container-fluid">
                        <span class="label label-info">* 1</span> - <small> No of Cumulative Active Patients/Clients on this regimen at the End of the Reporting period</small>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <table cellpadding="4" width="100%" class="table">
                                    <tbody>
                                        <tr>
                                            <td><b>Facility Name: </b><span class="facility_name"> <?= $columns['maps']['data'][0][49]; ?></span></td>
                                            <td><b>Facility code: </b><span class="mflcode"><?= $columns['maps']['data'][0][41]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>County: </b><span class="county"><?= $columns['maps']['data'][0][51]; ?></span></td>
                                            <td><b>Subcounty: </b><span class="subcounty"><?= $columns['maps']['data'][0][50]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Type of Service provided at the Facility: </b><span class="services"><?= $columns['maps']['data'][0][9]; ?></span></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <b>Period of Reporting: </b>
                                                <b>Beginning:</b> <span class="period_begin"><?= $columns['maps']['data'][0][5]; ?></span>
                                                <b>Ending:</b> <span class="period_end"><?= $columns['maps']['data'][0][6]; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <th >Category</th>
                                        <th >Regimen Code</th>
                                        <th >ARV Treatment Regimen</th>
                                        <th >Active Patients on this regimen <span class="label label-info">* 1</span></th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($columns['maps']['data'] as $cdrr ) {?>
                                            <tr>
                                                <td><?= $cdrr[40];?></td>
                                                <td><?= $cdrr[4];?></td>
                                                <td><?= $cdrr[48];?></td>
                                                <td><?= $cdrr[22]; // total adult  23 = total child?></td>
                                            </tr>
                                        <?php } ?>
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

<script type="text/javascript">
    $(function(){
        $('#side-menu').remove();
        // alert('page-wrapper!');

    });
</script>
<style type="text/css">
.breadcrumb{
    padding: 8px 15px 5px 8px;
    margin-bottom: 0px; 
}
.panel-default{
    margin: 12px;
}
</style>
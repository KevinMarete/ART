<style>
    div.FLOATER {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }
    thead .holdHeader{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 220px;
    }
    tbody .holdHeader{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 220px;
    }

    thead .holdHeader2{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 150px;
    }
    tbody .holdHeader2{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 150px;
    }

    tbody .stickyColumn{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 2px;
    }
    thead .stickyColumn{
        position: -webkit-sticky;
        background: #ffffff;
        text-align: center;
        position: sticky;
        left: 2px;
    }

    td.details-control {
        background: url('<?= base_url(); ?>public/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('<?= base_url(); ?>public/details_close.png') no-repeat center center;
    }

    td:hover {
        background-color: #ffff99;
    }

    .groups {
        height: 70px;	
        overflow: hidden;
        position: relative;
    }
    .groups  {
        position: absolute;
        width: 100%;
        height: 100%;
        margin: 0;
        line-height: 50px;
        animation: example1 15s linear infinite;  /* Apply the animation */
    }
    /* Define the animation */
    @keyframes groups {
        from {
            margin-left: 667px;
            width: 300%;
        }
        to {
            margin-left: -100%;
            width: 100%;
        }
    }


</style>


<div id="container" class="container-fluid">

    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('manager/orders/allocation'); ?>">Allocation</a></li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i>View Allocation</li>
            <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>
            <a href="<?php echo base_url('manager/orders/view/') . '/' . $this->uri->segment('4') . '/' . $this->uri->segment('5'); ?>" class="btn btn-sm btn-warning pull-right" target="_blank"> <i class="glyphicon glyphicon-eye-open"></i> View Order</a>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
    <!-- /.row -->

    <div class="col-lg-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" style="margin: 10px;"> 

                            <?php if ($role == 'county' && date('d') <= 30 && $columns['cdrrs']['data'][0]['status'] == 'allocated') { ?>
                                <button type="submit" class="btn btn-success" id="approveOrder">Approve Order</button>
                                <button type="submit" class="btn btn-danger" id="rejectOrder">Reject Order</button>
                            <?php } else if ($role == 'nascop' && date('d') <= 30 && $columns['cdrrs']['data'][0]['status'] == 'approved') { ?>
                                <button type="submit" class="btn btn-success" id="reviewOrder">Submit to KEMSA</button>
                                <button type="submit" class="btn btn-danger" id="rejectOrder">Reject Order</button>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Facility Name: </b>
                                            <span class="facility_name"> <?= ucwords($columns['cdrrs']['data'][0]['facility_name']); ?></span>
                                            <?php $this->session->set_userdata('facility_name', ucwords($columns['cdrrs']['data'][0]['facility_name'])); ?>
                                            <?php $this->session->set_userdata('county_pharm', ucwords($columns['cdrrs']['data'][0]['county'])); ?>

                                        </td>
                                        <td>
                                            <b>Facility code: </b>
                                            <span class="mflcode"><?= ucwords($columns['cdrrs']['data'][0]['mflcode']); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>County: </b>
                                            <span class="county"><?= ucwords($columns['cdrrs']['data'][0]['county']); ?></span>
                                        </td>
                                        <td>
                                            <b>Subcounty: </b>
                                            <span class="subcounty"><?= ucwords($columns['cdrrs']['data'][0]['subcounty']); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Period of Reporting: </b>
                                            <span><?= ucwords(date('F Y', strtotime($columns['cdrrs']['data'][0]['period_begin']))); ?></span>
                                        </td>
                                        <td>
                                            <b>Status: </b> <span><?php
                                                if ($columns['cdrrs']['data'][0]['status'] == 'reviewed') {
                                                    echo 'Submitted to KEMSA';
                                                } else {
                                                    echo ucwords($columns['cdrrs']['data'][0]['status']);
                                                };
                                                ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>                            
                    </div>

                </div>
            </div>
        </div>
        <div class="row FLOATER">
            <a href="<?= base_url(); ?>public/kemsa_templates/AllocationTemplate.xlsx" style="margin: 10px;" class="btn btn-primary btn-sm" >Download KEMSA MOS Template Guide</a>

            <div class="panel panel-default ">
                <div class="panel-body">
                    <div class="col-sm-12 ">
                        <div class="col-sm-9">
                            <form name="orderForm" id="orderForm">
                                <table class="table table-striped table-bordered table-condensed table-hover" id="AllocationTable">
                                    <thead id="THEAD" >
                                        <tr>
                                            <th class="stickyColumn" style="background: #FFFFFF;">Drug Name</th>
                                            <th>Pack Size</th>
                                            <th>Previous Closing Balance</th>
                                            <th>Beginning Balance</th>
                                            <th>Quantity Received</th>
                                            <?php if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') { ?> 
                                                <th>Quantity Issued</th>
                                            <?php } else { ?>
                                                <th>Quantity Dispensed</th>
                                            <?php } ?>
                                            <th>Losses & Wastage</th>
                                            <th>Positive Adjustments</th>
                                            <th>Negative Adjustments</th>
                                            <th class="holdHeader2" style="background: #ffffff;">End Month Stock on Hand</th>

                                            <th class="">Aggregate Consumed</th>
                                            <th >Aggregate Stock on Hand</th>

                                            <th colspan="2">Commodities Expiring < 6 Months</th>
                                            <th>Days out of Stock</th>
                                            <th>Resupply Quantity</th>
                                            <th class="holdHeader" >AMC</th>
                                            <th>Facility MOS</th>
                                            <th>AutoCalc Resupply</th>
                                            <th>Allocated</th>
                                            <th>Allocated MOS</th>
                                            <th>Comments</th>
                                            <th>Decision</th>
                                            <th>regimen</th>
                                        </tr>
                                        <tr>
                                            <th class="stickyColumn" style="background: #ffffff;">A</th>
                                            <th></th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>E</th>
                                            <th>F</th>
                                            <th>G</th>

                                            <th>I</th>
                                            <th class="holdHeader2" style="background: #ffffff;">J</th>


                                            <th>Quantity</th>
                                            <th>K</th>
                                            <th>L</th>
                                            <th>Expiry Date</th>
                                            <th>M</th>
                                            <th>N</th>
                                            <th class="holdHeader" style="background: #ffffff;">O</th>
                                            <th>P</th>
                                            <th>Q</th>
                                            <th>R</th>
                                            <th>S</th>
                                            <th>T</th>
                                            <th>U</th>
                                            <th>Y</th>
                                        </tr>
                                    </thead>
                                    <tbody id="TBODY">

                                        <?php
                                        foreach ($columns['drugs'] as $key => $drug) {
                                            $drugid = $drug['id'];
                                            if (in_array($drugid, array_keys($columns['cdrrs']['data']['cdrr_item']))) {
                                                $pcount = $columns['pcdrrs']['data']['cdrr_item'][$drugid]['count'];
                                                $balance = $columns['cdrrs']['data']['cdrr_item'][$drugid]['balance'];
                                                $drugamc = $columns['cdrrs']['data']['cdrr_item'][$drugid]['drugamc'];
                                                $consumed = $columns['cdrrs']['data']['cdrr_item'][$drugid]['dispensed_packs'];
                                                $count = $columns['cdrrs']['data']['cdrr_item'][$drugid]['count'];
                                                $amc_months = $drug['facility_amc'];
                                                empty($pcount) ? $pcount = 0 : $pcount = $pcount;
                                                empty($balance) ? $balance = 0 : $balance = $balance;
                                                ?>
                                                <tr>
                                                    <td class='stickyColumn'  title="Commodity Name"><?= $drug['name']; ?></td>                                              
                                                    <td  title="Package Size"><?= $drug['pack_size']; ?></td>
                                                    <td title="Commodity quantity closed with previous or last month"><?= $pcount; ?></td>
                                                    <td title="Commodity quantity opening with in the current month">
                                                        <?= $balance; ?>
                                                        <?php
                                                        if ($pcount > $balance) {
                                                            $p = round($pcount - $balance, 0);
                                                            echo '<sup><span style="background: red; font-size:9px;" class="badge"> -' . $p . '</span></sup>';
                                                        } else if ($balance > $pcount) {
                                                            $p = round($balance - $pcount, 0);
                                                            echo '<sup><span style="background: red; font-size:9px;" class="badge"> +' . $p . '</span></sup>';
                                                        }
                                                        ?>                                                        
                                                    </td>
                                                    <?php
                                                    $disabled = '';
                                                    $comment = '';
                                                    $status = $columns['cdrrs']['data']['cdrr_item'][$drugid]['stock_status'];
                                                    if ($status == 2) {
                                                        $disabled = 'disabled';
                                                        $comment = 'Stocked Out';
                                                    }
                                                    ?>
                                                    <td title="Commodity quantity received"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['received']; ?></td>
                                                    <td title="Commodity quantity dispensed from facility"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['dispensed_packs']; ?></td>
                                                    <td title="Quantity of commodity lost or wasted"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['losses']; ?></td>
                                                    <td title="Positive (+) ajustment on commodity quantity"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments']; ?></td>
                                                    <td title="Negative (-) ajustment on commodity quantity"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments_neg']; ?></td>
                                                    <td class="eMOSH holdHeader2" style="background: #ffffff;" title="Beginning balance less Quantity Issued (C - E)"><?= $eMSOH = $columns['cdrrs']['data']['cdrr_item'][$drugid]['count']; ?></td>

                                                    <td class="" title="Quantity consumed including in the satellite sites"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_consumed']; ?></td>
                                                    <td class="aggSOH  " title="Quantity available at the facility currently"><?= $aggSOH = $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_on_hand']; ?></td>

                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_quant']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_date']; ?></td>
                                                    <td title="No of days commodity has been out of stock"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['out_of_stock']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['resupply']; ?></td>
                                                    <?php if ($amc_months == '0') { ?>
                                                        <td style="background: #ffffff" class="AMC holdHeader" title="Average Monthly Consumption for the last 3 Months">No AMC</td>                                                       
                                                        <td style="" title="Aggregate Stock on Hand / AMC (K/O)">No AMC</td>
                                                        <td style="" title="Resupply Quantity which is AMC by three less stock on hand ((AMC(O)*3)-J)">No AMC</td>                                                       
                                                    <?php } else { ?>                                                    
                                                        <td style="background: #ffffff" class="AMC holdHeader" title="Average Monthly Consumption for the last 3 Months"><?= $drugamc; ?></td>
                                                        <?php
                                                        $allocated = '';
                                                        if ($columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated'] >= 0) {
                                                            $allocated = $columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated'];
                                                        } else {
                                                            $allocated = $columns['cdrrs']['data']['cdrr_item'][$drugid]['resupply'];
                                                        }
                                                        $sSOH = $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_on_hand'];
                                                        ?>
                                                        <td title="Aggregate Stock on Hand / AMC (K/O)">
                                                            <?php
                                                            if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') {
                                                                echo $mos = number_format(($count) / $drugamc, 2);
                                                            } else {
                                                                echo $mos = number_format($eMSOH / $drugamc, 2);
                                                            }
                                                            ?>
                                                            <input class="FacilityMOS" type="hidden" value="<?= $mos; ?>"/>
                                                        </td>

                                                        <?php
                                                        $resupply = '';
                                                        $resup = ($drugamc * 3) - $count;
                                                        if ($resup < 0) {
                                                            $resupply = 0;
                                                        } else {
                                                            $resupply = $resup;
                                                        }
                                                        ?>
                                                        <td title="Resupply Quantity which is AMC by three less stock on hand ((AMC(O)*3)-J)"><?= $resupply ?></td>
                                                    <?php } ?>
                                                    <td title="Actual order quantity to allocate">

                                                        <input type="text" style="width:80px; text-align: center;" class="form-control AMOS Allocated"  data-toggle="tooltip" title="" <?= $disabled; ?> data-drug="<?= $drugid ?>"  name="qty_allocated-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" value="<?= $allocated ?>">
                                                    </td>
                                                    <td title="Total Months of stock that will be available after allocation is done">
                                                        <?php
                                                        $min_mos = $columns['cdrrs']['data']['cdrr_item'][$drugid]['min_mos'];
                                                        $max_mos = $columns['cdrrs']['data']['cdrr_item'][$drugid]['max_mos'];
                                                        ?>
                                                        <input type="hidden" style="width:70px;" class="MIN" value="<?= $min_mos; ?>"/>
                                                        <input type="hidden" style="width:70px;"class="MAX" value="<?= $max_mos; ?>"/>
                                                        <?php if ($amc_months !== '0') { ?>
                                                            <input type="text"   style="width:50px; text-align: center;" class="form-control MOS AllocatedMOS" data-toggle="tooltip" <?= $disabled; ?> title="Max MOS 3months" name="qty_allocated_mos-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" value="<?= number_format($columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated_mos'], 2) ?>">
                                                        <?php } else { ?>
                                                            No AMC
                                                        <?php } ?>
                                                    </td>

                                                    <td title="Any feedback deemed necessary">
                                                        <textarea type="text" style="width:100px;" class="form-control comment" <?= $disabled; ?> name="feedback-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" ><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['feedback']; ?></textarea>
                                                    </td>



                                                    <td>
                                                        <?php
                                                        // echo $mos;
                                                        if ($mos < 3) {
                                                            echo '<span class="label label-danger">RESUPPLY</span>';
                                                        } else if ($mos >= 3 && $mos <= 6) {
                                                            echo '<span class="label label-warning">MONITOR</span>';
                                                        } else if ($mos > 6) {
                                                            echo '<span class="label label-success">REDISTRIBUTE</span>';
                                                        } else {
                                                            echo '<span class="label label-success"></span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $drug['regimen_category']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </tbody>

                                </table>
                            </form>
                        </div>
                        <div class="col-sm-3" >
                            <div class="table-responsive-removed">
                                <table class="table table-striped table-bordered table-hover" id="mapsTableReg">
                                    <thead>
<!--                                        <tr>
                                            <th colspan="3"><a href="#MapsNo" class="btn btn-info btn-block"  data-toggle="modal" data-target="#myModal">View Patient Numbers / Drugs</a></th>
                                        </tr>-->
                                        <tr>
                                            <th></th>
                                            <th>Code | Regimen</th>
                                            <th title="Current Active Patient">No. of Patients </th>
                                            <th title="Previous Active Patient">(% Change)</th>
                                            <th title="Regimen Line">Regimen Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $curr_ = 0;
                                        $prev = 0;

                                        foreach ($columns['regimens'] as $category => $regimens) {
                                            ?>
                                            <?php foreach ($regimens as $regimen) { ?>
                                                <?php if (in_array($regimen['id'], array_keys($columns['maps']['data']))) { ?>
                                                    <tr class="REGOPEN" data-reg="<?= $regimen['id']; ?>" >
                                                        <td class="details-control"></td>
                                                        <td><?= $regimen['name']; ?></td>
                                                        <td><?php echo $current = $columns['maps']['data'][$regimen['id']]; ?></td>
                                                        <td><?php
                                                            echo $previous = $columns['previousmaps']['data'][$regimen['id']];
                                                            if ($current > $previous) {
                                                                $p = round((($current - $previous) / $current) * 100, 0);
                                                                echo '<sup><span style="background: green; font-size:9px;" class="badge"> +' . $p . '%</span></sup>';
                                                            } else if ($previous > $current) {
                                                                $p = round((($previous - $current) / $previous) * 100, 0);
                                                                echo '<sup><span style="background: red; font-size:9px;" class="badge"> -' . $p . '%</span></sup>';
                                                            }
                                                            $curr_ = $curr_ + $current;
                                                            $prev = $prev + $previous;
                                                            ?>

                                                        </td>
                                                        <td><?= $category ?></td>

                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </tbody>
                                </table>                  


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default" style="background: #ffffff;   position:relative; ma">
                <div class="panel-body" style="background: #ffffff;">
                    <div class="col-sm-9" style="margin-top: 20px;" >
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed" id="TimeLog" style="background: #ffffff;">
                                <thead>
                                <th>Status</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Timestamp</th>
                                <th>Time Taken</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($columns['cdrrs']['data']['cdrr_logs'] as $key => $log) { ?>
                                        <tr>
                                            <td><?php
                                                if ($log['description'] == 'reviewed') {
                                                    echo 'Submitted to KEMSA';
                                                } else {
                                                    echo ucwords($log['description']);
                                                };
                                                ?>  </td>
                                            <td><?= ucwords($log['firstname'] . ' ' . $log['lastname']); ?> </td>
                                            <td><?= ucwords($log['role']); ?> </td>
                                            <td class="start_date"><?= $log['created']; ?><input type="hidden" class="end_date"/></td>
                                            <td>0 Day(s)</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <?php $variance = number_format((($curr_ - $prev) / $curr_) * 100, 1); ?>
                        <table class="table table-responsive table-bordered" >
                            <tr>
                                <td>Current Patient Numbers</td>
                                <td style="text-align: right; font-weight: bold;"><?= number_format($curr_, 0); ?></td>
                            </tr>
                            <tr>
                                <td>Previous Patient Numbers</td>
                                <td style="text-align: right;font-weight: bold;"><?= number_format($prev, 0); ?></td>
                            </tr>
                            <tr>
                                <td>Patient Numbers % Variance</td>
                                <td style="text-align: right;font-weight: bold;"><?= $variance; ?>%</td>
                            </tr>
                        </table>
                    </div>


                </div> <!--end of cdrr-->
                <div class="panel-footer">
                    
                    <?php if ($role == 'subcounty' && date('d') <= 30 && $columns['cdrrs']['data'][0]['status'] == 'pending' ||  $columns['cdrrs']['data'][0]['status'] == 'rejected') { ?>
                        <button type="submit" class="btn btn-info" id="save_allocation">Save Allocation</button>
                        <button type="submit" class="btn btn-success" id="complete_allocation">Complete Allocation</button>
                    <?php } else if ($role == 'subcounty' && date('d') >= 10 && $columns['cdrrs']['data'][0]['status'] == 'pending') { ?>
                        <p><div class="alert alert-warning"><strong>NB: Allocation period has ended. No more allocations allowed beyond the 20<sup>th</sup> of each month. </strong></div></p>

                    <?php } else { ?>
                        <p><div class = "alert alert-warning"><strong>NB: Allocation Complete. </strong></div></p>

                    <?php } ?>

                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-12 -->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Patient Numbers Per Regimen against Drugs</h4>
                </div>
                <div class="modal-body">
                    <table id="REGTABLE" class="table table-bordered  table-striped " style="width:100%;">
                        <thead style="width:100%;">
                            <tr>
                                <th>Regimen</th>
                                <th>Patient NOs</th>
                                <th>Issued Drugs</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_maps as $p): ?>
                                <tr>
                                    <td style="font-weight: bold;"><?= $p['regimen']; ?></td>
                                    <td style="text-align: right; font-weight: bold;"><?= number_format($p['total']); ?></td>
                                    <td style="text-align: right; font-weight: bold;"><?= number_format($p['total_drugs']); ?></td>
                                    <td><?= $p['category']; ?></td>
                                </tr> 
                            <?php endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
if (empty($columns['maps']['data'])) {
    $maps = 'nomaps';
};
?>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(function () {
        base_url = "<?php echo base_url(); ?>";

        maps = "<?= $maps; ?>";
        role = "<?= $this->session->userdata('role'); ?>";
        scope = "<?= $this->session->userdata('scope'); ?>";
        maps = "<?= $seg_5; ?>";
        cdrr_id = "<?= $seg_4; ?>";
        res = '';
        if (maps == 'nomaps') {
            swal({
                title: "MISSING MAPPS",
                text: "MAPPS data not found, please update your mapps",
                icon: "info",
            });
        }


        $('[data-toggle = "tooltip"]').tooltip();
        var table = $('#AllocationTable').DataTable({
            scrollY: "380px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            searching: false,
            info: false,
            order: [[23, "asc"]],
            fixedColumns: true,
            drawCallback: function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;
                api.column(23, {page: 'current'}).data().each(function (group, i) {

                    if (last !== group) {

                        $(rows).eq(i).before(
                                '<tr class="group" style="background:green; color:white;font-weight:bold;"><td colspan="24">' + group.toUpperCase() + '</td></tr>'
                                );
                        last = group;
                    }
                });
                api.column(23).visible(false);
            }

        });
        MAPS = $('#mapsTableReg').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            searching: false,
            info: false,
            drawCallback: function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;

                api.column(4, {page: 'current'}).data().each(function (group, i) {

                    if (last !== group) {

                        $(rows).eq(i).before(
                                '<tr class="group" style="background:green; color:white;font-weight:bold;"><td colspan="4"><span id="groups">' + group.toUpperCase() + '</span></td></tr>'
                                );

                        last = group;
                    }
                });
                api.column(4).visible(false);
            }
        });
        // Add event listener for opening and closing details
        $('#mapsTableReg tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = MAPS.row(tr);
            id = tr.attr('data-reg');
            //alert(id)

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data(), id)).show();
                tr.addClass('shown');
            }
        });
        function format(d, id) {

            $.post("<?php echo base_url() . 'Manager/getRegimenDetails/' ?>", {regimen: id, scope: scope, role: role, cdrr_id: cdrr_id, maps_id: maps}, function (resp) {
                res = '<table cellpadding="5" class="table table-bordered table-hover" cellspacing="0" border="0" style="padding-left:50px;">' +
                        '<tr>' +
                        '<th>Regimen</th>' +
                        '<th>Drug</th>' +
                        '<th title="Total drug Dispansed against patient numbers">Dispensed</th>' +
                        '</tr>';
                $.each(resp, function (i, da) {
                    res += '<tr><td>' + da.regimen + '</td><td>' + da.drug + '</td><td>' + da.total_drugs + '</td></tr>'
                }, 'json');
                res += '</table>';
            }).done(function () {

            });




            return res;

        }

        $('.REGOPEN').click(function () {
            val = $(this).attr('data-reg');
//alert(val);
        });


        var table = $('#REGTABLE').DataTable({
            scrollY: "380px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            searching: false,
            info: false,
            order: [[3, "asc"]],
            fixedColumns: true,
            /* drawCallback: function (settings) {
             var api = this.api();
             var rows = api.rows({page: 'current'}).nodes();
             var last = null;
             
             api.column(3, {page: 'current'}).data().each(function (group, i) {
             
             if (last !== group) {
             
             $(rows).eq(i).before(
             '<tr class="group" style="background:green; color:white;font-weight:bold;"><td colspan="4">' + group.toUpperCase() + '</td></tr>'
             );
             
             last = group;
             }
             });
             api.column(3).visible(false);
             } */

        });




        $('#AllocationTable tr').hover(function () {
            row = $(this).closest('tr');
            drugname = row.find('.stickyColumn').text();
        });

        $('.AMOS').change(function () {
            row = $(this).closest('tr');
            input_val = row.find('.AMOS').val();
            min_mos = parseInt(row.find('.MIN').val());
            max_mos = parseInt(row.find('.MAX').val());
            AMC = parseInt(row.find('.AMC').text());
            eMOSH = row.find('.eMOSH').text();
            aggSOH = row.find('.aggSOH').text();

            if (isNaN(eMOSH) || eMOSH == '') {
                eMOSH = 0;
            }
            if (isNaN(aggSOH) || aggSOH == '') {
                aggSOH = 0;
            }

            cMOS = (parseInt(input_val) / AMC).toFixed(2);
            if (AMC == 0) {
                cMOS = 0;
            }
            row.find('.AllocatedMOS').val(cMOS);
            AllMOS = row.find('.AllocatedMOS').val();
            FacMOS = row.find('.FacilityMOS').val();
            if (AllMOS < min_mos) {
                swal({
                    title: "Low Allocation MOS",
                    text: "The lowest that can be allocated for" + ' is ' + min_mos,
                    icon: "error",
                });
                return false;
            } else if (AllMOS > (max_mos - FacMOS)) {
                swal("Write Reason Here :", {
                    title: "Excess Allocation MOS 1",
                    text: "The highest that can be allocated is " + max_mos + " MOS",
                    content: "input",
                    icon: "error",
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Write the reason for exceeding maximum mos!",
                            type: "text",
                        },
                    },
                    buttons: true,
                })
                        .then((value) => {
                            if (value == null) {
                                $(this).val(((max_mos - FacMOS) * AMC));
                                $(this).trigger('change');
                            } else {
                                if (value == '') {
                                    swal("Warning", 'Please enter a reason', 'error');
                                    return false;
                                } else {
                                    row.find('.comment').val(value);
                                }
                            }
                        });
                return false;
            }
        });

        $('.MOS').change(function () {
            row = $(this).closest('tr');
            input_val = $(this).val();
            min_mos = row.find('.MIN').val();
            max_mos = row.find('.MAX').val();
            AMC = parseInt(row.find('.AMC').text());
            eMOSH = row.find('.eMOSH').text();
            aggSOH = row.find('.aggSOH').text();
            FacMOS = row.find('.FacilityMOS').val();

            if (isNaN(eMOSH) || eMOSH == '') {
                eMOSH = 0;
            }
            if (isNaN(aggSOH) || aggSOH == '') {
                aggSOH = 0;
            }


            cMOS = (parseInt(input_val) * parseInt(AMC));


            cMOS = (parseInt(input_val) * AMC);
            if (AMC == 0) {
                cMOS = 0;
            }

            row.find('.AMOS').val(cMOS);

            if (input_val < min_mos) {
                swal({
                    title: "Low Allocation MOS",
                    text: "The lowest that can be allocated for" + " is " + min_mos + " MOS",
                    icon: "error",
                });
                return false;
            } else if (input_val > (max_mos - FacMOS)) {
                swal("Write Reason Here:", {
                    closeOnClickOutside: false,
                    title: "Excess Allocation MOS",
                    text: "The highest that can be allocated is " + max_mos + " MOS",
                    content: "input",
                    icon: "error",
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Write the reason for exceeding maximum mos!",
                            type: "text",
                        },
                    },
                    //buttons: true,
                })
                        .then((value) => {
                            if (value == null) {
                                $(this).val(max_mos - FacMOS);
                                $(this).trigger('change');
                            } else {
                                if (value == '') {
                                    alert("Warning", 'Please enter a reason', 'error');
                                    return false;
                                } else {
                                    row.find('.comment').val(value);
                                }
                            }
                        });
                return true;
            }
        });

        row = 1;
        $('#TimeLog tr').each(function (i, j) {
            var start_date = $("#TimeLog tr:nth-child(" + row + ") td:nth-child(4)").text();
            $("#TimeLog tr:nth-child(" + i + ") td:nth-child(4)").find('.end_date').val(start_date);
            row++;
        });
        setTimeout(function () {
            datediff = '';
            $('#TimeLog  tr').each(function (i, j) {

                var start_date = $("#TimeLog tr:nth-child(" + i + ") td:nth-child(4)").text();
                var end_date = $("#TimeLog tr:nth-child(" + i + ") td:nth-child(4)").find('.end_date').val();
                var date1 = new Date(start_date);
                var date2 = new Date(end_date);
                var timeDiff = Math.abs(date2 - date1);
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                if (isNaN(diffDays)) {
                    datediff = 'N/A';
                } else {
                    datediff = diffDays + " Day(s)";
                }
                $("#TimeLog tr:nth-child(" + i + ") td:nth-child(5)").html(datediff);
            });
        }, 5000);
        $('#side-menu').remove();
        $('#reviewOrder').click(function (e) {
            $(this).prop('disabled', true);
//Show spinner
            $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
            updateValues();
            $.get(base_url + "Manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/reviewed", function (data) {
                swal('Order Reviewed');
                window.location.href = base_url + "manager/orders/view_allocation/<?= $cdrr_id . '/' . $map_id; ?>";
            });
        });
        $('#approveOrder').click(function (e) {
            $(this).prop('disabled', true);
//Show spinner
            $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
            updateValues();
            $.get(base_url + "Manager/Orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/approved", function (data) {
                swal('Order Approved');
                window.location.href = base_url + "manager/orders/view_allocation/<?= $cdrr_id . '/' . $map_id; ?>";

            });
        });
        $('#rejectOrder').click(function (e) {
            swal("Write something here:", {
                title: "Are you sure?",
                text: "Please enter your reason behind this order rejection",
                icon: "warning",
                buttons: ["Cancel", "Reject Order"],
                dangerMode: true,
                content: "input",
                closeOnClickOutside: false,
                closeOnEsc: false,
                allowOutsideClick: false
            }).then((value) => {
                if (value) {
                    val = $('.swal-content__input').val();
//Show spinner      
                    $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
                    $.post(base_url + "Manager/Orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/rejected", {reason: val}, function (data) {
                        swal('Order Rejected Successfully!');
                        window.location.href = base_url + "manager/orders/view_allocation/<?= $cdrr_id . '/' . $map_id; ?>";
                    });
                }
            });
        });
        $('#complete_allocation').click(function (e) {
            $(this).prop('disabled', true);
//Show spinner
            $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
            $('#save_allocation').prop('disabled', true);
            //updateValues();
            $.get(base_url + "Manager/Orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/allocated", function (data) {
                swal('Allocation order submitted to county');
                window.location.href = base_url + "manager/orders/view_allocation/<?= $cdrr_id . '/' . $map_id; ?>";
            });
        });
        $('#save_allocation').click(function (e) {
            $(this).prop('disabled', true);
//Show spinner
            $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
            var form = $('#orderForm');
            var url = base_url + "Manager/Orders/updateOrder/<?= $cdrr_id . '/' . $map_id; ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (response) {
                    swal('Allocation data saved');
                    $.get(base_url + "Manager/Orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/pending");
                    window.location.href = base_url + "manager/orders/allocate/<?= $cdrr_id . '/' . $map_id; ?>";
                }
            });
        });
        if (role == '') {
            window.location.href = "<?= base_url() ?>manager";
        } else {
            setInterval(function () {
//$(this).prop('disabled', true);
//Show spinner
// $.blockUI({message: '<h1><img src="' + base_url + 'public/spinner.gif" /> Working...</h1>'});
                var form = $('#orderForm');
                var url = base_url + "Manager/Orders/updateOrder/<?= $cdrr_id . '/' . $map_id; ?>";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function (response) {
// swal('Allocation data saved');
//$.get(base_url + "Manager/Orders/actionOrder/<?= $cdrr_id . '/' . $map_id;
?>/pending");
                        // window.location.href = base_url + "manager/orders/allocate/<?= $cdrr_id . '/' . $map_id; ?>";
                    }
                });
            }, 60000);
        }



        //Disable input fields
<?php if (in_array($columns['cdrrs']['data'][0]['status'], array('allocated', 'approved', 'reviewed')) || in_array($columns['cdrrs']['data'][0]['status'], array('pending', 'reviewed', 'rejected')) && in_array($this->session->userdata('role'), array('county', 'nascop'))) { ?>
    <?php if ($this->session->userdata('role') == 'nascop') { ?>
                $('.Allocated').attr('disabled', false);
                $('.AllocatedMOS').attr('disabled', true);
    <?php } else if ($this->session->userdata('role') == 'county') { ?>
                $('.Allocated').attr('disabled', true);
                $('.AllocatedMOS').attr('disabled', false);
    <?php } else { ?>
                // $('input').attr('disabled', true);
    <?php } ?>

<?php } ?>

<?php if ($role == 'subcounty' && date('d') > 13) { ?>
           // $('#save_allocation,#complete_allocation').hide();
<?php } elseif ($role == 'county' && date('d') > 15) { ?>
           // $('#approveOrder,#rejectOrder').hide();
<?php } elseif ($role == 'nascop' && date('d') > 20) { ?>
           // $('#reviewOrder,#rejectOrder').hide();
<?php } ?>

    });
    function updateValues() {
        var form = $('#orderForm');
        var url = base_url + "Manager/Orders/updateOrder/<?= $cdrr_id . '/' . $map_id; ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (response) {
                console.log('Order Updated');
            }
        });
    }

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


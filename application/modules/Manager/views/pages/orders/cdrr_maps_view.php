<div id="container" class="container-fluid">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> View Order</li>
            <?php if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') { ?> 
                <a href="<?php echo base_url('manager/orders/view_satellites/') . '/' . $this->uri->segment('4') . '/' . $this->uri->segment('5'); ?>" class="btn btn-sm btn-warning pull-right" target="_blank"> <i class="glyphicon glyphicon-eye-open"></i> View Satellites</a>
            <?php } ?>
            <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <b>Facility Name: </b>
                                                <span class="facility_name"> <?= ucwords($columns['cdrrs']['data'][0]['facility_name']); ?></span>
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
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="table-responsive-removed">
                                <table class="table table-striped table-bordered table-condensed" id="MapsData">
                                    <thead >
                                        <tr style="">
                                            <th rowspan="2">Drug Name</th>
                                            <th rowspan="2">Pack Size</th>
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
                                            <th>End Month Stock on Hand</th>
                                            <?php if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') { ?> 
                                                <th >Aggregate Consumed</th>
                                                <th >Aggregate Stock on Hand</th>
                                            <?php } ?>
                                            <th colspan="2">Commodities Expiring < 6 Months</th>
                                            <th>Days out of Stock</th>
                                            <th>Resupply Quantity</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>E</th>
                                            <th>F</th>
                                            <th>G</th>
                                            <?php if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') { ?> 
                                                <th>I</th>
                                                <th>J</th>
                                            <?php } ?>
                                            <th>Quantity</th>
                                            <th>Expiry Date</th>
                                            <th>K</th>
                                            <th>L</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form name="orderForm" id="orderForm">
                                        <?php
                                        foreach ($columns['drugs'] as $key => $drug) {
                                            $drugid = $drug['id'];
                                            if (in_array($drugid, array_keys($columns['cdrrs']['data']['cdrr_item']))) {
                                                $count = $columns['pcdrrs']['data']['cdrr_item'][$drugid]['count'];
                                                $balance = $columns['cdrrs']['data']['cdrr_item'][$drugid]['balance'];
                                                empty($count) ? $count = 0 : $count = $count;
                                                empty($balance) ? $balance = 0 : $balance = $balance;
                                                ?>
                                                <tr>
                                                    <td class="drug_name"><?= $drug['name']; ?></td>
                                                    <td><?= $drug['pack_size']; ?></td>
                                                    <td class="count"><?= $count; ?></td>
                                                    <td class="balance"><?= $balance; ?>
                                                        <?php
                                                        if ($count > $balance) {
                                                            //  $p = round((($count - $balance) / $count) * 100, 0);
                                                            $p = round($count - $balance, 0);
                                                            echo '<sup><span style="background: red; font-size:9px;" class="badge"> -' . $p . '</span></sup>';
                                                        } else if ($balance > $count) {
                                                            //$p = round((($balance - $count) / $balance) * 100, 0);
                                                            $p = round($balance - $count, 0);
                                                            echo '<sup><span style="background: red; font-size:9px;" class="badge"> +' . $p . '</span></sup>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['received']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['dispensed_packs']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['losses']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments_neg']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['count']; ?></td>
                                                    <?php if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') { ?> 
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_consumed']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_on_hand']; ?></td>
                                                    <?php } ?>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_quant']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_date']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['out_of_stock']; ?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['resupply']; ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </form>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                               
                                    <div class="table-responsive-removed">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Role</th>
                                            <th>Timestamp</th>
                                            </thead>
                                            <?php foreach ($columns['cdrrs']['data']['cdrr_logs'] as $key => $log) { ?>
                                                <tr>
                                                    <td> 
                                                        <?php
                                                        if ($log['description'] == 'reviewed') {
                                                            echo 'Submitted to KEMSA';
                                                        } else {
                                                            echo ucwords($log['description']);
                                                        };
                                                        ?>
                                                    </td>
                                                    <td><?= ucwords($log['firstname'] . ' ' . $log['lastname']); ?> </td>
                                                    <td><?= ucwords($log['role']); ?> </td>
                                                    <td><?= $log['created']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                

                            </div>
                        </div> <!--end of cdrr-->
                        <div class="col-sm-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed" id="mapsTable" >
                                    <thead>
                                    <th>Code | Regimen</th>
                                    <th title="Current Active Patient">No. of Patients</th>
                                    <th title="Previous Active Patient">(% Change)</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $curr_ = 0;
                                        $prev = 0;
                                        foreach ($columns['regimens'] as $category => $regimens) {
                                            ?>
                                            <?php foreach ($regimens as $regimen) { ?>
                                                <?php if (in_array($regimen['id'], array_keys($columns['maps']['data']))) { ?>
                                                    <tr>
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
                                                            ?>

                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $curr_ = $curr_ + $current;
                                                    $prev = $prev + $previous;
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
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
                        </div><!--end of maps-->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(function () {
        $('#side-menu').remove();

        $('#MapsData,#mapsTable').DataTable({
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            searching: false,
            info: false
        });

        $('#mapsTable').DataTable({
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            searching: false,
            info: false
        });

        $('.balance').click(function () {
            row = $(this).closest('tr');
            drug = row.find('.drug_name').text();
            facility = $('.facility_name').text();
            console.log(drug + facility);

        });

        $('#approveOrder').click(function (e) {
            $.get("/ART/manager/orders/actionOrder/<?= $cdrr_id; ?>/approved", function (data) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#rejectOrder').click(function (e) {
            $.get("/ART/manager/orders/actionOrder/<?= $cdrr_id; ?>/rejected", function (data) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#complete_allocation').click(function (e) {
            $.get("/ART/manager/orders/actionOrder/<?= $cdrr_id; ?>/allocated", function (data) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#save_allocation').click(function (e) {
            var form = $('#orderForm');
            var url = "/ART/manager/orders/updateOrder/<?= $cdrr_id; ?>";

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (response) {
                    alert('Allocation Saved')
                    $.get("/ART/manager/orders/actionOrder/<?= $cdrr_id; ?>/pending");
                }
            });
        });

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
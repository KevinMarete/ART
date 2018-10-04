<style>



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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($role == 'county' && date('d') <= 20 && $columns['cdrrs']['data'][0]['status'] == 'allocated') { ?>
                                <button type="submit" class="btn btn-success" id="approveOrder">Approve Order</button>
                                <button type="submit" class="btn btn-danger" id="rejectOrder">Reject Order</button>
                            <?php } else if ($role == 'national' && date('d') <= 20 && $columns['cdrrs']['data'][0]['status'] == 'approved') { ?>
                                <button type="submit" class="btn btn-success" id="reviewOrder">Review Order</button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
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
                                                <b>Status: </b> <span><?= ucwords($columns['cdrrs']['data'][0]['status']); ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>                            
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="col-sm-9">
                                <form name="orderForm" id="orderForm">
                                    <table class="table table-striped table-bordered table-condensed" id="AllocationTable">
                                        <thead id="THEAD" >
                                            <tr>
                                                <th >Drug Name</th>
                                                <th >Pack Size</th>
                                                <th> Closing Balance </th>
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
                                                <th>AMC</th>
                                                <th>Facility MOS</th>
                                                <th>AutoCalc Resupply</th>
                                                <th>Allocated</th>
                                                <th>Allocated MOS</th>
                                                <th >Comments</th>
                                                <th >Decision</th>
                                            </tr>
                                            <tr>
                                                <th>A</th>
                                                <th></th>
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
                                                <th>K</th>
                                                <th>L</th>
                                                <th>Expiry Date</th>
                                                <th>M</th>
                                                <th>N</th>
                                                <th>O</th>
                                                <th>P</th>
                                                <th>Q</th>
                                                <th>R</th>
                                                <th>S</th>
                                                <th>T</th>
                                                <th>U</th>
                                            </tr>
                                        </thead>
                                        <tbody id="TBODY">

                                            <?php
                                            foreach ($columns['drugs'] as $key => $drug) {
                                                $drugid = $drug['id'];


                                                if (in_array($drugid, array_keys($columns['cdrrs']['data']['cdrr_item']))) {
                                                    $count = $columns['cdrrs']['data']['cdrr_item'][$drugid]['count'];
                                                    $balance = $columns['cdrrs']['data']['cdrr_item'][$drugid]['balance'];
                                                    $drugamc = $columns['cdrrs']['data']['cdrr_item'][$drugid]['drugamc'];
                                                    $consumed = $columns['cdrrs']['data']['cdrr_item'][$drugid]['dispensed_packs'];
                                                    $new = @$columns['pcdrrs']['data']['cdrr_item'][$drugid]['count'];
                                                    ?>
                                                    <tr>
                                                        <td class='stickyColumn'><?= $drug['name']; ?></td>                                                   
                                                        <td><?= $drug['pack_size']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['count'] ?></td>
                                                        <td>
                                                            <?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['balance'] ?>
                                                            <?php
                                                            if ($count > $balance) {
                                                                $p = round((($count - $balance) / $count) * 100, 0);
                                                                echo '<sup><span style="background: red; font-size:9px;" class="badge"> -' . $p . '%</span></sup>';
                                                            } else if ($balance > $count) {
                                                                $p = round((($balance - $count) / $balance) * 100, 0);
                                                                echo '<sup><span style="background: red; font-size:9px;" class="badge"> +' . $p . '%</span></sup>';
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
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['received']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['dispensed_packs']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['losses']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['adjustments_neg']; ?></td>
                                                        <td class="eMOSH"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['count']; ?></td>
                                                        <?php
                                                        if ($columns['cdrrs']['data'][0]['code'] == 'D-CDRR') {
                                                            $count = $columns['cdrrs']['data']['cdrr_item'][$drugid]['count'] + $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_on_hand'];
                                                            ?> 
                                                            <td class=""><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_consumed']; ?></td>
                                                            <td class="aggSOH"><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['aggr_on_hand']; ?></td>
                                                        <?php } ?>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_quant']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['expiry_date']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['out_of_stock']; ?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['resupply']; ?></td>
                                                        <td class="AMC"><?= $drugamc; ?></td>
                                                        <td ><?= $mos = ($count > 0 && $drugamc > 0) ? number_format($count / $drugamc) : 0; ?></td>
                                                        <td><?= (($drugamc * 3) - $count) > 0 ? (($drugamc * 3) - $count) : 0; ?></td>

                                                        <td>
                                                            <input type="text" style="width:80px; text-align: center;" class="form-control AMOS Allocated"  data-toggle="tooltip" title="" <?= $disabled; ?> data-drug="<?= $drugid ?>"  name="qty_allocated-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" value="<?= ($columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated'] > 0) ? $columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated'] : $columns['cdrrs']['data']['cdrr_item'][$drugid]['resupply']; ?>">
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $min_mos = $columns['cdrrs']['data']['cdrr_item'][$drugid]['min_mos'];
                                                            $max_mos = $columns['cdrrs']['data']['cdrr_item'][$drugid]['max_mos'];
                                                            ?>
                                                            <input type="hidden" style="width:70px;" class="MIN" value="<?= $min_mos; ?>"/>
                                                            <input type="hidden" style="width:70px;"class="MAX" value="<?= $max_mos; ?>"/>
                                                            <input type="text"  style="width:50px; text-align: center;" class="form-control MOS AllocatedMOS" data-toggle="tooltip" <?= $disabled; ?> title="Max MOS 6months" name="qty_allocated_mos-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" value="<?= ($columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated_mos'] == '') ? $columns['cdrrs']['data']['cdrr_item'][$drugid]['qty_allocated_mos'] : $mos ?>">
                                                        </td>

                                                        <td>
                                                            <textarea type="text" style="width:100px;" class="form-control" <?= $disabled; ?> name="feedback-<?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['cdrr_item_id']; ?>" ><?= $columns['cdrrs']['data']['cdrr_item'][$drugid]['feedback']; ?></textarea>
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
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tbody>

                                    </table>
                                </form>
                            </div>
                            <div class="col-sm-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead>
                                        <th>Code | Regimen</th>
                                        <th title="Current Active Patient">CAP</th>
                                        <th title="Previous Active Patient">PAP</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($columns['regimens'] as $category => $regimens) { ?>
                                                <?php foreach ($regimens as $regimen) { ?>
                                                    <?php if (in_array($regimen['id'], array_keys($columns['maps']['data']))) { ?>
                                                        <tr>
                                                            <td><?= $regimen['name']; ?></td>
                                                            <td><?php echo $columns['maps']['data'][$regimen['id']]; ?></td>
                                                            <td><?php echo @$columns['previousmaps']['data'][$regimen['id']]; ?></td>

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

                    <div class="col-sm-9" style="margin-top: 20px;" >
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed" id="TimeLog">
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
                                            <td><?= ucwords($log['description']); ?>  </td>
                                            <td><?= ucwords($log['firstname'] . ' ' . $log['lastname']); ?> </td>
                                            <td><?= ucwords($log['role']); ?> </td>
                                            <td class="start_date"><?= $log['created']; ?><input type="hidden" class="end_date"/></td>
                                            <td>0 Day(s)</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($role == 'subcounty' && date('d') <= 20 && !in_array($columns['cdrrs']['data'][0]['status'], array('allocated', 'approved', 'reviewed'))) { ?>
                            <button type="submit" class="btn btn-info" id="save_allocation">Save Allocation</button>
                            <button type="submit" class="btn btn-success" id="complete_allocation">Complete Allocation</button>
                        <?php } else { ?>
                            <p><div class="alert alert-warning"><strong>NB: Allocation period has ended. No more allocations allowed beyond the 20<sup>th</sup> of each month. </strong></div></p>
                        <?php } ?>
                    </div> <!--end of cdrr-->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(function () {
        var base_url = "<?php echo base_url(); ?>";


        var table = $('#AllocationTable').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            searching: false,
            info: false
        });


        $('#AllocationTable tr').hover(function () {
            row = $(this).closest('tr');
            drugname = row.find('.stickyColumn').text();
            //console.log(drugname)
        });



        $('.AMOS').focusout(function () {
            row = $(this).closest('tr');
            input_val = $(this).val();
            min_mos = row.find('.MIN').val();
            max_mos = row.find('.MAX').val();
            eMOSH = row.find('.eMOSH').text();
            aggSOH = row.find('.aggSOH').text();
            AMC = row.find('.AMC').text();
            cMOS = (parseInt(eMOSH) + parseInt(aggSOH) + parseInt(input_val)) / parseInt(AMC);
            row.find('.AllocatedMOS').val(Math.floor(cMOS));
            AllMOS = row.find('.AllocatedMOS').val();
            console.log(AllMOS);
            if (AllMOS < 3) {
                swal({
                    title: "Low Allocation MOS",
                    text: "The lowest that can be allocated for" + ' is ' + 3,
                    icon: "error",
                });
                $(this).val('');

                return false;
            } else if (AllMOS > 6) {
                swal({
                    title: "Excess Allocation MOS",
                    text: "The highest that can be allocated is " + 6,
                    icon: "error",
                });

                $(this).val('');
                return false;
            } else {

            }

        });
        
        
           $('.MOS').focusout(function () {
            row = $(this).closest('tr');
            input_val = $(this).val();
            min_mos = row.find('.MIN').val();
            max_mos = row.find('.MAX').val();
            eMOSH = row.find('.eMOSH').text();
            aggSOH = row.find('.aggSOH').text();
            AMC = row.find('.AMC').text();
            cMOS = (parseInt(input_val) * parseInt(AMC))-(parseInt(eMOSH) + parseInt(aggSOH)) ;
            row.find('.AMOS').val(Math.floor(cMOS));
            row.find('.AMOS').val();
           
            if (input_val < 3) {
                swal({
                    title: "Low Allocation MOS",
                    text: "The lowest that can be allocated for" + ' is ' + 3,
                    icon: "error",
                });
                $(this).val('');

                return false;
            } else if (input_val > 6) {
                swal({
                    title: "Excess Allocation MOS",
                    text: "The highest that can be allocated is " + 6,
                    icon: "error",
                });

                $(this).val('');
                return false;
            } else {

            }

         });


        //$('[data-toggle="tooltip"]').tooltip();
        row = 1;
        $('#TimeLog  tr').each(function (i, j) {

            var start_date = $("#TimeLog tr:nth-child(" + row + ") td:nth-child(4)").text();
            $("#TimeLog tr:nth-child(" + i + ") td:nth-child(4)").find('.end_date').val(start_date);
            row++;
            //console.log(diffDays);
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
            $.get(base_url + "Manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/reviewed", function (data) {
                alert(data);
                window.location.href = "";
            });
        });
        $('#approveOrder').click(function (e) {
            $(this).prop('disabled', true);
            $.get(base_url + "Manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/approved", function (data) {
                alert(data);
                window.location.href = "";
            });
        });
        $('#rejectOrder').click(function (e) {
            $(this).prop('disabled', true);
            $.get(base_url + "Manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/rejected", function (data) {
                alert(data);
                window.location.href = "";
            });
        });
        $('#complete_allocation').click(function (e) {
            $(this).prop('disabled', true);
            $.get(base_url + "manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/allocated", function (data) {
                alert(data);
                window.location.href = "";
            });
        });
        $('#save_allocation').click(function (e) {
            $(this).prop('disabled', true);
            var form = $('#orderForm');
            var url = base_url + "Manager/orders/updateOrder/<?= $cdrr_id . '/' . $map_id; ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (response) {
                    alert('Allocation Saved')
                    $.get(base_url + "Manager/orders/actionOrder/<?= $cdrr_id . '/' . $map_id; ?>/pending");
                    window.location.href = "";
                }
            });
        });
        //Disable input fields
<?php if (in_array($columns['cdrrs']['data'][0]['status'], array('allocated', 'approved', 'reviewed')) || in_array($columns['cdrrs']['data'][0]['status'], array('pending', 'reviewed', 'rejected')) && in_array($this->session->userdata('role'), array('county', 'national'))) { ?>
            $('input').attr('disabled', true);
<?php } ?>
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


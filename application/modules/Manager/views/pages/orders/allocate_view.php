 <div id="container" class="container-fluid">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('manager/orders/allocation'); ?>">Allocation</a></li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i>View Allocation </li>
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
                            <?php if ($role=='county' && $columns['cdrrs']['data'][0]['status'] == 'allocated'){?>
                                <button type="submit" class="btn btn-success" id="approveOrder">Approve Order</button>
                                <button type="submit" class="btn btn-danger" id="rejectOrder">Reject Order</button>
                            <?php }else if($role=='national' && $columns['cdrrs']['data'][0]['status'] == 'approved'){?>
                                <button type="submit" class="btn btn-success" id="reviewOrder">Review Order</button>
                            <?php }?>
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
                                                <span><?= ucwords(date( 'F Y', strtotime($columns['cdrrs']['data'][0]['period_begin']))); ?></span>
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
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Drug Name</th>
                                        <th rowspan="2">Pack Size</th>
                                        <th>Beginning Balance</th>
                                        <th>Quantity Received</th>
                                        <th>Quantity Issued</th>
                                        <th>Losses & Wastage</th>
                                        <th>Positive Adjustments</th>
                                        <th>Negative Adjustments</th>
                                        <th>End Month Stock on Hand</th>
                                        <?php if($columns['cdrrs']['data'][0]['code'] == 'D-CDRR'){ ?> 
                                            <th >Aggregate Consumed</th>
                                            <th >Aggregate Stock on Hand</th>
                                        <?php }?>
                                        <th colspan="2">Commodities Expiring < 6 Months</th>
                                        <th>Days out of Stock</th>
                                        <th>Resupply Quantity</th>
                                        <th>AMC</th>
                                        <th>MOS</th>
                                        <th>AutoCalc</th>
                                        <th>Allocated</th>
                                        <th rowspan="2">Comments</th>
                                        <th rowspan="2">Decision</th>
                                    </tr>
                                    <tr>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C</th>
                                        <th>D</th>
                                        <th>E</th>
                                        <th>F</th>
                                        <th>G</th>
                                        <?php if($columns['cdrrs']['data'][0]['code'] == 'D-CDRR'){ ?> 
                                            <th>I</th>
                                            <th>J</th>
                                        <?php }?>
                                        <th>Quantity</th>
                                        <th>Expiry Date</th>
                                        <th>K</th>
                                        <th>L</th>
                                        <th>M</th>
                                        <th>N</th>
                                        <th>O</th>
                                        <th>P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form name="orderForm" id="orderForm">
                                        <?php foreach ($columns['drugs'] as $key => $drug) {  
                                                $drugname = $drug['name']; 
                                                if (in_array($drugname, array_keys($columns['cdrrs']['data']['cdrr_item']))){
                                                    $count  = $columns['cdrrs']['data']['cdrr_item'][$drugname]['count'];
                                                    $drugamc  = $columns['cdrrs']['data']['cdrr_item'][$drugname]['drugamc']; 
                                                    $consumed  = $columns['cdrrs']['data']['cdrr_item'][$drugname]['dispensed_packs'];
                                                    ?>
                                                <tr>
                                                    <td><?= $drug['name'];?></td>
                                                    <td><?= $drug['pack_size'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['balance'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['received'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['dispensed_packs'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['losses'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['adjustments'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['adjustments_neg'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['count'];?></td>
                                                    <?php if($columns['cdrrs']['data'][0]['code'] == 'D-CDRR'){ ?> 
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['aggr_consumed'];?></td>
                                                        <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['aggr_on_hand'];?></td>
                                                    <?php }  ?>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['expiry_quant'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['expiry_date'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['out_of_stock'];?></td>
                                                    <td><?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['resupply'];?></td>
                                                    <td><?= $drugamc;?></td>
                                                    <td id="mos"><?= $mos = ($count > 0 && $drugamc > 0) ? number_format($count/$drugamc) : 0;?></td>
                                                    <td id="auto"><?= (($consumed * 3) - $count);?></td>
                                                    <td>
                                                        <input type="text" class="form-control" name="qty_allocated-<?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['cdrr_item_id'];?>" value="<?= ($columns['cdrrs']['data']['cdrr_item'][$drugname]['qty_allocated'] > 0) ? $columns['cdrrs']['data']['cdrr_item'][$drugname]['qty_allocated'] : $columns['cdrrs']['data']['cdrr_item'][$drugname]['resupply'];?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="feedback-<?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['cdrr_item_id'];?>" value="<?= $columns['cdrrs']['data']['cdrr_item'][$drugname]['feedback'];?>">
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if ($mos < 3){
                                                                echo '<span class="label label-danger">RESUPPLY</span>';
                                                            }else if($mos > 3 && $mos < 6){
                                                                echo '<span class="label label-warning">MONITOR</span>';
                                                            }else{
                                                                echo '<span class="label label-success">REDISTRIBUTE</span>';
                                                            } 
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php 
                                            }
                                        }?>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Timestamp</th>
                                    </thead>
                                    <?php  foreach ($columns['cdrrs']['data']['cdrr_logs'] as $key => $log) {?>
                                    <tr>
                                        <td><?= ucwords($log['description']);?>  </td>
                                        <td><?= ucwords($log['firstname'].' '.$log['lastname']);?> </td>
                                        <td><?= ucwords($log['role']);?> </td>
                                        <td><?= $log['created'];?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <?php if ($role=='subcounty' && !in_array($columns['cdrrs']['data'][0]['status'], array('allocated', 'approved', 'reviewed'))){?>
                                <button type="submit" class="btn btn-info" id="save_allocation">Save Allocation</button>
                                <button type="submit" class="btn btn-success" id="complete_allocation">Complete Allocation</button>
                            <?php }?>
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
    $(function(){
        var base_url = "<?php echo base_url(); ?>";
        $('#side-menu').remove();

        $('#reviewOrder').click(function(e){
            $(this).prop('disabled', true);
            $.get( base_url+"manager/orders/actionOrder/<?= $cdrr_id.'/'.$map_id; ?>/reviewed", function( data ) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#approveOrder').click(function(e){
            $(this).prop('disabled', true);
            $.get( base_url+"manager/orders/actionOrder/<?= $cdrr_id.'/'.$map_id; ?>/approved", function( data ) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#rejectOrder').click(function(e){
            $(this).prop('disabled', true);
            $.get( base_url+"manager/orders/actionOrder/<?= $cdrr_id.'/'.$map_id; ?>/rejected", function( data ) {
                alert(data);
                window.location.href = "";
            });
        });

        $('#complete_allocation').click(function(e){
            $(this).prop('disabled', true);
            $.get( base_url+"manager/orders/actionOrder/<?= $cdrr_id.'/'.$map_id; ?>/allocated", function( data ) {
              alert(data);
              window.location.href = "";
            });
        });

        $('#save_allocation').click(function(e){
            $(this).prop('disabled', true);
            var form = $('#orderForm');
            var url = base_url+"manager/orders/updateOrder/<?= $cdrr_id.'/'.$map_id; ?>";

            $.ajax( {
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function( response ) {
                    alert('Allocation Saved')
                    $.get( base_url+"manager/orders/actionOrder/<?= $cdrr_id.'/'.$map_id; ?>/pending");
                    window.location.href = "";
                }
            });
        });

        //Disable input fields
        <?php if (in_array($columns['cdrrs']['data'][0]['status'], array('allocated', 'approved', 'reviewed')) || in_array($columns['cdrrs']['data'][0]['status'], array('pending', 'reviewed', 'rejected')) && in_array($this->session->userdata('role'), array('county', 'national'))) {?>
            $('input').attr('disabled',true);
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
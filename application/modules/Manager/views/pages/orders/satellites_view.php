<div id="container" class="container-fluid">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
            <li><a href="<?php echo base_url('manager/orders/view/') . '/' . $this->uri->segment('4') . '/' . $this->uri->segment('5'); ?>">View Order</a></li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> View Satellites</li>
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
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#cdrr" aria-controls="cdrr" role="tab" data-toggle="tab">CDRRs</a></li>
                        <li><a href="#maps" aria-controls="maps" role="tab" data-toggle="tab">MAPs</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="cdrr">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed" id="MapsData">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">Drug Name</th>
                                                    <th rowspan="2">Pack Size</th>
                                                    <?php
                                                    foreach ($columns['cdrrs']['data'] as $facility => $items) {
                                                        echo '<th colspan="2">' . ucwords($facility) . '</th>';
                                                    }
                                                    echo '<th colspan="2"> Aggregate Totals</th>';
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    foreach ($columns['cdrrs']['data'] as $facility => $items) {
                                                        echo '<th> Quantity Consumed </th>';
                                                        echo '<th> Stock on Hand</th>';
                                                    }
                                                    echo '<th> Aggregate Consumed</th>';
                                                    echo '<th> Aggregate Stock on Hand</th>';
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($columns['drugs'] as $key => $drug) {
                                                    $aggr_consumed = 0;
                                                    $aggr_on_hand = 0;
                                                    $aggr_total = 0;
                                                    $row = '<tr><td>' . $drug['name'] . '</td>';
                                                    $row .= '<td>' . $drug['pack_size'] . '</td>';
                                                    foreach ($columns['cdrrs']['data'] as $facility => $items) {
                                                        if (in_array($drug['id'], array_keys($columns['cdrrs']['data'][$facility]))) {
                                                            $aggr_consumed += $columns['cdrrs']['data'][$facility][$drug['id']]['consumed'];
                                                            $aggr_on_hand += $columns['cdrrs']['data'][$facility][$drug['id']]['stock_on_hand'];
                                                            $aggr_total += ($aggr_consumed + $aggr_on_hand);
                                                            $row .= '<td>' . $columns['cdrrs']['data'][$facility][$drug['id']]['consumed'] . '</td>';
                                                            $row .= '<td>' . $columns['cdrrs']['data'][$facility][$drug['id']]['stock_on_hand'] . '</td>';
                                                        } else {
                                                            $row .= '<td> 0 </td>';
                                                            $row .= '<td> 0 </td>';
                                                        }
                                                    }
                                                    $row .= '<td>' . $aggr_consumed . '</td>';
                                                    $row .= '<td>' . $aggr_on_hand . '</td>';
                                                    $row .= '</tr>';
                                                    if ($aggr_total > 0) {
                                                        echo $row;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="maps">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Regimen</th>
                                                    <?php
                                                    foreach ($columns['maps']['data'] as $facility => $items) {
                                                        echo '<th>' . ucwords($facility) . '</th>';
                                                    }
                                                    echo '<th> Total Patients</th>';
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($columns['regimens'] as $category => $regimens) {
                                                    foreach ($regimens as $regimen) {
                                                        $patient_total = 0;
                                                        $row = '<tr><td>' . $regimen['name'] . '</td>';
                                                        foreach ($columns['maps']['data'] as $facility => $items) {
                                                            if (in_array($regimen['id'], array_keys($columns['maps']['data'][$facility]))) {
                                                                $patient_total += $columns['maps']['data'][$facility][$regimen['id']]['patients'];
                                                                $row .= '<td>' . $columns['maps']['data'][$facility][$regimen['id']]['patients'] . '</td>';
                                                            } else {
                                                                $row .= '<td> 0 </td>';
                                                            }
                                                        }
                                                        $row .= '<td>' . $patient_total . '</td>';
                                                        $row .= '</tr>';
                                                        if ($patient_total > 0) {
                                                            echo $row;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.tab-content -->
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
        $('#side-menu').remove();
         $('#MapsData').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            searching: false,
            info: false
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
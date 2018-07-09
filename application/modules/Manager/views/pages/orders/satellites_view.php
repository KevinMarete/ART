<div id="container" class="container-fluid">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
            <li><a href="<?php echo base_url('manager/orders/view/').'/'.$this->uri->segment('4').'/'.$this->uri->segment('5');?>">View Order</a></li>
            <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> View Satellites</li>
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
                                <div class="col-lg-12">
                                    My CDRR
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="maps">
                            <div class="row">
                                <div class="col-lg-12">
                                    My MAPs
                                </div>
                            </div>
                        </div>
                    </div>
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
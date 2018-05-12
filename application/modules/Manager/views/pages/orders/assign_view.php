<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Assign Scope</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Scope
                    <?php echo $this->session->flashdata('orders_msg'); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <form role="form" action="<?php echo base_url().'manager/assign_scope';?>" method="POST">
                                <div class="form-group">
                                    <label><?php echo ucwords($this->session->userdata('role')); ?></label>
                                    <select class="form-control" name="scope" required>
                                        <option value=''>Select Scope</option>
                                        <?php foreach ($scopes as $scope) {
                                            if ($scope['id'] == $this->session->userdata('scope')){
                                                echo "<option value='".$scope["id"]."' selected>".$scope["name"]."</option>";
                                            }else{
                                                echo "<option value='".$scope["id"]."'>".$scope["name"]."</option>";
                                            }
                                        }?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Update Scope</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
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
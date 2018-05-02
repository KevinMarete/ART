 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo ucwords($page_name); ?> Listing</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--Add button conttrols-->
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default"> <i class="fa fa-plus-square"></i> Add</button>
                        <button type="button" class="btn btn-default"> <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-default"> <i class="fa fa-trash"></i> Remove</button>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
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

<script>
    $(document).ready(function() {
        $('#dataTables-listing').DataTable({
            responsive: true,
            ajax: "<?php echo base_url().'Manager/Admin/get_data/tbl_'.$page_name.'/';?>"
        });
    });
</script>
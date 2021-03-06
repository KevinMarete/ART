<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?= ucwords(str_replace("_", " ",$page_name));?></li>
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
                    <table width="100%" class="table table-striped table-bordered table-hover table-condensed display compact nowrap" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php
                                foreach ($columns as $column) {
                                    echo"<th>" . ucwords($column) . "</th>";
                                }
                                ?>
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
    $(document).ready(function () {
        var role = "<?php echo $this->session->userdata('role'); ?>"
        var filters = {
            'national' : [0, 1, 2],
            'county': [0, 1],
            'subcounty': [0, 1]
        }
        $('#dataTables-listing').DataTable({
            responsive: true,
            order: [[1, "desc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Orders/get_orders'; ?>",
            "columnDefs": [
                {"width": "5%", "targets": 0}
            ],
            initComplete: function () {
                this.api().columns(filters[role]).every(function () {
                    var column = this;
                    var select = $('<br/><select><option value="">Show all</option></select>')
                            .appendTo($(column.header()))
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );
                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        var val = $('<div/>').html(d).text();
                        select.append('<option value="' + val + '">' + val + '</option>');
                    });
                });
            }
        });

        //Show reports sidemenu
        $(".reports ").closest('ul').addClass("in");
        $(".reports ").addClass("active active-page");
    });
</script>
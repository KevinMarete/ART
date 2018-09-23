<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?php echo base_url('manager/orders/edit_allocation') . '/' . date('Y-m-d', strtotime('first day of last month')); ?>">Allocation</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> County Orders</li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>

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
                    <table width="100%" class="table table-striped table-bordered table-hover table-condensed" id="dataTables-listing">
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
        $('#dataTables-listing').DataTable({
            responsive: true,
            order: [[4, "desc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Orders/get_county_reporting_rates' . $retVal = ($seg_4 == "county") ? "/county/" . $seg_5 . "/allocation" : ""; ?>",
            initComplete: function () {
                this.api().columns([0, 1, 2]).every(function () {
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
                //Show reporting rate
                var reporting_rate = Math.ceil(($("#dataTables-listing td:nth-child(5):contains('REVIEWED')").length / this.api().data().rows().count()) * 100)
                $('.panel-heading').html('Reporting Rate: <b>' + reporting_rate + '%</b><div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="' + reporting_rate + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + reporting_rate + '%;">' + reporting_rate + '%</div></div>')
            }
        });

        //Show Allocation sidemenu
        $(".allocation").closest('ul').addClass("in");
        $(".allocation").addClass("active active-page");
    });
</script>
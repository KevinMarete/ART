<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Orders</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?= ucwords(str_replace("_", " ", $page_name)); ?></li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row"> <!--row-->
        <div class="col-lg-12">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
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
            order: [[1, "asc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Orders/get_reporting_rates'; ?>",
            initComplete: function () {
                this.api().columns([1, 2]).every(function () {
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
                var filteredData = this.api().column(3).data().filter(function (value, index) {
                    return value == 'Report' ? true : false;
                });
//                alert(filteredData.length)

            }
        });
//         var pending = $("#dataTables-listing td:nth-child(3):contains('Pending')").length;
////                alert("Unknown rows :" + pending);
//                var submitted = $("#dataTables-listing td:nth-child(3):contains('Submitted')").length;
////                alert("Unknown rows :" + submitted);
//                var percentage;
//                percentage=(submitted/pending)*100;
////                console.log(percentage);
    });
    $(document).ready(function () {
        var table = $('#dataTables-listing').DataTable();
        var dataCount = table.rows(':contains("Unknown")').data().length;
        console.log(dataCount);

        $('#output').text('Number of rows that contain Unknown: ' + dataCount)
        console.log(dataCount);
    })
</script>
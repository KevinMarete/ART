<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?= ucwords(str_replace("_", " ", $page_name)); ?></li>
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
        var role = "<?php echo $this->session->userdata('role'); ?>"
        if(role == 'county' || role == 'national'){
            $('#dataTables-listing').DataTable({
                responsive: true,
                order: [[2, "desc"]],
                pagingType: "full_numbers",
                ajax: "<?php echo base_url() . 'Manager/Orders/get_reporting_rates'; ?>",
                initComplete: function () {
                    this.api().columns([0]).every(function () {
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
                    //Show total reporting rate
                    var reporting_rate =  Math.ceil(this.api().columns([2]).data().average())
                    reporting_rate = reporting_rate || 0
                    $('.panel-heading').html('Reporting Rate: <b>'+reporting_rate+'%</b><div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+reporting_rate+'" aria-valuemin="0" aria-valuemax="100" style="width: '+reporting_rate+'%;">'+reporting_rate+'%</div></div>')

                    //Show row reporting rate
                    this.api().rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                        var data = this.data();
                        data[2] = '<div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+data[2]+'" aria-valuemin="0" aria-valuemax="100" style="width: '+data[2]+'%;">'+data[2]+'%</div></div>'
                        this.data(data)
                    });

                }
            });
        }else{
            $('#dataTables-listing').DataTable({
                responsive: true,
                order: [[1, "asc"]],
                pagingType: "full_numbers",
                ajax: "<?php echo base_url() . 'Manager/Orders/get_reporting_rates';?>",
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
                    var reporting_rate =  Math.ceil(($("#dataTables-listing td:nth-child(3):not(:contains('PENDING'))").length / this.api().data().rows().count())*100)
                    reporting_rate = reporting_rate || 0
                    $('.panel-heading').html('Reporting Rate: <b>'+reporting_rate+'%</b><div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+reporting_rate+'" aria-valuemin="0" aria-valuemax="100" style="width: '+reporting_rate+'%;">'+reporting_rate+'%</div></div>')
                }
            });
        }

        //Show reporting_rates sidemenu
        $(".reporting_rates ").closest('ul').addClass("in");
        $(".reporting_rates ").addClass("active active-page");
    });
</script>
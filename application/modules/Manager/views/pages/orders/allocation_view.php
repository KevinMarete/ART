<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?php echo base_url('manager/orders/reports'); ?>">Orders</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>

            </ol>
        </div>
    </div><!--end row-->
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"><!--panel default-->
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <?php if ($this->session->userdata('role') == 'nascop') { ?>
                        <a href="#uploadTemplateGuide" style="margin: 10px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">Upload KEMSA MOS Template Guide</a>

                    <?php } else { ?>

                    <?php } ?>

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php
                                foreach ($columns as $column) {
                                    echo "<th>" . ucwords($column) . "</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>

                    <span style="color:blue; font-weight: bold;">
                        **Description "Report Incomplete" - Either D-CDRR, D-MAPS, F-CDRR, F-MAPS has not been reported <br>
                        All the **4 reports **must first be dully entered in DHIS2 so as to enable Allocation.
                    </span>
                </div>
            </div><!--end panel default-->
        </div>
    </div><!--end row-->
</div><!--end page wrapper--->
<script>
    $(document).ready(function () {
        var role = "<?php echo $this->session->userdata('role'); ?>"
        if (role == 'nascop' || role == 'county') {
            $('#dataTables-listing').DataTable({
                responsive: true,
                order: [[0, "a=desc"]],
                pagingType: "full_numbers",
                ajax: "<?php echo base_url() . 'Manager/Orders/get_allocation'; ?>",
                initComplete: function () {
                    this.api().columns([0, 2]).every(function () {
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
        } else {
            dtable = $('#dataTables-listing').DataTable({
                responsive: true,
                order: [[1, "asc"]],
                pagingType: "full_numbers",
                ajax: "<?php echo base_url() . 'Manager/Orders/get_allocation'; ?>",
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
                    var thecount = dtable.rows().column(4).data()
                            .filter(function (value, index) {
                                return value !== 'PENDING';
                            }).length;
                    var reporting_rate = Math.ceil((thecount / dtable.rows().count()) * 100);
                    // var reporting_rate = Math.ceil(($("#dataTables-listing td:nth-child(5):contains('allocated'),#dataTables-listing td:nth-child(5):not(:contains('PENDING'))").length / this.api().data().rows().count()) * 100)
                    $('.panel-heading').html('Allocation Rate: <b>' + reporting_rate + '%</b><div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="' + reporting_rate + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + reporting_rate + '%;">' + reporting_rate + '%</div></div>')
                }
            });
        }

        //Show Allocation sidemenu
        $(".allocation").closest('ul').addClass("in");
        $(".allocation").addClass("active active-page");
    });
</script>
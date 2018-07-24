<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Procurement</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <?php echo $this->session->flashdata('tracker_msg'); ?>
            </ol>
        </div>
    </div><!--end row-->
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"><!--panel default-->
                <div class="panel-heading">
                    <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#add_procurement_modal"> 
                        <i class='fa fa-plus'></i> Add Procurement
                    </button>
                </div>
                <div class="panel-body">
                    
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <th>Commodity</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div><!--end panel default-->
        </div>
    </div><!--end row-->
</div><!--end page wrapper--->
<!--modal(s)-->
<div class="modal fade" id="add_procurement_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url().'create_app';?>" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New Procurement</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="open_kemsa" class="col-sm-4 col-form-label">Open-Kemsa</label>
                        <div class="col-sm-6">
                            <input type="number" readonly class="form-control" id="open_kemsa" name="open_kemsa" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="receipts_usaid" class="col-sm-4 col-form-label">Receipts-USAID</label>
                        <div class="col-sm-6">
                            <input type="number" readonly class="form-control" id="receipts_usaid" name="receipts_usaid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="receipts_gf" class="col-sm-4 col-form-label">Receipts-GF</label>
                        <div class="col-sm-6">
                            <input type="number" readonly class="form-control" id="receipts_gf" name="receipts_gf">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="close_kemsa" class="col-sm-4 col-form-label">Close-Kemsa</label>
                        <div class="col-sm-6">
                            <input type="number" readonly class="form-control" id="close_kemsa" name="close_kemsa" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
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

        //Show tracker sidemenu
        $(".tracker").closest('ul').addClass("in");
        $(".tracker").addClass("active active-page");
    });
</script>
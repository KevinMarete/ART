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
                </div>
                <div class="panel-body">
                    
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <th>Commodity</th>
                                <th>Action</th>
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
<div class="modal fade" id="add_procurement_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!--/modal-header-->
            <div class="modal-body">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a data-toggle="tab" href="#drug_procurement">Procurement</a></li>
                    <li><a data-toggle="tab" href="#drug_transactions">Transactions</a></li>
                    <li><a data-toggle="tab" href="#drug_logs">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <div id="drug_procurement" class="tab-pane fade in active">
                        <h3>Procurement Order</h3>
                        <p>
                            <form action="<?php echo base_url().'create_app';?>" method="POST" class="form-horizontal" role="form">
                                <div class="form-group row">
                                    <label for="open_kemsa" class="col-sm-3 col-form-label">Commodity Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control" id="commodity_name" name="commodity_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Stock on Hand (SOH)</label>
                                    <div class="col-sm-3">
                                        <input type="number" readonly class="form-control" id="commodity_soh">
                                    </div>
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Months of Stock (MOS)</label>
                                    <div class="col-sm-3">
                                        <input type="number" readonly class="form-control" id="commodity_mos">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Expected Order Quantity</label>
                                    <div class="col-sm-3">
                                        <input type="number" readonly class="form-control" id="expected_qty">
                                    </div>
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Actual Order Quantity</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="actual_qty" name="receipt_total_qty" required="">
                                    </div>
                                </div>
                                <div class="form-group row" id="commodity_frm">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped table-hover table-condensed">
                                            <thead>
                                                <th>Quantity</th>
                                                <th>Month/Year</th>
                                                <th>Category</th>
                                                <th>Funding Agent</th>
                                                <th>Supplier</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" name="receipt_qty[]" required="">
                                                    </td>
                                                    <td>
                                                        <input type="date" name="transaction_date[]" required="">
                                                    </td>
                                                    <td>
                                                        <select name="category[]" required="">
                                                            <option value="contracted" selected="selected">Contracted</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="funding_agent[]" required="">
                                                            <option value="usaid" selected="selected">USAID</option> 
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="supplier[]" required="">
                                                            <option value="aurobindo" selected="selected">Aurobindo PTY</option> 
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="#"> <i class="fa fa-plus"></i></a>
                                                        <a href="#"> <i class="fa fa-minus"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Justification/Comments</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments" required="" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Create Order</button>
                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                    <div id="drug_transactions" class="tab-pane fade">
                        <h3>Transactions</h3>
                        <p>Some Transactions</p>
                    </div>
                    <div id="drug_logs" class="tab-pane fade">
                        <h3>Logs</h3>
                        <p>Some Logs</p>
                    </div>
                </div>
            </div><!--/modal-body-->
            <div class="modal-footer">
            </div><!--/modal-footer-->
        </div><!--/modal-content-->
    </div><!--/modal-dialog-->
</div><!--/modal-->

<script>
    $(document).ready(function () {
        $('#dataTables-listing').DataTable({
            responsive: true,
            order: [[0, "asc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Procurement/get_commodities'; ?>"
        });

        //Show tracker sidemenu
        $(".tracker").closest('ul').addClass("in");
        $(".tracker").addClass("active active-page");
    });
</script>
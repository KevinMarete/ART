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
                    
                    <table width="100%" class="table table-striped table-bordered table-hover" id="procurement-listing">
                        <thead>
                            <tr>
                                <th>Commodity</th>
                                <th>Packsize</th>
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
                    <li><a data-toggle="tab" href="#drug_orders">Orders</a></li>
                    <li><a data-toggle="tab" href="#drug_logs">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <div id="drug_procurement" class="tab-pane fade in active">
                        <h3>Procurement Order</h3>
                        <p>
                            <form action="<?php echo base_url().'manager/save_procurement';?>" method="POST" class="form-horizontal" role="form">
                                <div class="form-group row">
                                    <label for="open_kemsa" class="col-sm-3 col-form-label">Commodity Name</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" readonly class="form-control" id="drug_id" name="drug_id">
                                        <input type="text" readonly class="form-control" id="commodity_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Stock on Hand (SOH)</label>
                                    <div class="col-sm-3">
                                        <input type="text" readonly class="form-control" id="commodity_soh">
                                    </div>
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Months of Stock (MOS)</label>
                                    <div class="col-sm-3">
                                        <input type="number" readonly class="form-control" id="commodity_mos">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">System Calculated Order Quantity</label>
                                    <div class="col-sm-3">
                                        <input type="text" readonly class="form-control" id="expected_qty">
                                    </div>
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Actual Order Quantity</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="actual_qty" name="receipt_total_qty" required="">
                                    </div>
                                </div>
                                <div class="form-group row" id="commodity_frm">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover table-condensed" id="procurement_tbl">
                                                <thead>
                                                    <th>Quantity</th>
                                                    <th>Transaction Date</th>
                                                    <th>Status</th>
                                                    <th>Funding Agent</th>
                                                    <th>Supplier</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="number" name="receipt_qty[]" required="" class="receipt_qty col-md-12">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="transaction_date[]" required="" class="transaction_date col-md-12">
                                                        </td>
                                                        <td>
                                                            <select name="status[]" required="" class="procurement_status"></select>
                                                        </td>
                                                        <td>
                                                            <select name="funding_agent[]" required="" class="funding_agent"></select>
                                                        </td>
                                                        <td>
                                                            <select name="supplier[]" required="" class="supplier col-md-12"></select>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="add"> <i class="fa fa-plus"></i></a>
                                                            <a href="#" class="remove"> <i class="fa fa-minus"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipts_usaid" class="col-sm-3 col-form-label">Justification/Comments</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments" required="" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Order</button>
                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                    <div id="drug_transactions" class="tab-pane fade">
                        <h3>Transactions</h3>
                        <p>
                            <div class="form-control" id="year-filter">
                                <input type="hidden" name="filter_year" id="filter_year" value="" />
                                Year: 
                                <a href="#" class="filter-year" data-value="2015"> 2015 </a>|
                                <a href="#" class="filter-year" data-value="2016"> 2016 </a>|
                                <a href="#" class="filter-year" data-value="2017"> 2017 </a>|
                                <a href="#" class="filter-year" data-value="2018"> 2018 </a>|
                                <a href="#" class="filter-year" data-value="2019"> 2019 </a>|
                                <a href="#" class="filter-year" data-value="2020"> 2020 </a>|
                                <a href="#" class="filter-year" data-value="2021"> 2021 </a>
                            </div>
                        </p>
                        <div id="transaction_tbl"></div>
                    </div>
                    <div id="drug_orders" class="tab-pane fade">
                        <h3>Orders</h3>
                        <div id="orders_tbl"></div>
                    </div>
                    <div id="drug_logs" class="tab-pane fade">
                        <h3>Logs</h3>
                        <div id="logs_tbl"></div>
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
        $('#procurement-listing').DataTable({
            responsive: true,
            order: [[0, "asc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Procurement/get_commodities'; ?>"
        });

        //Show tracker sidemenu
        $(".commodity").closest('ul').addClass("in");
        $(".commodity").addClass("active active-page");

        //Load Commodity Data when Modal shown
        $("#add_procurement_modal").on("show.bs.modal", function(e) {
            var drugID = $(e.relatedTarget).data('drug_id');
            //Load TrackerInfo
            var trackerURL = "<?php echo base_url() . 'Manager/Procurement/get_tracker/'; ?>"+drugID
            $.getJSON(trackerURL, function(json){
                $.each(json.data, function(key, value){
                    $("#"+ key).val(value)
                });
            });
            //Load Drug Data
            getTransactionsTable(drugID, '2018', "#transaction_tbl")
            getDrugOrders(drugID, "#orders_tbl")
            getDrugLogs(drugID, "#logs_tbl")
        });

        //Clean up fields when modal is closed
        $('#add_procurement_modal').on('hidden.bs.modal', function(e) {
            $('select,input').val('');
        });

        //Get dropdown data
        getDropdown('../../API/procurement_status', 'procurement_status')
        getDropdown('../../API/funding_agent', 'funding_agent')
        getDropdown('../../API/supplier', 'supplier')

        //Add datepicker
        $(".transaction_date").datepicker({
            format: 'yyyy-mm-dd',
            startDate: '1d'
        });

        //Validate receipt_qty
        $(".receipt_qty").on('keyup', function(){
            var curr_element = $(this)
            var sum = 0;
            var overall_qty = $("#actual_qty").val()
            $('.receipt_qty').each(function(){
                sum += parseInt(this.value);
                if(sum > overall_qty){
                    bootbox.alert({
                        title: "Quantity Alert",
                        message: "Quantity cannot be more than Actual Order Quantity!",
                        callback: function(){
                            curr_element.val('');
                        }
                    });
                }
            });
        });

        //Add row to table
        $(".add").click(function(){
            var last_row = $(this).closest('tr');

            if (last_row.find(".receipt_qty").val() == "" || last_row.find(".transaction_date").val() == "" || last_row.find(".procurement_status").val() == "" || last_row.find(".funding_agent").val() == "" || last_row.find(".supplier").val() == "") {
                bootbox.alert({
                    title: "Required Alert",
                    message: "All values must be entered/selected!"
                });
            }else{
                $(".transaction_date").datepicker('destroy');
                var cloned_row = last_row.clone(true);
                cloned_row.find('select,input').val('');
                cloned_row.insertAfter(last_row);
                $(".transaction_date").datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '1d'
                });
            }
        });

        //Remove row from table
        $(".remove").click(function() {
            var rows = $("#procurement_tbl > tbody").find("tr").length;
            if(rows > 1){
                bootbox.confirm({
                    title: "Remove Confirmation",
                    message: "Are you sure?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(res){
                        if(res){
                            $(this).closest('tr').remove();     
                        }
                    }
                });                                            
            }else{
                bootbox.alert({
                    title: "Remove Alert",
                    message: "You cannot remove the last row!"
                });
            }
        });

        //Filter transaction year
        $(".filter-year").click(function(){
            var periodYear = $(this).data('value');
            var drugID = $("#drug_id").val();
            getTransactionsTable(drugID, periodYear, "#transaction_tbl")
        });

    });

    function getDropdown(dataURL, elementClass){
        $.getJSON(dataURL, function(data){
            $("."+elementClass+" option").remove();
            $("."+elementClass).append($("<option value=''>Select One</option>"));          
            $.each(data, function(i, v) {
                $("."+elementClass).append($("<option value='" + v.id + "'>" + v.name.toUpperCase() + "</option>"));
            });
        });
    }

    function getTransactionsTable(drugID, periodYear, tableID){
        //Load Spinner
        LoadSpinner(tableID)
        //Load Table
        var transactionURL = "<?php echo base_url() . 'Manager/Procurement/get_transaction_table/'; ?>"+drugID+'/'+periodYear
        $.get(transactionURL, function(table){
            $(tableID).html(table)
        });
    }

    function getDrugOrders(drugID, tableID){
        //Load Spinner
        LoadSpinner(tableID)
        //Load Table
        var ordersURL = "<?php echo base_url() . 'Manager/Procurement/get_order_table/'; ?>"+drugID
        $.get(ordersURL, function(table){
            $(tableID).html(table)
        });
    }

    function getDrugLogs(drugID, tableID){
        //Load Spinner
        LoadSpinner(tableID)
        //Load Table
        var logsURL = "<?php echo base_url() . 'Manager/Procurement/get_log_table/'; ?>"+drugID
        $.get(logsURL, function(table){
            $(tableID).html(table)
        });
    }

    function LoadSpinner(divID){
        var spinner = new Spinner().spin()
        $(divID).empty('')
        $(divID).height('auto')
        $(divID).append(spinner.el)
    }

</script>
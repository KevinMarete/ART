<link href="<?php echo base_url() . 'public/manager/css/procurement.css'; ?>" rel="stylesheet"> 
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!--/modal-header-->
            <div class="modal-body">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a data-toggle="tab" href="#drug_decision">Decision</a></li>
                    <li><a data-toggle="tab" href="#drug_procurement">Procurement</a></li>
                    <li><a data-toggle="tab" href="#drug_transactions">Transactions</a></li>
                    <li><a data-toggle="tab" href="#drug_orders">Orders</a></li>
                    <li><a data-toggle="tab" href="#drug_logs">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <p><span style="font-size: 16px;" class="label label-info" id="productTitle">Product - Month</span></p>
                    <div id="drug_decision" class="tab-pane fade in active">
                        <h3>Decisions</h3>
                        <div class="container-fluid">
                            <div class="row pull-right">
                                <button id="addDecision" data-toggle="modal" data-target="#decisionModal" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Decision</button>
                            </div>
                            <div id="timeline" style="margin-top: 10px;">
                                <div class="row timeline-movement timeline-movement-top">
                                    <div class="timeline-badge timeline-future-movement">
                                        <a href="#" data-toggle="modal" data-target="#decisionModal">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    </div>
                                    <div class="timeline-badge timeline-filter-movement">
                                        <a href="#">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </a>
                                    </div>
                                </div>
                                <div id="decision_tbl"></div>
                            </div>
                        </div>
                    </div>

                    <div id="drug_procurement" class="tab-pane fade">
                        <h3>Procurement Form</h3>
                        <p>
                        <form action="<?php echo base_url() . 'manager/save_procurement'; ?>" method="POST" class="form-horizontal" role="form">
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
                            <div id="procurement_loader"></div>
                            <div class="form-group row" id="commodity_frm">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="procurement_tbl">
                                            <thead>
                                            <th>Quantity</th>
                                            <th>Expected Period</th>
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
                                                        <select name="funding_agent[]" class="funding_agent contracted"></select>
                                                    </td>
                                                    <td>
                                                        <select name="supplier[]" class="supplier contracted col-md-12"></select>
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
                        <p>
                        <div id="transaction_tbl" class="table-responsive"></div>
                        </p>
                        <p>
                            <button id="trans_download" class="btn btn-primary btn-md pull-left"><i class="fa fa-download"></i> Download as CSV</button>
                            <button id="trans_save" class="btn btn-success btn-md pull-right"><i class="fa fa-save"></i> Update Changes</button>
                        </p>


                    </div>
                    <div id="drug_orders" class="tab-pane fade">
                        <h3>Orders</h3>
                        <div id="orders_tbl" class="table-responsive"></div>
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

<!--Add decision Modal-->
<div class="modal fade" id="decisionModal" tabindex="-1" role="dialog" aria-labelledby="decisionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="decisionModalTitle">Add Decision & Reccomendations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='decisionForm'>
                    <div class="form-group">
                        <input type="hidden" id='Drug_ID' name="drug_id"/>
                        <label for="message-text" class="col-form-label">Decisions:</label>
                        <textarea class="form-control" name='discussion' required id="decisions"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Reccommendation:</label>
                        <textarea class="form-control" name='recommendation' required id="reccomendations"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id='saveDecision' class="btn btn-primary">Submit Decision</button>
            </div>
        </div>
    </div>
</div>

<!--Add decision Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="decisionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="decisionModalTitle">Edit Decision & Reccomendations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='editdecisionForm'>
                    <div class="form-group">
                        <input type="hidden" id='Drug_IDEdit' name="drug_id"/>
                        <input type="hidden" id='Disc_ID' name="decision_id"/>

                        <label for="message-text" class="col-form-label">Decisions:</label>
                        <textarea class="form-control" name='discussion' required id="decisionsEdit">Loading, Please wait....</textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Reccommendation:</label>
                        <textarea class="form-control" name='recommendation' required id="reccomendationsEdit">Loading, Please wait....</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id='editDecision' class="btn btn-primary">Submit Decision Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="trashModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this decision?
                <input type="hidden" name="decision_id" id="discID"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" id='deleteDecisionBtn' data-id="" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>


    now = new Date();
    currentYear = (new Date).getFullYear();
    currentMonth = GetMonthName((new Date).getMonth());
    newdate = new Date(now.setMonth(now.getMonth() - 1));
    lastMonth = GetMonthName((newdate.getMonth()));
    function GetMonthName(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber];
    }


    var statusURL = '../../API/procurement_status'
    var fundingURL = '../../API/funding_agent'
    var supplierURL = '../../API/supplier'
    $(document).ready(function () {

        $('#saveDecision').click(function () {
            $(this).text('Please Wait...');
            $(this).prop('disabled', true);
            $.post("<?php echo base_url() . 'Manager/Procurement/save_decision'; ?>", $('#decisionForm').serialize(), function () {
                window.location.href = "<?php echo base_url() . 'manager/procurement/commodity'; ?>";
            });
        });

        $('#editDecision').click(function () {
            $(this).text('Please Wait...');
            $(this).prop('disabled', true);
            $.post("<?php echo base_url() . 'Manager/Procurement/edit_decision'; ?>", $('#editdecisionForm').serialize(), function () {
                window.location.href = "<?php echo base_url() . 'manager/procurement/commodity'; ?>";
            });
        });

        $('#deleteDecisionBtn').click(function () {
            $(this).text('Please Wait...');
            $(this).prop('disabled', true);
            $.post("<?php echo base_url() . 'Manager/Procurement/delete_decision'; ?>", {decision_id: $('#discID').val()}, function () {
                window.location.href = "<?php echo base_url() . 'manager/procurement/commodity'; ?>";
            });
        });

        $(document).on('click', '.trash', function () {
            id = $(this).attr('data-id');
            $('#discID').val(id);

        });


        $(document).on('mouseenter', '.mainContent', function () {
            clearTimeout($(this).data('timeoutId'));
            $(this).find(".edit").show();
            $(this).find(".trash").show();
        }).mouseleave(function () {
            var someElement = $(this),
                    timeoutId = setTimeout(function () {
                        someElement.find(".edit").hide();
                        $(this).find(".trash").hide();
                    }, 650);
            //set the timeoutId, allowing us to clear this trigger if the mouse comes back over
            someElement.data('timeoutId', timeoutId);
        });

        $(document).on('click', '.edit', function () {
            $('#Disc_ID ').val('');
            $('#Drug_IDEdit').val('');
            $('#decisionsEdit').val('Loading, Please Wait....');
            $('#reccomendationsEdit').val('Loading, Please Wait....')
            drug_id = '';
            disc_id = $(this).attr('data-id');
            $.getJSON("<?php echo base_url() . 'Manager/Procurement/get_decisions_byID/'; ?>" + disc_id, function (res) {
                $('#Disc_ID ').val(disc_id);
                $('#Drug_IDEdit').val(res.data[0].drug_id);
                $('#decisionsEdit').val(res.data[0].discussion);
                $('#reccomendationsEdit').val(res.data[0].recommendation);
            }, 'json');




            //console.log('its me' +disc_id)

            //console.log(disc)
        });





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
        $("#add_procurement_modal").on("shown.bs.modal", function (e) {
            //Load Spinner
            LoadSpinner("#procurement_loader")

            drugID = $(e.relatedTarget).data('drug_id');
            $('#Drug_ID').val(drugID);
            $('#productTitle').empty();
            //Load TrackerInfo
            var trackerURL = "<?php echo base_url() . 'Manager/Procurement/get_tracker/'; ?>" + drugID;
            $.getJSON(trackerURL, function (json) {
                $.each(json.data, function (key, value) {
                    $("#" + key).val(value)
                });
                console.log(json);
                if (json.data.length < 1) {
                    $('#productTitle').text("No tracker data found for this product, please add");
                    $('#decisionModalTitle').text('Add Decisions and Reccomendations for this product');
                } else {
                    $('#productTitle').text(json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                    $('#decisionModalTitle').text('Edit Decisions and Reccomendations for ' + json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                }
                $("#procurement_loader").empty(); //Kill Loader
            });
            //Load Drug Data
            getDecisions(drugID, "#decision_tbl")
            getTransactionsTable(drugID, '2018', "#transaction_tbl")
            getDrugOrders(drugID, "#orders_tbl")
            getDrugLogs(drugID, "#logs_tbl")
        });
        //Clean up fields when modal is closed
        $('#add_procurement_modal').on('hidden.bs.modal', function (e) {
            $('select,input').val('');
        });
        //Get dropdown data
        getDropdown(statusURL, 'procurement_status')
        getDropdown(fundingURL, 'funding_agent')
        getDropdown(supplierURL, 'supplier')

        //Add datepicker
        $(".transaction_date").datepicker({
            format: 'yyyy-mm-dd',
            startDate: '1d'
        });
        //Validate receipt_qty
        $(".receipt_qty").on('keyup', function () {
            var curr_element = $(this)
            var sum = 0;
            var overall_qty = $("#actual_qty").val()
            $('.receipt_qty').each(function () {
                sum += parseInt(this.value);
                if (sum > overall_qty) {
                    swal({
                        title: "Excess Quantity!",
                        text: "Quantity cannot be more than Actual Order Quantity!",
                        icon: "error",
                    });
                }
            });
        });
        //Add row to table
        $(".add").click(function () {
            var last_row = $(this).closest('tr');
            if (last_row.find(".receipt_qty").val() == "" || last_row.find(".transaction_date").val() == "" || last_row.find(".procurement_status").val() == "") {
                swal({
                    title: "Required!",
                    text: "All values must be entered/selected!",
                    icon: "error",
                });
            } else {
                $(".transaction_date").datepicker('destroy');
                var cloned_row = last_row.clone(true);
                cloned_row.find('select,input').val('');
                cloned_row.insertAfter(last_row);
                $(".transaction_date").datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '1d'
                });
                cloned_row.find('.contracted').hide();
            }
        });
        //Remove row from table
        $(".remove").click(function () {
            var rows = $("#procurement_tbl > tbody").find("tr").length;
            if (rows > 1) {
                swal({
                    title: "Remove Alert",
                    text: "Are you sure, You want to delete this row?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $(this).closest('tr').remove();
                    }
                });
            } else {
                swal({
                    title: "Invalid!",
                    text: "You cannot remove the last row!",
                    icon: "error",
                });
            }
        });
        //Filter transaction year
        $(".filter-year").click(function () {
            var periodYear = $(this).data('value');
            var drugID = $("#drug_id").val();
            getTransactionsTable(drugID, periodYear, "#transaction_tbl")
        });
        //Hide contracted fields
        $(".contracted").hide()

        //Procurement status change event
        $(".procurement_status").on('change', function () {
            var selected_text = $(this).closest('tr').find(".procurement_status option:selected").text().toLowerCase();
            if (selected_text === 'contracted' || selected_text === 'proposed') {
                $(this).closest('tr').find('.contracted').show();
            } else {
                $(this).closest('tr').find('.contracted').hide();
            }
        });
        //Transaction table download
        $('#trans_download').on('click', function () {
            $('#transaction_tbl').jexcel('download');
        });
        //Transaction table save
        $('#trans_save').on('click', function () {
            $('#trans_save').prop('disabled', true);
            $('#trans_save').prop('value', 'Please Wait....');
            tbl = html2json();
            newdata = JSON.parse(tbl);
            $.post("<?php echo base_url() . 'Manager/Procurement/get_transaction_data/'; ?>", {data: newdata, drug_id: drugID}, function () {
             $('#transaction_tbl').empty();
            }).done(function () {
                getTransactionsTable(drugID, '2018', "#transaction_tbl");
                $('#trans_save').prop('disabled', false);
                $('#trans_save').prop('value', 'Update Changes');
            });

        });
    });


    function html2json() {
        var json = '{';
        var otArr = [];
        var tbl2 = $('#transaction_tbl tr').each(function (i) {
            x = $(this).children();
            var itArr = [];
            x.each(function () {
                itArr.push('"' + $(this).text() + '"');
            });
            otArr.push('"' + i + '": [' + itArr.join(',') + ']');
        })
        json += otArr.join(",") + '}'

        return json;
    }

    function getDropdown(dataURL, elementClass) {
        $.getJSON(dataURL, function (data) {
            $("." + elementClass + " option").remove();
            $("." + elementClass).append($("<option value=''>Select One</option>"));
            $.each(data, function (i, v) {
                $("." + elementClass).append($("<option value='" + v.id + "'>" + v.name.toUpperCase() + "</option>"));
            });
        });
    }

    function getDecisions(drugID, divID) {
        //Load Spinner
        LoadSpinner(divID)
        //Load Table
        var decisionsURL = "<?php echo base_url() . 'Manager/Procurement/get_decisions/'; ?>" + drugID
        $.get(decisionsURL, function (timeline) {
            $(divID).html(timeline)
        });
    }

    function getTransactionsTable(drugID, periodYear, tableID) {
        //Load Spinner
        LoadSpinner(tableID)
        //Load tableData
        var transactionURL = "<?php echo base_url() . 'Manager/Procurement/get_transaction_table/'; ?>" + drugID + '/' + periodYear
        $.get(transactionURL, function (tableData) {
            var readonlyRows = ['0', '1', '3', '5', '6', '7']
            //Create table
            $(tableID).jexcel($.parseJSON(tableData));
            //Settings for table
            $(tableID).jexcel('updateSettings', {
                table: function (instance, cell, col, row, val, id) {
                    //Make rows readonly
                    if ($.inArray(row, readonlyRows) != -1) {
                        $(cell).addClass('readonly');
                    }
                    //Add colors to mos row
                    if (row == 7 && col > 0) {
                        if (val >= 6 && val <= 9) {
                            $(cell).css('background-color', '#32CD32');
                        } else if (val >= 4 && val <= 5) {
                            $(cell).css('background-color', '#CCCC00');
                        } else if (val <= 3) {
                            $(cell).css('background-color', '#DC143C');
                        } else {
                            $(cell).css('background-color', '#87CEFA');
                        }
                        $(cell).css('color', '#000');
                    }
                }
            });
        });
    }

    function getDrugOrders(drugID, tableID) {
        //Load Spinner
        LoadSpinner(tableID)
        //Load Table
        var ordersURL = "<?php echo base_url() . 'Manager/Procurement/get_order_table/'; ?>" + drugID
        var editOrderURL = "<?php echo base_url() . 'Manager/Procurement/edit_order/'; ?>"
        var itemURL = "<?php echo base_url() . 'Manager/Procurement/get_order_items/'; ?>"
        $.get(ordersURL, function (table) {
            $.getJSON(itemURL, function (jsondata) {
                $(tableID).html(table)
                $(".order_tbl").Tabledit({
                    url: editOrderURL,
                    hideIdentifier: true,
                    columns: {
                        identifier: [0, 'id'],
                        editable: [[1, 'transaction_year', '{"2018": "2018", "2019": "2019", "2020": "2020", "2021": "2021"}'], [2, 'transaction_month', '{"Jan": "Jan", "Feb": "Feb", "Mar": "Mar", "Apr": "Apr", "May": "May", "Jun": "Jun", "Jul": "Jul", "Aug": "Aug", "Sep": "Sep", "Oct": "Oct", "Nov": "Nov", "Dec": "Dec"}'], [3, 'quantity'], [4, 'procurement_status_id', JSON.stringify(jsondata.status)], [5, 'funding_agent_id', JSON.stringify(jsondata.funding)], [6, 'supplier_id', JSON.stringify(jsondata.supplier)]]
                    },
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-default',
                            html: '<span class="fa fa-pencil-square-o"></span>',
                            action: 'edit'
                        }, /*
                         delete: {
                         class: 'btn btn-sm btn-default',
                         html: '<span class="fa fa-trash-o"></span>',
                         action: 'delete'
                         }*/
                    },
                    onSuccess: function (data, textStatus, jqXHR) {
                        getDrugOrders(drugID, tableID)
                    }
                });
            });
        });
        $('.tabledit-delete-button').hide();
    }

    function getDrugLogs(drugID, tableID) {
        //Load Spinner
        LoadSpinner(tableID)
        //Load Table
        var logsURL = "<?php echo base_url() . 'Manager/Procurement/get_log_table/'; ?>" + drugID
        $.get(logsURL, function (table) {
            $(tableID).html(table)
            $('.log_tbl').DataTable({
                pagingType: "full_numbers",
                order: [[1, "desc"]],
                initComplete: function () {
                    this.api().columns([1, 2, 3]).every(function () {
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
        });
    }

    function LoadSpinner(divID) {
        var spinner = new Spinner().spin()
        $(divID).empty('')
        $(divID).height('auto')
        $(divID).append(spinner.el)
    }

</script>
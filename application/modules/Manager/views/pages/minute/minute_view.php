<link href="<?php echo base_url() . 'public/manager/css/procurement.css'; ?>" rel="stylesheet"> 

<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 5px; /* 5px rounded corners */
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    /* Add some padding inside the card container */
    .container {
        padding: 20px;
    }

    .textarea {
        width: 320px;
        height: auto;
        padding: 5px;
        border: #fff;       
        overflow: hidden;
        display:block;
    }

    .jexcel bossanova-ui {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    .jexcel bossanova-ui td,
    .jexcel bossanova-ui th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    .jexcel bossanova-ui th {
        background-color: #ccd;
    }
    .jexcel bossanova-ui > tr:nth-child(even) {
        background-color: #dddddd;
    }
    jexcel bossanova-ui > tr:nth-child(odd) {
        background-color: #ddeedd;
    }
    .highlight {
        background-color: Yellow;
        color: Green;
    }

</style>
<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Minute</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>
                <?php echo $this->session->flashdata('tracker_msg'); ?>
            </ol>
        </div>
    </div><!--end row-->
    <!--row-->
    <div class="row">

        <div class="col-lg-12 card"  style="padding: 10px;">
            <div class="col-md-12">
                <div class="col-md-3">
                    Category:  <select id="drugCategory"></select>
                </div>
                <div class="col-md-3">
                    Decision Date: <select id="lastMinutes"></select>
                </div>
                <div class="col-md-3">
                    <a href="#minutes" data-toggle="modal" data-target="#MinuteD"  class="btn btn-warning">Create / Load Minute</a> 
                </div>
            </div><br>
            <div class="row" style="font-weight: bold; font-size: 14px; margin-left: 20px;" >MINUTE 2: STOCK STATUS PER PRODUCT AND REQUIRED DELIVERIES AND NEW PROCUREMENTS</div>

            <form id="meetingForm">
                <div class="row" id="commodityHolder" style="padding:5px;">

                </div>
            </form>
            <?php if (date('m') < 10) { ?>
                <button id="meetingSave" class="btn btn-lg btn-success" ><i class="fa fa-save"></i> Save Meeting Data</button>
            <?php } else { ?>
                <div class="alert alert-warning"><i class="fa fa-warning"></i> You cannot make changes on this page at this time</div>
            <?php } ?>

        </div>

    </div><!--end row-->
</div><!--end page wrapper--->

<script>
    $(function () {
        var editor;
        var selected_category = '';
        var date = "<?= $this->uri->segment(5) ?>";
        newdate = "<?= substr($this->uri->segment(5), 0, -3) ?>";




        loadTable('ART', date);



        var facilityinstallURL = '<?= base_url(); ?>API/facility_install';
        $("#facility").empty();
        $.getJSON(facilityinstallURL, function (facilities) {
            $("#facility").append($("<option value=''>Select Facility</option>"));
            $.each(facilities, function (index, facility) {
                $("#facility").append($("<option value='" + facility.id + "'>" + facility.name.toUpperCase() + "</option>"));
            });
        });

        var categoryURL = '<?= base_url(); ?>API/Drug_category';
        $("#drugCategory").empty();
        $.getJSON(categoryURL, function (d) {
            $.each(d, function (index, cat) {
                $("#drugCategory").append($("<option value='" + cat.name + "'>" + cat.name.toUpperCase() + "</option>"));
            });
        });

        var lastURL = '<?= base_url(); ?>Manager/Procurement/loadLastMinutes';
        $("#lastMinutes").empty();
        $('#lastMinutes').append("<option value='<?= date('Y-m-d'); ?>'></option>")
        $.getJSON(lastURL, function (d) {
            $.each(d, function (index, cat) {
                $("#lastMinutes").append($("<option value='" + cat.meeting_date + "'>" + cat.meeting_date.toUpperCase() + "</option>"));
            });
        });

        $("#drugCategory option:selected").val(selected_category);



        $(document).on('change', '#drugCategory,#lastMinutes', function () {
            $('#commodityHolder').empty();
            editor.destroy();
            category = $("#drugCategory").val();
            date = $('#lastMinutes').val();
            selected_category = category;
            loadTable(category, date);

        });


        function loadTable(category, date) {
            $.get("<?= base_url(); ?>Manager/Procurement/getMinutesData/" + category + '/' + date, function (data) {
                $('#commodityHolder').html(data);

                ContentTools.StylePalette.add([
                    new ContentTools.Style('Author', 'author', ['p'])
                ]);
                editor = ContentTools.EditorApp.get();
                editor.myToolsState = 'rich';
                ContentEdit.Root.get().bind('focus', function (element) {

                    if (element.domElement().classList.contains('plain-text')) {
                        if (editor.myToolsState != 'plain') {
                            editor.myToolsState = 'plain';
                            editor.toolbox().tools([]);
                        }
                    } else {
                        if (editor.myToolsState != 'rich') {
                            editor.myToolsState = 'rich';
                            editor.toolbox().tools(ContentTools.DEFAULT_TOOLS);
                        }
                    }
                });


                editor.init('*[data-editable]', 'data-name');

                editor.addEventListener('saved', function (ev) {
                    var name, payload, regions, xhr;

                    // Check that something changed
                    regions = ev.detail().regions;
                    if (Object.keys(regions).length == 0) {
                        return;
                    }

                    // Set the editor as busy while we save our changes
                    this.busy(true);

                    // Collect the contents of each region into a FormData instance
                    payload = new FormData();
                    for (name in regions) {
                        if (regions.hasOwnProperty(name)) {
                            payload.append(name, regions[name]);
                        }
                    }

                    // Send the update content to the server to be saved
                    function onStateChange(ev) {
                        // Check if the request is finished
                        if (ev.target.readyState == 4) {
                            editor.busy(false);
                            if (ev.target.status == '200') {
                                // Save was successful, notify the user with a flash
                                new ContentTools.FlashUI('ok');
                            } else {
                                // Save failed, notify the user with a flash
                                new ContentTools.FlashUI('no');
                            }
                        }
                    }
                    ;

                    xhr = new XMLHttpRequest();
                    xhr.addEventListener('readystatechange', onStateChange);
                    xhr.open('POST', '/save-my-page');
                    xhr.send(payload);
                });

            }).done(function () {
                $('#minutesTable').DataTable({
                    "bPaginate": false,
                    "ordering": false,
                    "bInfo": false,
                    fixedHeader: true
                });



            });
        }
        $('#meetingSave').click(function () {
            $.post("<?= base_url() ?>Manager/Procurement/saveMeetingData", $('#meetingForm').serialize(), function (resp) {
                $('#commodityHolder').empty();
                editor.destroy();
                category = $("#drugCategory").val();
                date = $('#lastMinutes').val();
                loadTable(category, date);
            })
        });

    });
</script>
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
                    <!--li class="active"><a data-toggle="tab" href="#drug_decision">All Decisions</a></li-->
                    <!--li  class="active"> <a data-toggle="tab" href="#minutes">Minutes</a></li-->
                    <li  class="active"><a data-toggle="tab" href="#drug_procurement">Procurement</a></li>
                    <li><a data-toggle="tab" href="#drug_transactions">Product Tracker</a></li>
                    <li><a data-toggle="tab" href="#drug_orders">Transactions</a></li>
                    <li><a data-toggle="tab" href="#drug_logs">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <!--iv id="drug_decision" class="tab-pane fade in active">
                        <h3>All Product Decisions</h3>
                        <div class="container-fluid">

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
                    </div-->

                    <!--div id="minutes" class="tab-pane fade">
                        <h3>Minutes</h3>
                    <?php $this->load->view('pages/procurement/minutes_view'); ?>
                    </div-->


                    <div id="drug_procurement" class="tab-pane fade in active">

                        <h3>Procurement Form</h3>
                        <p>Switch Drug:<select class="form-control select2" id="DrugList"></select></p>
                        <p><span style="font-size: 16px;" class="label label-info " id="productTitle1">Product - Month</span></p>


                        <form action="<?php echo base_url() . 'manager/save_procurement'; ?>" method="POST" class="form-horizontal" role="form">
                            <div class="form-group row">
                                <div class="row pull-right" style="margin-right: 100px;">
                                    <button id="addDecision" data-toggle="modal" data-target="#decisionModal" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Decision</button>
                                </div>
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
                                <label for="receipts_usaid" class="col-sm-3 col-form-label">Proposed Order Quantity</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="actual_qty" name="receipt_total_qty" required="">
                                </div>
                            </div>
                            <div id="procurement_loader"></div>
                            <div class="row procurement_history">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <strong><em>Product's Last Procurement History</em></strong>
                                        <p><strong>Expected Delivery</strong></p>
                                        <div id="procurement_history"></div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="form-group row" id="commodity_frm">                              
                                <div class="col-sm-12">
                                    <h4>Order Form <div id="REMID" style="background: green; color: white;font-weight: bold; padding: 5px; border-radius: 5px; display: none;"></div></h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="procurement_tbl">
                                            <thead>
                                            <th>Quantity</th>
                                            <th>Qty in percentage (%)</th>
                                            <th>Proposed procurement Date</th>
                                            <th>Transaction Type</th>
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
                                                        <input type="number" name="receipt_qty_percentage[]" required="" class="receipt_qty_percentage col-md-12">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="transaction_date[]" required="" class="transaction_date col-md-12">
                                                    </td>
                                                    <td>
                                                        <select name="status[]" required="" class="procurement_status"></select>
                                                    </td>
                                                    <td>
                                                        <select name="funding_agent[]" class="funding_agent "></select>
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
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Order</button>
                                </div>
                            </div>

                            <div class="form-group row col-md-11 col-md-offset-0">
                                <label for="receipts_usaid" class="col-sm-3 col-form-label"><h4>Product Decisions</h4></label>
                                <div id="timeline" style="margin-top: 5px;">
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
                                    <div class="col-sm-12" id='decision_tbl_procurement'>
                                    </div>
                                </div>
                            </div>



                        </form>
                        </p>
                    </div>
                    <div id="drug_transactions" class="tab-pane fade">
                        <h3>Transactions</h3>
                        <p><span style="font-size: 16px;" class="label label-info " id="productTitle1">Product - Month</span></p>

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
                        <p><span style="font-size: 16px;" class="label label-info productTitle" id="productTitle2">Product - Month</span></p>

                        <div id="orders_tbl" class="table-responsive"></div>
                    </div>
                    <div id="drug_logs" class="tab-pane fade">
                        <h3>Logs</h3>
                        <p><span style="font-size: 16px;" class="label label-info productTitle" id="productTitle3">Product - Month</span></p>

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
                <h5 class="modal-title" id="decisionModalTitle">Add Decision & Reccommendations</h5>
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

<!-- Modal -->
<div id="MinuteD" class="modal fade" role="dialog"  >
    <div class="modal-dialog modal-lg" style="width:90%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Minutes</h4>
            </div>
            <div class="modal-body">
                <p>    <?php $this->load->view('pages/procurement/minutes_view'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Close</button>
                <input type="button" id="saveMinute" class="btn btn-primary" style="margin-top: 20px; width: 100px;" value="Save Minute"/>
                <input type="button" id="saveMinuteEmail" class="btn btn-warning" style="margin-top: 20px;  width: 250px;" value="Save Minute & Dispatch Emails"/>

            </div>
        </div>

    </div>
</div>

<!--Add decision Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="decisionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="decisionModalTitle">Edit Decision & Reccommendations</h5>
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




<div id="ReceiveFormDiv" style="display:none;">
    <form id="ReceiveForm" style="z-index:1000000;">

        <p>
            <input type="text" class="form-control" placeholder="Batch No."/>
        </p>
        <p>
            <input type="text" class="form-control" placeholder="Expiry Date." />
        </p>
        <p>
            <input type="button" class="form-control" value="Submit" />
        </p>
    </form>
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


    var totalPercentage = 0;
    formTemplate = $('#ReceiveForm').clone()[0];
    var swalConfig = {
        title: 'Received Form',
        content: formTemplate,
        button: {
            text: 'Submit',
            closeModal: false
        }
    };

    var statusURL = '<?= base_url(); ?>API/procurement_status';
    var fundingURL = '<?= base_url(); ?>API/funding_agent';
    var supplierURL = '<?= base_url(); ?>API/supplier';
    $(document).ready(function () {
        ls = window.localStorage;

        document.oncontextmenu = function () {
            return false;
        };

        $(document).on('mousedown', '.jexcel td', function (e) {
            if (e.button == 2) {
                if ($(this).hasClass('readonly')) {

                } else {
                    var value = ls.getItem('cd', value);
                    $(this).text(value);
                    return false;
                }
            }
            return true;
        });


        $(document).on('click', '.jexcel td', function () {
            if ($(this).hasClass('readonly')) {

            } else {
                var value = $(this).text();
                ls.setItem('cd', value);
            }
            //  alert(value);
        })

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

        $.getJSON("<?php echo base_url() . 'Manager/Procurement/getAllDrugs/'; ?>", function (res) {
            drug_list = $('#DrugList');
            drug_list.append('<option value="">--Select Drug--</option>');
            $.each(res, function (i, d) {
                drug_list.append('<option value="' + d.id + '">' + d.name + '</option>');
            });
        }, 'json');

        $('#DrugList').on('change', function () {
            var id = $(this).val();
            LoadSpinner("#procurement_loader");
            var trackerURL = "<?php echo base_url() . 'Manager/Procurement/get_tracker/'; ?>" + id;
            $.getJSON(trackerURL, function (json) {
                $.each(json.data, function (key, value) {
                    $("#" + key).val(value)
                });

                if (json.data.length < 1) {
                    $('#productTitle1,#productTitle2,#productTitle3,#productTitle4').text("No tracker data found for this product, please add");
                    $('#decisionModalTitle').text('Add Decisions and Reccomendations for this product');
                } else {
                    $('#productTitle1,#productTitle2,#productTitle3,#productTitle4').text(json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                    $('.decisionModalTitle').text('Edit Decisions and Reccomendations for ' + json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                }
                $("#procurement_loader").empty(); //Kill Loader
                $('#actual_qty').val('');
            });
            $('.productTitle').empty();
            getDecisions(id, "#decision_tbl_procurement");
            getTransactionsTable(id, currentYear, "#transaction_tbl");
            getDrugOrders(id, "#orders_tbl")
            getDrugOrdersHistory(id, '#procurement_history');
            getDrugLogs(id, "#logs_tbl");
        })






        $('#procurement-listing').DataTable({
            responsive: true,
            order: [[0, "asc"]],
            pagingType: "full_numbers",
            ajax: "<?php echo base_url() . 'Manager/Procurement/get_commodities'; ?>",
            initComplete: function () {
                this.api().columns([2]).every(function () {
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
        $(".commodity").closest('ul').addClass("in");
        $(".commodity").addClass("active active-page");
        //Load Commodity Data when Modal shown
        $("#add_procurement_modal").on("shown.bs.modal", function (e) {
            //Load Spinner
            LoadSpinner("#procurement_loader")

            drugID = $(e.relatedTarget).data('drug_id');
            $('#Drug_ID').val(drugID);
            $('.productTitle').empty();
            //Load TrackerInfo
            var trackerURL = "<?php echo base_url() . 'Manager/Procurement/get_tracker/'; ?>" + drugID;
            $.getJSON(trackerURL, function (json) {
                $.each(json.data, function (key, value) {
                    $("#" + key).val(value)
                });

                if (json.data.length < 1) {
                    $('#productTitle1,#productTitle2,#productTitle3,#productTitle4').text("No tracker data found for this product, please add");
                    $('#decisionModalTitle').text('Add Decisions and Reccomendations for this product');
                } else {
                    $('#productTitle1,#productTitle2,#productTitle3,#productTitle4').text(json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                    $('.decisionModalTitle').text('Edit Decisions and Reccomendations for ' + json.data.commodity_name + " | " + lastMonth + "-" + currentYear + " Tracker");
                }
                $("#procurement_loader").empty(); //Kill Loader
                $('#actual_qty').val('');
            });
            //Load Drug Data
            //getDecisionsTimeline(drugID, "#decision_tbl");
            getDecisions(drugID, "#decision_tbl_procurement");
            getTransactionsTable(drugID, currentYear, "#transaction_tbl");
            getDrugOrders(drugID, "#orders_tbl")
            getDrugOrdersHistory(drugID, '#procurement_history');
            getDrugLogs(drugID, "#logs_tbl");

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

        /* $("#actual_qty").on('keyup', function () {
         var curr_element = parseInt($(this).val());
         var overall_qty = $("#expected_qty").val();
         var new_ = overall_qty.replace(",", "");
         
         if (curr_element > parseInt(new_)) {
         swal({
         title: "Excess Quantity!",
         text: "Quantity cannot be more than System Calculated Order Quantity!",
         icon: "error",
         });
         $(this).val('')
         } else {
         }
         
         });*/

        $(document).on('click', '.receipt_qty,.receipt_qty_percentage', function () {
            var overall_qty = $("#actual_qty").val()
            if (overall_qty === '') {
                swal({
                    title: "No Proposed Quantity!",
                    text: "Please enter value for Proposed Actual Quantity",
                    icon: "error",
                });
            }
        })


        //Validate receipt_qty
        $(".receipt_qty").on('keyup', function () {
            var curr_element = $(this)
            var sum = 0;
            var overall_qty = parseInt($("#actual_qty").val());
            $('.receipt_qty').each(function () {
                sum += parseInt(this.value);
                if (sum > overall_qty) {
                    swal({
                        title: "Excess Quantity!",
                        text: "Quantity cannot be more than Proposed Order Quantity!",
                        icon: "error",
                    });
                } else {
                    var bal = overall_qty - sum;

                }
            });
        });

        $(".receipt_qty").on('focusout', function () {
            var curr_element = $(this)
            var sum = 0;
            var overall_qty = parseInt($("#actual_qty").val());
            $('.receipt_qty').each(function () {
                sum += parseInt(this.value);
                if (sum > overall_qty) {
                    swal({
                        title: "Excess Quantity!",
                        text: "Quantity cannot be more than Proposed Order Quantity!",
                        icon: "error",
                    });
                } else {
                    var bal = overall_qty - sum;
                    $('#REMID').text('You have  ' + bal + '(qty.) left to assign.').show();

                }
            });
        });


        $(".receipt_qty_percentage").on('focusout', function () {
            var curr_element = $(this);
            var sum = 0;
            var overall_qty = 100;
            $('.receipt_qty_percentage').each(function () {
                sum += parseInt(this.value);
                if (sum > overall_qty) {
                    swal({
                        title: "Excess Quantity!",
                        text: "Precentage cannot exceed 100%",
                        icon: "error",
                    });
                } else {
                    bal = overall_qty - sum;
                    if (isNaN(bal)) {
                        bal = 0;
                    }
                    ;

                    $('#REMID').text('You have  ' + bal + '% left to assign.').show();

                }
            });
        });
        //Add row to table
        $(".add").click(function () {
            var sum = 0;
            $(".receipt_qty_percentage").each(function () {
                sum += +$(this).val();
            });
            if (sum > 100) {
                swal({
                    title: "Quantity Error!",
                    text: "You have exeeded the value of proposed quantity !",
                    icon: "error",
                });
                return false;

            } else {


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
            }
        });

        $(document).on('keyup', '.receipt_qty_percentage', function () {
            var row_data = $(this).closest('tr');
            var actual_qty = $('#actual_qty').val();
            var qty_ = row_data.find('.receipt_qty');
            var percentage = row_data.find('.receipt_qty_percentage').val();
            var calculated_qty = (parseInt(percentage) / 100) * parseInt(actual_qty);
            qty_.val(Math.ceil(calculated_qty));
        });


        $(document).on('keyup', '.receipt_qty', function () {
            var row_data = $(this).closest('tr');
            var actual_qty = $('#actual_qty').val();
            var qty_ = row_data.find('.receipt_qty').val();
            var percentage = row_data.find('.receipt_qty_percentage');
            var calculated_perc = ((parseInt(qty_) / parseInt(actual_qty)) * 100);
            percentage.val(Math.ceil(calculated_perc));
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

        $(document).on('change', '[name="procurement_status_id"]', function () {
            row = $(this).closest('tr');
            m = row.find('[name="month"]').val();
            var months = {
                'Jan': '01',
                'Feb': '02',
                'Mar': '03',
                'Apr': '04',
                'May': '05',
                'Jun': '06',
                'Jul': '07',
                'Aug': '08',
                'Sep': '09',
                'Oct': '10',
                'Nov': '11',
                'Dec': '12'
            }

            date = row.find('[name="year"]').val() + '-' + months[m] + '-01';

            var now = new Date();
            var end = new Date(date);
            alert(end)
            if (end > now) {
                swal({
                    title: "Invalid!",
                    text: "You cannot receive this order at this time.",
                    icon: "error",
                });
                row.find('[name="procurement_status_id"] option:eq(1)').prop('selected', true);
                return false;
            }
        });

        //Procurement status change event
        $(".procurement_status").on('change', function () {
            row = $(this).closest('tr');
            var selected_text = $(this).closest('tr').find(".procurement_status option:selected").text().toLowerCase();
            transaction_date = row.find('.transaction_date').val();

            if (selected_text === 'contracted') {
                $(this).closest('tr').find('.contracted').show();
                $(this).closest('tr').find('.funding_agent').hide();
            } else if (selected_text === 'proposed') {
                $(this).closest('tr').find('.contracted').show();
                $(this).closest('tr').find('.funding_agent').show();
            } else if (selected_text === 'received') {
                var start = new Date();
                var end = new Date(transaction_date);
                if (end > start) {
                    swal({
                        title: "Invalid!",
                        text: "You cannot receive this order at this time.",
                        icon: "error",
                    });
                    row.find('.procurement_status option:eq(0)').prop('selected', true);
                    return false;
                }
                //  swal(swalConfig);
                $(this).closest('tr').find('.funding_agent').hide();
                $(this).closest('tr').find('.contracted').show();
            } else {
                $(this).closest('tr').find('.contracted').hide();
                $(this).closest('tr').find('.funding_agent').hide();
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

    $("#actual_qty").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            //display error message

            return false;
        }
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

    function getDecisionsTimeline(drugID, divID) {
        //Load Spinner
        LoadSpinner(divID)
        //Load Table
        var decisionsURL = "<?php echo base_url() . 'Manager/Procurement/get_timeline/'; ?>" + drugID
        $.get(decisionsURL, function (timeline) {
            $(divID).html(timeline)
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
            months = ['Sep 2018'];
            //Create table
            $(tableID).jexcel($.parseJSON(tableData));
            //Settings for table
            $(tableID).jexcel('updateSettings', {
                table: function (instance, cell, col, row, val, id) {
                    //Make rows readonly
                    m = "<?= date("n", strtotime("-1 month")); ?>";
                    //m = "<?= date("n"); ?>";



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

                    $('.c' + m).css('background-color', '#e67e22');
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
                    editButton: false,
                    deleteButton: false,
                    hideIdentifier: true,
                    columns: {
                        identifier: [0, 'id'],
                        editable: [
                            [1, 'year', '{"2018": "2018", "2019": "2019", "2020": "2020", "2021": "2021"}'],
                            [2, 'month', '{"Jan": "Jan", "Feb": "Feb", "Mar": "Mar", "Apr": "Apr", "May": "May", "Jun": "Jun", "Jul": "Jul", "Aug": "Aug", "Sep": "Sep", "Oct": "Oct", "Nov": "Nov", "Dec": "Dec"}'],
                            // [3, 'date_added', JSON.stringify(jsondata.date_added)],
                            [3, 'quantity'],
                            [4, 'procurement_status_id', JSON.stringify(jsondata.status)],
                            [5, 'funding_agent_id', JSON.stringify(jsondata.funding)],
                            [6, 'supplier_id', JSON.stringify(jsondata.supplier)]]
                    },
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-default',
                            html: '<span class="fa fa-pencil-square-o"></span>',
                            action: 'edit'
                        },
                        delete: {
                            class: 'btn btn-sm btn-default',
                            html: '<span class="fa fa-trash-o"></span>',
                            action: 'delete'
                        }
                    },
                    onSuccess: function (data, textStatus, jqXHR) {
                        getDrugOrders(drugID, tableID)


                    }
                });
            });
        });
        // $('.tabledit-delete-button').hide();

    }


    function getDrugOrdersHistory(drugID, divID) {

        var ordersURL = "<?php echo base_url() . 'Manager/Procurement/get_order_table_history/'; ?>" + drugID;
        var editOrderURL = "<?php echo base_url() . 'Manager/Procurement/edit_order/'; ?>"
        var itemURL = "<?php echo base_url() . 'Manager/Procurement/get_order_items/'; ?>"
        $.getJSON(itemURL, function (jsondata) {
            $.get(ordersURL, function (table) {
                $(divID).empty();
                $(divID).append(table);
                $(".order_tbl_history").Tabledit({
                    url: editOrderURL,
                    hideIdentifier: true,
                    deleteButton: false,
                    columns: {
                        identifier: [0, 'id'],
                        editable: [
                            [1, 'year', '{"2018": "2018", "2019": "2019", "2020": "2020", "2021": "2021"}'],
                            [2, 'month', '{"Jan": "Jan", "Feb": "Feb", "Mar": "Mar", "Apr": "Apr", "May": "May", "Jun": "Jun", "Jul": "Jul", "Aug": "Aug", "Sep": "Sep", "Oct": "Oct", "Nov": "Nov", "Dec": "Dec"}'],
                            //[3, 'transaction_date'],
                            [4, 'quantity'],
                            [5, 'procurement_status_id', JSON.stringify(jsondata.status)],
                            [6, 'funding_agent_id', JSON.stringify(jsondata.funding)],
                            [7, 'supplier_id', JSON.stringify(jsondata.supplier)]
                        ]

                    },
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-default',
                            html: '<span class="fa fa-pencil-square-o"></span>',
                            action: 'edit'
                        },
                        delete: {
                            class: 'btn btn-sm btn-default',
                            html: '<span class="fa fa-trash-o"></span>',
                            action: 'delete'
                        }
                    },
                    onSuccess: function (data, textStatus, jqXHR) {
                        getDrugOrdersHistory(drugID, divID)


                    }
                });
            });
        })


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
            //$('#procurement_loader').hide();
        });
        $('#actual_qty').val('');
    }

    function LoadSpinner(divID) {
        var spinner = new Spinner().spin()
        $(divID).empty('')
        $(divID).height('auto')
        $(divID).append(spinner.el)
    }

</script>

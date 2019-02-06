<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
    .AVGISCON td:nth-child(2),td:nth-child(3) {
        text-align: right;
        font-weight: bold;
    } 
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <?php echo $this->session->flashdata('dashboard_msg'); ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-collapse collapse" id="navbar-filter">
                        <div class="navbar-form" role="search">
                            <div class="form-group">
                                <a href="#advancedFilter" class="btn btn-warning" data-toggle="modal" data-target="#advancedFilterModal">Advanced Filter</a>
                            </div>
                            <div class="form-group">
                                <div class="filter form-control" id="year-filter">
                                    <input type="hidden" name="filter_year" id="filter_year" value="" />
                                    Year: 
                                     <?php
                                    $start = (int)date('Y')-4;
                                    $current=(int)date('Y');
                                    for($i=$start;$i<=$current;$i++){ ?>                                              
                                    <a href="#" class="filter-year" data-value="<?=$i;?>"> <?=$i;?> </a>|                                 
                                    <?php } ?>
                                </div>
                                <div class="filter form-control" id="month-filter">
                                    <input type="hidden" name="filter_month" id="filter_month" value="" />
                                    Month: 
                                    <a href="#" class="filter-month" data-value="Jan"> Jan </a>|
                                    <a href="#" class="filter-month" data-value="Feb"> Feb </a>|
                                    <a href="#" class="filter-month" data-value="Mar"> Mar </a>|
                                    <a href="#" class="filter-month" data-value="Apr"> Apr </a>|
                                    <a href="#" class="filter-month" data-value="May"> May </a>|
                                    <a href="#" class="filter-month" data-value="Jun"> Jun </a>|
                                    <a href="#" class="filter-month" data-value="Jul"> Jul </a>|
                                    <a href="#" class="filter-month" data-value="Aug"> Aug </a>|
                                    <a href="#" class="filter-month" data-value="Sep"> Sep </a>| 
                                    <a href="#" class="filter-month" data-value="Oct"> Oct </a>|
                                    <a href="#" class="filter-month" data-value="Nov"> Nov </a>|
                                    <a href="#" class="filter-month" data-value="Dec"> Dec</a>
                                </div>
                            </div>
                            <button id="btn_clear" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span></button>
                            <button id="btn_filter" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span></button>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div><!--/filter-row-->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Reporting Rates
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="reporting_rates_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="reporting_rates_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Patients by Regimen
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="patients_by_regimen_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="patients_by_regimen_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Drug Consumption and Allocation Trend
                            <?php if ($this->session->userdata('role') == 'nascop') { ?>
                                <a href="#AvgIssues" class="btn btn-sm btn-primary pull-right"  data-toggle="modal" data-target="#advancedIssuesModal">Average Issues / Consumption</a>
                            <?php } ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="drug_consumption_allocation_trend_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="drug_consumption_allocation_trend_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Stock On Hand Trend
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="stock_status_trend_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="stock_status_trend_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Low MOS Commodities in Facilities
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="low_mos_commodity_table"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="low_mos_commodity_table_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> High MOS Commodities in Facilities
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="high_mos_commodity_table"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="high_mos_commodity_table_heading heading"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!--Advanced Filter Modal -->
<div id="advancedFilterModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <input id="filterStatus" type="hidden"/>
        <!-- Filter Modal-->
        <div class="modal-content">
            <form id="AdvancedFilter">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Advanced Filter</b></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="scope_id" value="<?php echo $this->session->userdata('scope'); ?>"/>
                    <input type="hidden" id="scope" value="<?php echo $this->session->userdata('scope_name'); ?>"/>
                    <input type="hidden" id="role" value="<?php echo $this->session->userdata('role'); ?>"/>
                    <div class="form-group">
                        <select class="form-control drug subcounty_default county_default nascop_default hidden filter_item" data-item="drug" name="drug" size="2"></select>
                    </div>
                    <div class="form-group">
                        <select class="form-control county nascop_default hidden filter_item" data-item="county" name="county" multiple="multiple"></select>
                    </div>
                    <div class="form-group">
                        <select class="form-control sub_county county_default hidden filter_item" data-item="sub_county" name="sub_county" multiple="multiple"></select>
                    </div>
                    <div class="form-group">
                        <select class="form-control facility subcounty_default hidden filter_item" data-item="facility" name="facility" multiple="multiple"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"  class="btn btn-warning" id="advFilter" ><i class="fa fa-filter"></i> Filter</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="advancedIssuesModal" class="modal fade modal-lg" style="width:100%">
    <div class="modal-dialog">
        <input id="filterStatus" type="hidden"/>
        <!-- Filter Modal-->
        <div class="modal-content">
            <form id="AvgForm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Commodity Average Issues & Consumption List</b></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="scope_id" value="<?php echo $this->session->userdata('scope'); ?>"/>
                    <input type="hidden" id="scope" value="<?php echo $this->session->userdata('scope_name'); ?>"/>
                    <input type="hidden" id="role" value="<?php echo $this->session->userdata('role'); ?>"/>


                    <div class="form-group col-lg-6">
                        <label>Year-Month From:</label>
                        <input type="text" name="from" id="from"  value="2018-01" class="form-control DatePickers"  placeholder="From">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Year-Month To:</label>
                        <input type="text" name="to" id="to" value="2018-12" class="form-control DatePickers" placeholder="To">
                    </div>
                    <div class="form-group col-lg-12">
                        <select class="form-control national_drug subcounty_default county_default nascop_default hidden filter_item" multiple="multiple" data-item="drug" name="drug[]" size="2"></select>

                    </div>


                    <div class="form-group col-lg-12">
                        <center><span class="badge badge-info"></span></center>
                    </div>


                    <div class="form-group col-lg-12">
                        <table class="table table-bordered table-condensed AVGISCON table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Commodity</th>
                                    <th>Issues</th>
                                    <th>Consumption</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="avgFilterForm" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Results"><i class="fa fa-filter"></i> Filter</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!--dashboard-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/dashboard.js'; ?>"></script>
<script>
    $(function () {
        var d = new Date();
        year = d.getFullYear();
        monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        // table = $('.AVGISCON').DataTable();
        $(".DatePickers").monthpicker({
            pattern: 'yyyy-mm',
            selectedYear: year,
            startYear: 2017,
            finalYear: year
        });

        $('#avgFilterForm').click(function () {
            from = $('#from').val();
            to = $('#to').val();
            monthfrom = parseInt(from.substr(-2)) - 1;
            monthto = parseInt(to.substr(-2)) - 1;
            yearfrom = from.substr(0, 4);
            yearto = to.substr(0, 4);
            period = monthNames[monthfrom] + " " + yearfrom + " and " + monthNames[monthto] + " " + yearto;
            $('.badge-info').text('');
            $('.badge-info').text('Commodity Averages Issues & Consumption between ' + period);
            var $this = $(this);
            $this.button('loading');
            data = $('#AvgForm').serialize();
            $.post("<?php echo base_url(); ?>Manager/Procurement/FilterAvg", data, function (resp) {
                if ($.fn.DataTable.isDataTable('.AVGISCON')) {
                    $('.AVGISCON').DataTable().destroy();
                }
                $('.AVGISCON').DataTable({
                    "processing": true,
                    "data": resp,
                    "columns": [
                        {"data": "drug"},
                        {"data": "issues"},
                        {"data": "consumption"}
                    ]
                });
                $this.button('reset');
            });
        });

    })
</script>
<style>
    .active-red{
        color:red;
    }
    span.multiselect-native-select{position:relative}span.multiselect-native-select select{border:0!important;clip:rect(0 0 0 0)!important;height:1px!important;margin:-1px -1px -1px -3px!important;overflow:hidden!important;padding:0!important;position:absolute!important;width:1px!important;left:50%;top:30px}.multiselect-container{position:absolute;list-style-type:none;margin:0;padding:0}.multiselect-container .input-group{margin:5px}.multiselect-container .multiselect-reset .input-group{width:93%}.multiselect-container>li{padding:0}.multiselect-container>li>a.multiselect-all label{font-weight:700}.multiselect-container>li.multiselect-group label{margin:0;padding:3px 20px;height:100%;font-weight:700}.multiselect-container>li.multiselect-group-clickable label{cursor:pointer}.multiselect-container>li>a{padding:0}.multiselect-container>li>a>label{margin:0;height:100%;cursor:pointer;font-weight:400;padding:3px 20px 3px 40px}.multiselect-container>li>a>label.checkbox,.multiselect-container>li>a>label.radio{margin:0}.multiselect-container>li>a>label>input[type=checkbox]{margin-bottom:5px}.btn-group>.btn-group:nth-child(2)>.multiselect.btn{border-top-left-radius:4px;border-bottom-left-radius:4px}.form-inline .multiselect-container label.checkbox,.form-inline .multiselect-container label.radio{padding:3px 20px 3px 40px}.form-inline .multiselect-container li a label.checkbox input[type=checkbox],.form-inline .multiselect-container li a label.radio input[type=radio]{margin-left:-20px;margin-right:0}
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
                                <select  id="filter_item"  multiple="multiple" data-filter_type="" name="filter_item[]"  class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <div class="filter form-control" id="year-filter">
                                    <input type="hidden" name="filter_year" id="filter_year" value="" />
                                    Year: 
                                    <a href="#" class="filter-year" data-value="2015"> 2015 </a>|
                                    <a href="#" class="filter-year" data-value="2016"> 2016 </a>|
                                    <a href="#" class="filter-year" data-value="2017"> 2017 </a>|
                                    <a href="#" class="filter-year" data-value="2018"> 2018 </a>
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Drug Consumption and Allocation Trend
                            <div class="nav navbar-right">
                                <!--button data-toggle="modal" data-target="#drug_consumption_allocation_trend_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button-->
                            </div>
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
                            <div class="nav navbar-right">

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="stock_status_trend_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="stock_status_trend_chart heading"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Summary Table
                            <div class="nav navbar-right">

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-responsive table-striped" id="summaryTable">
                                <thead>
                                    <tr>
                                        <th>Commodity</th>
                                        <th>Allocated</th>
                                        <th>Balance</th>
                                        <th>MOS</th>
                                        <th>Year</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="stock_status_ heading">Commodity Summaries</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
<!--modal(s)-->
<div class="modal fade" id="drug_consumption_allocation_trend_chart_filter_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><strong>COMMODITY/ALLOCATION CONSUMPTION FILTER</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9">
                        <select id="drug_consumption_allocation_trend_chart_filter" data-filter_type="drug" size="2"></select>
                    </div>
                    <div class="col-sm-3">
                        <button id="drug_consumption_allocation_trend_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                        <button id="drug_consumption_allocation_trend_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var chartURL = '../Manager/get_chart'
    var drugListURL = '../API/drug/list'
    var filters = {}
    $(document).ready(function () {
        dt = new Date();

        newmonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        year = dt.getFullYear(), month = newmonth[dt.getMonth()], drug = 'Dolutegravir (DTG) 50mg Tabs';
        //alert(year + monthname)

        $('#filter_item').change(function () {
            drug = $('#filter_item').val();
        });



        $('.filter-year').click(function () {
            $('a.filter-year').removeClass('active-red');
            $(this).addClass('active-red');
            year = $(this).text();
        });

        $('.filter-month').click(function () {
            $('a.filter-month').removeClass('active-red');
            $(this).addClass('active-red');
            month = $(this).text();
        });

        $('#btn_filter').click(function () {
           // alert(drug + '---' + month + '----' + year);
        })


        $('#summaryTable').DataTable({

            "bProcessing": true,
            "order": [[3, "desc"]],
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
            "sAjaxSource": "<?= base_url(); ?>Manager/orders/getSummaryTable/summary",
            "aoColumns": [
                {mData: 'commodity'},
                {mData: 'allocated'},
                {mData: 'balance'},
                {mData: 'mos'},
                {mData: 'year'},
                {mData: 'month'}
            ]

        });

        charts = ['stock_status_trend_chart', 'drug_consumption_allocation_trend_chart', 'reporting_rates_chart', 'patients_by_regimen_chart']

        //Add filter to chart then load chart
        setChartFilter('drug_consumption_allocation_trend_chart', drugListURL)

        //Load Charts
        $.each(charts, function (key, chartName) {
            LoadChart('#' + chartName, chartURL, chartName, {})
        });

        //Show dashboard sidemenu
        $(".dashboard").closest('ul').addClass("in");
        $(".dashboard").addClass("active active-page");

        //Filter click Event
        $("#btn_filter").on("click", MainFilterHandler);

        //Clear click Event
        $("#btn_clear").on("click", ClearBtnHandler);


        $.getJSON(drugListURL, function (resp) {
            $('#filter_item').empty();
            $.each(resp, function (i, d) {
                $('#filter_item').append('<option value="' + d.name + '">' + d.name + '</option>');
            });
        }, 'json').done(function () {
            $('#filter_item').multiselect({
                enableFiltering: true,
                filterBehavior: 'value'
            });

        });





        function setChartFilter(chartName, filterURL) {
            $.ajax({
                url: filterURL,
                datatype: 'JSON',
                success: function (data) {
                    filterID = '#' + chartName + '_filter'
                    //Create multiselect box
                    CreateSelectBox(filterID, '100%', 10)
                    //Add data to selectbox
                    $(filterID + " option").remove();
                    $.each(data, function (i, v) {
                        $(filterID).append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
                    });
                    $(filterID).multiselect('rebuild');
                    $(filterID).data('filter_type', 'drug');
                },
                complete: function () {
                    LoadChart('#' + chartName, chartURL, chartName, {})
                }
            });
        }

        function CreateSelectBox(elementID, width, limit) {
            $(elementID).val('').multiselect({
                enableCaseInsensitiveFiltering: true,
                enableFiltering: true,
                disableIfEmpty: true,
                maxHeight: 300,
                buttonWidth: width,
                nonSelectedText: 'None selected',
                includeSelectAllOption: false,
                selectAll: false,
                onChange: function (option, checked) {
                    //Get selected options.
                    var selectedOptions = $(elementID + ' option:selected');
                    if (selectedOptions.length >= limit) {
                        //Disable all other checkboxes.
                        var nonSelectedOptions = $(elementID + ' option').filter(function () {
                            return !$(this).is(':selected');
                        });
                        nonSelectedOptions.each(function () {
                            var input = $('input[value="' + $(this).val() + '"]');
                            input.prop('disabled', true);
                            input.parent('li').addClass('disabled');
                        });
                    } else {
                        //Enable all checkboxes.
                        $(elementID + ' option').each(function () {
                            var input = $('input[value="' + $(this).val() + '"]');
                            input.prop('disabled', false);
                            input.parent('li').addClass('disabled');
                        });
                    }
                }
            });
        }

        function LoadSpinner(divID) {
            var spinner = new Spinner().spin()
            $(divID).empty('')
            $(divID).height('auto')
            $(divID).append(spinner.el)
        }

        function LoadChart(divID, chartURL, chartName, selectedfilters) {
            //Load Spinner
            LoadSpinner(divID)
            //Load Table

            //Load Chart*
            $(divID).load(chartURL, {'name': chartName, 'selectedfilters': selectedfilters}, function () {
                //Pre-select filters for charts
                $.each($(divID + '_filters').data('filters'), function (key, data) {
                    if ($.inArray(key, ['data_year', 'data_month', 'data_date', 'county', 'subcounty']) == -1) {
                        $(divID + "_filter").val(data).multiselect('refresh');
                        //Output filters
                        var filtermsg = '<b><u>' + key.toUpperCase() + ':</u></b><br/>'
                        if ($.isArray(data)) {
                            filtermsg += data.join('<br/>')
                        } else {
                            filtermsg += data
                        }
                        $("." + chartName + "_heading").html(filtermsg)
                    }
                });
            });
        }


        function MainFilterHandler(e) {
            var filter_year = year;
            var filter_month = month;

            //Add filters to request
            filters['data_year'] = filter_year;
            filters['data_month'] = filter_month;
            filters['drugs'] = drug;


            if ($("#filter_item").val() != null) {
                filters[$("#filter_item").data("filter_type")] = $("#filter_item").val()
            }

            if (filters['data_year'] != '' || filters['data_month'] != '')
            {
                $('#summaryTable').DataTable().destroy();
                $('#summaryTable > tbody').empty();

                $('#summaryTable').DataTable({

                    "bProcessing": true,
                    "order": [[3, "desc"]],
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "searching": false,
                    "ajax": {type:'post',url:"<?= base_url(); ?>manager/orders/getSummaryTable/summary",data:filters},
                    "aoColumns": [
                        {mData: 'commodity'},
                        {mData: 'allocated'},
                        {mData: 'balance'},
                        {mData: 'mos'},
                        {mData: 'year'},
                        {mData: 'month'}
                    ]

                });


                //Load charts
                $.each(charts, function (key, chartName) {
                    chartID = '#' + chartName
                    LoadChart(chartID, chartURL, chartName, filters)

                });
            } else {
                alert('Filter Year or Month cannot be Blank!')
            }
        }

        function MainClearHandler(e) {
            //Clear filters
            filters = {}
            //Get default month and year
            $.getJSON(LatestDateURL, function (data) {
                //Set hidden values
                $("#filter_month").val(data.month)
                $("#filter_year").val(data.year)
                //Display labels
                $(".filter-month[data-value='" + data.month + "']").addClass("active-tab");
                $(".filter-year[data-value='" + data.year + "']").addClass("active-tab");
                //Clear filter_item dropdown multi-select
                $('#filter_item option:selected').each(function () {
                    $(this).prop('selected', false);
                });
                //Set default drug dropdeon
                $('#filter_item').val(data.drug).multiselect('refresh');
                //Trigger filter event
                $("#btn_filter").trigger("click");
            });
        }


        function FilterBtnHandler(e) {
            var filterName = String($(e.target).attr("id")).replace('_btn', '')
            var filterID = "#" + filterName
            var filterType = $(filterID).data('filter_type')
            var chartName = filterName.replace('_filter', '')
            var chartID = "#" + chartName


            if ($(filterID).val() != null) {
                filters[filterType] = $(filterID).val()
            }

            LoadChart(chartID, chartURL, chartName, filters)

            //Hide Modal
            $(filterID + '_modal').modal('hide')
        }

        function ClearBtnHandler(e) {
            var filterName = String($(e.target).attr("id")).replace('_clear_btn', '')
            var filterID = "#" + filterName
            var filterType = $(filterID).data('filter_type')

            //Clear filterType
            filters[filterType] = {}

            //Filter multiple multiselect
            $(filterID).multiselect('deselectAll', false);
            $(filterID).multiselect('updateButtonText');
            $(filterID).multiselect('refresh');

            //Trigger filter event
            $(filterID + '_btn').trigger('click');
        }
    });
</script>
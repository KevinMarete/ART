<style type="text/css">
    .active-tab{
        color:red;
    }
</style>
<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Procurement</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>

            </ol>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-collapse collapse" id="navbar-filter">
                        <div class="navbar-form" role="search">
                            <div class="form-group">
                                <select id="filter_item" size="2" name="filter_item[]" data-filter_type="" class="form-control"></select>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> AVERAGE CONSUMPTION/ISSUES TREND
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#consumption_issues_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="consumption_issues_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="consumption_issues_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> ACTUAL CONSUMPTION/ISSUES TREND
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#actual_consumption_issues_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="actual_consumption_issues_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="actual_consumption_issues_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> KEMSA STOCK ON HAND(SOH) TREND
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#kemsa_soh_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="kemsa_soh_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="kemsa_soh_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> ADULT PATIENTS ON SELECTED DRUG
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#adult_patients_on_drug_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="adult_patients_on_drug_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="adult_patients_on_drug_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> PAEDIATRIC PATIENTS ON SELECTED DRUG
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#paed_patients_on_drug_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="paed_patients_on_drug_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="paed_patients_on_drug_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> STOCK STATUS
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#stock_status_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="stock_status_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="stock_status_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> EXPECTED DELIVERY
                            <div class="nav navbar-right">
                                <button data-toggle="modal" data-target="#expected_delivery_chart_filter_modal" class="btn btn-warning btn-xs">
                                    <span class="glyphicon glyphicon-filter"></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="expected_delivery_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <span class="expected_delivery_chart_heading heading"></span>
                        </div>
                    </div>
                </div>
            </div><!--/row-->
        </div><!--/col-lg-12-->
    </div><!--/row-->

    <!--modal(s)-->
    <div class="modal fade" id="consumption_issues_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>AVERAGE CONSUMPTION/ISSUES TREND FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="consumption_issues_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="consumption_issues_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="consumption_issues_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="actual_consumption_issues_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>ACTUAL CONSUMPTION/ISSUES TREND FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="actual_consumption_issues_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="actual_consumption_issues_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="actual_consumption_issues_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kemsa_soh_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>KEMSA STOCK ON HAND(SOH) TREND FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="kemsa_soh_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="kemsa_soh_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="kemsa_soh_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="adult_patients_on_drug_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>ADULT PATIENTS ON SELECTED DRUG FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="adult_patients_on_drug_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="adult_patients_on_drug_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="adult_patients_on_drug_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paed_patients_on_drug_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>PAED PATIENTS ON SELECTED DRUG FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="paed_patients_on_drug_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="paed_patients_on_drug_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="paed_patients_on_drug_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="stock_status_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>STOCK STATUS FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="stock_status_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="stock_status_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="stock_status_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="expected_delivery_chart_filter_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>EXPECTED DELIVERY FILTER</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <select id="expected_delivery_chart_filter" data-filter_type="drug" size="2"></select>
                        </div>
                        <div class="col-sm-3">
                            <button id="expected_delivery_chart_filter_clear_btn" class="btn btn-danger btn-xs clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                            <button id="expected_delivery_chart_filter_btn" class="btn btn-warning btn-xs filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!--end page wrapper--->

<script>
    var chartURL = '../../Manager/Procurement/get_chart'
    var drugListURL = '../../API/drug/list'
    var LatestDateURL = '../../Manager/Procurement/get_default_period'
    var charts = ['consumption_issues_chart', 'actual_consumption_issues_chart', 'kemsa_soh_chart', 'adult_patients_on_drug_chart', 'paed_patients_on_drug_chart', 'stock_status_chart', 'expected_delivery_chart']
    var filters = {}
    $(document).ready(function () {
        //Show dashboard sidemenu
        $(".tracker").closest('ul').addClass("in");
        $(".tracker").addClass("active active-page");
        //Load Main filter
        setMainFilter(drugListURL);
        //Load Charts
        $.each(charts, function (key, chartName) {
            setChartFilter(chartName, drugListURL);
        });
        //Filter click Event
        $(".filter_btn").on("click", FilterBtnHandler);
        //Clear click Event
        $(".clear_btn").on("click", ClearBtnHandler);
        //Year click event
        $(".filter-year").on("click", function () {
            $("#filter_year").val($(this).data("value"))
        });
        //Month click event
        $(".filter-month").on("click", function () {
            $("#filter_month").val($(this).data("value"))
        });
        //Main filter click event
        $("#btn_filter").on("click", MainFilterHandler);
        //Main clear click event 
        $("#btn_clear").on("click", MainClearHandler);
    });

    function setMainFilter(filterURL) {
        $.getJSON(filterURL, function (data) {
            //Create multiselect box
            CreateSelectBox("#filter_item", "250px", 10)
            //Add data to selectbox
            $("#filter_item option").remove();
            $.each(data, function (i, v) {
                $("#filter_item").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
            });
            $('#filter_item').multiselect('rebuild');
            $("#filter_item").data('filter_type', 'drug');
            //Set default period
            setDefaultPeriod(LatestDateURL)
        });
    }

    function setDefaultPeriod(URL) {
        $.getJSON(URL, function (data) {
            //Remove active-tab class
            $(".filter-year").removeClass('active-tab')
            $(".filter-month").removeClass('active-tab')
            //Set hidden values
            $("#filter_month").val(data.month)
            $("#filter_year").val(data.year)
            //Display labels
            $(".filter-month[data-value='" + data.month + "']").addClass("active-tab");
            $(".filter-year[data-value='" + data.year + "']").addClass("active-tab");
            //Dropdown tab filters
            $('#filter_item').val(data.drug).multiselect('refresh');
        });
    }

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

    function getMonth(monthStr) {
        monthval = new Date(monthStr + '-1-01').getMonth() + 1
        return ('0' + monthval).slice(-2)
    }

    function MainFilterHandler(e) {
        var filter_year = $("#filter_year").val()
        var filter_month = $("#filter_month").val()

        //Add filters to request
        filters['data_year'] = filter_year
        filters['data_month'] = filter_month
        filters['data_date'] = filter_year + '-' + getMonth(filter_month) + '-01'

        if ($("#filter_item").val() != null) {
            filters[$("#filter_item").data("filter_type")] = $("#filter_item").val()
        }

        if (filters['data_year'] != '' || filters['data_month'] != '')
        {
            //Load charts
            $.each(charts, function (key, chartName) {
                chartID = '#' + chartName
                LoadChart(chartID, chartURL, chartName, filters)
                //Remove active-tab class
                $(".filter-year").removeClass('active-tab')
                $(".filter-month").removeClass('active-tab')
                //Set colors for filters
                $(".filter-year[data-value='" + $("#filter_year").val() + "']").addClass("active-tab")
                $(".filter-month[data-value='" + $("#filter_month").val() + "']").addClass("active-tab")
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
</script>
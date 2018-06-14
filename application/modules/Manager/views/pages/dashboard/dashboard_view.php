<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <?php echo $this->session->flashdata('dashboard_msg'); ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
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
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="drug_consumption_allocation_trend_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Facility ADT Version Distribution
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="facility_adt_version_distribution_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Facility Internet Access
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="facility_internet_access_chart"></div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
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
<script>
    $(document).ready(function () {
        var chartURL = '../Manager/get_chart'
        var charts = ['reporting_rates_chart', 'patients_by_regimen_chart', 'drug_consumption_allocation_trend_chart', 'facility_adt_version_distribution_chart', 'facility_internet_access_chart']

        //Load Charts
        $.each(charts, function(key, chartName) {
            LoadChart('#'+chartName, chartURL, chartName, {})
        });

        //Show dashboard sidemenu
        $(".dashboard").closest('ul').addClass("in");
        $(".dashboard").addClass("active active-page");
    });

    function LoadSpinner(divID){
        var spinner = new Spinner().spin()
        $(divID).empty('')
        $(divID).height('auto')
        $(divID).append(spinner.el)
    }

    function LoadChart(divID, chartURL, chartName, selectedfilters){
        //Load Spinner
        LoadSpinner(divID)
        //Load Chart*
        $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters});
    }
</script>
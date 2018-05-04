<div role="tabpanel" class="tab-pane" id="adt_reports">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!--adt_reports_patients_started_art_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>PATIENT(S) STARTED ON ART</strong>
                        <div class="nav navbar-right">
                            <button data-toggle='modal' data-target='#adt_reports_patients_started_art_chart_filter_modal' class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_patients_started_art_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_patients_started_art_chart_heading heading"></span>
                    </div>
                </div>
            </div>
            <!--adt_reports_active_patients_regimen_chart-->
            <div class="col-md-6">
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>ACTIVE PATIENT(S) BY REGIMEN</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_active_patients_regimen_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_active_patients_regimen_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_active_patients_regimen_chart_heading heading"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!--commodity_consumption_regimen_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>COMMODITY CONSUMPTION BY REGIMEN</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_commodity_consumption_regimen_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_commodity_consumption_regimen_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_commodity_consumption_regimen_visit_chart_heading heading"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!--commodity_consumption_drug_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>COMMODITY CONSUMPTION BY DRUG</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_commodity_consumption_drug_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_commodity_consumption_drug_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_commodity_consumption_drug_chart_heading heading"></span>
                    </div>
                </div>
            </div>
        </div>

        <!--patients commodity and dosing-->
        <div class="row">
            <div class="chart-wrapper">
                <div class="chart-title">
                    <strong>COMMODITY CONSUMPTION BY DOSE</strong>
                    <div class="nav navbar-right">
                        <button data-toggle="modal" data-target="#adt_reports_patients_commodity_dosing_chart_filter_modal" class="btn btn-warning btn-xs">
                            <span class="glyphicon glyphicon-filter"></span>
                        </button>
                    </div>
                </div>
                <div class="chart-stage">
                    <div id="adt_reports_commodity_consumption_dose_chart"></div>
                </div>
                <div class="chart-notes">
                    <span class="adt_reports_patients_commodity_dosing_chart_heading heading"></span>
                </div>
            </div>
        </div>

        <!--commodity_consumption_chart-->
        <div class="row">
            <div class="col-sm-12">
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>COMMODITY CONSUMPTION OVER TIME</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_commodity_consumption_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_commodity_consumption_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_commodity_consumption_chart heading"></span>
                    </div>
                </div>
            </div>
        </div>

        <!--modal(s)-->
        <!--Patients Started Art filter-->
        <div class="modal fade" id="patients_started_art_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Patients Started On Art</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <select id="patients_started_art_chart_filter" multiple="multiple" data-filter_type="regimen"></select>
                            </div>
                            <div class="col-md-3">
                                <button id="patients_started_art_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span>Reset</button>
                                <button id="patients_started_art_chart_filter_btn" class=" btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span>Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Patients Active regimen filter-->
        <div class="modal fade" id="patients_active_regimen_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Active Patients By Regimen</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <select id="patients_active_regimen_chart_filter" multiple="multiple" data-filter_type="regimen"></select>
                            </div>
                            <div class="col-md-3">
                                <button id="patients_active_regimen_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span>Reset</button>
                                <button id="patients_active_regimen_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span>Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--commodity consumption based on Current Regimen (visit)-->
        <div class="modal fade" id="commodity_consumption_regimen_visit_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Commodity Consumption Based On Current Regimen (Visit)</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <select id="commodity_consumption_regimen_visit_chart_filter" size="1" data-filter_type="current_regimen"></select>
                            </div>
                            <div class="col-md-3">
                                <button id="commodity_consumption_regimen_visit_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="commodity_consumption_regimen_visit_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--commodity consumption based on Drug (visit)-->
        <div class="modal fade" id="commodity_consumption_drug_visit_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Commodity Consumption Based On Drug (Visit)</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <select id="commodity_consumption_drug_visit_chart_filter" size="1" data-filter_type="drug"></select>
                            </div>
                            <div class="col-md-3">
                                <button id="commodity_consumption_drug_visit_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="commodity_consumption_drug_visit_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Patients Commodity and dosing filter-->
        <div class="modal fade" id="patients_commodity_dosing_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Patients Commodity and Dosing</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <select id="patients_commodity_dosing_chart_filter" size="1" data-filter_type="drug"></select>
                            </div>
                            <div class="col-md-4">
                                <button id="patients_commodity_dosing_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="patients_commodity_dosing_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adt_reports_commodity_consumption_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Commodity Consumption Over Time</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <select id="adt_reports_commodity_consumption_chart_filter" multiple="multiple" data-filter_type="regimen"></select>
                            </div>
                            <div class="col-md-3">
                                <button id="adt_reports_commodity_consumption_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span>Reset</button>
                                <button id="adt_reports_commodity_consumption_chart_filter_btn" class=" btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span>Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
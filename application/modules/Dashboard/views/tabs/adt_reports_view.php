<div role="tabpanel" class="tab-pane" id="adt_reports">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
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
            <div class="col-sm-6">
                <!--adt_reports_active_patients_regimen_chart-->
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
            <div class="col-sm-6">
                <!--adt_reports_commodity_consumption_regimen_chart-->
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
                        <span class="adt_reports_commodity_consumption_regimen_chart_heading heading"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!--adt_reports_commodity_consumption_drug_chart-->
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
        <div class="row">
            <div class="col-sm-6">
                <!--adt_reports_commodity_consumption_dose_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>COMMODITY CONSUMPTION BY DOSE</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_commodity_consumption_dose_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_commodity_consumption_dose_chart"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_reports_commodity_consumption_dose_chart_heading heading"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!--adt_reports_paediatric_weight_age_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>PAEDIATRIC PATIENTS BY WEIGHT AND AGE</strong>
                        <div class="nav navbar-right">
                            <button data-toggle="modal" data-target="#adt_reports_paediatric_weight_age_chart_filter_modal" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        </div>
                    </div>
                    <div class="chart-stage">
                        <div id="adt_reports_paediatric_weight_age_chart"></div>
                    </div>                  
                    <div class="chart-notes">
                        <span class="adt_reports_paediatric_weight_age_chart_heading heading"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!--adt_reports_commodity_consumption_chart-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>COMMODITY CONSUMPTION TREND</strong>
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
                        <span class="adt_reports_commodity_consumption_chart_heading heading"></span>
                    </div>
                </div>
            </div>
        </div>
        <!--modal(s)-->
        <div class="modal fade" id="adt_reports_patients_started_art_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>PATIENT(S) STARTED ON ART FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_patients_started_art_chart_filter" multiple="multiple" data-filter_type="start_regimen"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_patients_started_art_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_patients_started_art_chart_filter_btn" class=" btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adt_reports_active_patients_regimen_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>ACTIVE PATIENT(S) BY REGIMEN FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_active_patients_regimen_chart_filter" multiple="multiple" data-filter_type="current_regimen"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_active_patients_regimen_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_active_patients_regimen_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adt_reports_commodity_consumption_regimen_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>COMMODITY CONSUMPTION BY REGIMEN FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_commodity_consumption_regimen_chart_filter" size="2" data-filter_type="drug"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_commodity_consumption_regimen_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_commodity_consumption_regimen_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adt_reports_commodity_consumption_drug_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>COMMODITY CONSUMPTION BY DRUG FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_commodity_consumption_drug_chart_filter" size="2" data-filter_type="current_regimen"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_commodity_consumption_drug_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_commodity_consumption_drug_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adt_reports_commodity_consumption_dose_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>COMMODITY CONSUMPTION BY DOSE FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_commodity_consumption_dose_chart_filter" size="2" data-filter_type="drug"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_commodity_consumption_dose_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_commodity_consumption_dose_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adt_reports_paediatric_weight_age_chart_filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>PAEDIATRIC PATIENTS BY WEIGHT AND AGE FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_paediatric_weight_age_chart_filter" multiple="multiple" data-filter_type="drug"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_paediatric_weight_age_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_paediatric_weight_age_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
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
                        <h4 class="modal-title"><strong>COMMODITY CONSUMPTION TREND FILTER</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <select id="adt_reports_commodity_consumption_chart_filter" multiple="multiple" data-filter_type="drug"></select>
                            </div>
                            <div class="col-sm-3">
                                <button id="adt_reports_commodity_consumption_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                                <button id="adt_reports_commodity_consumption_chart_filter_btn" class=" btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
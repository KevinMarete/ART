var countyURL = 'API/county'
var drugListURL = 'API/drug/list'
var charts = ['patient_scaleup_chart', 'patient_services_chart', 'national_mos_chart']

$(function() {
    //Get counties
    $.getJSON(countyURL, function(data){
		$("#filter_item option").remove();
		$.each(data, function(i, v) {
			$("#filter_item").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
        });
        $('#filter_item').multiselect('rebuild');
        $("#filter_item").data('filter_type', 'county')
    });

    //Set national_mos_chart_filter
    $('#national_mos_chart_filter').multiselect({
        disableIfEmpty: true,
        enableFiltering: true,
        maxHeight: 200,
        buttonWidth: '400px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,
    });

    //Get drugs to national_mos_chart_filter
    $.getJSON(drugListURL, function(data){
        $("#national_mos_chart_filter option").remove();
        $.each(data, function(i, v) {
            $("#national_mos_chart_filter").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
        });
        $('#national_mos_chart_filter').multiselect('rebuild');
        $("#national_mos_chart_filter").data('filter_type', 'drug')
    }).promise().done(function () { 
        //Load charts
        $.each(charts, function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    });

    //Filter mos_chart
    $("#national_mos_chart_filter_btn").click(function(){
        getMOSChart()
    });

    //Clear national_mos_chart_filter
    $("#national_mos_chart_filter_clear_btn").click(function(){
        //Clear drug filter
        filters['drug'] = {}

        //Clear filter_item dropdown multi-select
        $('#national_mos_chart_filter option:selected').each(function() {
            $(this).prop('selected', false);
        });
        $('#national_mos_chart_filter').multiselect('refresh');

        //Refresh mos_chart
        getMOSChart()
    });

});

function getMOSChart(){
    //Add filters to request
    filters['data_year'] = $("#filter_year").val()
    filters['data_month'] = $("#filter_month").val()
    filters['data_date'] = $("#filter_year").val() + '-' + getMonth($("#filter_month").val()) + '-01'

    if($("#national_mos_chart_filter").val() != null){
        filters['drug'] = $("#national_mos_chart_filter").val()
    }

    if(filters['data_year'] != '' || filters['data_month'] != '')
    {   
        chartName = 'national_mos_chart';
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, filters)
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab')
        $(".filter-month").removeClass('active-tab')
        //Set colors for filters
        $(".filter-year[data-value='" +  $("#filter_year").val() + "']").addClass("active-tab")
        $(".filter-month[data-value='" + $("#filter_month").val() + "']").addClass("active-tab")
    }else{
        alert('Filter Year or Month cannot be Blank!')
    }

    //Hide Modal
    $('#national_mos_chart_filter_modal').modal('hide')
}
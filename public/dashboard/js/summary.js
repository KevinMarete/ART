var countyURL = 'API/county'
var drugListURL = 'API/drug/list'
var charts = ['patient_scaleup_chart', 'patient_services_chart', 'national_mos_chart']

$(function() {
    //Load charts
    $.each(charts, function(key, chartName) {
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, filters)
    });

    //Get counties
    $.getJSON(countyURL, function(data){
		$("#filter_item option").remove();
		$.each(data, function(i, v) {
			$("#filter_item").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
        });
        $('#filter_item').multiselect('rebuild');
        $("#filter_item").data('filter_type', 'county')
    });

    //Set mos drug filter
    $('#mos_filter').multiselect({
        disableIfEmpty: true,
        enableFiltering: true,
        maxHeight: 200,
        buttonWidth: '400px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,
    });

    //Get drugs to mos_filter
    $.getJSON(drugListURL, function(data){
        $("#mos_filter option").remove();
        $.each(data, function(i, v) {
            $("#mos_filter").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
        });
        $('#mos_filter').multiselect('rebuild');
        $("#mos_filter").data('filter_type', 'drug')
    });

    //Filter mos_chart
    $("#mos_fimos_filter_btnlter").click(function(){
        //Add filters to request
        filters['data_year'] = $("#filter_year").val()
        filters['data_month'] = $("#filter_month").val()
        filters['data_date'] = $("#filter_year").val() + '-' + getMonth($("#filter_month").val()) + '-01'

        if($("#mos_filter").val() != null){
            filters['drug'] = $("#mos_filter").val()
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
    });

    //Clear mos_filter




});
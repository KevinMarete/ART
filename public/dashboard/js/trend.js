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
        $.each(charts['trend'], function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    });

    $('#drugs').multiselect({
        disableIfEmpty: true,
        enableFiltering: true,
        maxHeight: 200,
        buttonWidth: '400px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,  
    });
    // reset button
    $('#trend_view_filter_frm').on('reset', function() {
        $('#drugs option:selected').each(function() {
            $(this).prop('selected', false);
        })

        $('#drugs').multiselect('refresh');
    });

    $('#regimen').multiselect({
        disableIfEmpty: true,
        enableFiltering: true,
        maxHeight: 200,
        buttonWidth: '400px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,
    });

    $('#commodity_stock').multiselect({
        disableIfEmpty: true,
        enableFiltering: true,
        maxHeight: 200,
        buttonWidth: '400px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,

        on: {
            change: function(option, checked) {
                var values = [];
                $('#commodity_stock option').each(function() {
                    if ($(this).val() !== option.val()) {
                        values.push($(this).val());
                    }
                });

                $('#commodity_stock').multiselect('deselect', values);
            }
        }
    });

});
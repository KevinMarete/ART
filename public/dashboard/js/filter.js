$(function() {
    //Set dropdown multislect
    $('#filter_item').multiselect({
        nonSelectedText: 'National',
        maxHeight: 600,
        enableFiltering: true,
        buttonWidth: '250px',
        includeSelectAllOption: true,
        selectAllNumber: true,
        enableCaseInsensitiveFiltering: true,
        enableFullValueFiltering: true,
    });

    //Set filters
    $('#btn_filter').click(function(){
        filterRequest()
    });

    //Clear filters
    $('#btn_clear').click(function(){
        clearRequest()
    });

    //Set year on filter*
    $('.filter-year').on('click', function(){
        $("#filter_year").val($(this).data('value'))
    });

    //Set month on filter
    $('.filter-month').on('click', function(){
        $("#filter_month").val($(this).data('value'))
    });

});

function filterRequest(){
    //Add filters to request
    filters['data_year'] = $("#filter_year").val()
    filters['data_month'] = $("#filter_month").val()
    filters['data_date'] = $("#filter_year").val() + '-' + getMonth($("#filter_month").val()) + '-01'

    if($("#filter_item").val() != null){
        filters[$("#filter_item").data('filter_type')] = $("#filter_item").val()
    }

    if(filters['data_year'] != '' || filters['data_month'] != '')
    {   
        //Load charts
        $.each(charts, function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
            //Remove active-tab class
            $(".filter-year").removeClass('active-tab')
            $(".filter-month").removeClass('active-tab')
            //Set colors for filters
            $(".filter-year[data-value='" +  $("#filter_year").val() + "']").addClass("active-tab")
            $(".filter-month[data-value='" + $("#filter_month").val() + "']").addClass("active-tab")
        });
    }else{
        alert('Filter Year or Month cannot be Blank!')
    }
}

function getMonth(monthStr){
    return new Date(monthStr+'-1-01').getMonth()+1
}

function clearRequest(){
    //Clear filters
    var filters = {}
    //Get default month and year
    $.getJSON(LatestDateURL, function(data){
        //Set hidden values
        $("#filter_month").val(data.month)
        $("#filter_year").val(data.year)
        //Display labels
        $(".filter-month[data-value='" + data.month + "']").addClass("active-tab"); 
        $(".filter-year[data-value='" + data.year + "']").addClass("active-tab"); 
        //Clear filter_item dropdown multi-select
        $('#filter_item option:selected').each(function() {
            $(this).prop('selected', false);
        });
        $('#filter_item').multiselect('refresh');
        //Set filters
        filterRequest();
    });
}
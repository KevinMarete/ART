var chartURL = 'dashboard/get_chart'
var filterURL = 'dashboard/get_filter/'
var filterDIVClass = '.auto_filter'
var tab = 'commodities'
var filters = {}
var charts = []
charts['commodities'] = ['national_mos', 'drug_consumption_trend']
charts['patients'] = ['patient_in_care', 'patient_regimen_category', 'art_scaleup']

$(function() {
    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        chartHeadingClass = '.'+chartName+'_heading'
        LoadChart(chartID, chartURL, chartName, filters)
        //LoadHeading(chartHeadingClass, order, limit)
    });
    /*Tab Change Event*/
    $("#main_tabs a").on("click", TabFilterHandler);
    /*Load Filters on Filter Modal Show Event*/
    $('#filterModal').on('show.bs.modal', LoadFilterHandler);
    /*ChartFilter Change Event*/
    $("#filter_btn").on("click", ChartFilterHandler);
    /*Clear Filter Click Event*/
    $(".clear_filter_btn").on("click", ClearFilterHandler)
});

function LoadChart(divID, chartURL, chartName, selectedfilters){
    /*Load Spinner*/
    LoadSpinner(divID)
    /*Load Chart*/
    $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters})
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

/*
function LoadHeading(spanClass, order, limit){
    var titles = new Array();
    titles['desc'] = 'Top'
    titles['asc'] = 'Bottom'
    message = titles[order]+' '+limit
    $(spanClass).text(message)
}*/

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href')
    var filters = {}
    tab = filtername.replace('#','')

    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        chartHeadingClass = '.'+chartName+'_heading'
        LoadChart(chartID, chartURL, chartName, filters)
        //LoadHeading(chartHeadingClass, order, limit)
    });
}

function LoadFilterHandler(e){
    var chartName = e.relatedTarget.id.replace('_filter','')
    var current_filter = $("#filter_btn").attr('data-filter')
    if(current_filter != chartName){
        /*Clear previous filter*/
        ClearFilterData()
        /*Load previous unfiltered chart*/
        ChartFilterHandler()
        /*Load Spinner*/
        LoadSpinner(filterDIVClass)
        /*Append chart filter name to modal*/
        var filter_text = toTitleCase(chartName.replace(/_/g,' '))
        $('.filter_text').html(filter_text)
        //Get filters and content
        $.getJSON(filterURL+chartName, function(filters) {
            //Clear Spinner
            $(filterDIVClass).html('');
            $.each(filters, function(filter, filter_values){
                var filterhtml = '';
                var filtername = filter.replace(/DATA|_/gi,' ').toUpperCase();
                filterhtml += '<div class="form-group">'
                filterhtml += '<label for="'+filter+'" class="col-sm-2 control-label">'+filtername+'</label>'
                filterhtml += '<div class="col-sm-8">'
                filterhtml += '<select class="form-control filter '+filter+'" multiple="multiple" id="'+filter+'">'
                filterhtml += '</select></div></div>';
                //Append filter to DOM
                $('.auto_filter').append(filterhtml);
                LoadSelectBox('.'+filter, filter_values, 'classic')
            });
        });
        //Add chartName to filter_btn
        $("#filter_btn").attr('data-filter', chartName)
    }
}

function LoadSelectBox(divClass, data, theme){
    $(divClass).select2({
        theme: theme,
        data: data,
        tags: true
    })
}

function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function(match) {
        return match.toUpperCase();
    });
}

function ChartFilterHandler(e){
    var chartName = $("#filter_btn").attr('data-filter')
    var chartHeadingClass = '.'+chartName+'_heading'
    var chartID = '#'+chartName+'_chart'
    /*Reset filters array*/
    filters = {}
    /*Dynamic filters*/
    $('.filter').each(function() {
        var element = $(this)
        var filterData = element.val()
        if(filterData != null){
            filters[element.attr('id')] = filterData
        }
    }).promise().done(function () { 
        //Load Chart Heading
        //LoadHeading(chartHeadingClass, order, limit)
        //Load Chart
        LoadChart(chartID, chartURL, chartName, filters)
        //Close modal
        $('#filterModal').modal('hide');
    });
}

function ClearFilterHandler(e){
    var previousChartName = $("#filter_btn").attr('data-filter')
    var chartName = e.currentTarget.id.replace('_clear','')
    var filters_tmp = filters
    //Set new chartName
    $("#filter_btn").attr('data-filter', chartName)

    //Clear filter data fields
    ClearFilterData()

    //Click filter_btn
    $("#filter_btn").trigger('click');

    //Reset the previous chartname and selected_items
    if(previousChartName != chartName){
        filters = filters_tmp
        $.each(filters, function(element, values){
            $("#"+element).val(values).trigger("change");
        });
        $("#filter_btn").attr('data-filter', previousChartName)
    }

}

function ClearFilterData(){
    //Clear all filter elements
    filters = {}
    $(".filter").val(null).trigger("change");
}


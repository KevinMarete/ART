var chartURL = 'dashboard/load_chart'
var filterURL = 'dashboard/get_filter/'
var filterDIVClass = '.auto_filter'
var tab = 'commodities'
var metric = 'total'
var order = 'desc'
var limit = '5'
var exemptedTabs = ['upload']
var filters = []
var charts = []
charts['commodities'] = ['pipeline_consumption', 'facility_consumption', 'facility_soh']
charts['patients'] = ['adult_art', 'paed_art', 'oi', 'patient_regimen_category', 'patient_site']

$(function() {
    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        LoadChart(chartID, chartURL, chartName, metric, filters, order, limit)
    });
    /*Load Chart Heading*/
    LoadHeading('.heading', order, limit)
    /*Tab Change Event*/
    $("#main_tabs a").on("click", TabFilterHandler);
    /*Load Filters on Filter Modal Show Event*/
    $('#filterModal').on('show.bs.modal', LoadFilters);
    /*ChartFilter Change Event*/
    $("#filter_btn").on("click", ChartFilterHandler);
    /*Clear Filter Click Event*/
    $(".clear_filter_btn").on("click", ClearFilterHandler)
});

function LoadChart(divID, chartURL, chartName, metric, selectedcharts, order, limit){
    /*Load Spinner*/
    LoadSpinner(divID)
    /*Load Chart*/
    $(divID).load(chartURL, {'name':chartName, 'metric': metric, 'selectedcharts': selectedcharts, 'order':order, 'limit':limit})
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function LoadHeading(spanClass, order, limit){
    var titles = new Array();
    titles['desc'] = 'Top'
    titles['asc'] = 'Bottom'
    message = titles[order]+' '+limit
    $(spanClass).text(message)
}

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href')
    tab = filtername.replace('#','')
    if($.inArray(tab, exemptedTabs) == -1){ 
        /*Load Charts*/
        $.each(charts[tab], function(key, chartName) {
            chartID = '#'+chartName+'_chart'
            LoadChart(chartID, chartURL, chartName, metric, filters, order, limit)
        });
    }
}

function LoadFilters(e){
    var chartName = e.relatedTarget.id.replace('_filter','')
    /*Load Spinner*/
    LoadSpinner(filterDIVClass)
    /*Append chart filter name to modal*/
    
    var filter_text = chartName.replace(/_/g,' ').toUpperCase()
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
}

function LoadSelectBox(divClass, data, theme){
    $(divClass).select2({
        theme: theme,
        data: data,
        tags: true
    })
}

function ChartFilterHandler(){
    //Main charts
    var metric = $('.metric').val()
    var order = $('.order').val()
    var limit = $('.limit').val()
    //Dynamic charts
    var selectedcharts = {}
    //Combine and check Chartcharts and Customcharts
    $.each(charts[tab].concat(customcharts[tab]), function(i, v){
        if(v != 'metric'){
            var filterata = $('.'+v).val()
            if(filterata != null){
                selectedcharts[v] = filterata
            }
        }
    });
    //Load Chart Heading
    LoadHeading('.heading', order, limit)
    //Load Charts
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        LoadChart(chartID, chartURL, chartName, metric, selectedcharts, order, limit)
    });
    //Close modal
    $('#filterModal').modal('hide');
}

function ClearFilterHandler(){
    //Clear all filter elements
    $(".filter").val(null).trigger("change");
    //Clear DOM charts
    $('.metric').val(metric).trigger("change");
    $('.order').val(order).trigger("change");
    $('.limit').val(limit).trigger("change");
    //CLick filter_btn
    $(".filter_btn").trigger('click');
}


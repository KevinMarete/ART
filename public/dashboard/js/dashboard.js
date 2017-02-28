var chartURL = 'dashboard/load_chart'
var filterURL = 'dashboard/get_filter/'
var customfilterURL = 'dashboard/get_custom_filter/'
var tableURL = 'dashboard/get_table_data/'
var defaultTab = 'products'
var defaultMetric = 'quantity'
var defaultOrder = 'desc'
var defaultLimit = '5'
var defaultFilter = []
var filters = [] //Similar to charts
filters['products'] = ['atc_code', 'route', 'dosage_form', 'country', 'manufacturer', 'importer']
filters['premises'] = ['county', 'cadre']
var customFilters = [] //Custom filters
customFilters['products'] = ['data_month', 'data_year', 'metric']
customFilters['premises'] = ['data_year', 'metric']

$(function() {
    /*Load Chart Heading*/
    LoadHeading('.heading', defaultOrder, defaultLimit)
    /*Load Filters*/
    LoadFilters(defaultTab, filters[defaultTab])
    LoadSelectBox('.order', JSON.stringify([{ id: 'asc', text: 'Bottom' }]), 'classic')
    LoadSelectBox('.limit', JSON.stringify([{ id: '10', text: '10' }]), 'classic')
    /*Load Charts*/
    $.each(filters[defaultTab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        tableID = '#'+chartName+'_table'
        LoadChart(chartID, chartURL, chartName, defaultMetric, defaultFilter, defaultOrder, defaultLimit)
        LoadTable(tableID, tableURL, chartName, defaultMetric, defaultFilter)
    });
    /*ChartFilter Change Event*/
    $("#filter_btn").on("click", ChartFilterHandler);
    /*Tab Change Event*/
    $("#main_tabs a").on("click", TabFilterHandler);
    /*Clear Filter Click Event*/
    $("#clear_filter_btn").on("click", ClearFilterHandler)
});


function ClearFilterHandler(){
    //Clear all filter elements
    $(".filter").val(null).trigger("change");
    //Clear DOM filters
    $('.metric').val(defaultMetric).trigger("change");
    $('.order').val(defaultOrder).trigger("change");
    $('.limit').val(defaultLimit).trigger("change");
    //CLick filter_btn
    $("#filter_btn").trigger('click');
}

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href')
    defaultTab = filtername.replace('#','')
    /*Load Filters*/
    LoadFilters(defaultTab, filters[defaultTab])
    /*Load Charts*/
    $.each(filters[defaultTab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        tableID = '#'+chartName+'_table'
        LoadChart(chartID, chartURL, chartName, defaultMetric, defaultFilter, defaultOrder, defaultLimit)
        LoadTable(tableID, tableURL, chartName, defaultMetric, defaultFilter)
    });
}

function LoadFilters(tabname, chartFilters){
    var filterhtml = '';
    //Clear filterDIV
    $('.auto_filter').html(filterhtml);
    //Generate filter html content
    $.each(chartFilters, function(i, filter){
        //Chart filters
        var filtername = filter.replace('_',' ').toUpperCase();
        filterhtml += '<div class="form-group">'
        filterhtml += '<label for="'+filter+'" class="col-sm-2 control-label">'+filtername+'</label>'
        filterhtml += '<div class="col-sm-10">'
        filterhtml += ' <select class="form-control filter '+filter+'" multiple="multiple" id="'+filter+'"></select>'
        filterhtml += '</div>'
        filterhtml += '</div> ';
        //Load data
        $.get(filterURL+tabname+'/'+filter, function(data) {
            //Append data to Select2
            LoadSelectBox('.'+filter, data, 'classic')
        });
    }); 
    //Generate Custom filter html content
    $.each(customFilters[tabname], function(i, filter){
        //Price filter fix for premises tab
        if(filter == 'metric'){
            if(tabname == 'premises'){
                $(".metric option[value='price']").remove();
            }else{
                LoadSelectBox('.metric', JSON.stringify([{ id: 'price', text: 'Price' }]), 'classic')
            }
        }else{
            //Chart filters
            var filtername = filter.replace('data_',' ').toUpperCase();
            filterhtml += '<div class="form-group">'
            filterhtml += '<label for="'+filter+'" class="col-sm-2 control-label">'+filtername+'</label>'
            filterhtml += '<div class="col-sm-10">'
            filterhtml += ' <select class="form-control filter '+filter+'" multiple="multiple" id="'+filter+'"></select>'
            filterhtml += '</div>'
            filterhtml += '</div> ';
            //Load data
            $.get(customfilterURL+tabname+'/'+filter, function(data) {
                //Append data to Select2
                LoadSelectBox('.'+filter, data, 'classic')
            });
        }
    }); 
    //Append filters to DOM
    $('.auto_filter').html(filterhtml);
}

function LoadSelectBox(divClass, data, theme){
    $(divClass).select2({
        theme: theme,
        data: jQuery.parseJSON(data),
        width: '450px',
        tags: true
    })
}
    
function LoadChart(divID, chartURL, chartName, metric, selectedfilters, order, limit){
    /*Load Spinner*/
    LoadSpinner(divID)
    /*Load Chart*/
    $(divID).load(chartURL, {'name':chartName, 'metric': metric, 'selectedfilters': selectedfilters, 'order':order, 'limit':limit})
}

function LoadTable(tableID, tableURL, tableName, metric, selectedfilters){
    /*Load Spinner on table*/
    LoadSpinner(tableID)
    //Load Data
    $.ajax({
        'method': 'POST',
        'url': tableURL,
        'data': {'name':tableName, 'metric': metric, 'selectedfilters': selectedfilters},
        'success':function(data){
            //Clear table spinner
            $(tableID).empty('')
            //Load data to dataTable
            $(tableID).DataTable({
                "destroy": true,
                "data": $.parseJSON(data),
                columns: [
                    {title: tableName.toUpperCase()},
                    {title: metric.toUpperCase()}
                ]
            });
        }
    });
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function ChartFilterHandler(){
    //Main filters
    var metric = $('.metric').val()
    var order = $('.order').val()
    var limit = $('.limit').val()
    //Dynamic Filters
    var selectedfilters = {}
    //Combine and check ChartFilters and CustomFilters
    $.each(filters[defaultTab].concat(customFilters[defaultTab]), function(i, v){
        if(v != 'metric'){
            var filterata = $('.'+v).val()
            if(filterata != null){
                selectedfilters[v] = filterata
            }
        }
    });
    //Load Chart Heading
    LoadHeading('.heading', order, limit)
    //Load Charts
    $.each(filters[defaultTab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        tableID = '#'+chartName+'_table'
        LoadChart(chartID, chartURL, chartName, metric, selectedfilters, order, limit)
        LoadTable(tableID, tableURL, chartName, metric, selectedfilters)
    });
    //Close modal
    $('#filterModal').modal('hide');
}

function LoadHeading(spanClass, order, limit){
    var titles = new Array();
    titles['desc'] = 'Top'
    titles['asc'] = 'Bottom'
    message = titles[order]+' '+limit
    $(spanClass).text(message)
}
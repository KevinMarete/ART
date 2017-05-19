var chartURL = 'Dashboard/get_chart'
var filterURL = 'Dashboard/get_filter/'
var specificFilterURL = 'Dashboard/get_specific_filter/'
var filterDIVClass = '.auto_filter'
var tab = 'summary'
var filters = {}
var charts = []
charts['summary'] = ['patient_by_regimen', 'stock_status']
charts['commodities'] = ['national_mos', 'drug_consumption_trend']
charts['patients'] = ['patient_in_care', 'patient_regimen_category', 'nnrti_drugs_in_regimen', 'nrti_drugs_in_regimen', 'patient_scaleup']

$(function() {
    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        LoadChart(chartID, chartURL, chartName, filters)
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
    $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters}, function(){
        LoadHeading(chartName)
    });
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function LoadHeading(chartName){
    var chartHeadingClass = '.'+chartName+'_heading'
    var filter_length = $('.filter').length
    var current_filter = $("#filter_btn").attr('data-filter')
    var message = ''

    LoadSpinner(chartHeadingClass)
    
    if(filter_length > 0 && current_filter != ''){
        $('.filter').each(function() {
            var element = $(this)
            var filterData = element.val()
            var filterName = element.attr('id')
            if(filterData != null && filterData != 0){
                filterName = filterName.replace(/DATA|_/gi,' ')
                if($.isArray(filterData)){
                    message += '<br/><b><u>'+toTitleCase(filterName)+'</u></b><br/>'+filterData.join('<br/>');
                }else{
                    message += '<br/><b><u>'+toTitleCase(filterName)+'</u></b><br/>'+filterData;
                }
            }
        });
        $(chartHeadingClass).html(message) 
    }else{
        $.getJSON(filterURL+chartName, function(filters) {
            if(typeof Object.keys(filters.default) !== 'undefined' && Object.keys(filters.default).length > 0){
                $.each(filters.default, function(filter, filter_values){
                    filter = filter.replace(/DATA|_/gi,' ')
                    message += '<br/><b><u>'+toTitleCase(filter)+'</u></b><br/>'+filter_values.join('<br/>');
                });
            }else{
                message = 'No Filter!'
            }
            $(chartHeadingClass).html(message) 
        });
    }   
}

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href')
    var filters = {}
    tab = filtername.replace('#', '')

    //Reset filter identifier
    $("#filter_btn").attr('data-filter', '')

    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName+'_chart'
        LoadChart(chartID, chartURL, chartName, filters)
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
        $.getJSON(filterURL+chartName+'/0', function(filters) {
            //Clear Spinner
            $(filterDIVClass).html('');
            $.each(filters.all, function(filter, filter_values){
                var filterhtml = '';
                var filtername = filter.replace(/DATA|_/gi,' ').toUpperCase();
                filterhtml += '<div class="form-group">'
                filterhtml += '<label for="'+filter+'" class="col-sm-2 control-label">'+filtername+'</label>'
                filterhtml += '<div class="col-sm-9">'
                //Check for multiple option
                var none_multiple_options = ['data_year', 'data_month']
                var excluded_charts = ['patient_scaleup']
                if($.inArray(filter, none_multiple_options) == -1 || $.inArray(chartName, excluded_charts) != -1){ //not found or excluded chart
                    filterhtml += '<select class="form-control filter '+filter+'" multiple="multiple" id="'+filter+'">'
                }else{
                    filterhtml += '<select class="form-control filter '+filter+'" id="'+filter+'">'
                }
                filterhtml += '</select></div></div>';
                //Append filter to DOM
                $('.auto_filter').append(filterhtml);
                LoadSelectBox('.'+filter, filter_values)
            });
            //Autoselect defaults
            $.each(filters.default, function(filter, filter_values){
                $('.'+filter).val(filter_values).multiselect('refresh');
            });
        });
        //Add chartName to filter_btn
        $("#filter_btn").attr('data-filter', chartName)
    } 
}

function LoadSelectBox(divClass, data){
    $(divClass).multiselect({
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        includeSelectAllOption: true,
        disableIfEmpty: true,
        maxHeight: 400,
        buttonWidth: '100%',
        nonSelectedText: 'None selected',
        onChange: function(option, checked) {
            var selectID = $(option).parent().attr('id');
            var filterable_options = ['county', 'sub_county']
            if($.inArray(selectID, filterable_options) != -1){ //found
                var selectedOptions = $('.'+selectID).val();
                //Filter specific data
                getFilterData(selectID, selectedOptions)
            }
        }
    });
    $(divClass).multiselect('dataprovider', data);
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
        if(filterData != null && filterData != 0){
            filters[element.attr('id')] = filterData
        }
    }).promise().done(function () { 
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

    /*Load Spinner*/
    LoadSpinner('#'+chartName+'_chart')

    //Set new chartName
    $("#filter_btn").attr('data-filter', chartName)

    //Clear filter fields
    ClearFilterData()

    //Autoselect defaults
    $.getJSON(filterURL+chartName, function(filters) {
        //set chartName default filters
        $.each(filters.default, function(filter, filter_values){
            $('.'+filter).val(filter_values).multiselect('refresh');
        });
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
    });
}

function ClearFilterData(){
    //Clear all filter elements
    filters = {}
    $(".filter").multiselect('deselectAll', false);
    $(".filter").multiselect('updateButtonText');
    $(".filter").multiselect('rebuild');
}

function getFilterData(filtername, selectedOptions){
    $.post(specificFilterURL, {'filter_name':filtername, 'selected_options': selectedOptions}, function(filterData){
        filterData = $.parseJSON(filterData)
        if(filtername == 'county'){
            filtername = 'sub_county'
        }else if(filtername == 'sub_county'){
            filtername = 'facility'
        }
        $('.'+filtername).multiselect('destroy');
        LoadSelectBox('.'+filtername, filterData)
    });
}
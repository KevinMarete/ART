var countyURL = 'API/county'
var drugListURL = 'API/drug/list'
var regimenListURL = 'API/regimen/list'
var chartURL = 'Dashboard/get_chart'
var LatestDateURL = 'Dashboard/get_default_period'
var mainFilterURLs = {
    'summary': [
        {
            'link': countyURL, 
            'type': 'county'
        }
    ],
    'trend': [
        {
            'link': countyURL, 
            'type': 'county'
        }
    ]
}
var tabFiltersURLs = {
    'summary': [
        {
            'link': drugListURL, 
            'type': 'drug', 
            'chart': [
                {
                    'name':'#national_mos_chart_filter', 
                    'multiple': true
                }
            ]
        }
    ],
    'trend': [
        {
            'link': drugListURL,
            'type': 'drug', 
            'chart': [
                {
                    'name': '#commodity_consumption_chart_filter', 
                    'multiple': true
                }, 
                {
                    'name': '#commodity_month_stock_chart_filter',
                    'multiple': false
                }
            ]
        }, 
        {
            'link': regimenListURL, 
            'type': 'regimen', 
            'chart': [
                {
                    'name': '#patients_regimen_chart_filter',
                    'multiple': false
                }
            ]
        }
    ]
}
var charts = {
    'summary': ['patient_scaleup_chart', 'patient_services_chart', 'national_mos_chart'],
    'trend': ['commodity_consumption_chart', 'patients_regimen_chart', 'commodity_month_stock_chart']
}
var filters = {}
var defaultTab = 'summary'

$(function() {
    //Load default tab
    LoadTabContent(defaultTab)
    //Tab Change Event
    $("#main_tabs a").on("click", TabFilterHandler);
});

function LoadTabContent(tabName){
    //Set period
    setDefaultPeriod(LatestDateURL)
    //Set main filter
    setMainFilter(tabName)
    //Set tab filter
    setTabFilter(tabName)
    //Load charts
    $.each(charts[tabName], function(key, chartName) {
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, filters)
    });
}

function setDefaultPeriod(URL){
    $.getJSON(URL, function(data){
        //Set hidden values
        $("#filter_month").val(data.month)
        $("#filter_year").val(data.year)
        //Display labels
        $(".filter-month[data-value='" + data.month + "']").addClass("active-tab"); 
        $(".filter-year[data-value='" + data.year + "']").addClass("active-tab"); 
    });
}

function setMainFilter(tabName){
    $.each(mainFilterURLs[tabName], function(key, value){
        $.getJSON(value.link, function(data){
            $("#filter_item option").remove();
            $.each(data, function(i, v) {
                $("#filter_item").append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
            });
            $('#filter_item').multiselect('rebuild');
            $("#filter_item").data('filter_type', value.type)
        }); 
    });
}

function setTabFilter(tabName){
    $.each(tabFiltersURLs[tabName], function(key, value){
        $.getJSON(value.link, function(data){
            $.each(value.chart, function(index, chart){
                var filterID = chart.name
                var filterType = chart.multiple
                //Create multiselect box
                CreateSelectBox(filterID, filterType)
                //Add data to selectbox
                $(filterID+ " option").remove();
                $.each(data, function(i, v) {
                    $(filterID).append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
                });
                $(filterID).multiselect('rebuild');
                $(filterID).data('filter_type', value.type)
            });
        });
    });
}

function CreateSelectBox(elementID, multiple){
    $(elementID).multiselect({
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        includeSelectAllOption: true,
        disableIfEmpty: true,
        maxHeight: 300,
        buttonWidth: '400px',
        buttonWidth: '100%',
        nonSelectedText: 'None selected'
    });
    if(multiple == false){
        $(elementID).multiselect("disable");
    }
}

function LoadChart(divID, chartURL, chartName, selectedfilters){
    //Load Spinner
    LoadSpinner(divID)
    //Load Chart*
    $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters}, function(){
        //Pre-select filters for charts
        $.each($(divID + '_filters').data('filters'), function(key, data){
            if($.inArray(key, ['data_year', 'data_month', 'data_date']) == -1){
                $(divID + "_filter").val(data).multiselect('refresh');
            }
        });
    });
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href')
    var tabName = filtername.replace('#', '')
    var filters = {}
    
    LoadTabContent(tabName)
}

//Set filter_btn function

//Set clear_btn function
var chartURL = '../Manager/get_chart'

var drugListURL = '../API/drug/list'
var countyURL = 'API/county'
var subcountyURL = 'API/subcounty'
var facilityURL = 'API/facility'

var LatestDateURL = '../Dashboard/get_default_period'
var charts = ['reporting_rates_chart', 'patients_by_regimen_chart', 'drug_consumption_allocation_trend_chart', 'stock_status_trend_chart', 'low_mos_commodity_table', 'high_mos_commodity_table']
var filters = {}

//Autoload
$(function() {
    get_advanced_filters()
    //Get default filters
    setDefaultPeriod(LatestDateURL)
	//Load Charts
    $.each(charts, function (key, chartName) {
        LoadChart('#' + chartName, chartURL, chartName, {})
    });
    //Year click event
    $(".filter-year").on("click", function(){ $("#filter_year").val($(this).data("value")) });
    //Month click event
    $(".filter-month").on("click", function(){ $("#filter_month").val($(this).data("value")) });
    //Filter click Event
    $("#btn_filter, #advFilter").on("click", MainFilterHandler);
    //Clear click Event
    $("#btn_clear").on("click", MainClearHandler);
});

function get_advanced_filters(){
    var scope = $('#scope').val().toLowerCase();
    var role  = $('#role').val().toLowerCase();
    var view_label = role+"_view";
    //Show filters for your scope
    $("."+view_label).removeClass('hidden');
    //Get data for viewable filters
    $('select[class*="'+view_label+'"]').each(function(i){
        //console.log($(this).data('item'))
    });
    //console.log(role+'='+scope)
}

function setDefaultPeriod(URL){
    $.getJSON(URL, function(data){
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab')
        $(".filter-month").removeClass('active-tab')
        //Set hidden values
        $("#filter_month").val(data.month)
        $("#filter_year").val(data.year)
        //Display labels
        $(".filter-month[data-value='" + data.month + "']").addClass("active-tab"); 
        $(".filter-year[data-value='" + data.year + "']").addClass("active-tab");
    });
}

function LoadChart(divID, chartURL, chartName, selectedfilters) {
    //Load Spinner
    LoadSpinner(divID)
    //Load Chart*
    $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters}, function(){
        //Pre-select filters for charts
        $.each($(divID + '_filters').data('filters'), function(key, data){
            if($.inArray(key, ['data_year', 'data_month', 'data_date']) == -1){
                $(divID + "_filter").val(data).multiselect('refresh');
                //Output filters
                var filtermsg = '<b><u>'+key.toUpperCase()+':</u></b><br/>'
                if($.isArray(data)){
                    filtermsg += data.join('<br/>')
                }else{
                    filtermsg += data
                }
                $("."+chartName+"_heading").html(filtermsg) 
            }
        });
    });
}

function LoadSpinner(divID) {
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function getMonth(monthStr){
    monthval = new Date(monthStr+'-1-01').getMonth()+1
    return ('0' + monthval).slice(-2)
}

function MainFilterHandler(e){
    var filter_year = $("#filter_year").val()
    var filter_month = $("#filter_month").val()
    
    //Add filters to request
    filters['data_year'] = filter_year
    filters['data_month'] = filter_month
    filters['data_date'] = filter_year + '-' + getMonth(filter_month) + '-01'

    /*Check all filter_items [THIS NEEDS TO INCLUDE ALL ADVANCED FILTERS*/
    if($("#filter_item").val() != null){
        filters[$("#filter_item").data("filter_type")] = $("#filter_item").val()
    }

    if(filters['data_year'] != '' || filters['data_month'] != '')
    {   
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab');
        $(".filter-month").removeClass('active-tab');
        //Set colors for filters
        $(".filter-year[data-value='" +  $("#filter_year").val() + "']").addClass("active-tab");
        $(".filter-month[data-value='" + $("#filter_month").val() + "']").addClass("active-tab");
        //Load charts
        $.each(charts, function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    }else{
        swal('Filter Year or Month cannot be Blank!')
    }
}

function MainClearHandler(e){
    //Clear filters
    filters = {}
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
        $("#filter_item").multiselect("refresh");
        //Trigger filter event
        $("#btn_filter").trigger("click");
    });
}

function CreateSelectBox(elementID, width, limit) {
    $(elementID).val('').multiselect({
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        disableIfEmpty: true,
        maxHeight: 300,
        buttonWidth: width,
        nonSelectedText: 'None selected',
        includeSelectAllOption: false,
        selectAll: false,
        onChange: function (option, checked) {
            //Get selected options.
            var selectedOptions = $(elementID + ' option:selected');
            if (selectedOptions.length >= limit) {
                //Disable all other checkboxes.
                var nonSelectedOptions = $(elementID + ' option').filter(function () {
                    return !$(this).is(':selected');
                });
                nonSelectedOptions.each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            } else {
                //Enable all checkboxes.
                $(elementID + ' option').each(function () {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
}
var countyURL = 'API/county'
var subcountyURL = 'API/subcounty'
var facilityURL = 'API/facility'
var partnerURL = 'API/partner'
var drugListURL = 'API/drug/list'
var regimenListURL = 'API/regimen/list'
var chartURL = 'Dashboard/get_chart'
var LatestDateURL = 'Dashboard/get_default_period'
var mainFilterURLs = {
    'summary': [{'link': countyURL, 'type': 'county' }], 
    'trend': [{'link': countyURL, 'type': 'county'}],
    'county': [{'link': countyURL, 'type': 'county'}],
    'subcounty': [{'link': subcountyURL, 'type': 'sub_county'}],
    'facility': [{'link': facilityURL, 'type': 'facility'}],
    'partner': [{'link': partnerURL, 'type': 'partner'}],
    'regimen': [{'link': regimenListURL, 'type': 'regimen'}],
    'adt_sites': [{'link': countyURL, 'type': 'county'}],
    'adt_reports': [{'link': countyURL, 'type': 'county'}]
}
var tabFiltersURLs = {
    'summary': [{'link': drugListURL, 'type': 'drug', 'filters': ['#national_mos_chart_filter']}],
    'trend': [
        {'link': drugListURL, 'type': 'drug', 'filters': ['#commodity_consumption_chart_filter', '#commodity_month_stock_chart_filter']}, 
        {'link': regimenListURL, 'type': 'regimen', 'filters': ['#patients_regimen_chart_filter']}
    ],
    'county': [],
    'subcounty': [],
    'facility': [],
    'partner': [],
    'regimen': [],
    'adt_sites': [],
    'adt_reports': [
        {'link': drugListURL, 'type': 'drug', 'filters': ['#adt_reports_commodity_consumption_regimen_chart_filter', '#adt_reports_commodity_consumption_dose_chart_filter', '#adt_reports_paediatric_weight_age_chart_filter', '#adt_reports_commodity_consumption_chart_filter']},
        {'link': regimenListURL, 'type': 'start_regimen', 'filters': ['#adt_reports_patients_started_art_chart_filter']},
        {'link': regimenListURL, 'type': 'current_regimen', 'filters': ['#adt_reports_active_patients_regimen_chart_filter', '#adt_reports_commodity_consumption_drug_chart_filter']}
    ]
}
var charts = {
    'summary': ['patient_scaleup_chart', 'patient_services_chart', 'national_mos_chart'],
    'trend': ['commodity_consumption_chart', 'patients_regimen_chart', 'commodity_month_stock_chart'],
    'county': ['county_patient_distribution_chart', 'county_patient_distribution_table'],
    'subcounty': ['subcounty_patient_distribution_chart', 'subcounty_patient_distribution_table'],
    'facility': ['facility_patient_distribution_chart', 'facility_patient_distribution_table'],
    'partner': ['partner_patient_distribution_chart', 'partner_patient_distribution_table'],
    'regimen': ['regimen_patient_chart', 'regimen_nrti_drugs_chart', 'regimen_nnrti_drugs_chart'],
    'adt_sites': ['adt_sites_version_chart', 'adt_sites_internet_chart', 'adt_sites_backup_chart', 'adt_sites_distribution_chart', 'adt_sites_distribution_table'],
    'adt_reports': ['adt_reports_patients_started_art_chart', 'adt_reports_active_patients_regimen_chart', 'adt_reports_commodity_consumption_regimen_chart', 'adt_reports_commodity_consumption_drug_chart', 'adt_reports_commodity_consumption_dose_chart', 'adt_reports_commodity_consumption_chart', 'adt_reports_paediatric_weight_age_chart']
}
var filters = {}
var tabName = 'summary'

//Autoload
$(function() {
    //Set default period
    setDefaultPeriod(LatestDateURL)
    //Load default tab charts
    LoadTabContent(tabName)
    //Tab change Event
    $("#main_tabs li a").on("click", TabFilterHandler);
    //Filter click Event
    $(".filter_btn").on("click", FilterBtnHandler);
    //Clear click Event
    $(".clear_btn").on("click", ClearBtnHandler);
    //Year click event
    $(".filter-year").on("click", function(){ $("#filter_year").val($(this).data("value")) });
    //Month click event
    $(".filter-month").on("click", function(){ $("#filter_month").val($(this).data("value")) });
    //Main filter click event
    $("#btn_filter").on("click", MainFilterHandler);
    //Main clear click event 
    $("#btn_clear").on("click", MainClearHandler);
    //Add This to Block SHIFT Key for multiselect 
    disableShiftKey()
});

function LoadTabContent(tabName){
    //Refresh tab chart(s)
    if(charts[tabName].length > 0){
        $.each(charts[tabName], function(key, chartName) {
            LoadSpinner('#'+chartName)
        });
    }
    //Set main filter
    setMainFilter(tabName)
    //Set tab filter
    setTabFilter(tabName)
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
            //Create multiselect box
            CreateSelectBox("#filter_item", "250px", 10)
            //Add data to selectbox
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
    if(tabFiltersURLs[tabName].length > 0){
        $.each(tabFiltersURLs[tabName], function(key, value){
            $.ajax({
                url: value.link,
                datatype: 'JSON',
                success: function(data){
                    $.each(value.filters, function(index, filterID){
                        //Create multiselect box
                        CreateSelectBox(filterID, '100%', 10)
                        //Add data to selectbox
                        $(filterID+ " option").remove();
                        $.each(data, function(i, v) {
                            $(filterID).append($("<option value='" + v.name + "'>" + v.name.toUpperCase() + "</option>"));
                        });
                        $(filterID).multiselect('rebuild');
                        $(filterID).data('filter_type', value.type);
                    });
                },
                complete: function(){
                    //Load charts after filter options
                    $.each(charts[tabName], function(key, chartName) {
                        chartID = '#'+chartName
                        LoadChart(chartID, chartURL, chartName, filters)
                    });
                }
            });
        });
    }else{
        //Load charts without filter options
        if(charts[tabName].length > 0){
            $.each(charts[tabName], function(key, chartName) {
                chartID = '#'+chartName
                LoadChart(chartID, chartURL, chartName, filters)
            });
        }
    }
}

function CreateSelectBox(elementID, width, limit){
    $(elementID).val('').multiselect({
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        disableIfEmpty: true,
        maxHeight: 300,
        buttonWidth: width,
        nonSelectedText: 'None selected',
        includeSelectAllOption: false,
        selectAll: false, 
        onChange: function(option, checked) {
            //Get selected options.
            var selectedOptions = $(elementID + ' option:selected');
            if (selectedOptions.length >= limit) {
                //Disable all other checkboxes.
                var nonSelectedOptions = $(elementID + ' option').filter(function() {
                    return !$(this).is(':selected');
                });
                nonSelectedOptions.each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            }
            else {
                //Enable all checkboxes.
                $(elementID + ' option').each(function() {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
}

function disableShiftKey(){   
    var shiftClick = $.Event("click");
    shiftClick.shiftKey = true;
    $(".multiselect-container li *").click(function(event) {
        if (event.shiftKey) {
            event.preventDefault();
            return false;
        }
    });
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

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function TabFilterHandler(e){
    var filtername = $(e.target).attr('href');
    if(filtername !== '#' && filtername.charAt(0) == "#"){
        filters = {}
        //Set tabName
        tabName = filtername.replace('#', '');
        //Clear heading
        $(".heading").empty();
        //Set default period
        setDefaultPeriod(LatestDateURL)
        //Load selected tab charts
        LoadTabContent(tabName)
    }
}

function FilterBtnHandler(e){
    var filter_year = $("#filter_year").val()
    var filter_month = $("#filter_month").val()
    var filterName = String($(e.target).attr("id")).replace('_btn', '')
    var filterID = "#"+filterName
    var filterType = $(filterID).data('filter_type')
    var chartName = filterName.replace('_filter', '')
    var chartID = "#"+chartName

    //Add filters to request
    filters['data_year'] = filter_year
    filters['data_month'] = filter_month
    filters['data_date'] = filter_year + '-' + getMonth(filter_month) + '-01'

    if($(filterID).val() != null){
        filters[filterType] = $(filterID).val()
    }

    if(filters['data_year'] != '' || filters['data_month'] != '')
    {   
        LoadChart(chartID, chartURL, chartName, filters)
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab')
        $(".filter-month").removeClass('active-tab')
        //Set colors for filters
        $(".filter-year[data-value='" +  filter_year + "']").addClass("active-tab")
        $(".filter-month[data-value='" + filter_month + "']").addClass("active-tab")
    }else{
        alert('Filter Year or Month cannot be Blank!')
    }

    //Hide Modal
    $(filterID+'_modal').modal('hide')
}

function ClearBtnHandler(e){
    var filterName = String($(e.target).attr("id")).replace('_clear_btn', '')
    var filterID = "#"+filterName
    var filterType = $(filterID).data('filter_type')

    //Clear filterType
    filters[filterType] = {}

    //Filter multiple multiselect
    $(filterID).multiselect('deselectAll', false);
    $(filterID).multiselect('updateButtonText');
    $(filterID).multiselect('refresh');
    
    //Trigger filter event
    $(filterID+'_btn').trigger('click');
}

function getMonth(monthStr){
    return new Date(monthStr+'-1-01').getMonth()+1
}

function MainFilterHandler(e){
    var filter_year = $("#filter_year").val()
    var filter_month = $("#filter_month").val()
    
    //Add filters to request
    filters['data_year'] = filter_year
    filters['data_month'] = filter_month
    filters['data_date'] = filter_year + '-' + getMonth(filter_month) + '-01'

    if($("#filter_item").val() != null){
        filters[$("#filter_item").data("filter_type")] = $("#filter_item").val()
    }

    if(filters['data_year'] != '' || filters['data_month'] != '')
    {   
        //Load charts
        $.each(charts[tabName], function(key, chartName) {
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
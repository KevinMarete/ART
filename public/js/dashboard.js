var chartURL = 'Dashboard/get_chart'
var tab = 'summary'
var filters = {}
var charts = []
var selected_year
var selected_month
var counties = []
var selected_regimen
var selected_drugs_mos = []
var selected_cms_drug
var selected_drugs_com_consumption = []

charts['summary'] = ['patient_scaleup_chart','patient_services_chart', 'national_mos_chart']
charts['trend'] = ['commodity_consumption_chart', 'patients_regimen_chart', 'commodity_month_stock_chart']
charts['county'] = ['county_patient_distribution_chart', 'county_patient_distribution_table']
charts['subcounty'] = ['subcounty_patient_distribution_chart', 'subcounty_patient_distribution_table']
charts['facility'] = ['facility_patient_distribution_chart', 'facility_patient_distribution_table','facility_regimen_distribution_chart','facility_commodity_consumption_chart']
charts['partner_summary'] = ['partner_patient_distribution_chart', 'partner_patient_distribution_table']
charts['adt_site'] = ['adt_version_distribution_chart','adt_site_distribution_chart', 'adt_site_distribution_table']
charts['commodity'] = ['regimen_patient_chart']
charts['drug'] = ['drug_consumption_chart','drug_regimen_consumption_chart','regimen_patients_counties_chart']


$(function() {
    
    // get selected date and year
    $.getJSON("Dashboard/get_latest_date", function(jsonData){
        selected_year = jsonData.year;
        selected_month = jsonData.month;

        //set filter values active
        $(".filter-year[data-value='" + selected_year + "']").addClass("active-tab");
        $(".filter-month[data-value='" + selected_month + "']").addClass("active-tab");   
    });

    //get selected counties
    $.getJSON("Dashboard/get_selected_counties", function(jsonData){
        counties = jsonData;

        cb = '';
        $.each(jsonData, function(i,data){
            cb+='<option value="'+data+'">'+data+'</option>';
        });
        $(".county_filter").append(cb);
        $('#filter_item').multiselect('rebuild');
    });

    //get selected regimen --patients on regimen chart
    $.getJSON("Dashboard/get_selected_regimen", function(jsonData){
        selected_regimen = jsonData
    });

    //get selected drugs mos
    $.getJSON("Dashboard/get_selected_drugs_mos", function(jsonData){
        selected_drugs_mos = jsonData;
    });

    //get selected cms drug
    $.getJSON("Dashboard/get_selected_cms_drug", function(jsonData){
        selected_cms_drug = jsonData;
    });

    //get selected commodity consumption drugs
    $.getJSON("Dashboard/get_selected_drugs_com_consumption", function(jsonData){
        selected_drugs_com_consumption = jsonData;
    });

    /*Load Charts*/
    $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, filters)
    });
    /*Set selected tab*/
    $("#filter_tab").val(tab)
    /*Tab Change Event*/
    $("#main_tabs a").on("click", TabFilterHandler);    

    // on regimen change. load regimen page
    $("#single_regimen_filter").on("change", TabFilterHandler);
    $("#regimen_filter").on("change", TabFilterHandler);

    //dropdown drug list commodity trend
    $.getJSON("Dashboard/get_consmp_drug_dropdowns", function(jsonData){
        drugs = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            if (selected_drugs_com_consumption.includes(data.drug)) {
                    drugs+='<option value="'+data.drug+'" selected>'+data.drug+'</option>';
            } else {
                drugs+='<option value="'+data.drug+'">'+data.drug+'</option>';
            }
        });
        $(".drug_list").append(drugs);
        $('#drugs').multiselect('rebuild');
        $('#commodity_stock').multiselect('rebuild');
        $('#facility_commodity_consumption').multiselect('rebuild');
    });

    //dropdown drug list commodity month stock
    $.getJSON("Dashboard/get_stock_drug_dropdowns", function(jsonData){
        drugs = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            if (data.drug === selected_cms_drug) {
                    drugs+='<option value="'+data.drug+'" selected>'+data.drug+'</option>';
            } else {
                drugs+='<option value="'+data.drug+'">'+data.drug+'</option>';
            }
        });
        $(".cms_drug_list").append(drugs);
        $("#selected-cms-drug").text(selected_cms_drug).css('font-weight', 'bold');
        $('#commodity_stock').multiselect('rebuild');
    });
    
    //dropdown drug list national MOS
    $.getJSON("Dashboard/get_stock_drug_dropdowns", function(jsonData){
        drugs = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            if (selected_drugs_mos.includes(data.drug)) {
                    drugs+='<option value="'+data.drug+'" selected>'+data.drug+'</option>';
            } else {
                drugs+='<option value="'+data.drug+'">'+data.drug+'</option>';
            }
        });
        $(".mos_drug_list").append(drugs);
        $('#mos_filter').multiselect('rebuild');
    });
    
    $.getJSON("Dashboard/get_regimen_dropdowns", function(jsonData){
        cb = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            if (data.regimen == selected_regimen) {
                    cb+='<option value="'+data.regimen+'" selected>'+data.regimen+'</option>';
            } else {
                cb+='<option value="'+data.regimen+'">'+data.regimen+'</option>';
            }
        });
        $(".regimen_list").append(cb);
        $('#regimen').multiselect('rebuild');
    });

    $.getJSON("Dashboard/get_sites", function(jsonData){
        $('.total_sites').text(jsonData.summary.total_sites);
        $('.internet_sites').text(jsonData.summary.internet_sites);
        $('.internet_percentage').text(jsonData.summary.internet_percentage+'%');
        $('.backup_sites').text(jsonData.summary.backup_sites);
        $('.backup_percentage').text(jsonData.summary.backup_percentage+'%');
        $('.installed_sites').text(jsonData.summary.installed);

        $('.total_sites_no').text(jsonData.overview.total_facilities);
        $('.ordering_sites_no').text(jsonData.overview.ordering_sites);


        $('.facilities_percentage').text(jsonData.overview.ordering_sites_percentage);
        $('.facilities_percentage').css("width:",jsonData.overview.ordering_sites_percentage);
    });

    $.getJSON("Dashboard/get_regimens", function(jsonData){
        cb = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            cb+='<option value="'+data.name+'">'+data.name+'</option>';
        });
        $("#regimen_filter,#single_regimen_filter").append(cb);
        $('#single_regimen_filter').multiselect('rebuild');
    });

    //get all the facilities
    $.getJSON("Dashboard/get_facilities", function(jsonData){
        cb = '';
        $.each(jsonData, function(i,data){
            // set the default selected
            cb+='<option value="'+data.facility+'">'+data.facility+'</option>';
        });
        $("#single_facility_filter").append(cb);
        $('#single_facility_filter').multiselect('rebuild');
    });

        /*Filter Month*/
    $(".filter-month").on("click", function(){
        // style the default selected month on the filter
        $("#month-filter a").css("color", "#31B0D5");
        $(this).css("color", "#f00");

        month_selected = $(this).data('value');
        $("#filter_month").val(month_selected);
    });
    /*Filter Year*/
    $(".filter-year").on("click", function(){
        // style the default selected year on the filter
        $("#year-filter a").css("color", "#31B0D5");
        $(this).css("color", "#f00");

        year_selected = $(this).data('value');
        $("#filter_year").val(year_selected);


    });

    /*Filter Submit*/
    $("#filter_frm").on("submit", function(e){
        var default_year = ($("#filter_year").val() == "" ? selected_year : $("#filter_year").val());
        var default_month = ($("#filter_month").val() == "" ? selected_month : $("#filter_month").val());
        var default_county = ($(".county_filter").val() == null ? counties : $(".county_filter").val());

        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['data_month'] = default_month;
        filters['data_year'] = default_year;
        filters['data_date'] = default_year + '-'+ default_month;

        filters['county'] = default_county;
        filters['regimen'] = $("#regimen_filter").val();
        
        /*Load Charts based on tab*/
        $.each(charts[tab], function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    });
    
    /*Commodity consumption trend filter*/
    $("#trend_view_filter_frm").on("submit", function(e){
        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['drug'] = $("#drugs").val();

        /*close modal*/
        $('#commodity_consumption_modal').modal('hide');
        /*Load Charts based on tab*/
       
        chartName = 'commodity_consumption_chart';
        chartID = '#'+chartName

        LoadChart(chartID, chartURL, chartName, filters)
    });

    /*Patients Regimen filter*/
    $("#patient_regimen_filter_frm").on("submit", function(e){
        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['patient_regimen'] = $("#regimen").val();

        /*close modal*/
        $('#patients_regm_modal').modal('hide');
        
        /*Load Charts based on tab*/
        chartName = 'patients_regimen_chart';
        chartID = '#'+chartName
        
        LoadChart(chartID, chartURL, chartName, filters)
    });

    /*Commodity Month Stock filter*/
    $("#commodity_stock_filter_frm").on("submit", function(e){
        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['cms_drug'] = $("#commodity_stock").val();

        /*close modal*/
        $('#commodity_month_stock_modal').modal('hide');

        /*show filter method*/
        $('.commodity_month_stock_heading').text($("#commodity_stock").val()).css('font-weight', 'bold');

        /*Load Charts based on tab*/
        chartName = 'commodity_month_stock_chart';
        chartID = '#'+chartName
        
        LoadChart(chartID, chartURL, chartName, filters)
    });

    /*National MOS filter*/
    $("#mos_filter_frm").on("submit", function(e){
        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['drug'] = $("#mos_filter").val();

        /*close modal*/
        $('#mos_filter_modal').modal('hide');

        /*Load Charts based on tab*/
        
        chartName = 'national_mos_chart';
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, filters)
    });

    /*Facility Consumption Filter*/
    $("#facility_commodity_consumption_frm").on("submit", function(e){
        //*Prevent submission*/
        e.preventDefault();
        /*Set filters*/
        filters['drug'] = $("#facility_commodity_consumption").val();

        /*close modal*/
        $('#facility_commodity_consumption_modal').modal('hide');

        /*Load Charts based on tab*/
        chartName = 'facility_commodity_consumption_chart';
        chartID = '#'+chartName

        LoadChart(chartID, chartURL, chartName, filters)
    });

    //facilities tab select specific facility
    $("#single_facility_filter").on("change", function(){
        filters['facility'] = $("#single_facility_filter").val();
        
        $('#facility_chart_one, #facility_chart_two').addClass('hidden');
        $('#facility_chart_four, #facility_chart_five').removeClass('hidden');

        $("#facility_clear_btn").removeClass('hidden');

        $.each(charts[tab], function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    });

    //clear selected filter on facility
    $("#facility_clear_btn").on("click", function(){
        filters['facility'] = $("#single_facility_filter").val();
        
        $('#facility_chart_one, #facility_chart_two').removeClass('hidden');
        $('#facility_chart_four, #facility_chart_five').addClass('hidden');

        $.each(charts[tab], function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
        
        $("#facility_clear_btn").addClass('hidden');
    });

    $('#btn-filter-clear').click(function(e){
      //*Prevent submission*/
      $('.county_filter').val("");
      $("#filter_month").val("");
      $("#filter_year").val("");
      $(".county_filter").val("");
      
      e.preventDefault();
      // /*clearSet filters*/
      clearfilters = {};
      // retain regimen id if set 
      clearfilters['regimen'] = $("#regimen_filter").val();

       /*reset filter method on commodity month stock chart*/
       $('.commodity_month_stock_heading').text(selected_cms_drug).css('font-weight', 'bold');
       
       // reset county multi-select
       $('#filter_item option:selected').each(function() {
            $(this).prop('selected', false);
        })
        $('#filter_item').multiselect('refresh');

        // reset to the default selected filters
        $("#month-filter a, #year-filter a").css("color", "#31B0D5");
        $('#month-filter .active-tab, #year-filter .active-tab').css("color", "#f00");

      /*Load Charts based on tab*/
      $.each(charts[tab], function(key, chartName) {
        chartID = '#'+chartName
        LoadChart(chartID, chartURL, chartName, clearfilters)
    });  

  }); 
});

function LoadChart(divID, chartURL, chartName, selectedfilters){
    /*Load Spinner*/
    LoadSpinner(divID)
    /*Load Chart*/
    $(divID).load(chartURL, {'name':chartName, 'selectedfilters': selectedfilters});
}

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function TabFilterHandler(e){
    var filtername = ($(e.target).attr('href') !== undefined ) ? $(e.target).attr('href') :  '#drug'; 
    var filters = {}

    tab = filtername.replace('#', '')
    if(tab){
        //Reset filter identifier
        $("#filter_tab").val(tab)
        
        /*Reset the filters on tab change*/
        $("#filter_month").val("");
        $("#filter_year").val("");
        $(".county_filter").val("");

        // reset county multi-select
        $('#filter_item option:selected').each(function() {
            $(this).prop('selected', false);
        })
        $('#filter_item').multiselect('refresh');

        // reset to the default selected filters
        $("#month-filter a, #year-filter a").css("color", "#31B0D5");
        $('#month-filter .active-tab, #year-filter .active-tab').css("color", "#f00");

        /*Load Charts*/
        if (tab == 'drug'){
            filters['regimen'] = $("#regimen_filter").val();
        }
        $.each(charts[tab], function(key, chartName) {
            chartID = '#'+chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    }
}

function setFilter(className, hiddenID){

}
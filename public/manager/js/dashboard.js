var chartURL = '../Manager/get_chart'
var URLs = {
    'drug': '../API/drug/list',
    'county': '../API/county',
    'sub_county': '../API/subcounty',
    'facility': '../API/facility'
}
var drilldownItems = {
    'county': {
        'element': 'sub_county',
        'url': '../API/subcounty/?county=',
        'hide': ['.sub_county', '.facility']
    },
    'sub_county': {
        'element': 'facility',
        'url': '../API/facility/?subcounty=',
        'hide': ['.facility']
    }
}
var LatestDateURL = '../Manager/get_default_period'
var charts = ['reporting_rates_chart', 'patients_by_regimen_chart', 'drug_consumption_allocation_trend_chart', 'stock_status_trend_chart', 'low_mos_commodity_table', 'high_mos_commodity_table']
var exempt_from_id = ['drug']
var non_national_scope = ['county', 'subcounty']
var exempt_drilldown = ['drug', 'facility']
var filters = {}
months = {
    'Jan': '01',
    'Feb': '02',
    'Mar': '03',
    'Apr': '04',
    'May': '05',
    'Jun': '06',
    'Jul': '07',
    'Aug': '08',
    'Sep': '09',
    'Oct': '10',
    'Nov': '11',
    'Dec': '12'
}

function getTheMonth(m) {
    return months[m];
}

//Autoload
$(function () {
    //Get filters
    get_filters();
    //Load Charts
    $.each(charts, function (key, chartName) {
        LoadChart('#' + chartName, chartURL, chartName, {});
    });
    //Year click event
    $(".filter-year").on("click", function () {
        $("#filter_year").val($(this).data("value"))
    });
    //Month click event
    $(".filter-month").on("click", function () {
        $("#filter_month").val($(this).data("value"))
    });
    //Filter click Event
    $("#btn_filter, #advFilter").on("click", MainFilterHandler);
    //Clear click Event
    $("#btn_clear").on("click", MainClearHandler);
    //Advanced filter change event
    $(document).on("change", ".county, .sub_county", DrilldownHandler);
});

function get_filters() {
    var scope = $('#scope').val().toLowerCase(); //kiambu
    var scope_id = $('#scope_id').val(); //5
    var role = $('#role').val().toLowerCase(); //county
    var view_label = role + "_default";
    var default_elements = $('.' + view_label);
    //Show filters for your scope
    $("." + view_label).removeClass('hidden');
    //Get data for viewable filters
    $.each(default_elements, function (index) {
        var filter_option = $(this).data('item');
        var filter_element = '.' + filter_option
        var filterURL = URLs[filter_option];
        //Filter for non-national users
        if ($.inArray(role, non_national_scope) != -1 && filter_option != 'drug') {
            filterURL = filterURL + '/?' + role + '=' + scope_id
        }
        $.getJSON(filterURL, function (data) {
            //Create multiselect box
            CreateSelectBox(filter_element, "100%", 10, filter_option)
            //Add data to selectbox
            $(filter_element + " option").remove();
            $.each(data, function (i, v) {
                if ($.inArray(filter_option, exempt_from_id) != -1) {
                    $(filter_element).append($("<option value='" + v.name + "'>" + v.name + "</option>"));
                } else {
                    $(filter_element).append($("<option value='" + v.id + "'>" + v.name + "</option>"));
                }

            });

            $(filter_element).multiselect('rebuild');
            $(filter_element).data('filter_type', filter_option);
            //Set default filters
            if (index == (default_elements.length - 1)) {
                setDefaultPeriod(LatestDateURL)
            }
        });
    });
}

function DrilldownHandler(e) {
    var drilldown_option = $(this).data('item');
    var filter_option = drilldownItems[drilldown_option]['element'];
    var filter_element = '.' + filter_option;
    var drilldown_url = drilldownItems[drilldown_option]['url'];
    var hidden_elements = drilldownItems[drilldown_option]['hide'];
    var selected_options = $(this).find('option:selected');
    //Hide all hidden_elements and hide
    $.each(hidden_elements, function (i, hidden_element) {
        $(hidden_element + " option").remove();
        $(hidden_element).multiselect('destroy');
        $(hidden_element).addClass('hidden');
    });
    if (selected_options.length > 0) {
        //Show drilldown element
        $(filter_element).removeClass('hidden');
        //Create multiselect box
        CreateSelectBox(filter_element, "100%", 10, filter_option)
        //Remove existing options
        $(filter_element + " option").remove();
        //Get drilldown items based on (multiple) filters
        $(selected_options).each(function (index, value) {
            $.getJSON(drilldown_url + $(this).val(), function (data) {
                //Add data to selectbox
                $.each(data, function (i, v) {
                    $(filter_element).append($("<option value='" + v.id + "'>" + v.name + "</option>"));
                    //Rebuild multiselect once done
                    if (index == (selected_options.length - 1)) {
                        $(filter_element).multiselect('rebuild');
                        $(filter_element).data('filter_type', filter_option);
                    }
                });
            });
        });
    }
}

function setDefaultPeriod(URL) {
    $.getJSON(URL, function (data) {
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab')
        $(".filter-month").removeClass('active-tab')
        //Set hidden values
        $("#filter_month").val(data.month)
        $("#filter_year").val(data.year)
        //Display labels
        $(".filter-month[data-value='" + data.month + "']").addClass("active-tab");
        $(".filter-year[data-value='" + data.year + "']").addClass("active-tab");
        //Select default drug
        $(".drug").val(data.drug).multiselect('refresh');
    });
}

function LoadChart(divID, chartURL, chartName, selectedfilters) {
    //Load Spinner
    LoadSpinner(divID)
    //Load Chart*
    $(divID).load(chartURL, {'name': chartName, 'selectedfilters': selectedfilters}, function () {
        //Pre-select filters for charts
        var filtermsg = ''
        $.each($(divID + '_filters').data('filters'), function (key, data) {
            if ($.inArray(key, ['data_year', 'data_month', 'data_date']) == -1) {
                $(divID + "_filter").val(data).multiselect('refresh');
                //Output filters
                filtermsg += '<br/><b><u>' + key.toUpperCase() + ':</u></b><br/>'
                if ($.isArray(data)) {
                    filtermsg += data.join('<br/>')
                } else {
                    filtermsg += data
                }
            }
            $("." + chartName + "_heading").html(filtermsg)
        });
    });
}

function LoadSpinner(divID) {
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

function getMonth(monthStr) {
    monthval = new Date(monthStr + '-1-01').getMonth() + 1
    return ('0' + monthval).slice(-2)
}

function MainFilterHandler(e) {
    var filter_year = $("#filter_year").val()
    var filter_month = $("#filter_month").val()


    //Add filters to request
    filters['data_year'] = filter_year;
    filters['data_month'] = filter_month;
    filters['data_date'] = filter_year + '-' + getTheMonth(filter_month) + '-01';

    /*Check all filter_items*/
    $('.filter_item').each(function () {
        var selected = [];
        $.each($(this).find('option:selected'), function (v) {
            selected.push($(this).text());
        });
        if (selected.length > 0) {
            filters[$(this).data("item")] = selected;
        }

        console.log(filters);

    });

    //Ensure month and year are selected
    if (filters['data_year'] != '' || filters['data_month'] != '')
    {
        //Remove active-tab class
        $(".filter-year").removeClass('active-tab');
        $(".filter-month").removeClass('active-tab');
        //Set colors for filters
        $(".filter-year[data-value='" + $("#filter_year").val() + "']").addClass("active-tab");
        $(".filter-month[data-value='" + $("#filter_month").val() + "']").addClass("active-tab");
        //Load charts
        $.each(charts, function (key, chartName) {
            chartID = '#' + chartName
            LoadChart(chartID, chartURL, chartName, filters)
        });
    } else {
        swal('Filter Year or Month cannot be Blank!')
    }
}

function MainClearHandler(e) {
    //Clear filters
    filters = {}
    //Get default filters
    var scope = $('#scope').val().toLowerCase(); //kiambu
    var scope_id = $('#scope_id').val(); //5
    var role = $('#role').val().toLowerCase(); //county
    var view_label = role + "_default";
    var default_elements = $('.' + view_label);
    //Get data for viewable filters
    $.each(default_elements, function (index) {
        var filter_option = $(this).data('item');
        var filter_element = '.' + filter_option
        var filterURL = URLs[filter_option];
        if ($.inArray(filter_option, exempt_drilldown) == -1) {
            var hidden_elements = drilldownItems[filter_option]['hide'];
            //Hide all hidden_elements and hide
            $.each(hidden_elements, function (i, hidden_element) {
                $(hidden_element + " option").remove();
                $(hidden_element).multiselect('destroy');
                $(hidden_element).addClass('hidden');
            });
            //Show filters for your scope
            $("." + view_label).removeClass('hidden');
        }

        //Filter for non-national users
        if ($.inArray(role, non_national_scope) != -1 && filter_option != 'drug') {
            filterURL = filterURL + '/?' + role + '=' + scope_id
        }
        $.getJSON(filterURL, function (data) {
            //Create multiselect box
            CreateSelectBox(filter_element, "100%", 10, filter_option)
            //Add data to selectbox
            $(filter_element + " option").remove();
            $.each(data, function (i, v) {
                if ($.inArray(filter_option, exempt_from_id) != -1) {
                    $(filter_element).append($("<option value='" + v.name + "'>" + v.name + "</option>"));
                } else {
                    $(filter_element).append($("<option value='" + v.id + "'>" + v.name + "</option>"));
                }
            });
            $(filter_element).multiselect('rebuild');
            $(filter_element).data('filter_type', filter_option);
            //Set default filters
            if (index == (default_elements.length - 1)) {
                $.getJSON(LatestDateURL, function (data) {
                    //Remove active-tab class
                    $(".filter-year").removeClass('active-tab')
                    $(".filter-month").removeClass('active-tab')
                    //Set hidden values
                    $("#filter_month").val(data.month)
                    $("#filter_year").val(data.year)
                    //Display labels
                    $(".filter-month[data-value='" + data.month + "']").addClass("active-tab");
                    $(".filter-year[data-value='" + data.year + "']").addClass("active-tab");
                    //Select default drug
                    $(".drug").val(data.drug).multiselect('refresh');
                    //Trigger filter event
                    $("#btn_filter").trigger("click");
                });
            }
        });
    });
}

function CreateSelectBox(elementID, width, limit, placeholdertext) {
    $(elementID).val('').multiselect({
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        disableIfEmpty: true,
        maxHeight: 300,
        buttonWidth: width,
        nonSelectedText: 'Select ' + placeholdertext,
        includeSelectAllOption: false,
        selectAll: false,
        onChange: function (option, checked) {
            // alert($(elementID).val());
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
var filter_item = '';
var filter_year = '';
var filter_month = '';
var filterURL = 'Dashboard/get_filter'

$(function() {
    /*Search data based on filters*/
    $('#filter_frm').on('submit', function(e){
        /*Stop form posting*/
        e.preventDefault();
        /*Build request*/
        var request_data = {
            'filter_tab' : $("#filter_tab").val(),
            'filter_type' : $("#filter_item").data('filter_type'),
            'filter_item' : $("#filter_item").val(),
            'filter_year' : $("#filter_year").val(),
            'filter_month' : $("#filter_month").val(),
            'data_date' : $("#filter_year").val()+ '-'+ $("#filter_month").val()
        }
        /*Post request*/
        $.post(filterURL, request_data, function(response_data){
            //console.log(response_data)
        });
    });

    /*Set year on filter*/
    $('.filter-year').on('click', function(){
        $("#filter_year").val($(this).data('value'))
    });

    /*Set month on filter*/
    $('.filter-month').on('click', function(){
        $("#filter_month").val($(this).data('value'))
    });
    
});
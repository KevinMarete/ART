var siteURL = '../API/install';
var facilityURL = '../API/facility';
var countyURL = '../API/county';
var subcountyURL = '../API/subcounty';
var partnerURL = '../API/partner';
var userURL = '../API/user';

$(function () {
//     Gets installed sites  
//    $.getJSON(siteURL, function (data) {
//        var siteData = [];
//        $.each(data, function (i, v) {
//            siteData[i] = [v['facility_id'], v['version'], v['setup_date'], v['active_patients'], v['contact_name'], v['contact_phone'], v['']];
//        });
//        var table = $('#sites_listing').DataTable({
//
//            data: siteData,
//            responsive: true,
//            "columnDefs": [{
//                    "targets": -1,
//                    "data": null,
//                    "render": function (facility_id, type, full, meta) {
//                        return '<a href="Sites/pages/update_site' + facility_id + '"><i class="fa fa-pencil"></i></a>';
//                    }}]
//             "defaultContent": "<button>Edit</button>"
//        });
//
//        $('#sites_listing tbody').on('click', 'tr', function () {
////            var rowData = table.row(this).data();
//            // ... do something with `rowData`
//            var data = table.row($(this).parents('tr')).data();
//            alert(data[0] + "'s salary is: " + data[ 5 ]);
////            alert(rowData)
////            console.log(rowData);
//        });
//    });

    $.getJSON(facilityURL, function (data) {
        $("#facility option").remove();
        $("#facility").append($("<option value=''>Select Facility</option>"));
        $.each(data, function (i, v) {
            $("#facility").append($("<option value='" + v.id + "' mflcode='" + v.mflcode + "' subcountyid='" + v.subcounty_id + "' partnerid='" + v.partner_id + "' >" + v.name + "</option>"));
        });
    });

    //Gets all subcounties
    $.getJSON(subcountyURL, function (data) {
        $("#subcounty option").remove();
        $("#subcounty").append($("<option value=''>Select Subcounty</option>"));
        $.each(data, function (i, v) {
            $("#subcounty").append($("<option value='" + v.id + "' countyid='" + v.county_id + "'>" + v.name + "</option>"));
        });
    });

    //Gets all counties
    $.getJSON(countyURL, function (data) {
        $("#county option").remove();
        $("#county").append($("<option value=''>Select County</option>"));
        $.each(data, function (i, v) {
            $("#county").append($("<option value='" + v.id + "' countyid='" + v.county_id + "'>" + v.name + "</option>"));
        });
    });

    //Gets all partners
    $.getJSON(partnerURL, function (data) {
        $("#partner option").remove();
        $("#partner").append($("<option value=''>Select Partner</option>"));
        $.each(data, function (i, v) {
            $("#partner").append($("<option value='" + v.id + "'>" + v.name + "</option>"));
        });
    });

    //Gets all users
    $.getJSON(userURL, function (data) {
        $("#user option").remove();
        $("#user").append($("<option value=''>Select Assignee</option>"));
        $.each(data, function (i, v) {
            $("#user").append($("<option value='" + v.id + "'>" + v.name + "</option>"));
        });
    });

    //Add mflcode when facility is selected
    $('#facility').on('change', function () {
        $('#mflcode').val($(this).find(':selected').attr('mflcode'));
        $('#subcounty').val($(this).find(':selected').attr('subcountyid'));
        $("#county").val($('#subcounty').find(':selected').attr('countyid'));
        $("#partner").val($(this).find(':selected').attr('partnerid'));
    });

    //EMRS Used multiselect
    $('#emrs_used').multiselect();


    //Date picker setup_date
    $.fn.datepicker.defaults.format = "yyyy/mm/dd";
    $.fn.datepicker.defaults.endDate = '0d';
    $('#setup_date').datepicker({
    });

    //Date picker update_date
    $.fn.datepicker.defaults.format = "yyyy/mm/dd";
    $.fn.datepicker.defaults.endDate = '0d';
    $('#update_date').datepicker({
    });
});

//Gets all installed sites
var table;

$(document).ready(function () {
    //datatables
    table = $('#table').DataTable({

        "processing": true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        "serverSide": true,
        "order": [],

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "Sites/ajax_list",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [-1], //last column
                "orderable": false,
            },
        ],

    });

});

function deleteSite(id)
{
    if (confirm('Are you sure you want to delete this site?'))
    {
        // ajax delete data from database
        $.ajax({
            url: "Sites/delete_site/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {

                location.reload();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

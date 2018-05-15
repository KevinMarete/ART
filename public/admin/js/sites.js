var siteURL = '../API/install';
var facilityURL = '../API/facility';
var countyURL = '../API/county';
var subcountyURL = '../API/subcounty';
var partnerURL = '../API/partner';
var userURL = '../API/user';

$(function () {
    $.getJSON(facilityURL, function (data) {
        $("#facility option").remove();
        $("#facility").append($("<option value=''>Select Facility</option>"));
        $.each(data, function (i, v) {
            $("#facility").append($("<option value='" + v.id + "' mflcode='" + v.mflcode + "' subcountyid='" + v.subcounty_id + "' partnerid='" + v.partner_id + "' >" + v.name + " (" + v.mflcode + ")</option>"));
        });
        $("#facility").chosen({width: "100%"});
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
        $('#mflcode').val($(this).find(':selected').attr('mflcode')).trigger('change');
        $('#subcounty').val($(this).find(':selected').attr('subcountyid')).trigger('change');
        $("#county").val($('#subcounty').find(':selected').attr('countyid')).trigger('change');
        $("#partner").val($(this).find(':selected').attr('partnerid')).trigger('change');
    });

    //EMRS Used multiselect
    $('#emrs_used').multiselect();

    //Select2 for county
    $("#county").select2({
        placeholder: "Select County",
        allowClear: true,
        dropdownParent: $("#exampleModal")
    });

    //select2 for Subcounty
    $("#subcounty").select2({
        placeholder: "Select Subcounty",
        allowClear: true,
        dropdownParent: $("#exampleModal")
    });
    //select2 for partner
    $("#partner").select2({
        placeholder: "Select Partner",
        allowClear: true,
        dropdownParent: $("#exampleModal")
    });

    //select2 for assignee
    $("#user").select2({
        placeholder: "Select Assignee",
        allowClear: true,
        dropdownParent: $("#exampleModal")
    });

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

//function deleteSite
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
//select2 for assignee_edit
$("#user_edit").select2();
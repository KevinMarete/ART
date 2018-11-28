$(document).ready(function () {
    dt = new Date();
    newmonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    year = dt.getFullYear(), month = newmonth[dt.getMonth()], drug = 'Dolutegravir (DTG) 50mg Tabs';
    //alert(year + monthname)
    role = "<?php echo $this->session->userdata('role'); ?>";
    scope_name = "<?php echo $this->session->userdata('scope_name'); ?>";

    if (role == 'subcounty') {
        $.post("<?php echo base_url() . 'Manager/Procurement/loadMenuData/facility/subcounty/' ?>", {id: scope_name}, function (res) {
            subcountyfacility = $('#SubCountyFacilityFilter');
            subcountyfacility.empty();
            $('#SubCountyFacilityFilter').append('<option value="">-Facility(None)-</option>');
            $.each(res.data, function (i, c) {
                subcountyfacility.append('<option value="' + c.facility + '">' + c.facility.toUpperCase() + '</option>');
            });
        }, 'json');
    } else if (role =='county') {
        $.post("<?php echo base_url() . 'Manager/Procurement/loadMenuData/subcounty/county/' ?>", {id: scope_name}, function (res) {
            subcounty = $('#SubCountyFilter');
            subcounty.empty();
            $('#SubCountyFilter').append('<option value="">-Sub-County(None)-</option>');
            $.each(res.data, function (i, c) {
                subcounty.append('<option value="' + c.subcounty + '">' + c.subcounty.toUpperCase() + '</option>');
            });
        }, 'json');
    }


    $.getJSON("<?php echo base_url() . 'Manager/Procurement/loadMenuData/county/'; ?>", function (res) {
        county = $('#CountyFilter');
        county.empty();
        $('#CountyFilter').append('<option value="">-County(None)-</option>');
        $.each(res.data, function (i, c) {
            county.append('<option value="' + c.county + '">' + c.county.toUpperCase() + '</option>');
        });

    });

    $.getJSON(drugListURL, function (res) {
        drugs = $('#DrugFilter');
        drugs.empty();
        $.each(res, function (i, c) {
            drugs.append('<option value="' + c.name + '">' + c.name.toUpperCase() + '</option>');
        });

    }).done(function () {
        $('#DrugFilter').multiselect({
            enableFiltering: true,
            filterBehavior: 'value'
        });
    });


    //Get drug list
    $.getJSON(drugListURL, function (resp) {
        $('#filter_item').empty();
        $.each(resp, function (i, d) {
            $('#filter_item').append('<option value="' + d.name + '">' + d.name + '</option>');
        });
    }, 'json').done(function () {
        $('#filter_item').multiselect({
            enableFiltering: true,
            filterBehavior: 'value'
        });
    });
    

    $('#CountyFilter').change(function () {
        id = $(this).val();

        $.post("<?php echo base_url() . 'Manager/Procurement/loadMenuData/subcounty/county/' ?>", {id: id}, function (res) {
            subcounty = $('#SubCountyFilter');
            subcounty.empty();
            $('#SubCountyFilter').append('<option value="">-County(None)</option>');
            $.each(res.data, function (i, c) {
                subcounty.append('<option value="' + c.subcounty + '">' + c.subcounty.toUpperCase() + '</option>');
            });

        }, 'json');
    });

    $('#SubCountyFilter').change(function () {
        id = $(this).val();
        $.post("<?php echo base_url() . 'Manager/Procurement/loadMenuData/facility/subcounty/' ?>", {id: id}, function (res) {
            subcountyfacility = $('#SubCountyFacilityFilter');
            subcountyfacility.empty();
            $('#SubCountyFacilityFilter').append('<option value="">-Facility(None)</option>');
            $.each(res.data, function (i, c) {
                subcountyfacility.append('<option value="' + c.facility + '">' + c.facility.toUpperCase() + '</option>');
            });

        }, 'json');
    });

});
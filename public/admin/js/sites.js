var siteURL = '../API/install'
var facilityURL = '../API/facility'
var countyURL = '../API/county'
var subcountyURL = '../API/subcounty'
var partnerURL = '../API/partner'
var userURL = '../API/user'

$(function() {
	//Gets installed sites
	$.getJSON(siteURL, function(data){
		var siteData = []
		$.each(data, function(i, v){
			siteData[i] = [v['facility_id'], v['version'], v['setup_date'], v['active_patients'], v['contact_name'], v['contact_phone']]
		});
		$('#sites_listing').DataTable({
			data: siteData,
	        responsive: true
	    });
	});

	//Gets all facilities
	$.getJSON(facilityURL, function(data){
		$("#facility option").remove();
		$("#facility").append($("<option value=''>Select Facility</option>"));
		$.each(data, function(i, v) {
			$("#facility").append($("<option value='" + v.id + "' mflcode='"+v.mflcode+"' subcountyid='"+v.subcounty_id+"' partnerid='"+v.partner_id+"' >" + v.name + "</option>"));
		});
	});

	//Gets all subcounties
	$.getJSON(subcountyURL, function(data){
		$("#subcounty option").remove();
		$("#subcounty").append($("<option value=''>Select Subcounty</option>"));
		$.each(data, function(i, v) {
			$("#subcounty").append($("<option value='" + v.id + "' countyid='" + v.county_id + "'>" + v.name + "</option>"));
		});
	});

	//Gets all counties
	$.getJSON(countyURL, function(data){
		$("#county option").remove();
		$("#county").append($("<option value=''>Select County</option>"));
		$.each(data, function(i, v) {
			$("#county").append($("<option value='" + v.id + "' countyid='" + v.county_id + "'>" + v.name + "</option>"));
		});
	});

	//Gets all partners
	$.getJSON(partnerURL, function(data){
		$("#partner option").remove();
		$("#partner").append($("<option value=''>Select Partner</option>"));
		$.each(data, function(i, v) {
			$("#partner").append($("<option value='" + v.id + "'>" + v.name + "</option>"));
		});
	});

	//Gets all users
	$.getJSON(userURL, function(data){
		$("#user option").remove();
		$("#user").append($("<option value=''>Select Assignee</option>"));
		$.each(data, function(i, v) {
			$("#user").append($("<option value='" + v.id + "'>" + v.name + "</option>"));
		});
	});

	//Add mflcode when facility is selected
	$('#facility').on('change', function(){
		$('#mflcode').val($(this).find(':selected').attr('mflcode'))
		$('#subcounty').val($(this).find(':selected').attr('subcountyid'))
		$("#county").val($('#subcounty').find(':selected').attr('countyid'));
		$("#partner").val($(this).find(':selected').attr('partnerid'));
	});

	//EMRS Used multiselect
	$('#emrs_used').multiselect();
});
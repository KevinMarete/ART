var siteURL = '../API/install'
$(function() {
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
});
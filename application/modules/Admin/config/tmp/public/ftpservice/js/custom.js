$(document).ready(function(){
	//Hide alert message after(20sec)
	setTimeout(function() {
		$(".alert-msg").fadeOut("20000");
	}, 20000);

	/*Multi-file upload*/
	$('#filer_input').filer({
		showThumbs: true,
		addMore: true,
		allowDuplicates: false
	});

	/*Load Pending Files*/
	var ftp_pending_table = $('#ftp_pending').DataTable({
        "ajax": 'files/pending_dir',
        "pageLength": 5
    });

	/*Load Completed Files*/
   	var ftp_completed_table = $('#ftp_completed').DataTable({
        "ajax": 'files/completed_dir',
        "pageLength": 5
    });

	/*Prevent Double Submission*/
	jQuery('form').on('submit',function(){
		$(this).find(':submit').prop('disabled', true);
	});

	/*Send request to analyze pending files*/
	$('#analyze_files').on('click', function(e){
		var element = $(this)
		var analysisDiv = '#analysis_progress'
		//Disable link
		element.addClass('disabled');
		//Prevent href
		e.preventDefault();
		//Load Spinner to show progress
		LoadSpinner(analysisDiv);
		//Send request and provide feedback
		$.getJSON(element.attr('href'), function(files){
			//Clear Spinner
			$(analysisDiv).html('')
			//Get responses
			$.each(files, function(file, data){
				var inner_msg = '<strong><u>'+file+'</u></strong><br/>'+data.message
				$.each(data.sheets, function(sheet, status){
					if(status){
						inner_msg += 'SUCCESS: '+sheet+'<br/>'
					}else{
						inner_msg += 'FAILED: '+sheet+'<br/>'
					}
				});
				var message = '<div class="alert alert-info alert-dismissible alert-msg" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+inner_msg+'</div>'
				$(analysisDiv).append(message)
			});
			//Enable link
			element.removeClass('disabled');
			//Reload tables
			ftp_pending_table.ajax.reload();
			ftp_completed_table.ajax.reload();
		});
	});

});

function LoadSpinner(divID){
    var spinner = new Spinner().spin()
    $(divID).empty('')
    $(divID).height('auto')
    $(divID).append(spinner.el)
}

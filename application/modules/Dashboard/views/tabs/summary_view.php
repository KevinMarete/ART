<div role="tabpanel" class="tab-pane active" id="summary">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-sm-12">
		  		<!--patient_scaleup_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						PATIENT SCALEUP TREND
					</div>
					<div class="chart-stage">
						<div id="patient_scaleup_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="patient_scaleup_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    
	    <div class="row">
		  	<div class="col-sm-12">
		  		<!--national_mos_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						PATIENT SERVICES BY COUNTY 
					</div>
					<div class="chart-stage">
						<div id="patient_services_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="patient_services_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <div class="row">
		  	<div class="col-sm-12">
		  		<!--national_mos_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						NATIONAL MONTHS OF STOCK (MOS) 
						<button class="btn btn-default" data-toggle="modal" data-target="#mos_filter_modal">Filter</button>
					</div>
					<div class="chart-stage">
						<div id="mos-filter">
							<script type="text/javascript">
							    $(document).ready(function() {
							        $('#mos_filter').multiselect({
							        	disableIfEmpty: true,
						            	enableFiltering: true,
						            	maxHeight: 200,
						            	buttonWidth: '400px',
						            	includeSelectAllOption: true,
						            	selectAllNumber: true,
						            	enableCaseInsensitiveFiltering: true,
							        });

							        // reset button
						            $('#mos_filter_frm').on('reset', function() {
							            $('#mos_filter option:selected').each(function() {
							                $(this).prop('selected', false);
							            })
							 
							            $('#mos_filter').multiselect('refresh');
							        });
							    });
							</script>
						</div>
						<div id="national_mos_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="national_mos_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>

	    <!-- modals -->
	    <div class="modal fade" id="mos_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">National MOS Drug Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="mos_filter_frm">
		            		<select id="mos_filter" multiple="multiple" class="mos_drug_list"></select>
							<button type="reset" class="btn btn-default">Reset</button>
		                	<button type="submit" class="btn btn-success">Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
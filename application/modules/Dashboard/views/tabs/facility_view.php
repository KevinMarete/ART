<div role="tabpanel" class="tab-pane" id="facility">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<!--commodities analysis-->
				<div class="form-group">
					<!-- facility select button -->
					<script type="text/javascript">
					    $(document).ready(function() {
					        $('#single_facility_filter').multiselect({
					        	nonSelectedText: 'Select Facility',
					        	disableIfEmpty: true,
				            	enableFiltering: true,
				            	maxHeight: 200,
				            	buttonWidth: '400px',
				            	includeSelectAllOption: true,
				            	selectAllNumber: true,
				            	enableCaseInsensitiveFiltering: true,
					        });

					        //reset the form
					        $('#facilities_filter_frm').on('reset', function() {
					            $('#single_facility_filter option:selected').each(function() {
					                $(this).prop('selected', false);
					            })
					 
					            $('#single_facility_filter').multiselect('refresh');
					        });
					    });
					</script>
					<form id="facilities_filter_frm">
						<select id="single_facility_filter" class="single_facility_filter" size="2"></select>
						<!-- clear button -->
						<button id="facility_clear_btn" class="btn btn-info btn-md hidden" type="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
					</form>
				</div>
			</div>
		  	<div class="col-sm-12" id="facility_chart_one">
		  		<!--facility_patient_distribution_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						Facility Patient Distribution
					</div>
					<div class="chart-stage">
						<div id="facility_patient_distribution_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="facility_patient_distribution_heading"></span>
					</div>
				</div>
		 	</div>
		  	<div class="col-sm-12" id="facility_chart_two">
		  		<!--facility_patient_distribution_table-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						Facilities Table
					</div>
					<div class="chart-stage">
						<div id="facility_patient_distribution_table"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="facility_patient_distribution_heading"></span>
					</div>
				</div>
	 		</div>

		 	<div class="col-sm-12 hidden" id="facility_chart_four">
		  		<!--regimen_distribution_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						Regimen Distribution by Line
					</div>
					<div class="chart-stage">
						<div id="facility_regimen_distribution_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="facility_patient_distribution_heading"></span>
					</div>
				</div>
		 	</div>

		 	<div class="col-sm-12 hidden" id="facility_chart_five">
		  		<!--facility_commodity_consumption_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						Commodity Consumption in Facility
						<button data-toggle="modal" data-target="#facility_commodity_consumption_modal" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
					</div>
					<div class="chart-stage">
						<script type="text/javascript">
						    $(document).ready(function() {
						        $('#facility_commodity_consumption').multiselect({
						        		disableIfEmpty: true,
						            	enableFiltering: true,
						            	maxHeight: 200,
						            	buttonWidth: '400px',
						            	includeSelectAllOption: true,
						            	selectAllNumber: true,
						            	enableCaseInsensitiveFiltering: true,
						        });
						        // reset button
					            $('#facility_commodity_consumption_frm').on('reset', function() {
						            $('#facility_commodity_consumption option:selected').each(function() {
						                $(this).prop('selected', false);
						            })
						 
						            $('#facility_commodity_consumption').multiselect('refresh');
						        });
						    });
						</script>
						<div id="facility_commodity_consumption_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="facility_patient_distribution_heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<!-- modal -->
		<div class="modal fade" id="facility_commodity_consumption_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">Facility Commodity Consumption Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="facility_commodity_consumption_frm">
		                	<select id="facility_commodity_consumption" multiple="multiple" class="drug_list"></select>
		                	<!-- <button type="reset" class="btn btn-info btn-md"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
		                	<button type="submit" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
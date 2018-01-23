<div role="tabpanel" class="tab-pane" id="facility">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<!--commodities analysis-->
				<div class="form-group">
					<!-- facility select button -->
					<select id="single_facility_filter" class="single_facility_filter" size="2"></select>
					<script type="text/javascript">
					    $(document).ready(function() {
					        $('#single_facility_filter').multiselect({
					        	nonSelectedText: '--Select Facility--',
					        	disableIfEmpty: true,
				            	enableFiltering: true,
				            	maxHeight: 200,
				            	buttonWidth: '400px',
				            	includeSelectAllOption: true,
				            	selectAllNumber: true,
				            	enableCaseInsensitiveFiltering: true,
					        });
					    });
					</script>
					<!-- clear button -->
					<button id="facility_clear_btn" class="hidden">clear</button>
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
						<button class="btn btn-warning" data-toggle="modal" data-target="#facility_commodity_consumption_modal">Filter</button>
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
		                <h4 class="modal-title">Facility Commodity Consumption Modal</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="facility_commodity_consumption_frm">
		                	<select id="facility_commodity_consumption" multiple="multiple" class="drug_list"></select>
		                	<button type="reset" class="btn btn-default">Reset</button>
		                	<button type="submit" class="btn btn-warning">Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
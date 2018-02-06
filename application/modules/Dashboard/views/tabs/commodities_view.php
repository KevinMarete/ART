<div role="tabpanel" class="tab-pane" id="commodity">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<!--commodities analysis-->
				<div class="form-group">
					<script type="text/javascript">
					    $(document).ready(function() {
					        $('#single_regimen_filter').multiselect({
					        	nonSelectedText: 'Select Regimen',
					        	disableIfEmpty: true,
				            	enableFiltering: true,
				            	maxHeight: 200,
				            	buttonWidth: '400px',
				            	includeSelectAllOption: true,
				            	selectAllNumber: true,
				            	enableCaseInsensitiveFiltering: true,
					        });

					        //reset the form
					        $('#regimen_filter_frm').on('reset', function() {
					            $('#single_regimen_filter option:selected').each(function() {
					                $(this).prop('selected', false);
					            })
					 
					            $('#single_regimen_filter').multiselect('refresh');
					        });
					    });
					</script>
					<form id="regimen_filter_frm">
						<select id="single_regimen_filter" class="regimen_filter" size="2"></select>
						<button id="regimen_clear_btn" class="btn btn-info btn-md hidden" type="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
					</form>
				</div>
			</div>
			<div class="col-sm-12" id="regimen_chart_one">
				<div class="chart-wrapper">
					<div class="chart-title">
						Regimens
					</div>
					<div class="chart-stage">
						<div id="regimen_patient_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="commodity_analysis_heading"></span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 hidden" id="regimen_chart_two">
				<div class="chart-wrapper">
					<div class="chart-title">
					</div>
					<div class="chart-stage">
						<div id="drug_regimen_consumption_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="drug_regimen_heading"></span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 hidden" id="regimen_chart_three">
				<div class="chart-wrapper">
					<div class="chart-title">
						Regimen Drugs consumption
					</div>
					<div class="chart-stage">
						<div id="drug_consumption_chart"></div>
						<small>*Note: drugs may be used in more than 1 regimen hence may affect accuracy of above data</small> 
					</div>
					<div class="chart-notes">
						Filtered By: <span class="drug_consumption_heading"></span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 hidden" id="regimen_chart_four">
				<div class="chart-wrapper">
					<div class="chart-title">
						Patients on regimen by County
					</div>
					<div class="chart-stage">
						<div id="regimen_patients_counties_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="regimen_patients_counties_heading"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
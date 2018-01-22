<div role="tabpanel" class="tab-pane" id="drug">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<!--commodities analysis-->
				<div class="form-group">
					<select name="facility_filter" id="facility_filter" data-filter_type="facility" class="form-control facility_filter">
						<option value="">-- Select Facility --</option>
					</select>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="chart-wrapper">
					<div class="chart-title">
					</div>
					<div class="chart-stage">
						<div id="patients_distribution_service_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="drug_regimen_heading"></span>
					</div>
				</div>
			</div>

			<div class="col-sm-12">
				<div class="chart-wrapper">
					<div class="chart-title">
						Regimen Drugs consumption
					</div>
					<div class="chart-stage">
						<div id="regimen_distribution_chart"></div>
						<small>*Note: drugs may be used in more than 1 regimen hence may affect accuracy of above data</small> 
					</div>
					<div class="chart-notes">
						Filtered By: <span class="drug_consumption_heading"></span>
					</div>
				</div>
			</div>


			<div class="col-sm-12">
				<div class="chart-wrapper">
					<div class="chart-title">
						Patients on regimen by County
					</div>
					<div class="chart-stage">
						<div id="facility_commodity_consumption_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="regimen_patients_counties_heading"></span>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
<div role="tabpanel" class="tab-pane" id="procurement">	
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--consumption_issues_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>AVERAGE CONSUMPTION/ISSUES TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#consumption_issues_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="consumption_issues_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="consumption_issues_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--actual_consumption_issues_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>ACTUAL CONSUMPTION/ISSUES TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#actual_consumption_issues_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="actual_consumption_issues_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="actual_consumption_issues_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--kemsa_soh_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>KEMSA STOCK ON HAND(SOH) TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#kemsa_soh_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="kemsa_soh_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="kemsa_soh_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
		  	<div class="col-sm-6">
			  	<!--adult_patients_on_drug_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>ADULT PATIENTS ON SELECTED DRUG</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#adult_patients_on_drug_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="adult_patients_on_drug_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="adult_patients_on_drug_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		 	<div class="col-sm-6">
			  	<!--ppaed_atients_on_drug_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>PAEDIATRIC PATIENTS ON SELECTED DRUG</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#paed_patients_on_drug_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="paed_patients_on_drug_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="paed_patients_on_drug_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
		<div class="row">
		  	<div class="col-sm-6">
			  	<!--stock_status_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>STOCK STATUS</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#stock_status_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="stock_status_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="stock_status_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		 	<div class="col-sm-6">
			  	<!--expected_delivery_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>EXPECTED DELIVERY</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#expected_delivery_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="expected_delivery_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="expected_delivery_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
		<!--modal(s)-->
		<div class="modal fade" id="consumption_issues_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>AVERAGE CONSUMPTION/ISSUES TREND FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="consumption_issues_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="consumption_issues_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="consumption_issues_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="actual_consumption_issues_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>ACTUAL CONSUMPTION/ISSUES TREND FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="actual_consumption_issues_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="actual_consumption_issues_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="actual_consumption_issues_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="kemsa_soh_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>KEMSA STOCK ON HAND(SOH) TREND FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="kemsa_soh_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="kemsa_soh_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="kemsa_soh_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="adult_patients_on_drug_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>PATIENTS ON SELECTED DRUG FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="adult_patients_on_drug_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="adult_patients_on_drug_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="adult_patients_on_drug_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="paed_patients_on_drug_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>PATIENTS ON SELECTED DRUG FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="paed_patients_on_drug_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="paed_patients_on_drug_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="paed_patients_on_drug_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="stock_status_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>STOCK STATUS FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="stock_status_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="stock_status_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="stock_status_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="expected_delivery_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>EXPECTED DELIVERY FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="expected_delivery_chart_filter" data-filter_type="drug" size="2"></select>
							</div>
							<div class="col-sm-3">
								<button id="expected_delivery_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="expected_delivery_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
    </div>
</div>
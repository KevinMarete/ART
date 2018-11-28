<div role="tabpanel" class="tab-pane" id="county">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-sm-12">
		  		<!--county_patient_distribution_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COUNTY PATIENT DISTRIBUTION</strong>
					</div>
					<div class="chart-stage">
						<div id="county_patient_distribution_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="county_patient_distribution_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--county_commodity_soh_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COUNTY COMMODITY STOCK ON HAND TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#county_commodity_soh_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="county_commodity_soh_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="county_commodity_soh_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
		  		<!--county_commodity_stock_movement_table-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COUNTY COMMODITY STOCK MOVEMENT</strong>
					</div>
					<div class="chart-stage">
						<div id="county_commodity_stock_movement_table"></div>
					</div>
					<div class="chart-notes">
						<span class="county_commodity_stock_movement_table_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
		<div class="row">
			<div class="col-sm-12">
		  		<!--county_patient_distribution_table-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COUNTY PATIENT DISTRIBUTION (BY FACILITIES AND AGEGROUP)</strong>
					</div>
					<div class="chart-stage">
						<div id="county_patient_distribution_table"></div>
					</div>
					<div class="chart-notes">
						<span class="county_patient_distribution_table_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	   	<!--modal(s)-->
		<div class="modal fade" id="county_commodity_soh_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>COUNTY COMMODITY SOH FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-sm-9">
								<select id="county_commodity_soh_chart_filter" multiple="multiple" data-filter_type="drug"></select>
							</div>
							<div class="col-sm-3">
								<button id="county_commodity_soh_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
								<button id="county_commodity_soh_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            		</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
    </div>
</div>


<div role="tabpanel" class="tab-pane active" id="summary">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-sm-12">
		  		<!--patient_scaleup_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>PATIENT SCALEUP TREND</strong>
					</div>
					<div class="chart-stage">
						<div id="patient_scaleup_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="patient_scaleup_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <div class="row">
		  	<div class="col-sm-12">
		  		<!--patient_services_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>PATIENT SERVICES BY COUNTY</strong>
					</div>
					<div class="chart-stage">
						<div id="patient_services_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="patient_services_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <div class="row">
		  	<div class="col-sm-12">
		  		<!--national_mos_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>NATIONAL MONTHS OF STOCK (MOS)</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#national_mos_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="national_mos_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="national_mos_chart_heading heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <!--modal(s)-->
	    <div class="modal fade" id="national_mos_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>NATIONAL MONTHS OF STOCK (MOS) FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<div class="row">
							<div class="col-md-9">
								<select id="national_mos_chart_filter" multiple="multiple" data-filter_type="drug"></select>
							</div>
							<div class="col-md-3">
								<button id="national_mos_chart_filter_clear_btn" class="btn btn-danger btn-sm clear_btn"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
								<button id="national_mos_chart_filter_btn" class="btn btn-warning btn-sm filter_btn"><span class="glyphicon glyphicon-filter"></span> Filter</button>
							</div>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
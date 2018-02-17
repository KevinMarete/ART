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
						<span class="patient_scaleup_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <div class="row">
		  	<div class="col-sm-12">
		  		<!--patient_services_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						PATIENT SERVICES BY COUNTY 
					</div>
					<div class="chart-stage">
						<div id="patient_services_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="patient_services_heading"></span>
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
						<button data-toggle="modal" data-target="#national_mos_chart_filter_modal" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
					</div>
					<div class="chart-stage">
						<div id="national_mos_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="national_mos_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <!--filter-modal-->
	    <div class="modal fade" id="national_mos_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">National MOS Drug Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<div id="national_mos_chart_filter_frm">
		            		<select id="national_mos_chart_filter" multiple="multiple"></select>
							<button id="national_mos_chart_filter_clear_btn" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
		                	<button id="national_mos_chart_filter_btn" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            	</div>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
<!--summary-->
<script src="<?php echo base_url() . 'public/dashboard/js/summary.js'; ?>"></script>
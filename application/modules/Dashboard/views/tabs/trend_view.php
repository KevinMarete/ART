<div role="tabpanel" class="tab-pane" id="trend">	
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--commodity_consumption_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COMMODITY CONSUMPTION TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#commodity_consumption_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="commodity_consumption_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="commodity_consumption_chart_heading"></span>
					</div>
				</div>
		 	</div>
		</div>
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--patients_regimen_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>PATIENTS ON REGIMEN TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#patients_regimen_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="patients_regimen_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="patients_regimen_chart_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
		<div class="row">
		  	<div class="col-sm-12">
			  	<!--commodity_month_stock_chart-->
		    	<div class="chart-wrapper">
					<div class="chart-title">
						<strong>COMMODITY MONTHS OF STOCK TREND</strong>
						<div class="nav navbar-right">
							<button data-toggle="modal" data-target="#commodity_month_stock_chart_filter_modal" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>
					<div class="chart-stage">
						<div id="commodity_month_stock_chart"></div>
					</div>
					<div class="chart-notes">
						<span class="commodity_month_stock_chart_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	    <!--modal(s)-->
		<div class="modal fade" id="commodity_consumption_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>COMMODITY CONSUMPTION FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<select id="commodity_consumption_chart_filter" multiple="multiple"></select>
						<button id="commodity_consumption_chart_filter_clear_btn" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
						<button id="commodity_consumption_chart_filter_filter_btn" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="patients_regimen_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>PATIENTS ON REGIMEN FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<select id="patients_regimen_chart_filter"></select>
						<button id="patients_regimen_chart_filter_clear_btn" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
						<button id="patients_regimen_chart_filter_btn" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="commodity_month_stock_chart_filter_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title"><strong>COMMODITY MONTHS OF STOCK (MOS) TREND FILTER</strong></h4>
		            </div>
		            <div class="modal-body">
						<select id="commodity_month_stock_chart_filter" class="cms_drug_list"></select>
						<button id="commodity_month_stock_chart_filter_clear_btn" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
						<button id="commodity_month_stock_chart_filter_btn" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
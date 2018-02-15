<div role="tabpanel" class="tab-pane" id="trend">	
	<div class="container-fluid">
  		<!--commodity_consumption_chart-->
		<div class="row">
		  	<div class="col-sm-12">
		    	<div class="chart-wrapper">
					<div class="chart-title">
						Commodity Consumption Trend
						<button data-toggle="modal" data-target="#commodity_consumption_modal" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
					</div>
					<div class="chart-stage">
						<div id="commodity_consumption_filter">
						    <!-- Initialize the plugin: -->
						    <script type="text/javascript">
						        $(document).ready(function() {
						            $('#drugs').multiselect({
						            	disableIfEmpty: true,
						            	enableFiltering: true,
						            	maxHeight: 200,
						            	buttonWidth: '400px',
						            	includeSelectAllOption: true,
						            	selectAllNumber: true,
						            	enableCaseInsensitiveFiltering: true,  
						            });
						            // reset button
						            $('#trend_view_filter_frm').on('reset', function() {
							            $('#drugs option:selected').each(function() {
							                $(this).prop('selected', false);
							            })
							 
							            $('#drugs').multiselect('refresh');
							        });
						        });
						    </script>
						</div>
						<div id="commodity_consumption_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="commodity_consumption_heading"></span>
					</div>
				</div>
		 	</div>
		</div>

  		<!--patients_regimen_chart-->
		<div class="row">
		  	<div class="col-sm-12">
		    	<div class="chart-wrapper">
					<div class="chart-title">
						PATIENTS ON REGIMEN
						<button data-toggle="modal" data-target="#patients_regm_modal" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
					</div>
					<div class="chart-stage">
						<div id="patients_regimen_filter">
							<script type="text/javascript">
							    $(document).ready(function() {
							        $('#regimen').multiselect({
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
						</div>
						<div id="patients_regimen_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="patient_regimen_heading"></span>
					</div>
				</div>
		 	</div>
	    </div>
	
		<!--commodity_month_stock_chart-->
		<div class="row">
		  	<div class="col-sm-12">
		    	<div class="chart-wrapper">
					<div class="chart-title">
						COMMODITY MONTHS OF STOCK
						<button data-toggle="modal" data-target="#commodity_month_stock_modal" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
					</div>
					<div class="chart-stage">
						<div id="commodity_month_stock">
							<script type="text/javascript">
							    $(document).ready(function() {
							        $('#commodity_stock').multiselect({
							        	disableIfEmpty: true,
						            	enableFiltering: true,
						            	maxHeight: 200,
						            	buttonWidth: '400px',
						            	includeSelectAllOption: true,
						            	selectAllNumber: true,
						            	enableCaseInsensitiveFiltering: true,

			            	            on: {
							                change: function(option, checked) {
							                    var values = [];
							                    $('#commodity_stock option').each(function() {
							                        if ($(this).val() !== option.val()) {
							                            values.push($(this).val());
							                        }
							                    });
							 
							                    $('#commodity_stock').multiselect('deselect', values);
							                }
							            }
							        });
							    });
							</script>
						</div>
						<div id="commodity_month_stock_chart"></div>
					</div>
					<div class="chart-notes">
						Filtered By: <span class="commodity_month_stock_heading" id="selected-cms-drug"></span>
					</div>
				</div>
		 	</div>
	    </div>

	    <!-- modals -->
	    <!-- commodity consumption modal -->
		<div class="modal fade" id="commodity_consumption_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">Commodity Consumption Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="trend_view_filter_frm">
		            		<select id="drugs" multiple="multiple" class="drug_list"></select>
							<!-- <button type="reset" class="btn btn-info btn-md"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
		                	<button type="submit" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
		
		<!-- patients on regimen modal -->
		<div class="modal fade" id="patients_regm_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">Patients on Regimen Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="patient_regimen_filter_frm">
		            		<select id="regimen" class="regimen_list"></select>
		                	<button type="submit" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
		
		<!-- commodity month stock modal -->
		<div class="modal fade" id="commodity_month_stock_modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		                <h4 class="modal-title">Commodity Month Stock Filter</h4>
		            </div>
		            <div class="modal-body">
		            	<form id="commodity_stock_filter_frm">
		            		<select id="commodity_stock" class="cms_drug_list"></select>
		                	<button type="submit" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		            	</form>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
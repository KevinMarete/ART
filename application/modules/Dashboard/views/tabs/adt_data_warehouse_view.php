<div role="tabpanel" class="tab-pane" id="adt_data_warehouse">
    <div class="container-fluid">
        <div class="row">
        	<div class="col-sm-3">
        		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          Data elements
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				      	<select id="data_element">
				      		<option value="dsh_patient_adt">Patient Demographics</option>
				      		<option value="dsh_visit_adt">Patient Visits</option>
				      	</select>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          Periods
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				       	<input type="text" id="date_period" name="date_period">
				       	<input type="hidden" id="period_start" value="">
				       	<input type="hidden" id="period_end" value="">
				      </div>
				    </div>
				  </div>
				</div>
				<button id="btn_get_adt_data" class="btn btn-success btn-sm pull-right"><span class="glyphicon glyphicon-filter"></span> Get Data</button>
        	</div>
            <div class="col-sm-9">
            	<!--adt_data_warehouse_pivot_table-->
                <div class="chart-wrapper">
                    <div class="chart-title">
                        <strong>CUSTOM DATA ANALYSIS</strong>
                    </div>
                    <div class="chart-stage">
                        <div id="data_warehouse_pivot_table"></div>
                    </div>
                    <div class="chart-notes">
                        <span class="adt_data_warehouse_pivot_table_heading heading"></span>
                    </div>
                </div>
           	</div>
        </div>
    </div>
</div>


<script type="text/javascript">
	//Autoload
	$(function() {
		//Data elements
		CreateSelectBox("#data_element", "250px", 10)
		//Period
		var period_start =  moment().subtract(29, 'days').format('YYYY-MM-DD'); 
	    var period_end = moment().format('YYYY-MM-DD');
	    $('#period_start').val(period_start);
	    $('#period_end').val(period_end);
	    //Create daterangepicker
	    $('#date_period').daterangepicker({
	        startDate: period_start,
	        endDate: period_end,
	        maxDate: period_end,
	        showDropdowns: true,
	        locale: {
		      	format: 'YYYY-MM-DD'
		    },
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, function(start, end) {
	        $('#date_period span').html('From: '+ start + ' To: ' + end);
	        $('#period_start').val(start.format('YYYY-MM-DD'))
	        $('#period_end').val(end.format('YYYY-MM-DD'))
	    });

	    //Get data
	    $('#btn_get_adt_data').on('click', function(){
	    	var data_element = $('#data_element').val()
	    	var period_start = $('#period_start').val()
	        var period_end = $('#period_end').val()
	        if(!data_element){
	        	bootbox.alert('<div class="alert alert-danger"><strong>Error!</strong> Please select a data element.</div>');
	        }else{
	        	//Request data and pivotTables
	        	LoadPivotTables('Dashboard/get_adt_data/'+data_element+'/'+period_start+'/'+period_end)
	        }
	    });
	});


	function LoadPivotTables(dataUrl){
		var pivotDiv = "#data_warehouse_pivot_table"
		LoadSpinner(pivotDiv)

		var derivers = $.pivotUtilities.derivers;

        var renderers = $.extend(
            $.pivotUtilities.renderers,
            $.pivotUtilities.c3_renderers,
            $.pivotUtilities.d3_renderers,
            $.pivotUtilities.export_renderers
            );

        $.getJSON(dataUrl, function(data){
	        $(pivotDiv).pivotUI(data.data, {
	            renderers: renderers,
	            rows: data.defs.rows,
	            cols: data.defs.cols,
	            rendererName: "Table",
	            aggregatorName: "Count"
	        }, true);
	    });
	}
</script>
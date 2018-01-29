<script type="text/javascript">
	$(function(){

		$.getJSON("Dashboard/get_regimens", function(jsonData){
			cb = '';
			$.each(jsonData, function(i,data){
				cb+='<option value="'+data.name+'">'+data.name+'</option>';
			});
			$("#single_regimen_filter").append(cb);
		});

			
		$("#single_regimen_filter").change(function(){
		$("#regimen_filter").val($("#single_regimen_filter").val());
			$("#main_tabs a[href='#drug']").trigger('click');
		});

	});

</script>
<div role="tabpanel" class="tab-pane" id="commodity">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<!--commodities analysis-->
				<div class="form-group">
					<select id="single_regimen_filter" class="regimen_filter" size="2"></select>
					<script type="text/javascript">
					    $(document).ready(function() {
					        $('#single_regimen_filter').multiselect({
					        	nonSelectedText: '-- Select Regimen --',
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
			</div>
			<div class="col-sm-12">
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
		</div>
	</div>
</div>
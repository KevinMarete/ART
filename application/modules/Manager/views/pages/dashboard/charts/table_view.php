<?php
	$dyn_table = "<table class='table table-bordered table-condensed table-hover table-striped ".$chart_name."_distribution_table'>";
	$thead = "<thead><tr>";
	$table_data = json_decode($chart_series_data, TRUE);
	$count = 0;
	$tbody = "<tbody>";
	if(!empty($table_data )){
		foreach ($table_data as $row_data) {
			$tbody .= "<tr>";
			foreach ($row_data as $key => $value) {
				//Header
				if($count == 0){
					$thead .= "<th>".strtoupper(str_ireplace('_', ' ', $key))."</th>";
				}
				//Body
				if(gettype($value) == 'string'){
					$tbody .= "<td>".ucwords($value)."</td>";
				}else{
					$tbody .= "<td>".number_format($value)."</td>";
				}
			}
			$tbody .= "</tr>";
			$count++;
		}
		//Add for percentage
		$thead .= "</tr></thead>";
		$tbody .= "</tbody>";
		$dyn_table .= $thead;
		$dyn_table .= $tbody;
		$dyn_table .= "</table>";
	}else{
		$dyn_table .= '<thead><tr><th>Drug</th></tr></thead><tbody></tbody></table>';
	}
 	echo $dyn_table;
?>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<script type="text/javascript">
	$(function() {
		var table_class = "<?php echo $chart_name.'_distribution_table'; ?>";
	    //DataTable
	    var table = $('.'+table_class).DataTable({
	    	"bDestroy": true,
			"pagingType": "full_numbers",
			"ordering": true,
			"responsive": true
		});
	});
</script>
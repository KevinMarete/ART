<?php
	$dyn_table = "<table class='table table-bordered table-condensed table-hover table-striped distribution_table'>";
	$thead = "<thead><tr>";
	$table_data = json_decode($chart_series_data, TRUE);
	$count = 0;
	$tbody = "<tbody>";
	foreach ($table_data as $row_data) {
		$tbody .= "<tr>";
		foreach ($row_data as $key => $value) {
			//Header
			if($count == 0){
				$thead .= "<th>".ucwords($key)."</th>";
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
	$thead .= "</tr></thead>";
	$tbody .= "</tbody>";
	$dyn_table .= $thead;
	$dyn_table .= $tbody;
	$dyn_table .= "</table>";
 	echo $dyn_table;
?>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<script type="text/javascript">
	$(function() {
	    /*DataTable*/
	    $('.distribution_table').DataTable({
	    	"bDestroy": true,
	    	"order": [[ 4, "desc" ]],
	    	"pagingType": "full_numbers",
		   	dom: 'Bfrtip',
	        buttons: [
	            'copy', 
	            {
	            	extend: 'csvHtml5',
	            	filename: '<?php echo $chart_title; ?>',
	            	title: ''
	            }, 
	            {
	            	extend: 'excelHtml5',
	            	filename: '<?php echo $chart_title; ?>',
	            	title: ''
	            },
	            {
	            	extend: 'pdfHtml5',
	            	filename: '<?php echo $chart_title; ?>',
	            	title: ''
	            },
	            {
	            	extend: 'print',
	            	title: ''
	            }
	        ]
	    });
	});
</script>
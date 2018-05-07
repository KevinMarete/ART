<?php
	$dyn_table = "<table class='table table-bordered table-condensed table-hover table-striped distribution_table'>";
	$thead = "<thead><tr>";
	$table_data = json_decode($chart_series_data, TRUE);
	$count = 0;
	$tbody = "<tbody>";
	$overall = array_sum(array_column($table_data, 'total_patients'));
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
		$percentage = round(($value/$overall)*100, 2);
		$progress_bar = '<div class="progress"><div class="progress-bar-info" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%">'.$percentage.'%</div></div>';
		$tbody .= "<td>".$progress_bar."</td>";
		$tbody .= "</tr>";
		$count++;
	}
	//Add for percentage
	$thead .= "<th>OVERALL PERCENTAGE</th>";
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

		//Add search input
		$('.distribution_table thead th').each(function(){
        	var title = $('.distribution_table thead th').eq($(this).index()).text();
        	$(this).html('<input type="text" placeholder="Search '+title.toLowerCase()+'"" />');
    	});

	    //DataTable
	    var table = $('.distribution_table').DataTable({
	    	"bDestroy": true,
			"pagingType": "full_numbers",
			"ordering": false,
			"responsive": true,
		   	"dom": 'Bfrtip',
	        "buttons": [
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
					orientation: 'landscape',
	            	filename: '<?php echo $chart_title; ?>',
	            	title: ''
	            },
	            {
	            	extend: 'print',
	            	title: ''
	            }
	        ]
		});

		//Apply the search
    	table.columns().eq(0).each(function(colIdx){
	        $('input', table.column(colIdx).header()).on('keyup change', function(){
	            table.column(colIdx).search(this.value).draw();
	        });
    	}); 

	});
</script>
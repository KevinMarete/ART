<?php
	$dyn_table = "<table class='table table-bordered table-condensed table-hover table-striped ".$chart_name."_distribution_table'>";
	$thead = "<thead><tr>";
	$table_data = json_decode($chart_series_data, TRUE);
	$count = 0;
	$tbody = "<tbody>";
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
		var table_class = "<?php echo $chart_name.'_distribution_table'; ?>";
	    //DataTable
	    var table = $('.'+table_class).DataTable({
	    	"bDestroy": true,
			"pagingType": "full_numbers",
			"ordering": false,
			"responsive": true,
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
	        ],
            initComplete: function () {
                this.api().columns([0, 1]).every(function () {
                    var column = this;
                    var select = $('<br/><select><option value="">Show all</option></select>')
                            .appendTo($(column.header()))
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );
                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        var val = $('<div/>').html(d).text();
                        select.append('<option value="' + val + '">' + val + '</option>');
                    });
                });
            }
		});

	});
</script>
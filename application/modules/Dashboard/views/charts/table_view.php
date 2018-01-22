<link href="<?php echo base_url()?>public/lib/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url()?>public/lib/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/lib/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/buttons.flash.min.js" > </script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/jszip.min.js" > </script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/pdfmake.min.js" > </script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/vfs_fonts.js" > </script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/buttons.html5.min.js" > </script>
<script type="text/javascript" src ="<?php echo base_url()?>public/lib/datatables/js/buttons.print.min.js" > </script>

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
			$tbody .= "<td>".ucwords($value)."</td>";
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

<script type="text/javascript">
	$(function() {
	    /*DataTable*/
	    $('.distribution_table').DataTable({
	    	"bDestroy": true,
	    	"order": [[ 1, "desc" ]],
	    	"pagingType": "full_numbers",

	    	   dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]

	    });
	});
</script>
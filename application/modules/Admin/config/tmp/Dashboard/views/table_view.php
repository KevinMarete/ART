<?php
	$dyn_table = "<table class='table table-bordered table-condensed table-hover table-striped regimen_table'>";
	$dyn_table .= "<thead><tr><th>Regimen</th><th>Total Patients</th></tr></thead><tbody>";
	$table_data = json_decode($chart_series_data, TRUE);
	$previous_heading = "";

	foreach ($table_data as $row_data) {
		if($row_data['regimen_category'] != $previous_heading){
			$previous_heading = $row_data['regimen_category'];
			$dyn_table .= "<tr class='accordion'><th colspan='2'>".$row_data['regimen_category']."</th></tr>";//Place heading
			$dyn_table .= "<tr><td>".$row_data['regimen']."</td><td>".number_format($row_data['total'])."</td></tr>";
		}else{
			$dyn_table .= "<tr><td>".$row_data['regimen']."</td><td>".number_format($row_data['total'])."</td></tr>";
		}
	}
	$dyn_table .= "</tbody></table>";
 	echo $dyn_table;
?>
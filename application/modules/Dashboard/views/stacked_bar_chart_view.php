<!--chart_container-->
<div id="container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            xAxis: {
                categories: <?php echo $chart_categories; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $chart_metric_title; ?>'
                },
                plotLines: [{
                    color: 'red',
                    dashStyle: 'longdashdot',
                    value: 9,
                    width: 2    
                },
                {
                    color: 'purple',
                    dashStyle: 'longdashdot',
                    value: 15,
                    width: 2    
                }]
            },
            legend: {
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: <?php echo $chart_series_data; ?>,
            exporting: { 
                enabled: false 
            }
        });
    });
</script>
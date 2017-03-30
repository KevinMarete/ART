<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>'

        Highcharts.setOptions({
            global: {
                useUTC: false,
                
            },
            lang: {
              decimalPoint: '.',
              thousandsSep: ','
            },
            colors: ['green', 'red', 'blue']
        });

        Highcharts.chart(chartDIV, {
            chart: {
                type: 'bar'
            },
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },
            credits: false,
            xAxis: {
                categories: <?php echo $chart_categories; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>'
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
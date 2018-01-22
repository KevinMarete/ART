<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>';

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
        xAxis: {
            categories: <?php echo $chart_categories; ?>,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $chart_yaxis_title; ?>',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' patients'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: <?php echo $chart_series_data; ?>,
    });
    })
</script>
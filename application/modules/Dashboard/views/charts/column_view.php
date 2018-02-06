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
            }
        });

        Highcharts.chart(chartDIV, {
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },
            credits: false,
            xAxis: {
                categories: <?php echo $chart_categories; ?>,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>'
                }
            },
            tooltip: {
                pointFormat: '{point.key} <b>{point.y:,.0f}</b>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    colorByPoint: true,
                    dataLabels: {
                        enabled: true
                    }
                },
            },
            series: [{
                name: '<?php echo $chart_xaxis_title; ?>',
                colorByPoint: true,
                data: <?php echo $chart_series_data; ?>
            }],
        });

    });
</script>        
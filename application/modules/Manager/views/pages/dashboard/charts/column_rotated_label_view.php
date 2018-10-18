<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name . "_container"; ?>';

        Highcharts.chart(chartDIV, {
            legend: {
                enabled: true
            },
            chart: {
                type: 'column'
            },

            colors: ['green', 'red', 'blue'],

            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },

            xAxis: {
                categories: <?php echo $chart_categories; ?>,
                crosshair: true
            },

            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>',
                }
            },

            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                footerFormat: 'Total: <b>{point.total:,.1f}</b>',
                shared: true
            },

            plotOptions: {
                series: {
                    stacking: 'normal',
                    pointWidth: 20,
                    dataLabels: {
                        enabled: true,
                        verticalAlign: 'bottom',
                        style: {
                            color: 'black'
                        }
                    },
                    enableMouseTracking: true,
                    borderWidth: 0
                }
            },

            credits: {
                enabled: false
            },

            series: <?php echo $chart_series_data; ?>
        });
    })
</script>

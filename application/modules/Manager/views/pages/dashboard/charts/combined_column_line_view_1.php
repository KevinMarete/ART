<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name . "_container"; ?>';

        Highcharts.setOptions({
            colors: ['#5cb85c', '#f0ad4e', '#5bc0de', '#808080', '#ac5353', '#0080ff', '#ff4000']
        });

        Highcharts.chart(chartDIV, {
            legend: {
                enabled: true,
                reversed: false
            },

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
                    text: 'Stock On Hand / Month(s) Of Stock (MOS)',
                }
            },

            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                // footerFormat: 'Total: <b>{point.total:,.0f}</b>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        y: -20,
                        verticalAlign: 'top',
                        pointWidth: 10
                    }
                },
                line: {
                    dataLabels: {
                        enabled: true,
                        y: -20,
                        verticalAlign: 'top'
                    }
                }
            },
            credits: {
                enabled: false
            },

            series: <?php echo $chart_series_data; ?>,
        });
    })
</script>

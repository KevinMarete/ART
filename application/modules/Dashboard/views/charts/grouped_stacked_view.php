<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>';

        Highcharts.setOptions({
            colors: ['#2f7ed8', '#0d233a', '#8bbc21']
        });

        Highcharts.chart(chartDIV, {
                legend: {
                enabled: true
            },
            chart: {
                type: 'column'
            },

            colors: ['#5cb85c', '#f0ad4e', '#5bc0de'],

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
                formatter: function () {
                    return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        'Total: ' + this.point.stackTotal;
                }
            },

            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },

            credits: {
                enabled: false
            },

            series: <?php echo $chart_series_data; ?>,
        });
    })
</script>

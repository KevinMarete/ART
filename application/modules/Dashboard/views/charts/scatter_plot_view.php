<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>';

        Highcharts.setOptions({
            colors: ['#5cb85c', '#f0ad4e', '#5bc0de']
        });

        Highcharts.chart(chartDIV, {
            legend: {
                enabled: true,
                reversed: true
            },

            chart: {
                type: 'scatter',
                zoomType: 'xy'
            },
            
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },

            xAxis: {
                crosshair: true,
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true,
                min: 0,
                title: {
                    text: '<?php echo $chart_xaxis_title; ?>'
                }
            },

            yAxis: 
            {
                allowDecimals: false,
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>'
                }
            },
            plotOptions: {
                scatter: {
                marker: {
                    radius: 5,
                    states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                    }
                },
                states: {
                    hover: {
                    marker: {
                        enabled: false
                    }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.y} yrs, {point.x} kg'
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

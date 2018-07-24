<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>';

        Highcharts.setOptions({
            colors: ['#5cb85c', '#f0ad4e', '#5bc0de','#808080','#ac5353','#0080ff','#ff4000']
        });

        Highcharts.chart(chartDIV, {
            legend: {
                enabled: true,
                reversed: true
            },

            chart: {
                type: 'column'
            },
            
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },

            xAxis: {
                categories: <?php echo $chart_categories; ?>,
                crosshair: true,                
                plotLines: [{
                    color: 'red',
                    dashStyle: 'longdashdot',
                    value: 9,
                    width: 2,
                    label: {
                        text: 'Minimum'
                    } 
                },{
                    color: 'purple',
                    dashStyle: 'longdashdot',
                    value: 15,
                    width: 2,
                    label: {
                        text: 'Maximum'
                    } 
                }]
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
                footerFormat: 'Total: <b>{point.total:,.0f}</b>',
                shared: true
            },

            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: 'black'
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

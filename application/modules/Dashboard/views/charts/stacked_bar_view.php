<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

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
        });

        Highcharts.chart(chartDIV, {
            chart: {
                type: 'bar'
            },
            colors: ['green', 'red', 'blue'],
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
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                footerFormat: 'Total: <b>{point.total:,.0f}</b>',
                shared: true
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
                enabled: true 
            }
        });
        
    });
</script>
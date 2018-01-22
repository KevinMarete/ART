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
      });

        Highcharts.chart(chartDIV, {
            chart: {
                type: 'bar'
            },
            colors: ['#5cb85c', '#f0ad4e', '#5bc0de'],
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
            // tooltip: {
            //     headerFormat: '<b>{point.x}</b><br/>',
            //     pointFormat: '{series.name}: {point.y}<br/>% contribution: {point.percentage:.1f}%'
            // },

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
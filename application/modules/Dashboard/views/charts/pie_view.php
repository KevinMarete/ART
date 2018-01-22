<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>'

        Highcharts.chart(chartDIV, {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text:  '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },
            legend: {
                enabled: true,
                width:555,
                itemWidth:500,
                itemStyle: {
                    width:500
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: false,
                        format: '{point.name}: {point.percentage:.1f}%'
                    },
                    showInLegend: true
                }
            },
            credits: false,
            tooltip: {
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.1f}%</b><br/>'
            },
            series: [{
                name: '<?php echo $chart_xaxis_title; ?>',
                colorByPoint: true,
                data: <?php echo $chart_series_data; ?>
            }],
            // drilldown: {
            //     series: <?php // echo $chart_drilldown_data; ?>
            // },
            exporting: { 
                enabled: true 
            }
        });
    });
</script>
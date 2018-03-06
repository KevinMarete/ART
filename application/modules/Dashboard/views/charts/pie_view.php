<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>
<input type="hidden" data-filters="<?php echo $selectedfilters; ?>" id="<?php echo $chart_name; ?>_filters"/>

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
            colors: ['red', 'green'],
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
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f}%',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            credits: false,
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '<span style="color:{series.color}">{point.name}</span>: <b>{point.y}</b> ({point.percentage:.1f}%)<br/>',
                footerFormat: 'Total: <b>{point.total:,.0f}</b>',
                shared: true
            },
            series: [{
                name: '<?php echo $chart_xaxis_title; ?>',
                colorByPoint: true,
                data: <?php echo $chart_series_data; ?>
            }],
            exporting: { 
                enabled: true 
            }
        });
    });
</script>
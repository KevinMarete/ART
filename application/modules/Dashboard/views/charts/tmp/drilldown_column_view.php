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
            }
        });

        Highcharts.chart(chartDIV, {
            chart: {
                type: 'column',
            },
            title: {
                text: 'Patients Numbers By Age & Regimen Category'
            },
            subtitle: {
                text: 'Source: www.nascop.org'
            },
            credits: false,
            xAxis: {
                type: 'category'
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No. of Patients'
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
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Regimen Category',
                colorByPoint: true,
                data: <?php echo $chart_series_data; ?>,           
            }],
            drilldown: {
                series: <?php echo $chart_drilldown_data; ?>         
            },
            exporting: { 
                enabled: true 
            }
        });

    });
</script>
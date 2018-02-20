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
                type: 'column'
            },
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },
            credits: false,
            xAxis: {
                categories: <?php echo $chart_categories; ?>,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>'
                }
            },
            tooltip: {
                formatter: function () {
                    //Get growth rate
                    var prevPoint = this.point.x == 0 ? null : this.series.data[this.point.x - 1];
                    var rV = '<b>' + this.x + '</b><br/>'
                    rV += '<span style="color:'+ this.series.color + '"><b>Total</b></span>: ' + Highcharts.numberFormat(this.y, 0) + '<br/>'
                    if (prevPoint){
                        var diff = this.y - prevPoint.y;
                        var percentage = (diff / prevPoint.y) * 100;
                        var formated = percentage.toFixed(1);
                        rV += '<br><b>Growth:</b> ' + formated + ' %'
                    }
                    return rV;
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    colorByPoint: true,
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:,.0f}',
                        y: 10
                    }
                },
            },
            series: <?php echo $chart_series_data; ?>
        });

    });
</script>        
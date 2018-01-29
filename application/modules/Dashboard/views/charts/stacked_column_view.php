<!--chart_container-->
<div id="<?php echo $chart_name; ?>_container"></div>

<!--highcharts_configuration-->
<script type="text/javascript">
    $(function () {
        var chartDIV = '<?php echo $chart_name."_container"; ?>'
        var chart;

        // function to sort the stacks
        var sortData = function(chartSource) {
        var series = chartSource.series;
        var axis = chartSource.xAxis[0];
        var categories = [];
        
        if($.isArray(series)) {
            var ser = $.grep(series, function(ser, seriesIndex) {
                return ser.visible;
            })[0];
            $.each(ser.data, function(dataIndex, datum) {
                // console.log(datum.category + ": " + datum.stackTotal);
                var obj = {
                    name: datum.category,
                    index: dataIndex,
                    stackTotal: datum.stackTotal
                }
                categories.push(obj);
            });
        }
        
        categories.sort(function(a, b) {
            var aName = a.name.toLowerCase();
            var bName = b.name.toLowerCase();
            var aTotal = a.stackTotal;
            var bTotal = b.stackTotal;
            if(aTotal === bTotal) {
                return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
            } else {
                return ((aTotal > bTotal) ? -1 : ((aTotal < bTotal) ? 1 : 0));
            }
        });
        
        var mappedIndex = $.map(categories, function(category, index) {
            return category.index;
        });
        
        categories = $.map(categories, function(category, index) {
            return category.name;
        });
        
        // console.log(categories);
        // console.log(mappedIndex);
        axis.setCategories(categories);
        
        $.each(series, function(seriesIndex, ser) {
            var data = $.map(mappedIndex, function(mappedIndex, origIndex) {
                return ser.data[mappedIndex].y;
            });
            ser.setData(data);
        });
    };

    // chart start
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false,
                
            },
            lang: {
              decimalPoint: '.',
              thousandsSep: ','
            },
        });

        chart = new Highcharts.Chart({
            chart: {
                renderTo: chartDIV,
                type: 'column'
            },
            colors: ['#5cb85c', '#434348', '#5bc0de', '#f7a35c', '#8085e9'],
            title: {
                text: '<?php echo $chart_title; ?>'
            },
            subtitle: {
                text: '<?php echo $chart_source; ?>'
            },
            xAxis: {
                categories: <?php echo $chart_categories; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $chart_yaxis_title; ?>'
                }
            },
            stackLabels: {
                enabled: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}<br />{point.otherdata}'
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            credits: false,
            exporting: { 
                enabled: true 
            },
            series: <?php echo $chart_series_data; ?>
        }, 
        function(chart) { sortData(chart); });
    });

    });
</script>
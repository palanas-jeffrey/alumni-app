<script>
    function barChartBuilder(elementId, categories, dataSeries, customColors, chartHeight, hideToolBar = false) {
        const defaultColors = ['#26a0fc', '#26e7a6', '#febc3b', '#ff6178', '#8b75d7', '#6d848e', '#46b3a9', '#d830eb'];
        const colors = customColors ? customColors : defaultColors;
        var options = {
                series: [{
                    name: "",
                    data: dataSeries
                }],
                chart: {
                    height: chartHeight ? chartHeight : '250px',
                    type: 'bar',
                    toolbar: {
                            show: hideToolBar
                        },
                    events: {
                        click: function(chart, w, e) {
                            //console.log(chart, w, e)
                        }
                    }
                },
                colors: colors,
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                        colors: colors,
                        fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                        return Number.isInteger(val) ? val : '';
                        }
                    },
                    tickAmount: 5,
                    forceNiceScale: true
                }
            };

        var chart = new ApexCharts(document.querySelector(elementId), options);
        chart.render();
    };
    </script>
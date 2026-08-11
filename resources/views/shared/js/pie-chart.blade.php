<script>
    function buildDonutChart(elementId, chartLabel, labels, series, colors, chartHeight=null, totalObj={}) {


        if (true) {
            var options = {
                series: series,
                chart: {
                    type: 'donut',
                    height: chartHeight ? chartHeight : '250px',   
                    // toolbar: {
                    //     show: true,
                    //     tools: {
                    //         download: true
                    //     }
                    // },

                },

                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270,
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '22px',
                                    color: '#000',
                                    offsetY: -10
                                },
                                value: {
                                    show: true,
                                    fontSize: '16px',
                                    color: '#000',
                                    offsetY: 10
                                },
                                total: totalObj,
                            }
                        }
                    }
                },
                title: {
                    text: chartLabel
                },
                labels: labels,
                // fill: {
                //     type: 'gradient',
                //     gradient: {
                //     shade: 'light',
                //     type: 'horizontal',
                //     shadeIntensity: 0.5,
                //     gradientToColors: ['#0D47A1'],
                //     inverseColors: true,
                //     opacityFrom: 0.8,
                //     opacityTo: 0.6,
                //     stops: [0, 100]
                //     }
                // },
                colors: colors,
                legend: {
                    show: false
                }
            };

            var selector = elementId.startsWith("#") ? elementId : "#" + elementId;
            var chart = new ApexCharts(document.querySelector(selector), options);

            chart.render();
        }
    }
</script>
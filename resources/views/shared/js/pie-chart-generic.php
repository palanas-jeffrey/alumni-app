<script>
    function buildPieChart (elementId, chartLabel, labels, series, colors, chartHeight=null) {

        if (true) {
            var options = {
                series: series,
                chart: {
                    type: 'donut',
                    height: chartHeight ? chartHeight : '250px'
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
                                }
                            }
                        }
                    }
                },
                title: {
                    text: chartLabel
                },
                labels: labels,
                colors: colors
            };

            var chart = new ApexCharts(document.querySelector(elementId), options);
            chart.render();
        }
    }
</script>
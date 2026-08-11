<script>
    function initChart() {
        var totalFields = Number(@json($totalFields)),
            remaining = Number(@json($noResponses)),
            completed = totalFields - remaining,
            remainingPercentage = Math.round(remaining / totalFields * 100),
            completedPercentage = (completed/totalFields* 100).toFixed(1),
            chartElement = document.querySelector("#chart"),
            labels = ["Completed", "Remaining"];

        const totalObj = {
                show: true,
                label: remainingPercentage == 100 ? 'Remaining' : 'Completion',
                formatter: function (w) {
                    return remaining == 100 ? `100%` : `${completedPercentage}%`;
                }
            };


        if (chartElement) {
            var options = {
                    series: [completed, remaining],
                    chart: {
                    width: 300,
                    type: 'donut',
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
                fill: {
                    type: 'gradient',
                },
                    legend: {
                },
                title: {
                    text: ''
                },
                labels: labels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                
                legend: {
                    show: false
                }
            };
    
            var chart = new ApexCharts(chartElement, options);
            chart.render();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initChart();
    });
</script>
<div>
    <div id="{{ $chart_id }}"></div>
  
    @include('shared.js.pie-chart')
    @include('shared.js.v-bar-chart')

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            (function() {
                // based from the shared.others.colors
                const COLORS = [
                    'rgb(69, 173, 252)', 'rgb(89, 237, 187)', 'rgb(254, 203, 104)', 'rgb(255, 129, 148)', 'rgb(143, 121, 216)',
                    'rgb(46, 196, 182)', 'rgb(255, 191, 105)', 'rgb(255, 107, 107)', 'rgb(106, 76, 147)', 'rgb(61, 90, 128)',
                    'rgb(152, 193, 217)', 'rgb(224, 251, 252)', 'rgb(238, 108, 77)', 'rgb(41, 50, 65)', 'rgb(244, 162, 97)',
                    'rgb(231, 111, 81)', 'rgb(168, 218, 220)', 'rgb(69, 123, 157)', 'rgb(29, 53, 87)', 'rgb(255, 175, 204)',
                    'rgb(205, 180, 219)', 'rgb(255, 200, 221)', 'rgb(189, 224, 254)', 'rgb(162, 210, 255)', 'rgb(212, 165, 165)',
                    'rgb(132, 165, 157)', 'rgb(242, 132, 130)', 'rgb(246, 189, 96)', 'rgb(247, 237, 226)', 'rgb(157, 78, 221)'
                ];
                let options = @json($choices);
                const chartType = "{{ $chart_type }}";
    
                let chartContainerId = "#" + "{{ $chart_id }}";
                
                const optionsArray = Object.keys(options);
                const responseCountArray = optionsArray.map(key => options[key] || 0);
    
                var labels = optionsArray;
                var series = responseCountArray;
    
                if (chartType == "vertical-bar") {
    
                    //expand parent size if choices is more than 2
                    if (responseCountArray.length > 2) {
                        const container = document.querySelector(chartContainerId).closest(".graph-per-program-container");
                        container.style.width = "100%";
                    }
    
                    barChartBuilder(chartContainerId, labels, series, COLORS);
                } else {
                    buildDonutChart(chartContainerId, "", labels, series, COLORS, '250px');
                }
            })();
        });
    </script>
</div>

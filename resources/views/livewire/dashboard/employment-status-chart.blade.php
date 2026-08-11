<div>
    <div>
        <h2 class="text-lg font-medium text-gray-900">
            Employment status
        </h2>
    </div>
    <div>
        <div id="graph-employment"></div>
    </div>
    <script>
         function renderChart() {
            const container = document.querySelector("#graph-employment");
            const employed = @json($employedCount);
            const unemployed = @json($unEmployedCount);

            if (!container) {
                console.error("Container element not found");
                return;
            }

            const id = "#graph-employment";
            var labels = ["Employed", "Unemployed"];
            var series = [employed, unemployed];
            var colors = ['#0D47A1', '#80D8FF'];

            buildPieChart (
                id,
                "",
                labels,
                series,
                colors
            );
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderChart();
        });
    </script>

    @include("shared.js.pie-chart-generic")
</div>

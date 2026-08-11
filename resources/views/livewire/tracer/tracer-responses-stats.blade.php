<div class="bg-dust-gray overflow-hidden rounded-4 shadow-sm h-100">
    <div class="p-4 w-100">
        <section class="w-100">
            <div class="w-100">
                <h2 class="font-medium poppins-semibold text-lg">Tracer study participation</h2>
                <p class="mb-3 text-gray-600 text-sm">Current alumni tracer participation statistics.</p>
                
                @if ($formId)
                    <div class="w-100">
                        <div class="w-100">
                            <div id="tracer-participation-stats"></div>
                        </div>
                    </div>
                    <div class="txt-28">
                        <span>Total participations: </span>
                        <span>{{ $totalResponseCount }}</span>
                    </div>
                    <div class="mt-32">
                        <x-link-btn href="{{ route('tracer.form-report-overview', ['id' => $formId]) }}">
                            <span>View statistics</span>
                        </x-link-btn>
                    </div>
                @else
                    <div class="txt-28">
                        <span>No record as of the moment.</span>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        window.addEventListener('renderChart', event => {
            var labels = @json($programsAbbrevList),
                series = @json($responsePerProgram),
                colors = ['#45adfc', '#59edbb','#fecb68', '#ff8194', '#8f79d8'],
                chartContainerId = "#tracer-participation-stats";
            
            if (document.querySelector(chartContainerId)) {
                barChartBuilder(chartContainerId, labels, series, colors);
            } else {
                console.warn("Chart container not found:", chartContainerId);
            }
        });
    </script>
</div>


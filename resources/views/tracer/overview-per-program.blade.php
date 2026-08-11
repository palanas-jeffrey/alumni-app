<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ $backUrl }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Participations
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 tracer-mgmt">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="font-medium poppins-semibold text-lg">
                            Tracer participation statistics
                        </h2>

                        <p class="mb-5 mt-1 text-sm">
                            Below is a list of programs along with their corresponding tracer study participation statistics.
                        </p>
                    </div>

                    <div class="flex flex-wrap">
                        @if($programArray)
                            @foreach($programArray as $program)
                                <div class="bg-light card graph-per-program-container mb-4 p-3 rounded-4 shadow w-100">
                                    <div class="d-flex {{ $loop->index % 2 == 0 ? '' : 'flex-row-reverse' }}">
                                        <div>
                                           <div id="program-chart-{{$program->id}}" class="chart"></div>
                                       </div>
                                        <div class="card-body {{ $loop->index % 2 == 0 ? '' : 'text-right' }}">
                                            <h2 class="card-title font-medium poppins-semibold text-lg">{{ $program->program_name }}</h2>
                                            <p>No. of participants: {{ $program->response_count }}</p>
                                            <p class="mb-4">Total registered graduates: {{ $program->user_count }}</p>
                                            <x-link-btn href="{{ route('tracer.report-overview.batches', ['form_id' => $form->id, 'program_id' => $program->id]) }}">View</x-link-btn>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>Nothing to show.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.js.pie-chart')

    <script>
        const programs = @json($programArray);

        function renderChart() {
            const container = document.querySelector(".graph-per-program-container");
            if (!container) {
                console.error("Container element not found");
                return;
            }

            if (!Array.isArray(programs)) {
                console.error("programs must be an array");
                return;
            }

            programs.forEach((program, key) => {
                try {
                    const id = "program-chart-" + program.id;
                    const noResponse = program.user_count - program.response_count;
                    const noResponsePercentage = Math.round(noResponse / program.user_count * 100) || 0;
                    const respondent = program.response_count;
                    const respondentPercentage = (respondent / program.user_count * 100).toFixed(1) || 0;
                    var labels = ["Responded", "No response"];
                    var series = [respondent, noResponse];
                    var colors;

                    const totalObj = {
                            show: true,
                            label: respondent == 0 && noResponse == 0 ? 'Nothing to show' :
                                noResponsePercentage == 100 ? 'No response' : 'Responded',
                            formatter: function (w) {
                                return respondent == 0 && noResponse == 0 ? "" : noResponsePercentage == 100 ? `100%` : `${respondentPercentage}%`;
                            }
                        };

                    if (key == 0) {
                        colors = ['#0D47A1', '#80D8FF'];
                    } else if ( key == 1) {
                        colors = ['#45adfc', '#59edbb'];
                    } else {
                        colors = ['#ff8194', '#8f79d8'];
                    }
                    
                    buildDonutChart(id, "", labels, series, colors, null, totalObj);
                } catch (error) {
                    console.error(`Error initializing chart for program ${key}:`, error);
                }
            });
        }

   
        document.addEventListener('DOMContentLoaded', function() {
            renderChart();
        });
    </script>
</x-generic-layout>


<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracer.form-report-overview', ['id' => $form->id]) }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Participation statistics by batches
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 tracer-mgmt">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div>
                    <div class="flex">
                        <section class="bg-dust-gray mb-6 mr-6 p-4 rounded-4 w-3/4">
                            <h2 class="font-medium poppins-semibold text-lg">
                                <span>{{ $program->program_name }}</span>
                            </h2>
                            <div class="mt-1 mb-1 text-sm flex">
                                <div>
                                    <div>
                                        <span class="txt-16">Registered graduate statistics</span>
                                    </div>
                                    <div>
                                        <span>Male:</span>
                                        <strong>{{ $male }}</strong>
                                    </div>
                                    <div>
                                        <span>Female:</span>
                                        <strong>{{ $female }}</strong>
                                    </div>
                                    <div>
                                        <span>Total:</span>
                                        <strong>{{ $totalAlumniByProgram }}</strong>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <div>
                                        <span class="txt-16">Participants statistics</span>
                                    </div>
                                    <div>
                                        <span>Male:</span>
                                        <strong>{{ $maleParticipants }}</strong>
                                    </div>
                                    <div>
                                        <span>Female:</span>
                                        <strong>{{ $femaleParticipants }}</strong>
                                    </div>
                                    <div>
                                        <span>Total:</span>
                                        <strong>{{ $totalParticipants }}</strong>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="bg-primary-subtle flex-grow-1 mb-6 p-4 rounded-4">
                            <h2 class="font-medium poppins-semibold text-lg">Total participants:</h2>
                            <div class="line-height-normal text-center txt-48">
                                <span>{{ $totalParticipants }}</span>
                            </div>
                        </section>
                    </div>

                    <div class="flex flex-wrap graph-per-batches">
                        @if($responseStatsPerBatch)
                            @foreach($responseStatsPerBatch as $batch)
                                <div class="bg-light card graph-per-program-container mb-4 ml-3 mr-3 p-3 rounded-4 shadow w-100">
                                    <div class="d-flex {{ $loop->index % 2 == 0 ? '' : 'flex-row-reverse' }}">
                                        <div>
                                           <div id="batch-chart-{{$batch->id}}" class="chart"></div>
                                       </div>
                                        <div class="card-body {{ $loop->index % 2 == 0 ? '' : 'text-right' }}">
                                            <h2 class="card-title font-medium poppins-semibold text-lg">Batch year: {{ $batch->batch_year }}</h2>
                                            <p>No. of participants: <strong>{{ $batch->response_count }}</strong></p>
                                            <p class="mb-4">Total registered graduates: <strong>{{ $batch->user_count }}</strong></p>
                                            <x-link-btn href="{{ route('tracer.report-overview.batch', ['form_id' => $form->id, 'program_id' => $program_id, 'batch_id' => $batch->id]) }}">View</x-link-btn>
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
        const batches = @json($responseStatsPerBatch);

        function renderChart() {
            const chartContainer = document.querySelectorAll(".chart");
            if (chartContainer.length == 0) {
                console.error("Chart container elements not found");
                return;
            }

            if (!Array.isArray(batches)) {
                console.error("batches must be an array");
                return;
            }

            batches.forEach((batch, key) => {
                try {
                    const id = "batch-chart-" + batch.id;
                    const noResponse = batch.user_count - batch.response_count;
                    const noResponsePercentage = Math.round(noResponse / batch.user_count * 100) || 0;
                    const respondent = batch.response_count;
                    const respondentPercentage = (batch.response_count / batch.user_count * 100).toFixed(1) || 0;
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
                    console.error(`Error initializing chart for batch ${key}:`, error);
                }
            });
        }

   
        document.addEventListener('DOMContentLoaded', function() {
            renderChart();
        });
    </script>
</x-generic-layout>


@php
    $nullResponses = null;
    $totalFields = null;
    $totalResponses = 0;
    $noResponseNumber = 0;
    $totalNoRespponses = 0;

    if ($responseWithFields && $responseWithFields->responseFields) {
        $responseFields = $responseWithFields->responseFields->toArray();

        $nullResponses = count(array_filter($responseFields, function($field) {
            return is_null($field['value']);
        }));

        $totalFields = $response->form->fields->count();

        $totalResponses = count($responseFields);
        $noResponseNumber = $totalFields - $responseWithFields->responseFields->count();
        $totalNoRespponses = $nullResponses + $noResponseNumber;
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tracer response edit
        </h2>
    </x-slot>

    <div class="py-12 tracer-mgmt">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 d-flex">
                    <section class="width-half">
                        <header class="pb-6">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $response->form->title }}
                            </h2>
                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                Program: {{$response->program->program_name}} 
                            </p>
                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                Publish year: {{$response->form->publish_year}}
                            </p>
                        </header>
                        <form action="" id="formElementContainer">
                            @include('shared.formBuilder-with-response', 
                                [
                                    'form' => $response->form
                                ])
                        </form>

                        <div class="mt-4">
                            <x-primary-button id="responseUpdate" type="button">{{ __('Submit response changes') }}</x-primary-button>
                        </div>
                    </section>
                    <div class="width-half">
                        <div id="chart" class="tracer-completion-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')
    @include('shared.js.script-tracer-response-submit', ['form_id' => $response->form->id])

     <script>
        function initChart() {
            var totalFields = Number(@json($totalFields));
            var noResponse = Number(@json($totalNoRespponses));
;
            var inComplete = Math.round(noResponse / totalFields * 100);
            var completed = Math.round(100 - inComplete);

            if (true) {
                var options = {
                        series: [completed, inComplete],
                        chart: {
                        width: 380,
                        type: 'donut',
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            let percentage = opts.w.globals.series[opts.seriesIndex];
                            if (percentage === completed) {
                                return completed + "% Completion";
                            } else if (percentage === inComplete) {
                                return inComplete + "% Remaining";
                            }
                        },
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Arial, sans-serif',
                            colors: ['#111827']
                        }
                    },
                    fill: {
                        type: 'gradient',
                    },
                        legend: {
                    },
                    title: {
                        text: 'Form completion'
                    },
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
                    }]
                };
        
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
           initChart();
        });
    </script>
</x-app-layout>





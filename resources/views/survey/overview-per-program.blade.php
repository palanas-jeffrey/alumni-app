<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('survey.survey-report-periods-overview', ['form_id' => $form->id]) }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Programs
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
                            Survey participation statistics
                        </h2>

                        <p class="mb-5 mt-1 text-sm">
                            Below is a list of all target programs.
                        </p>
                    </div>

                    <div class="flex flex-wrap">
                        @if($programArray)
                            @foreach($programArray as $program)
                                <div class="bg-light card mb-4 p-3 rounded-4 shadow w-100">
                                    <div>
                                        <div>
                                            <h2 class="card-title font-medium poppins-semibold text-lg">
                                                {{ $program->program_name }}
                                            </h2>
                                            <p>No. of participants: {{ $program->response_count }}</p>
                                            
                                            <div class="mt-6">
                                                <x-link-btn href="{{ route('survey.report-overview.batches', ['form_id' => $form->id, 'program_id' => $program->id, 'period_id' => $period_id]) }}">View</x-link-btn>
                                            </div>
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
</x-generic-layout>


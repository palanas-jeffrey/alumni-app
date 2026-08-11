<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('survey.report-overview.batches', ['form_id' => $form->id, 'program_id' => $program->id, 'period_id' => $period_id]) }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Survey response analysis
                </h1>
            </div>
        </div>
    </x-simple-nav>

    @include('shared.functions.roman-numeral-conversion')

    <div class="py-12 tracer-mgmt">
        <div class="tracer-program-overview max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="responses-overview">
                <div class="bg-white border-1 border-gray-300 flex-wrap p-6 rounded-4">
                    <div>
                        <div class="mb-2">
                            <h2 class=" text-lg">
                                <span>Program:</span>
                                <span class="poppins-semibold">{{ $program->program_name }}</span>
                            </h2>
                        </div>
                        <div>
                            <span>Batch:</span>
                            <strong>{{ $batch_year }}</strong>
                        </div>
                        <div class="mb-4 mt-2">
                            <span>Version:</span>
                            <strong>{{$form->title}}</strong>
                        </div>
                    </div>
                    
                    @if($sections)
                        @foreach($sections as $section)
                            <div class="pb-4 pt-4">
                                <h3 class="poppins-semibold text-lg font-medium text-gray-900">
                                    <span>{{numberToRoman($loop->iteration)}}. </span>
                                    <span>{{ $section->survey_section_title }}</span>
                                </h2>
                                @livewire("survey.report.section-response-analysis", ['section_id' => $section->id, 'program_id' => $program->id, 'form_id' => $form->id, 'batch_year' => $batch_year, 'period_id'=>$period_id])
                            </div>
                        @endforeach
                    @else
                        <div>Nothing to show.</div>
                    @endif
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="bg-dust-gray mb-3 p-4 rounded-4">
                    <div>
                        <h2>
                            <h2 id="modalHeadingtxt" class="font-medium mb-3 poppins-semibold text-lg">Generate survey report</h2>
                        </h2>
                        <div>
                            <x-primary-button type="button"
                                data-bs-toggle="modal" data-bs-target="#generateReport">Generate</x-primary-button>
                        </div>
                    </div>
                </div>
                <div class=" bg-white border-1 border-gray-300 rounded-4">
                    <div class="p-6 text-gray-900">
                        <section>
                            <header class="mb-2">  
                                <h2 class="font-medium mr-6 poppins-semibold text-lg">
                                    Participants
                                </h2>
                                <div class="flex justify-between">
                                    <div>
                                        <div class="mb-1 mt-1">
                                            <p>
                                                <span>Batch: </span>
                                                <strong>{{ $batch_year }}</strong>
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <span>Male: </span>
                                                <strong>{{ $maleParticipants }}</strong>
                                            </p>
                                            <p>
                                                <span>Female: </span>
                                                <strong>{{ $femaleParticipants }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="line-height-normal ml-6 text-center">
                                        <p>
                                            <strong class="txt-32">{{ $responseCount }}</strong>
                                            <div><span>Total</span></div>
                                        </p>
                                    </div>
                                </div>
                            </header>
                            <div class="section-report-table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User</th>
                                            <th scope="col" class="text-right">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($responses as $response)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $response->user->last_name }}, {{ $response->user->first_name[0] }}. </td>
                                                
                                                <td>
                                                    <div class="text-right">
                                                        <a href="{{ route('survey.view-response', ['response_id' => $response->id]) }}">
                                                            <i class="bi bi-box-arrow-in-right"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal-generic :modalId="'generateReport'">
        <div class="modal-body p-4 pt-0">
            <div class="space-y-6">
                <h2 id="modalHeadingtxt" class="modal-title poppins-semibold text-xl">Would you like to generate survey reports?</h2>
            </div>
        </div>

        <form action="{{ route('survey.generate-report') }}" method="POST"  target="_blank">
            @csrf
            <div>
                <input type="hidden" name="form_id" value="{{$form->id}}">
                <input type="hidden" name="program_id" value="{{$program->id}}">
                <input type="hidden" name="batch_year" value="{{$batch_year}}">
                <input type="hidden" name="period_id" value="{{$period_id}}">
            </div>
            <!-- Add any form inputs for filters in here, if needed -->

            <div class="modal-footer">
                <div class="flex items-center">
                    <x-primary-button type="submit" >Generate report</x-primary-button>
                    <x-link-generic href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel">
                        <span>Cancel</span>    
                    </x-link-generic>
                </div>
            </div>
        </form>
    </x-modal-generic> 
</x-generic-layout>


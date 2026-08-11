<div>
    <div class="tracer-bg lg:px-8 max-w-7xl mx-auto pb-0 px-4 py-6 sm:px-6">
        <div class="flex tracer-container">
            @if ($form && !$has_response)
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div>
                            <div class="p-6">
                                <h1 class="font-semibold mb-12 text-center txt-48">Tracer study</h1>
                                <h2 class="font-semibold text-center txt-24">Would you like to participate?</h2>
                                <div class="d-flex justify-center mt-4">
                                    <x-link-btn href="{{ route('tracer.consent') }}">Participate</x-link-btn>
                                </div>
                                <p class="mt-120 text-center txt-20">"All great achievements require time."</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($form && $has_response)
                <div>
                    <div class="lg:px-8 max-w-7xl mt-2 mx-auto sm:px-6">
                        <div>
                            <div>
                                <div id="chart" class="tracer-completion-chart"></div>
                            </div>
                            <div class="p-6">
                                <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">You have responded already.</h1>
                                <p class="text-center mt-1 mb-3">Would you like to view/update your response?</p>
                                <div class="d-flex justify-center">
                                <x-link-btn href="/tracer/view-response/{{$response_id}}">View response</x-link-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else 
                <div class="py-12">
                    <div>
                        <div class="">
                            <div class="p-6">
                                <h1 class="text-center font-semibold text-xl">No available form at the moment. :(</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('shared.js.script-progress-chart')
</div>

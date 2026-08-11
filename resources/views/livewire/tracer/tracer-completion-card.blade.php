<div class="bg-dust-gray flex-grow-1 ml-6 overflow-hidden rounded-4 shadow-sm">
    <div class="p-6">
        <section>
            <h2 class="font-medium poppins-semibold text-lg">Tracer participation</h2>

            @if ($form)
                <div>
                    
                    @if ($completionPercentage == 0)
                        <div class="line-height-normal mt-32 text-center txt-70">0%</div>
                        <p class="text-2xl text-center">Participate now</p>
                    @else
                        <div>
                            <div id="chart" class="tracer-completion-chart"></div>
                        </div>
                        <p class="text-2xl text-center">Update previous response</p>
                    @endif
              
                    <div class="mt-32 text-center">
                        <x-link-btn href="{{ route('tracer.participation') }}">
                            @if ($completionPercentage == 0)
                                <span>Participate</span>
                            @else
                                <span>Update</span>
                            @endif
                        </x-link-btn>
                    </div>
                </div>
            @else
                <div>
                    <div class="mt-30 line-height-normal text-center txt-32">
                        <span>No available form yet.</span>
                    </div>
                </div>
            @endif
        </section>
    </div>

    @include('shared.js.script-progress-chart')
</div>
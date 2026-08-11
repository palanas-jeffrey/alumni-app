<div class="p-6 bg-white border-1 border-gray-300 rounded-4 {{ $isHeightExtend ? 'h-100' : '' }} ">
    <div>
        <div>
            <h2 class="font-medium poppins-semibold text-lg">Tracer Submission reminder</h2>
        </div>
        <div class="{{ $isWarningBg ? 'bg-danger-subtle' : 'bg-light'}}  border-1 line-height-normal mt-3 p-3 rounded-3 shadow-lg text-center">
            @if ($incomingSchedule)
                <div class="txt-48">
                    <span>{{ \Carbon\Carbon::parse($incomingSchedule->date)->format('d M') }}</span>
                </div>
                <span class="txt-24">{{ \Carbon\Carbon::parse($incomingSchedule->date)->format('Y') }}</span>
                <div class="mt-2">
                    <x-link-generic href="javascript:void(0);" 
                        x-on:click="" x-on:click.prevent="$dispatch('open-modal', 'modal-show-schedule-{{ $incomingSchedule->id }}')">
                        <span>View details</span>  
                    </x-link-generic>
                </div>
                <div class="mb-3 mt-4">
                    @if ($incomingSchedule->isDone)
                        <div>
                            <div class="mb-2">
                                <span class="bg-mint-green p-1 poppins-semibold rounded-1 txt-18">Submitted</span>
                            </div>
                        </div>
                    @elseif ($isWarningBg)
                        <div>
                            <div class="mb-2">
                                <span class="bg-danger p-1 poppins-semibold rounded-1 text-light">Not yet submitted.</span>
                            </div>
                        </div>
                    @else
                        <div class="mb-2">
                                <div class="poppins-semibold">Not yet submitted.</div>
                        </div>
                    @endif
                </div>
            @else
                <div>
                    <span class="txt-24">Nothing to show.</span>
                </div>
            @endif
        </div>

        @if($showSetSchedule)
            <div class="mt-3 pt-3">
                <p>Don't miss the deadline. Set deadline schedule reminder and view report schedule here.</p>
            </div>

            <div class="mt-3">
                <x-link-btn href="{{ route('tracer.submission-reminders') }}">Set schedules</x-link-btn>
            </div>
        @endif
    </div>

    @if ($incomingSchedule)
        <x-modal name="modal-show-schedule-{{ $incomingSchedule->id }}" focusable>
            <div class="line-height-normal p-6 text-left">
                <h2 class="poppins-semibold text-xl">
                    Submission schedule
                </h2>

                <div class="mt-2 txt-18">
                    <span>Date:</span>
                    <span class="poppins-semibold">{{ \Carbon\Carbon::parse($incomingSchedule->date)->format('d M Y') }}</span>
                </div>
                <div class="mt-2 txt-18">
                    <span>Status:</span>
                        @if ($incomingSchedule->isDone)
                            <span class="bg-mint-green inline-block p-1 poppins-semibold rounded-2">Submitted</span>
                        @elseif ($isWarningBg)
                            <span class="bg-danger inline-block p-1 poppins-semibold rounded-2 text-light">Not yet submitted.</span>
                        @else
                            <span class="poppins-semibold">Not yet submitted.</span>
                        @endif
                </div>
                <div class="mt-2">
                    <span>Note:</span>
                    <span>{{ $incomingSchedule->note }}</span>
                </div>

                <div class="mt-6 flex">
                    @if ($incomingSchedule->isDone)
                        <x-primary-button type="button"
                            wire:click.prevent="toggleStatus({{ $incomingSchedule->id }}, false)">
                            <div class="relative">
                                <span class="btn-text">Undo status</span>
                            </div>
                        </x-primary-button>
                    @else
                        <x-primary-button type="button"
                            wire:click.prevent="toggleStatus({{ $incomingSchedule->id }})">
                            <div class="relative">
                                <span class="btn-text">Submitted</span>
                            </div>
                        </x-primary-button>
                    @endif

                    <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                        <span>Close</span>    
                    </x-link-generic>
                </div>
            </div>
        </x-modal>
    @endif
</div>
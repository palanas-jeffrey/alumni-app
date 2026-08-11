<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Management') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white">
                <div class="p-6 text-gray-900">
                    <section>
                        <div class="upcoming-event events-main pt-6">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upcoming-events" data-bs-toggle="tab" 
                                        data-bs-target="#upcoming-events-pane" type="button" role="tab" 
                                        aria-controls="upcoming-events-pane" aria-selected="false">
                                        <span class="poppins-semibold text-xl">
                                            Upcoming events
                                        </span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="previous-events" data-bs-toggle="tab" 
                                        data-bs-target="#previous-events-pane" type="button" role="tab" 
                                        aria-controls="previous-events-pane" aria-selected="false">
                                        <span class="poppins-semibold text-xl">
                                            Previous events
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div>
                             <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="upcoming-events-pane" role="tabpanel" 
                                    aria-labelledby="upcoming-events" tabindex="0">
                                    @livewire('events.upcoming-events')
                                </div>
                                <div class="tab-pane fade" id="previous-events-pane" role="tabpanel" 
                                    aria-labelledby="previous-events" tabindex="0">
                                    @livewire('events.previous-events')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

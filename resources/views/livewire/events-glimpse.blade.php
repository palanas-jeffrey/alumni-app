<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="upcoming-event pt-6">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Upcoming events') }}
                            </h2>
                        </div>
                    </section>

                    <section>
                        @foreach ($incomingEvents as $incomingEvent)
                            <x-event-card-v2 :uaEvent="$incomingEvent"></x-event-card-v2>
                        @endforeach
                    <section>
                </div>
            </div>
        </div>
    </div>
</div>



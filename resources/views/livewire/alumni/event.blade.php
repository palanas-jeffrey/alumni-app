<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-dust-gray overflow-hidden rounded-4 shadow-sm">
        <div class="p-6">
            <section>
                <h2 class="font-medium poppins-semibold text-lg">
                    Upcoming events
                </h2>
                
                <div class="mt-3">
                    @if ($incomingEvents)
                        <p class="mb-3 text-gray-600 text-sm">
                            Don't miss the exciting events happening in the next two weeks. Mark your calendars and stay informed to make the most of these special occasions!
                        </p>
                    @else
                        <div>No events available.</div>
                    @endif
                </div>

                @if ($incomingEvents)
                    <div id="carousel-events" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($incomingEvents as $incomingEvent)
                                <button type="button" data-bs-target="#carousel-events" 
                                    data-bs-slide-to="{{ $loop->index }}" 
                                    class="{{ $loop->index == 0 ? 'active' : '' }}" 
                                    @if($loop->index == 0) aria-current="true" @endif 
                                    aria-label="Slide {{ $loop->iteration }}">
                                </button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($incomingEvents as $incomingEvent)
                                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}"
                                    @if ($incomingEvent->photo)
                                        style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(255, 255, 255, 0.1) 50%), url({{ asset('storage/' . $incomingEvent->photo->photo_path) }})"
                                    @endif
                                    >
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="pb-3">
                                            <h3 class="font-medium poppins-semibold txt-32">{{$incomingEvent->event_name}}</h3>
                                            <p class="font-medium txt-20">
                                                @if ($incomingEvent->eventDates  && count($incomingEvent->eventDates))
                                                    @php
                                                        $groupedEvents = $incomingEvent->eventDates->groupBy(function($event_date) {
                                                            return date('F', strtotime($event_date->event_date)); // Group by month
                                                        });
                                                    @endphp

                                                    @foreach($groupedEvents as $month => $events)
                                                        <span>{{ $month }}</span>
                                                        @foreach($events as $event_date)
                                                            <strong>{{ date('j', strtotime($event_date->event_date)) }}</strong>
                                                            @if ($loop->index + 1 != count($events) )
                                                                <span>,</span>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->
                    </div>
                @endif
                <div class="mt-3">
                    @user
                        <x-link-btn href="{{ route('alumniEvents') }}"> View events</x-link-btn>
                    @enduser
                    @admin
                        <x-link-btn href="{{ route('eventManagement') }}">Manage events</x-link-btn>
                    @endadmin
                </div>
            </section>
        </div>
    </div>
</div>
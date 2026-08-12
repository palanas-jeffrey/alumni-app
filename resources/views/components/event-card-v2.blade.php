@php
    $startDateObject = collect($uaEvent->eventDates)->sortBy(function ($item) {
        return strtotime($item->event_date);
    })->first();
@endphp

<div class="mt-6 pt-6 event-card">
    <div class="flex f-direction-m">
        <div class="date-wrap">
            @if ($startDateObject && $startDateObject->event_date)
                <div>
                    <div>
                        <span class="font-semibold text-xl text-gray-800 leading-tight">
                            {{date('F', strtotime($startDateObject->event_date))}}
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="fmb-1 font-medium event-heading">
                            {{date('j', strtotime($startDateObject->event_date))}}
                        </span>
                    </div>
                </div>
            @endif
        </div>
        <div class="img-wrap">
            @if ($uaEvent->photo)
                @if ($uaEvent->photo->photo_path)
                    <div>
                        <div class="event-img" 
                            style="background-image: url('{{ asset('storage/' . $uaEvent->photo->photo_path) }}"></div>
                    </div>
                @endif
            @endif
        </div>
        <div class="info-wrap">
            <h3 class="event-heading poppins-semibold">{{ $uaEvent->event_name }}</h3>
            <p class="mt-2">{{ $uaEvent->description }}</p>
            <div class="mt-4">
                <div class="d-flex">
                    @if ($uaEvent->eventDates  && count($uaEvent->eventDates) > 1)
                       @php
                            $groupedEvents = $uaEvent->eventDates->groupBy(function($event_date) {
                                return date('F', strtotime($event_date->event_date)); // Group by month name
                            });

                            // Sort each group by date ascending
                            $sortedGroupedEvents = $groupedEvents->map(function ($events) {
                                return $events->sortBy(function ($event_date) {
                                    return strtotime($event_date->event_date);
                                });
                            });
                        @endphp

                        @foreach($sortedGroupedEvents as $month => $events)
                            <div class="date-tag">
                                <strong>{{ $month }}</strong>
                                @php $counter = 1; @endphp
                                @foreach($events as $event_date)
                                    <strong>{{ date('j', strtotime($event_date->event_date)) }}</strong>
                                    @if ($counter != count($events))
                                        <span>,</span>
                                    @endif
                                    @php $counter++; @endphp
                                @endforeach
                            </div>
                        @endforeach

                    @endif
                </div>
                <div>
                    <strong>Time start: {{date('g:i A', strtotime($uaEvent->start_time));}}</strong>
                </div>
                <!-- <div>
                    <strong>
                        Duration:$uaEvent->duration 
                        if($uaEvent->duration > 1)
                            hrs
                        else
                            hr
                        endif
                    </strong>
                </div> -->
                <div>
                    <strong>Venue: {{ $uaEvent->venue }}</strong>
                </div>
            </div>
        </div>
    </div>
    {{ $slot }}
</div>

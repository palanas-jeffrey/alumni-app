@extends('pdf.pdf-layout')

@section('content')
    <div>
        <header>
            <h2 class="text-lg font-semibold">
                Alumni events
            </h2>

            <p class="mt-1 mb-1">
                Below is the list of all alumni events.
            </p>
        </header>
    </div>
    <div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event</th>
                        <th scope="col">Date</th>
                        <!-- <th scope="col">Duration</th> -->
                        <th scope="col">Start</th>
                        <th scope="col">Venue</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowCount = 1; @endphp

                    @foreach ($uaEvents as $uaEvent)
                        <tr>
                            <th scope="row">{{ $rowCount++ }}</th>
                            <td>{{ $uaEvent->event_name }}</td>
                            <td>{{date('F', strtotime($uaEvent->event_date))}}</td>
                            <!-- <td>
                                $uaEvent->duration 
                                if($uaEvent->duration > 1)
                                    hrs
                                else
                                    hr
                                endif
                            </td> -->
                            <td>{{date('g:i A', strtotime($uaEvent->start_time));}}</td>
                            <td>{{ $uaEvent->venue }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

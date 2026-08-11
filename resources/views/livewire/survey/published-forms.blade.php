<section>
    @if(!empty($formObjects) && count($formObjects) > 0)
        @foreach($formObjects as $form)
            <div class="p-6 bg-white border-1 border-gray-300 rounded-4 mb-4">
                <div>
                    <h2 class="font-medium poppins-semibold text-lg">{{ $form->title }}</h2>
                    <p class="mb-3 text-gray-600 text-sm">{{ $form->description }}</p>
                </div>
                <div>
                    @if($form->openPeriods && count($form->openPeriods) > 0)
                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Start</th>
                                        <th scope="col">End</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($form->openPeriods as $period)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $period->start->format('F j, Y') }}</td>
                                            <td>{{ $period->end->format('F j, Y') }}</td>
                                            <td>
                                                @if ($period->hasResponded)
                                                    <x-link-btn 
                                                        href="{{ route('survey.view-response', ['response_id' =>$period->response_id]) }}">
                                                        View response
                                                    </x-link-btn>
                                                @else
                                                    <x-link-btn 
                                                        href="{{ route('survey.questionaire-respond', ['form_id' => $form->id, 'period_id' => $period->survey_period_id ]) }}">
                                                        Participate
                                                    </x-link-btn>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div>
                            <span>No periods available.</span>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    @else
        <div>
            <p>Looks like there aren’t any surveys right now. Please check back soon!</p>
        </div>
    @endif

</section>

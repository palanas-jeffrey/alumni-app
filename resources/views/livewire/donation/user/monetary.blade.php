<div>
    <section class="pt-4">
        <header>
            <h2 class="font-medium poppins-semibold text-lg">
                Financial
            </h2>

            <p class="mb-1 mt-1 text-sm">
                Below is the list of general financial support.
            </p>

            <div class="bg-dust-gray flex mb-3 mt-3 p-3">
                <div class="flex">
                    <div>
                        <label>
                            <span class="mr-1">Start date</span>
                            <x-input-date id="f-start-date" class="w-100" type="text" class="singleDatePicker" 
                                wire:model.live.debounce.500ms="startDate"
                                value="{{$startDate}}"/>
                        </label>
                    </div>
                    <div class="ml-6">
                        <label for="">
                            <span class="mr-1">End date</span>
                            <x-input-date id="f-end-date" class="w-100" type="text" class="singleDatePicker" 
                                wire:model.live.debounce.500ms="endDate"
                                value="{{$endDate}}"/>
                        </label>
                    </div>
                </div>
            </div>

        </header>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Payment ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Acknowledgment</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($monetaryDonations)
                        @php $rowCount = 1; @endphp

                        @foreach($monetaryDonations as $monetaryDonation)
                            <tr>
                                <th scope="row">{{ $rowCount++ }}</th>
                                <td>{{ $monetaryDonation->transaction_id }}</td>
                                <td>{{ $monetaryDonation->mode_of_payment }}</td>
                                <td>{{ $monetaryDonation->amount . $monetaryDonation->currency}}</td>
                                <td>{{ $monetaryDonation->status ? $monetaryDonation->status->status : "" }}</td>
                                <td>{{ \Carbon\Carbon::parse($monetaryDonation->created_at)->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="8">No payments found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    @include('shared.js.script-date-picker')
</div>

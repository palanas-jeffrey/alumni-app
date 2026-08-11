<div>
    <section class="pt-4">
        <header>
            <h2 class="font-medium poppins-semibold text-lg">
                {{ __('Facilities') }}
            </h2>

            <p class="mb-1 mt-1 text-sm">
                {{ __("Below is the list of all facilities donated.") }}
            </p>

            <div class="bg-dust-gray flex mb-3 mt-3 p-3">
                <div class="flex">
                    <div>
                        <label>
                            <span class="mr-1">Start date</span>
                            <x-input-date id="fa-start-date" class="w-100" type="text" class="singleDatePicker" 
                                wire:model.live.debounce.500ms="startDate"
                                value="{{$startDate}}"/>
                        </label>
                    </div>
                    <div class="ml-6">
                        <label for="">
                            <span class="mr-1">End date</span>
                            <x-input-date id="fa-end-date"  class="w-100" type="text" class="singleDatePicker" 
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
                        <th scope="col">Facility</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($facilityDonations)
                        @php $rowCount = 1; @endphp

                        @foreach($facilityDonations as $facilityDonation)
                            <tr>
                                <th scope="row">{{ $rowCount++ }}</th>
                                <td>{{ $facilityDonation->facility }}</td>
                                <td>{{ $facilityDonation->description }}</td>
                                <td>{{ $facilityDonation->status ? $facilityDonation->status->status : "" }}</td>
                                <td>{{ \Carbon\Carbon::parse($facilityDonation->created_at)->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="9">No records found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

     @include('shared.js.script-date-picker')
</div>

<div>
    <section class="pt-4">
        <div class="top-right-trigger-container">
            <div class="align-items-center flex">
                <div class="mr-6 poppins-semibold">
                    <span>Pending acknowledgment: </span>
                    <span>{{ $pendingFacility }}</span>
                </div>
                <x-primary-button type="button"
                    data-bs-toggle="modal" data-bs-target="#generateDonationFacilityReportModal">Generate report</x-primary-button>
            </div>
        </div>
        <header>
            <h2 class="font-medium poppins-semibold text-lg">
                {{ __('Facilities') }}
            </h2>

            <p class="mb-1 mt-1 text-sm">
                {{ __("Below is the list of all facilities donated.") }}
            </p>

            <div class="bg-dust-gray flex mb-3 mt-3 p-3">
                <div>
                    <label>
                        <span class="mr-1">Donor</span>
                        <x-text-input type="text"
                            wire:model.live.debounce.500ms="transactionDonor" placeholder="Search Name" 
                            value="{{$transactionDonor}}"/>
                    </label>
                </div>
                <div class="ml-6">
                    <label>
                        <span class="mr-1">Start date</span>
                        <x-input-date  class="w-100" type="text" class="singleDatePicker" 
                            wire:model.live.debounce.500ms="startDate"
                            value="{{$startDate}}"/>
                    </label>
                </div>
                <div class="ml-6">
                    <label>
                        <span class="mr-1">End date</span>
                        <x-input-date  class="w-100" type="text" class="singleDatePicker" 
                            wire:model.live.debounce.500ms="endDate"
                            value="{{$endDate}}"/>
                    </label>
                </div>
            </div>
        </header>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($facilityDonations)

                        @foreach($facilityDonations as $facilityDonation)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $facilityDonation->user->first_name }}</td>
                                <td>{{ $facilityDonation->user->last_name }}</td>
                                <td>{{ $facilityDonation->user->email }}</td>
                                <td>{{ $facilityDonation->facility }}</td>
                                <td>{{ $facilityDonation->description }}</td>
                                <td>
                                    @if ($facilityDonation->status)
                                        @php
                                            $status = $facilityDonation->status->status;
                                        @endphp
                                        <span class="p-1 text-capitalize {{ $status == 'pending' ? 'bg-pastel-yellow' : '' }}">
                                            {{ $status }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($facilityDonation->created_at)->format('F j, Y') }}</td>
                                <td>
                                    @if ($facilityDonation->status && isset($facilityDonation->status->status) && strtolower($facilityDonation->status->status) != "received")
                                        <div class="text-right">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button>
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <form class="update-donation-status" method="POST" action="{{ route('donation.facility.received') }}">
                                                        @csrf
                                                        <input class="hide-element" type="hidden" name="donation_id" value="{{$facilityDonation->id}}" />
                                                        <x-button-option>
                                                            <span>Update as received</span>
                                                        </x-button-option>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="9">No records found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
    <x-modal-generic :modalId="'generateDonationFacilityReportModal'">
        <div class="modal-body">
            <div class="p-4 space-y-6">
                <h2 id="" class="poppins-semibold text-xl">
                    Would you like to generate report for facilities?</h2>
            </div>
        </div>

        <form action="{{ route('donation-generate-facility-report') }}" method="POST"  target="_blank">
            @csrf

            <div>
                <div class="mt-3">
                    <div>
                        <x-text-input type="hidden" class="mt-1"
                            name="donor" value="{{$transactionDonor}}" readonly/>
                    </div>
                    <div class="flex">
                        <div>
                            <x-input-date  class="w-100" type="hidden"
                            name="start_date"  value="{{$startDate}}" readonly/>
                        </div>
                        <div>
                            <x-input-date  class="w-100" type="hidden"
                            name="end_date" value="{{$endDate}}" readonly/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="flex items-center gap-4">
                    <x-primary-button type="submit" >Generate report</x-primary-button>
                </div>
                <div>
                    <x-link-generic href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel">
                        <span>Cancel</span>    
                    </x-link-generic>
                </div>
            </div>
        </form>
    </x-modal-generic>
     @include('shared.js.script-date-picker')
</div>

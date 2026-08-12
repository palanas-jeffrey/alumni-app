<div>
    <section class="pt-4">
        <div class="top-right-trigger-container">
            
            <div class="align-items-center flex">
                <div class="mr-6 poppins-semibold">
                    <span>Pending acknowledgment: </span>
                    <span>{{ $pendingFinancial }}</span>
                </div>
                <x-primary-button type="button"
                    data-bs-toggle="modal" data-bs-target="#generateDonationMonetaryReportModal">Generate report</x-primary-button>
            </div>
        </div>
        <header>
            <h2 class="font-medium poppins-semibold text-lg">
                Financial
            </h2>

            <p class="mb-1 mt-1 text-sm">
                Below is the list of general financial support.
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
                        <th scope="col">Payment ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Acknowledgment</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($monetaryDonations)

                        @foreach($monetaryDonations as $monetaryDonation)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $monetaryDonation->transaction_id }}</td>
                                <td>{{ $monetaryDonation->user->first_name }}</td>
                                <td>{{ $monetaryDonation->user->last_name }}</td>
                                <td>{{ $monetaryDonation->user->email }}</td>
                                <td>{{ $monetaryDonation->mode_of_payment }}</td>
                                <td>{{ $monetaryDonation->amount . $monetaryDonation->currency}}</td>
                                <td>
                                    @if ($monetaryDonation->status)
                                        @php
                                            $status = $monetaryDonation->status->status;
                                        @endphp
                                        <span class="p-1 text-capitalize {{ $status == 'pending' ? 'bg-pastel-yellow' : '' }}">
                                            {{ $status }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($monetaryDonation->created_at)->format('F j, Y') }}</td>
                                <td>
                                    @if ($monetaryDonation->status && isset($monetaryDonation->status->status) &&
                                        strtolower($monetaryDonation->status->status) != "received")
                                        @endif
                                        <div class="text-right">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button>
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <form class="update-donation-status" method="POST" action="{{ route('donation.monetary.received') }}">
                                                        @csrf
                                                        <input class="hide-element" type="hidden" name="donation_id" value="{{$monetaryDonation->id}}" />
                                                        <x-button-option>
                                                            <span>Update as received</span>
                                                        </x-button-option>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="9">No payments found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <x-modal-generic :modalId="'generateDonationMonetaryReportModal'">
        <div class="modal-body">
            <div class="p-4 space-y-6">
                <h2 id="" class="poppins-semibold text-xl">
                    Would you like to generate reports for financial support?</h2>
            </div>
            <form action="{{ route('donation-generate-monetary-report') }}" method="POST"  target="_blank">
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
        </div>
    </x-modal-generic>
    @include('shared.js.script-date-picker')
</div>

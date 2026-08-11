<div class="bg-mint-green h-100 p-4 rounded-4">
    <section class="h-100 position-relative">
        <div class="border-gray-300">
            <div>
                <h2 class="poppins-semibold text-lg">
                    Donation pending acknowledgment
                </h2>
                <p class="mb-3 text-gray-600 text-sm">Please verify and acknowledge these donations to finalize the record.</p>
            </div>

            <div class="bg-white line-height-normal p-3 poppins-semibold rounded-3 shadow-lg txt-18">
                <div>
                    <div>
                        <div>
                            <span>Financial: </span>
                            <span>
                                {{ $pendingFinancial }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Resources: </span>
                            <span>
                                {{ $pendingResources }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Facility: </span>
                            <span>
                                {{ $pendingFacility }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-0 mt-1 position-absolute">
                <x-link-btn href="{{ route('donationLogs') }}">View donations</x-link-btn>
            </div>
        </div>
    </section>
</div>

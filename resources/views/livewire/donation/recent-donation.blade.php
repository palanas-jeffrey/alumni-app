<div class="bg-mint-green p-5 rounded-4 w-40p">
    <section>
        <div class="border-gray-300">
            <div>
                <h2 class="poppins-semibold text-lg">
                    Recent donation
                </h2>
            </div>

            <div class="line-height-normal pb-4 pt-4 txt-28 bold">
                <div>
                    <div>
                        <div>
                            <span>Financial: </span>
                            <span>
                                @if($monetaryDonation)
                                    {{ $monetaryDonation }}
                                @else
                                    none
                                @endif
                            </span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Resources: </span>
                            <span>
                                @if($inKindDonation)
                                    {{ $inKindDonation }}
                                @else
                                    none
                                @endif
                            </span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Facility: </span>
                            <span>
                                @if($facilityDonation)
                                    {{ $facilityDonation }}
                                @else
                                    none
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-1">
                @if ($isViewMyDonation)
                    <x-link-btn href="{{ route('donation.history') }}">View my donations</x-link-btn>
                @else
                    <x-link-btn href="{{ route('donation') }}">View donations</x-link-btn>
                @endif
            </div>
        </div>
    </section>
</div>

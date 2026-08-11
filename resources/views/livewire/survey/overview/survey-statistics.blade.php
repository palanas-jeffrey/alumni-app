<div class="bg-dust-gray overflow-hidden rounded-4 shadow-sm h-100">
    <div class="p-4 w-100 h-100">
        <section class="w-100 h-100">
            <div class="w-100 h-100">
                <div class="flex justify-between h-100">
                    <div class="mr-6 position-relative">
                        <h2 class="font-medium poppins-semibold text-lg">Survey statistics</h2>
                        <p class="mb-3 text-gray-600 text-sm">Current survey statistics.</p>
                        <div class="w-100">
                            <div class="w-100">
                                <div id="alumni-registration-stats"></div>
                            </div>
                        </div>
                        <div class="bottom-0 mt-32 position-absolute">
                            <x-link-btn href="{{ route('survey.survey-report-periods-overview', ['form_id' => $form_id]) }}">
                                <span>View</span>
                            </x-link-btn>
                        </div>
                    </div>

                    <div class="line-height-normal">
                        <div class="poppins-semibold text-right txt-48">
                            <span>{{$participation_count}}</span>
                        </div>
                        <div>
                            <span>Total participations</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
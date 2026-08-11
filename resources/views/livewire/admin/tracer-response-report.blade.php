<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <section>
                <h2 class="text-lg font-medium text-gray-900">
                    Tracer response
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    <!-- donations datas -->
                    <!-- Don't miss the exciting events happening in the next two weeks: from World Health Day on April 10 to Earth Day on April 22, and more. Mark your calendars and stay informed to make the most of these special occasions! -->
                </p>

                <div class="mt-3">
                </div>
                <!-- <div class="mt-3">
                    <x-primary-button type="button"
                        data-bs-toggle="modal" data-bs-target="#generateTracerResponseReportModal">Generate tracer response report</x-primary-button>
                </div> -->
            </section>
        </div>
    </div>

    <x-modal-generic :modalId="'generateTracerResponseReportModal'">
        <div class="modal-body">
            <div class="space-y-6">
                <h2 id="modalHeadingtxt" class="font-semibold text-xl text-gray-800 leading-tight">Would you like to generate tracer response report?</h2>
            </div>
        </div>

        <form action="{{ route('tracer-response-generate-report') }}" method="POST"  target="_blank">
            @csrf

            <!-- Add any form inputs for filters in here, if needed -->

            <div class="modal-footer">
                <div class="flex items-center gap-4">
                    <x-primary-button type="submit" >Generate report</x-primary-button>
                </div>
                <a href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#6365f1] ml-1">
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </x-modal-generic>
</div>
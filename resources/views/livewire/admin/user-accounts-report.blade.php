<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <section>
                <h2 class="text-lg font-medium text-gray-900">
                    User statistics
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Below, you'll find a summary of our active users and pending activations.
                </p>

                <div class="mt-3">
                    <div>
                        <strong class="txt-14">Active users: {{$activatedUsers}}</strong>
                    </div>
                    <div>
                        <strong class="txt-14">Pending activation: {{$nonActivatedUsers}}</strong>
                    </div>
                </div>
                <div class="mt-3">
                    <x-link-btn href="{{ route('accountManagement') }}"> View users </x-link-btn>
                </div>
                <!-- <div class="mt-2">
                    <x-primary-button type="button"
                        data-bs-toggle="modal" data-bs-target="#generateUserAccountReportModal">Generate user account report</x-primary-button>
                </div> -->
            </section>
        </div>
    </div>

    <x-modal-generic :modalId="'generateUserAccountReportModal'">
        <div class="modal-body">
            <div class="space-y-6">
                <h2 id="modalHeadingtxt" class="font-semibold text-xl text-gray-800 leading-tight">
                    Would you like to generate user acoounts report?
                </h2>
            </div>
        </div>

        <form action="{{ route('user-accounts-generate-report') }}" method="POST"  target="_blank">
            @csrf

            <!-- Add any form inputs for filters in here, if needed -->

            <div class="modal-footer">
                <div class="flex items-center gap-4">
                    <x-primary-button type="submit" >Generate report</x-primary-button>
                </div>
                <a href="javascript:void(0);" data-bs-dismiss="modal" 
                    class="modal-cancel inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#6365f1] ml-1">
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </x-modal-generic>
</div>
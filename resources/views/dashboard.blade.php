<x-app-layout>
    @include('shared.js.v-bar-chart')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="space-y-6">
            @admin
                <livewire:alumni.alumni-search />
                <livewire:alumni.event />
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex">
                        <div class="w-66p">
                            <livewire:dashboard.alumni-statistics />
                        </div>
                        <div class="w-1/3 ml-6">
                            @livewire('donation.pending-acknowledgment-card')
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex">
                        <div class="w-1/3 mr-6">
                            <div>
                                <livewire:tracer.tracer-mgmt-overview />
                            </div>
                        </div>
                        <div class="w-66p">
                            @livewire('tracer.submission-note-card', ['showSetSchedule' => false, 'isHeightExtend' => false])
                        </div>
                        <!-- <div class="w-66p">
                            livewire:tracer.tracer-responses-stats
                        </div> -->
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @include('configuration.configuration-card')
                </div>

                <script>
                    window.addEventListener('schedule-status-updated', event => {
                        showToast("Schedule status updated!");
                    });  
                </script>
            @endadmin
            @user
                <livewire:alumni.greetings />
                <livewire:alumni.alumni-search />
                <livewire:alumni.event />
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex">
                        @livewire('donation.recent-donation', ['isViewMyDonation' => false])
                        @livewire('tracer.tracer-completion-card')
                    </div>
                </div>

                @if (session('isFirstLogin'))
                    @livewire('alumni.change-password-modal')
                @endif
            @enduser
        </div>
    </div>
    @include('shared.toaster')
</x-app-layout>

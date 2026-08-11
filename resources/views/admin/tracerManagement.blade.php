

<x-app-layout>
    @include('shared.js.v-bar-chart')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tracer management') }}
        </h2>
    </x-slot>

    <div class="py-12 tracer-mgmt">
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                livewire:tracer.tracer-responses-stats
            </div>
        </div> -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="align-items-stretch flex flex-row h-auto">
                    <div class="w-50">
                        @include('tracer.form-mgmt-card')
                    </div>
                    <div class="flex-grow-1 ml-6">
                        @livewire('tracer.submission-note-card')
                    </div>
                </div>
            </div>
        </div>
    <div>

    @include('shared.toaster')

    <script>
        window.addEventListener('schedule-status-updated', event => {
            showToast("Schedule status updated!");

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    </script>
</x-app-layout>

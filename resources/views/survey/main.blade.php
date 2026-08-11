<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Survey management') }}
        </h2>
    </x-slot>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <div>
                    @livewire('survey.add-new-form-card')
                </div>
            </div>

            <div>
                <div>
                    @livewire('survey.survey-form-table')
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')

    @if(session('form_deleted'))
        <script>
            showToast('Survey form deleted!');
        </script>
    @endif

</x-app-layout>

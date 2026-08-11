<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracerMgmt.form-list') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back to main</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Survey form overview
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    @if(!$is_published)
                        <div class="mr-6">
                            @livewire('survey.overview.edit-survey-form', ['form_id' => $form_id])
                        </div>
                    @endif

                    <div class="flex-grow-1">
                        @livewire('survey.overview.survey-form-status', ['form_id' => $form_id])
                    </div>
                </div>
                <div class="mt-6">
                    @livewire('survey.overview.participant-settings', ['form_id' => $form_id])
                </div>
                <div class="mt-6">
                    @livewire('survey.overview.survey-open-period-component', ['form_id' => $form_id])
                </div>
            </div>
        </div>
    </main>

    @include('shared.toaster')
</x-generic-layout>

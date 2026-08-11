<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ $backUrl }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Survey form builder
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="mb-12">
            <div class="form-builder-container lg:px-8 max-w-7xl mx-auto sm:px-6">
                @livewire('survey.form-builder.root', ['form_id' => $form_id])
                <div>
                    <div>
                        @livewire('survey.form-builder.survey-section-manager', ['form_id' => $form_id])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</x-generic-layout>

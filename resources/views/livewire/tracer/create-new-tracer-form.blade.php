<section class="bg-dust-gray h-100 p-4 rounded-4 space-y-6">
    <div>
        <h2 class="poppins-semibold text-lg">Create tracer form</h2>
        <p class="mt-1 mb-1 text-sm text-gray-600">Create a new tracer form.</p>
        <div class="flex gap-4 items-center mt-4">
            <x-primary-button type="button" x-data=""
                 x-on:click.prevent="$dispatch('open-modal', 'modal-add-tracer-form')">Create</x-primary-button>
        </div>
    </div>

    <x-modal name="modal-add-tracer-form"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="tracer-details-form {{!$isNewFormCreated ? '' : 'd-none'}}">
            <div>
                <div class="p-4 pb-0">
                    <h2 class="mb-1 modal-title poppins-semibold text-xl" >
                        Create tracer survey form
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Fields marked with an asterisk (*) are required.
                    </p>
                </div>
                <form wire:submit.prevent="addForm" class="p-4">
                    <div class="mb-4">
                        <x-input-label for="title">Title*</x-input-label>
                        <x-textarea-box
                            name="title"
                            id="title"
                            wire:model="title"
                            rows="4"></x-textarea-box>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <x-input-label for="description">Description</x-input-label>
                        <x-textarea-box
                            name="description"
                            id="description"
                            wire:model="description"
                            rows="4"></x-textarea-box>
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mt-6 flex justify-start">
                        <x-primary-button type="submit">
                            Create
                        </x-primary-button>
        
                        <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$wire.cancelFormFillUp();">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>

        @if($isNewFormCreated)
            <div>
                <div class="p-4">
                    <div>
                        <h2 class="mb-1 modal-title poppins-semibold text-xl" >
                            Awesome! Your new tracer study form is good to go.
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Click the button below to view or edit the form.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-start">
                        <x-link-btn href="{{ $newFormRoute }}">
                            View form
                        </x-link-btn>
        
                        <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close'); $wire.resetForm();forcePageReload();">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </div>
            </div>
        @endif
    </x-modal>

    <script>
        function showTracerForm() {
            var tracerForm = document.querySelector(".tracer-details-form"),
                tracerTypeSelection = document.querySelector(".tracer-form-type-selection");
            
            if (tracerForm) {
                tracerTypeSelection.classList.add("d-none");
                tracerForm.classList.remove("d-none");
            }
        }

        window.addEventListener('survey-form-added', function () {
            showToast("Tracer study form added successfully!");
        });
        
        window.addEventListener('tracer-form-type-not-selected', function () {
            showToast('Please select a form type.', false);
        });
    </script>
</section>
<div>
    <div class="mt-6">
        <div class="border-4 border-white bg-white rounded-4 w-100">
            <div class="border-1 border-gray-300 p-4 rounded-4">
                <div class="flex justify-between">
                    <div class="mr-6">
                        <h3 class="font-medium poppins-semibold text-lg">Sections List:</h3>
                    </div>
                    <div class="flex">
                        <x-primary-button x-data="" class="mr-3"
                            x-on:click.prevent="$dispatch('open-modal', 'modal-section-setup')">
                                <span class="mr-2"><i class="bi bi-plus-circle"></i></span>
                                <span>Add</span>
                        </x-primary-button>
                        @livewire('survey.form-builder.modal-sorting-survey-sections', ['form_id' => $form_id])
                    </div>
                </div>
            </div>
        </div>

        @if($sections)
            <div class="mt-4">
                <div class="accordion" id="accordion-form-section">
                    @foreach ($sections as $section)
                        @php
                            $id = $section->id;
                        @endphp

                        <div class="accordion-item mt-3">
                            <h2 class="accordion-header d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="poppins-semibold txt-18">{{ $section->survey_section_title }}</h3>
                                </div>
                                <button 
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $id }}"
                                    aria-expanded="false"
                                    aria-controls="collapse-{{ $id }}">
                                </button>
        
                                {{-- Options dropdown --}}
                                <div>
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                                        </x-slot>
        
                                        <x-slot name="content">
                                            <x-dropdown-button
                                                x-on:click.prevent="setTimeout(() =>$dispatch('open-modal', 'modal-section-setup'), 1100)" 
                                                wire:click="editSection({{ $id }})">
                                                Edit section
                                            </x-dropdown-button>
                                            <x-dropdown-button-danger class="text-danger" type="button"
                                                x-on:click.prevent="$dispatch('open-modal', 'modal-section-{{ $id }}')">
                                                Delete section
                                            </x-dropdown-button-danger>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </h2>
                            <div id="collapse-{{ $id }}" class="accordion-collapse collapse" data-bs-parent="#accordion-form-section">
                                <div class="accordion-body bg-light pt-2">
                                    @if($section->description)
                                        <div class="pt-3">
                                            <p>{{ $section->description }}</p>
                                        </div>
                                    @endif

                                    <div>
                                        @livewire('survey.form-builder.section-fields', ['section_id' => $id], key('section-fields-' . $id))
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-modal name="modal-section-{{ $id }}"
                            x-on:close.window="@this.dispatch('close')" focusable>
                            <div class="p-4 bg-white shadow rounded">
                                <h3 class="modal-title poppins-semibold text-xl mb-2">Are you sure you want to delete the section?</h3>
                                <div class="mt-6 flex justify-start">
                                    <x-danger-button type="button"
                                        wire:click="deleteSection({{ $id }})">
                                        Delete
                                    </x-danger-button>
        
                                    <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                        <span>Cancel</span>    
                                    </x-link-generic>
                                </div>
                            </div>
                        </x-modal>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-modal name="modal-section-setup"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 pb-0">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="eventCreationModal">
                {{ $editingSectionId ? 'Update section' : 'Add section' }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ $editingSectionId ? 'Update section details.' : 'Add section details.' }}
            </p>
        </div>
        <form wire:submit.prevent="{{ $editingSectionId ? 'updateSection' : 'addSection' }}" class="p-4">
            <div class="mb-4">
                <x-input-label for="survey_section_title">Section title</x-input-label>
                <x-textarea-box
                    name="survey_section_title"
                    id="survey_section_title"
                    wire:model="survey_section_title"
                    rows="4"></x-textarea-box>
                @error('survey_section_title')
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
                    {{ $editingSectionId ? 'Update section' : 'Add Section' }}
                </x-primary-button>

                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close'); $wire.resetForm();">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        </form>
    </x-modal>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Sortable(document.querySelector('[wire\\:sortable="reorder"]'), {
                handle: '.sort-trigger',
                ghostClass: 'sortable-ghost',
                forceFallback: true,
                fallbackOnBody: true,

                onStart: function (evt) {
                },

                onEnd: function (evt) {
                },

                onMove: function(evt) {
                }
            });
        });
    </script>

    <script>
        window.addEventListener('section-added', event => {
            showToast("Section added!");
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'modal-section-setup' }));
            pageReload();
        });

        window.addEventListener('section-updated', event => {
            showToast("Section updated!");
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'modal-section-setup' }));
            pageReload();
        });

        window.addEventListener('section-deleted', event => {
            showToast("Section deleted successfully!");
            pageReload();
        });

        window.addEventListener('order-saved', event => {
            showToast("Section's order updated successfully!");
            pageReload();
        });

        window.addEventListener('order-field-saved', event => {
            showToast("Question/field's order updated successfully!");
            pageReload();
        });

        window.addEventListener('field-added', event => {
            showToast("Question/field added!");
            pageReload();
        });

        window.addEventListener('field-updated', event => {
            showToast("Question/field updated!");
            pageReload();
        });

        window.addEventListener('field-deleted', event => {
            showToast("Question/field deleted successfully!");
            pageReload();
        });

        function pageReload() {
            setTimeout(()=> {
                window.location.reload();
            }, 1500);
        }
    </script>
</div>

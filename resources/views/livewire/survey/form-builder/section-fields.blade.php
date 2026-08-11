<div>
    <div class="pt-4">
        <div class="flex justify-between">
            <div>
                <h3 class="text-lg font-boldtext-lg font-bold mb-2">Question list:</h3>
            </div>
            <div class="flex">
                <x-primary-button x-data="" class="mr-3"
                    x-on:click.prevent="$dispatch('open-modal', 'modal-section-field-setup-{{ $section_id }}')">
                        <span class="mr-2"><i class="bi bi-plus-circle"></i></span>
                        <span>Add</span>
                </x-primary-button>
                @livewire('survey.form-builder.modal-sorting-fields', ['section_id' => $section_id] )
            </div>
        </div>
        <div>
            @if($fields->isEmpty())
                <p class="text-gray-500">No questions/fields added yet.</p>
            @else
                <ul class="mt-3">
                    @foreach ($fields as $field)
                        <li class="bg-white border-1 border-gray-300 mt-2 p-3 rounded-4">
                            <div class="d-flex justify-content-between w-100">
                                @livewire('tracer.components.dynamic-field', ['order' => $loop->index + 1, 'field' => $field])

                                <div>
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-button
                                                x-on:click.prevent="$dispatch('open-modal', 'modal-section-field-setup-{{ $section_id }}')" 
                                                wire:click="editField({{$field->id }})">
                                                Edit section
                                            </x-dropdown-button>
                                            <x-dropdown-button-danger class="text-danger" type="button"
                                                x-on:click.prevent="$dispatch('open-modal', 'modal-field-delete-{{ $field->id }}')">
                                                Delete question
                                            </x-dropdown-button-danger>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </li>

                        <x-modal name="modal-field-delete-{{ $field->id }}"
                            x-on:close.window="@this.dispatch('close')" focusable>
                            <div class="p-4 bg-white shadow rounded">
                                <h3 class="modal-title poppins-semibold text-xl mb-2">Are you sure you want to delete the question/field?</h3>
                                <div class="mt-6 flex justify-start">
                                    <x-danger-button type="button"
                                        wire:click="deleteField({{ $field->id }})">
                                        Delete
                                    </x-danger-button>

                                    <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                        <span>Cancel</span>    
                                    </x-link-generic>
                                </div>
                            </div>
                        </x-modal>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <x-modal name="modal-section-field-setup-{{ $section_id }}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div>
            <div class="space-y-6 p-4">
                <h2 class="mb-1 modal-title poppins-semibold text-xl">Question/field</h2>

                {{-- Create New Field --}}
                <form wire:submit.prevent="{{ $editingField ? 'updateField' : 'saveField' }}" class="space-y-4">
                    <div class="">
                        <div class="mb-2">
                            <label class="block text-sm font-medium">Type</label>
                            <select wire:model="type" class="w-full border rounded px-3 py-2">
                                <option value="">-- Select Type --</option>
                                <option value="text">Short text</option>
                                <option value="textarea">Long text</option>
                                <option value="number">Number</option>
                                <option value="radio">Options</option>
                                <option value="checkbox">Multiple selection</option>
                                <option value="select">Dropdown</option>
                                <option value="file">Upload file</option>
                            </select>
                            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium" for="question_section_title">Question</label>
                            <x-textarea-box
                                name="question_section_title"
                                id="question_section_title"
                                wire:model.live="field_label"
                                rows="4"></x-textarea-box>
                            @error('field_label') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center space-x-2 mb-2">
                            <input type="checkbox" wire:model="required" id="required">
                            <label for="required" class="text-sm font-medium">Required</label>
                        </div>
                        
                            <div class="choices-block">
                                <label class="block text-sm font-medium">
                                    <span>Choices (Use the "|" symbol to separate each choice for options, multiple selection, dropdown)</span>
                                    <span>
                                        <i class="bi bi-info-circle" data-bs-toggle="tooltip"
                                        title="If type is either options, multiple selection, or dropdown, choices is required."></i>
                                    </span>
                                </label>
                                <x-textarea-box
                                    wire:model="choices"
                                    rows="4"
                                ></x-textarea-box>
                                @error('choices') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                    </div>

                    <div>
                        <x-primary-button type="submit">
                            @if($editingField)
                                <span>Update</span>
                            @else
                                <span>Add Field</span>
                            @endif
                        </x-primary-button>

                        <x-link-generic class="ml-6" href="javascript:void(0);" 
                            x-on:click="$dispatch('close')" 
                            wire:click="resetForm">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
</div>

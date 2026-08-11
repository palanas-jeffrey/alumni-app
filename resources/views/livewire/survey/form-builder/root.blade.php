<div class="bg-dust-gray mb-5 rounded-4">
    <div class="border-4 border-white p-4 rounded-4 w-100">
        <div class="flex justify-between">
            <h2 class="font-medium mb-2 poppins-semibold text-lg">{{ $survey_form->title }}</h2>
            <div class="ml-6">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                    </x-slot>

                    <x-slot name="content">
                        <div>
                            <x-dropdown-button type="button" x-on:click.prevent="$dispatch('open-modal', 'modal-update-form')">
                                Edit
                            </x-dropdown-button>
                            <x-dropdown-link :href="route('survey.survey-form-overview', $survey_form->id)">
                                Overview
                            </x-dropdown-link>

                            @if($survey_form->is_published)
                                <x-dropdown-button-danger class="text-danger"
                                    x-on:click.prevent="$dispatch('open-modal', 'modal-unpublish-form-{{ $survey_form->id }}')">
                                    <span>Unpublish</span>
                                </x-dropdown-button-danger>
                            @else
                                <x-dropdown-button type="button"
                                    x-on:click.prevent="$dispatch('open-modal', 'modal-publish-form-{{ $survey_form->id }}')">
                                    Publish
                                </x-dropdown-button>
                            @endif
                            
                            <x-dropdown-button-danger class="text-danger" type="button"
                                x-on:click.prevent="$dispatch('open-modal', 'modal-delete-form')">
                                Delete form
                            </x-dropdown-button-danger>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div>
            <p class="mb-3">{{ $survey_form->description }}</p>
        </div>
        <div>
            <x-link-btn href="{{ route('survey.questionaire', ['form_id' => $survey_form->id ]) }}">View questionaire</x-link-btn>
        </div>
    </div>

    <x-modal name="modal-publish-form-{{$survey_form->id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 text-left">
            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                Are you sure you want to publish this form?
            </h2>
            <div>
                <form wire:submit.prevent="publish('{{ $survey_form->id }}')">
                    <div class="d-flex mt-5">
                        <x-primary-button type="submit" class="publish-trigger mr-5">
                            <div class="relative">
                                <span class="btn-text">Publish</span>
                                <div class="dots-loader absolute v-hidden">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>
                        </x-primary-button>
                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <x-modal name="modal-unpublish-form-{{$survey_form->id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 text-left">
            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                Are you sure you want to unpublish this form?
            </h2>
            <div>
                <form wire:submit.prevent="unPublish('{{ $survey_form->id }}')">
                    <div class="d-flex mt-5">
                        <x-danger-button type="submit" class="unpublish-trigger mr-5">
                            <div class="relative">
                                <span class="btn-text">Unpublish</span>
                                <div class="dots-loader absolute v-hidden">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>
                        </x-primary-button>
                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <!-- form delete modal -->
    <x-modal name="modal-delete-form"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 text-left">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="modal-update-form">
                Are you sure you want to delete this form?
            </h2>
            <div>
                <form wire:submit.prevent="deleteForm">
                    <div class="d-flex mt-5">
                        <x-danger-button type="submit" id="delete-form-cta" class="mr-5">
                            <div class="relative">
                                <span class="btn-text">Delete</span>
                                <div class="dots-loader absolute v-hidden">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>
                        </x-danger-button>
                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <x-modal name="modal-update-form"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="modal-update-form">
                Update form
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Fields marked with an asterisk (*) are required.
            </p>
            <div class="mt-4">
                <form wire:submit.prevent="updateForm">
                    <div class="mb-4">
                        <x-input-label for="survey_title">Survey title*</x-input-label>
                        <x-textarea-box
                            name="survey_title"
                            id="survey_title"
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
                    <div class="d-flex mt-5">
                        <div class="mr-6">
                            <x-primary-button type="submit">
                                <div class="relative">
                                    <span class="btn-text">Update</span>
                                    <div class="dots-loader absolute v-hidden">
                                        <span></span><span></span><span></span>
                                    </div>
                                </div>
                            </x-primary-button>
                        </div>
                        <x-link-generic class="ml-3" href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <script>
        window.addEventListener('survey-form-updated', event => {
            showToast("Survey form updated!");
            setTimeout(()=> {
                window.location.reload();
            }, 1500);
        });

        window.addEventListener('survey-form-published', function () {
            showToast("Survey form published successfully!");
            setTimeout(()=> {
                window.location.reload();
            }, 1500);
        });

        window.addEventListener('survey-form-unpublished', function () {
            showToast("Survey form unpublished successfully!");
            setTimeout(()=> {
                window.location.reload();
            }, 1500);
        });
    </script>
</div>

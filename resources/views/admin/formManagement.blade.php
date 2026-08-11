<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracerMgmt.form-list') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Form builder
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="mb-12">
            <div class="form-builder-container lg:px-8 max-w-7xl mx-auto sm:px-6">
                <div class="bg-dust-gray mb-5 rounded-4">
                    <div class="border-4 border-white p-4 rounded-4 w-100">
                        <div class="flex justify-between">
                            <h2 class="font-medium mb-2 poppins-semibold text-lg">{{ $form->title }}</h2>
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

                                            @if(!$form->isPublished)
                                                <x-dropdown-button type="button"
                                                    x-on:click.prevent="$dispatch('open-modal', 'modal-publish-form-{{ $form->id }}')">
                                                    Publish
                                                </x-dropdown-button>
                                            @elseif($form->isPublished)
                                                <x-dropdown-button-danger class="text-danger"
                                                    x-on:click.prevent="$dispatch('open-modal', 'modal-unpublish-form-{{ $form->id }}')">
                                                    <span>Unpublish</span>
                                                </x-dropdown-button-danger>
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
                            <div class="mb-1">
                                <strong>Notes (For admin only):</strong>
                            </div>
                            <p class="mb-3">{{ $form->description }}</p>
                        </div>
                        <div>
                            <x-link-btn href="{{ route('tracer.questionaire', $form->id) }}">View questionaire</x-link-btn>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        @livewire('tracer.section-manager', ['form_id' => $form->id])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="modal-publish-form-{{$form->id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                Are you sure you want to publish this form?
            </h2>
            <div>
                <form action="{{ route('form.publish-form', ['form_id' => $form->id]) }}" method="POST">
                    @csrf
                    <div class="d-flex mt-5">
                        <x-primary-button type="button" data-formid="{{ $form->id }}" class="publish-trigger mr-5">Publish</x-primary-button>
                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <x-modal name="modal-unpublish-form-{{$form->id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                Are you sure you want to unpublish this form?
            </h2>
            <div>
                <form action="{{ route('form.publish-form', ['form_id' => $form->id]) }}" method="POST">
                    @csrf
                    <div class="d-flex mt-5">
                        <x-danger-button type="button" data-formid="{{ $form->id }}" class="unpublish-trigger mr-5">Unpublish</x-primary-button>
                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                            <span>Cancel</span>    
                        </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    @include('shared.toaster')

    @include('shared.js.script-date-picker')
    <script>
        //tocheck
        window.addEventListener('form-published', event => {
            showToast("Form publish date added successfully!");

            setTimeout(function(){
                window.location.reload();
            }, 1500);
        });

        window.addEventListener('publish-schedule-deleted', event => {
            showToast("Publish schedule deleted successfully!");

            setTimeout(function(){
                window.location.reload();
            }, 1500);
        });
        
    </script>

    <!-- form delete modal -->
    <x-modal name="modal-delete-form"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="modal-update-form">
                Are you sure you want to delete this form?
            </h2>
            <div>
                <form action="{{ route('tracerManagement.delete-form', ['form_id' => $form->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="d-flex mt-5">
                        <x-danger-button type="button" id="delete-form-cta" class="mr-5">{{ __('Delete') }}</x-danger-button>
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
            <p class="mb-4 mt-1 text-gray-600 text-sm">Update tracer study form.</p>
            <div>
                <form id="update-form" method="POST" 
                    action="{{ route('tracerManagement.update-form', ['form_id' => $form->id]) }}">
                    <div>
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="title" :value="__('Version')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $form->title }}" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Notes (For admin only):')" />
                                <x-textarea-box
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                                    name="description"
                                    id="description"
                                    rows="4"
                                    placeholder="Write your description here">{{ $form->description }}</x-textarea-box>
                            </div>
                            <!-- <div>
                                <x-input-label for="course" :value="__('Course')" />
                                <x-text-input id="course" name="course" type="text" class="mt-1 block w-full" value="{{ $form->course }}" required autofocus />
                            </div> -->
                        </div>
                    </div>
                    <div class="d-flex mt-5">
                        <div class="mr-6">
                            <x-primary-button type="submit">{{ __('Update') }}</x-primary-button>
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
        document.getElementById('delete-form-cta').addEventListener('click', async () => {
            const formId = {{ $form->id }};
            const csrfToken = '{{ csrf_token() }}';

            fetch("{{ route('tracerManagement.delete-form', ['form_id' => $form->id]) }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                   showToast('Form deleted successfully!');

                   setTimeout(() => {
                       window.location.href = "{{ route('tracerMgmt.form-list') }}";
                   }, 1200);
                } else {
                    showToast('Encountered error while deleting the form.');
                }
            })
            .catch(error=> {
                 showToast('Encountered error while deleting the form.');
            });
        });

        document.getElementById('update-form').addEventListener('submit', function(event) {
            const formElement = document.querySelector("#update-form");
            const formfields = formElement.querySelectorAll("input, textarea");
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            event.preventDefault();

            formfields.forEach(field => {
                if (field.name) {
                    formData.append(field.name, field.value.trim());
                    console.log(field.name, field.value.trim());
                } else {
                    console.warn("Field without value found", field);
                }
            });

            formData.append('_token', token);

            fetch('{{ route('tracerManagement.update-form', ['form_id' => $form->id]) }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP status ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                showToast("Form updated successfully!");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            })
            .catch(error => {
                console.log('Error saving: ' + error);
                showToast("Encountered error while saving the form.");
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @include('shared.js.script-publish-unpublish-form')
</x-generic-layout>

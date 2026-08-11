<section class="bg-primary-subtle h-100 p-4 rounded-4 space-y-6">
    <div>
        @if ($formId)
            <div class="flex justify-between">
                <h2 class="mr-6 poppins-semibold text-lg">Current published tracer study form</h2>
                <div>
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('form', $formId)">
                                Edit
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('tracer.form-report-overview', ['id' => $formId])">
                                View statistics
                            </x-dropdown-link>
                            <x-dropdown-button-danger class="text-danger"
                                x-on:click.prevent="$dispatch('open-modal', 'modal-unpublish-form-pcard-{{ $formId }}')">
                                <span>Unpublish</span>
                            </x-dropdown-button-danger>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            <p class="mt-1 mb-1 text-sm text-gray-600">
                <span>Tracer version:</span>
                <strong>{{ $version }}</strong>
            </p>
            <div class="flex gap-4 items-center mt-4">
                <x-link-btn href="{{ route('tracer.questionaire', ['form_id' => $formId]) }}">View form</x-link-btn>
            </div>

            <x-modal name="modal-unpublish-form-pcard-{{$formId}}"
                x-on:close.window="@this.dispatch('close')" focusable>
                <div class="p-4">
                    <h2 class="mb-1 modal-title poppins-semibold text-xl">
                        Are you sure you want to unpublish this form?
                    </h2>
                    <div>
                        <form action="{{ route('form.publish-form', ['form_id' => $formId]) }}" method="POST">
                            @csrf
                            <div class="d-flex mt-5">
                                <x-danger-button type="button" data-formid="{{ $formId }}" class="unpublish-trigger mr-5">Unpublish</x-primary-button>
                                <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                                    <span>Cancel</span>    
                                </x-link-generic>
                            </div>
                        </form>
                    </div>
                </div>
            </x-modal>
        @else
            <h2 class="mr-6 poppins-semibold text-lg">No published form</h2>
        @endif
    </div>
</section>
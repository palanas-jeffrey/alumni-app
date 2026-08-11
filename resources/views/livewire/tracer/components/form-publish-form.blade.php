<div>
    <div>
        @if ($isEdit)
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'modal-form-publish-{{ $form_id }}-{{ $form_publish_id }}')">
                    <span>Edit</span>
            </x-primary-button>
        @else
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'modal-form-publish-{{ $form_id }}-{{ $form_publish_id }}')">
                    <span><i class="bi bi-plus-circle"></i></span>
                    <span>Publish form</span>
            </x-primary-button>
        @endif
    </div>

    <x-modal name="modal-form-publish-{{ $form_id }}-{{ $form_publish_id }}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 bg-white shadow rounded">
            <h3 class="text-lg font-bold mb-2">Publish form</h3>

            <div>
                <div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="submit">
                        <div>
                            <div>
                                <label for="response_collection_start">Start Date</label>
                                <x-input-date 
                                    class="w-100 singleDatePicker" 
                                    wire:model="response_collection_start"
                                />
                                @error('response_collection_start') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label for="response_collection_end">End Date</label>
                                <x-input-date 
                                    class="w-100 singleDatePicker" 
                                    wire:model="response_collection_end"
                                />
                                @error('response_collection_end') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start">
                            <x-primary-button type="submit">
                                <span>{{ $form_publish_id ? 'Update Publish' : 'Publish Form' }}</span>
                            </x-primary-button>

                            <x-secondary-button class="ml-3" x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </x-modal>
</div>






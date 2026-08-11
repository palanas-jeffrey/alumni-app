<div class="h-100">
    <section class="h-100">
        <div class="bg-white border-1 border-gray-300 rounded-4 h-100">
            <div class="p-6 flex justify-between">
                <div>
                    <div>
                        <div>
                            <h2 class="font-medium poppins-semibold text-lg">{{ $form->title }}</h2>
                        </div>
                        <p>Description: {{ $form->description }}</p>
        
                        <div class="mt-3">
                            <h2 class="font-medium poppins-semibold text-lg">Form status</h2>
                        </div>
        
                        <div class="mt-2 flex flex-wrap">
                            @if($is_published)
                                <div class="bg-mint-green d-inline-block p-2">
                                    Published
                                </div>
                            @else
                                <div class="d-inline-block p-2">
                                    Unpublished
                                </div>
                            @endif
        
                            @if($is_active)
                                <div class="bg-mint-green d-inline-block p-2 ml-2">
                                    The form is currently open and accepting responses.
                                </div>
                            @else
                                <div class="d-inline-block p-2">
                                </div>
                            @endif
                        </div>
                    </div>
    
                    <div class="mt-4">
                        <div class="d-flex mt-4">
                            <x-link-btn href="{{ route('survey.questionaire', ['form_id' => $form->id]) }}">
                                <span>View form</span>
                            </x-link-btn>
    
                            @if(!$is_published)
                                <div class="ml-6">
                                    <x-primary-button x-on:click.prevent="$dispatch('open-modal', 'modal-publish-form-{{ $form->id }}')" type="button">{{ __('Publish') }}</x-primary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($is_published)
                    <div class="ml-6">
                        @livewire('survey.overview.survey-statistics', ['form_id' => $form->id])
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-modal name="modal-publish-form-{{$form->id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4 text-left">
            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                Are you sure you want to publish this form?
            </h2>
            <div>
                <form wire:submit.prevent="publish('{{ $form->id }}')">
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

    <script>
        window.addEventListener('survey-form-published', function () {
            showToast("Survey form published successfully!");
            setTimeout(()=> {
                window.location.reload();
            }, 1500);
        });
    </script>
</div>
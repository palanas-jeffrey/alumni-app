<div>
    <div class="p-6 bg-white border-1 border-gray-300 rounded-4">
        <div>
            <section>
                <header>
                    <h2 class="poppins-semibold text-lg">
                        {{ __('Tracer') }}
                    </h2>

                    <p class="mt-1 mb-1 text-sm text-gray-600">
                        {{ __("Below is the list of all available tracers versions.") }}
                    </p>
                </header>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Version</th>
                                <th scope="col">Notes (For admin only)</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($forms) && count($forms) > 0)
                                @foreach($forms as $form)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td class="text-wrap">{{ $form->title }}</td>
                                        <td class="text-wrap">{{ $form->description }}</td>
                                        <td>
                                            @if($form->isPublished)
                                                <span class="bg-mint-green inline-block p-1 text-success">Published</span>
                                            @endif
                                        </td>
                                        <td>{{ (new DateTime($form->created_at))->format('F j, Y') }}</td>
                                        <td>
                                            <div>
                                                <x-dropdown>
                                                    <x-slot name="trigger">
                                                        <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                                                    </x-slot>

                                                    <x-slot name="content">
                                                        <div>
                                                            @if(!$form->isPublished)
                                                                <x-dropdown-link :href="route('form', $form->id)">
                                                                    Edit this form
                                                                </x-dropdown-link>
                                                            @else
                                                                <x-dropdown-link :href="route('form', $form->id)">
                                                                    View this form
                                                                </x-dropdown-link>
                                                            @endif
            
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

                                                            @if($form->response_count > 0 || $form->isPublished)
                                                                <x-dropdown-link :href="route('tracer.form-report-overview', ['id' => $form->id])">
                                                                    View statistic
                                                                </x-dropdown-link>
                                                            @endif

                                                            <x-dropdown-button
                                                                x-on:click.prevent="$dispatch('open-modal', 'modal-clone-survey-form-{{ $form->id }}')">
                                                                <span>Clone form</span>
                                                            </x-dropdown-button>
                                                        </div>
                                                    </x-slot>
                                                </x-dropdown>

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

                                                @livewire("tracer.clone-form", ["form_id" => $form->id, "isModalOnly" => true])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="6"><div>Nothing to show.</div></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

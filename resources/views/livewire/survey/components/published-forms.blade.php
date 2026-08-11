<div class="mt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Publication status</th>
                <th scope="col">Created</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($forms as $form)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td class="text-wrap">{{ $form->title }}</td>
                    <td class="text-wrap">{{ $form->description }}</td>
                    <td>
                        @if($form->is_published)
                            <span class="bg-mint-green inline-block p-1 text-success">Published</span>
                        @endif
                    </td>
                    <td>{{ (new DateTime($form->created_at))->format('F j, Y') }}</td>
                    <td class="text-right">
                        <div>
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                                </x-slot>

                                <x-slot name="content">
                                    <div>
                                        <x-dropdown-link :href="route('survey.survey-form-overview', $form->id)">
                                            Overview
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('survey.survey-report-periods-overview', ['form_id' => $form->id])">
                                            View statistics
                                        </x-dropdown-link>
                                        <x-dropdown-button-danger class="text-danger"
                                            x-on:click.prevent="$dispatch('open-modal', 'modal-unpublish-form-{{ $form->id }}')">
                                            <span>Unpublish</span>
                                        </x-dropdown-button-danger>
                                        <x-dropdown-button
                                            x-on:click.prevent="$dispatch('open-modal', 'modal-clone-survey-form-{{ $form->id }}')">
                                            <span>Clone</span>
                                        </x-dropdown-button>
                                        <x-dropdown-button-danger class="text-danger" type="button"
                                            x-on:click.prevent="$dispatch('open-modal', 'modal-delete-form-{{ $form->id }}')">
                                            Delete
                                        </x-dropdown-button-danger>
                                    </div>
                                </x-slot>
                            </x-dropdown>

                            <x-modal name="modal-unpublish-form-{{$form->id}}"
                                x-on:close.window="@this.dispatch('close')" focusable>
                                <div class="p-4 text-left">
                                    <h2 class="mb-1 modal-title poppins-semibold text-xl">
                                        Are you sure you want to unpublish this form?
                                    </h2>
                                    <div>
                                        <form wire:submit.prevent="unPublish('{{ $form->id }}')">
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
                            <x-modal name="modal-delete-form-{{$form->id}}"
                                x-on:close.window="@this.dispatch('close')" focusable>
                                <div class="p-4 text-left">
                                    <h2 class="mb-1 modal-title poppins-semibold text-xl" id="modal-update-form">
                                        Are you sure you want to delete this form?
                                    </h2>
                                    <div>
                                        <form wire:submit.prevent="deleteForm('{{ $form->id }}')">
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

                            @livewire("survey.clone-form", ["form_id" => $form->id, "isModalOnly" => true])

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.addEventListener('survey-form-unpublished', function () {
            showToast("Survey form unpublished successfully!");
            refreshSurveyFormTable();
        });
    </script>
</div>

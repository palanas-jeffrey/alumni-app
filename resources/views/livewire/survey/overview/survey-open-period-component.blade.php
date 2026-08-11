<div>
    <section>
        <div class="bg-white border-1 border-gray-300 rounded-4">
            <div class="p-6">
                <div class="flex flex justify-between">
                    <div>
                        <h2 class="font-medium poppins-semibold text-lg">Survey open period</h2>
                        <p class="mb-3 text-gray-600 text-sm">Displays the scheduled periods for collecting survey responses.</p>
                    </div>

                    @if (!$is_published)
                        <div class="ml-6">
                            <x-primary-button x-data="" type="button"
                                x-on:click.prevent="$dispatch('open-modal', 'modal-survey-period')">
                                    <span>Add</span>
                            </x-primary-button>
                        </div>
                    @endif
                </div>
                <div>
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Start</th>
                                    <th scope="col">End</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($periods as $period)
                                    <tr>
                                        <th scope="row">{{ $loop -> index + 1 }}</th>
                                        <td class="text-wrap">
                                            <span>{{ \Carbon\Carbon::parse($period->start_date)->format('F j, Y') }}</span>
                                        </td>
                                        <td class="text-wrap">
                                            <span>{{ \Carbon\Carbon::parse($period->end_date)->format('F j, Y') }}</span>
                                        </td>
                                        <td class="text-right">
                                            @if (!$is_published)
                                                <div>
                                                    <x-dropdown>
                                                        <x-slot name="trigger">
                                                            <button class="dots-trigger"><i class="bi bi-three-dots-vertical"></i></button>
                                                        </x-slot>

                                                        <x-slot name="content">
                                                            <div>
                                                                <x-dropdown-button type="button"
                                                                    wire:click.prevent="editPeriod('{{ $period->start_date }}', '{{ $period->end_date }}')"
                                                                    x-on:click.prevent="$dispatch('open-modal', 'modal-update-period-form-{{ $period->id }}')">
                                                                    Update
                                                                </x-dropdown-button>
                                                                <x-dropdown-button-danger class="text-danger"
                                                                    x-on:click.prevent="$dispatch('open-modal', 'modal-delete-period-{{ $period->id }}')">
                                                                    <span>Delete</span>
                                                                </x-dropdown-button-danger>
                                                            </div>
                                                        </x-slot>
                                                    </x-dropdown>

                                                    <x-modal name="modal-update-period-form-{{$period->id}}"
                                                        x-on:close.window="@this.dispatch('close')">
                                                        <div class="p-4 text-left">
                                                            <h2 class="mb-1 modal-title poppins-semibold text-xl">
                                                                Update period
                                                            </h2>
                                                            <p class="mb-4 mt-1 text-gray-600 text-sm">All fields are required.</p>
                                                            <div>
                                                                <form wire:submit.prevent="updatePeriod({{$period->id}})">
                                                                    <div class="flex">
                                                                        <div class="mb-2 p-2 w-50">
                                                                            <x-input-label for="start_date" :value="__('Start')" />
                                                                            <x-input-date id="start_date" class="block mt-1 w-full" type="text" class="singleDatePicker"
                                                                                name="start_date" wire:model.lazy="start_date" required autocomplete="date_of_birth" />
                                                                            <div>
                                                                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-2 p-2 w-50">
                                                                            <x-input-label for="end_date" :value="__('End')" />
                                                                            <x-input-date id="end_date" class="block mt-1 w-full" type="text" class="singleDatePicker"
                                                                                name="end_date" wire:model.lazy="end_date" required autocomplete="end_date"/>
                                                                            <div>
                                                                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex mt-5">
                                                                        <x-primary-button>Update</x-primary-button>
                                                                        <x-link-generic class="ml-6" href="javascript:void(0);"
                                                                            wire:click.prevent="resetForm()"
                                                                            x-on:click="$dispatch('close')">
                                                                            <span>Cancel</span>    
                                                                        </x-link-generic>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </x-modal>

                                                    <x-modal name="modal-delete-period-{{$period->id}}"
                                                        x-on:close.window="@this.dispatch('close')">
                                                        <div class="p-4">
                                                            <h2 class="mb-1 modal-title poppins-semibold text-left text-xl">
                                                                Are you sure you want to delete this period?
                                                            </h2>
                                                            <div>
                                                                <form wire:submit.prevent="deletePeriod({{$period->id}})">
                                                                    <div class="d-flex mt-4">
                                                                        <x-danger-button type="submit">
                                                                            <div class="relative">
                                                                                <span class="btn-text">Delete</span>
                                                                                <div class="dots-loader absolute v-hidden">
                                                                                    <span></span><span></span><span></span>
                                                                                </div>
                                                                            </div>
                                                                        </x-primary-button>
                                                                        <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                                                            <span>Cancel</span>    
                                                                        </x-link-generic>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </x-modal>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <x-modal name="modal-survey-period"
        x-on:close.window="@this.dispatch('close')">
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="eventCreationModal">
                Add period
            </h2>
            <p class="mb-4 mt-1 text-gray-600 text-sm">Add new survey period.</p>

            <form wire:submit.prevent="addPeriod">
                <div class="flex">
                    <div class="mb-2 p-2 w-50">
                        <x-input-label for="start_date" :value="__('Start')" />
                        <x-input-date id="start_date" class="block mt-1 w-full" type="text" class="singleDatePicker" 
                            name="start_date" wire:model.lazy="start_date" required autocomplete="date_of_birth"/>
                        <div>
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mb-2 p-2 w-50">
                        <x-input-label for="end_date" :value="__('End')" />
                        <x-input-date id="end_date" class="block mt-1 w-full" type="text" class="singleDatePicker" 
                            name="end_date" wire:model.lazy="end_date" required autocomplete="end_date"/>
                        <div>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-start">
                    <x-primary-button type="submit" class="mr-6">
                        <div class="relative">
                            <span class="btn-text">Add</span>
                            <div class="dots-loader absolute v-hidden">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </x-primary-button>
        
                    <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close'); pageReload();">
                        <span>Cancel</span>    
                    </x-link-generic>
                </div>
            </form>
        </div>
    </x-modal>

    @include('shared.js.script-date-picker')

    <script>
        window.addEventListener('survey-period-added', event => {
            showToast("Survey period added successfully!");
            pageReload();
        });

        window.addEventListener('survey-period-deleted', event => {
            showToast("Survey period deleted successfully!");
            pageReload();
        });

        window.addEventListener('survey-period-updated', event => {
            showToast("Survey period updated successfully!");
            pageReload();
        });

        function pageReload() {
            setTimeout(function(){
                window.location.reload();
            }, 1500);
        }
    </script>
</div>

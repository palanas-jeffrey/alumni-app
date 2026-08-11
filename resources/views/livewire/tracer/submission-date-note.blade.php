<div class="py-12 p-b-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <div class="w-1/3">
            <div class="p-6 bg-dust-gray rounded-4 mr-6">
                <div class="mb-4">
                    <h2 class="font-medium poppins-semibold text-lg">
                        Submission date
                    </h2>
                    <p class="mb-1 mt-1 text-sm">
                        Create a submission date entry.
                    </p>
                </div>
                <form wire:submit.prevent="submit">
                    <div>
                        <div class="font-semibold text-xl text-gray-800 leading-tight">
                            <x-input-label for="singleDatePicker" :value="__('Submission date')" />
                            <x-input-date  class="w-100" type="text"
                                id="singleDatePicker" class="singleDatePicker block" required
                                wire:model="date" />
                            @error('date') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="note" :value="__('Note')" />
                        <x-textarea-box name="note" id="note" rows="4" placeholder="Write your note here"
                            wire:model="note"></x-textarea-box>
                        @error('note') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4">
                        <x-primary-button type="submit">
                            <div class="relative">
                                <span class="btn-text">Create</span>
                                <div class="dots-loader absolute v-hidden">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="p-6 bg-white border-1 border-gray-300 rounded-4">
                <div class="mb-4">
                    <h2 class="font-medium poppins-semibold text-lg">
                        Submission schedule
                    </h2>
                    <p class="mb-1 mt-1 text-sm">
                        Submission schedules list
                    </p>
                </div>
                <div>
                    @if ($incomingSchedules)
                        <ul>
                            @foreach ($incomingSchedules as $schedule)
                                <li class="mb-2">
                                    <div class="border-1 flex line-height-normal p-2 rounded-2 shadow-md">
                                        <div class="ml-1 mr-6 txt-18 w-18">
                                            @if ($schedule->isDone)
                                                <i class="bi bi-check-square-fill text-success"></i>
                                            @endif
                                        </div>
                                        <div class="mr-6 poppins-semibold txt-18">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                                        </div>
                                        <div class="w-65p">
                                            <span class="txt-18">Note: </span>
                                            <span>{{ $schedule->note }}</span>
                                        </div>
                                        <div class="flex-grow-1 text-right">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button class="txt-18">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </x-slot>
    
                                                <x-slot name="content">
                                                    <div>
                                                        @if ($schedule->isDone)
                                                            <x-dropdown-button type="button" wire:click.prevent="toggleStatus({{ $schedule->id }}, false)">
                                                                Undo status
                                                            </x-dropdown-button>
                                                        @else
                                                            <x-dropdown-button type="button" wire:click.prevent="toggleStatus({{ $schedule->id }})">
                                                                Mark as done
                                                            </x-dropdown-button>
                                                        @endif
    
                                                        <x-dropdown-button type="button" 
                                                            x-on:click.prevent="setTimeout(() => { $dispatch('open-modal', 'modal-edit-schedule-{{ $schedule->id }}') }, 1000); "
                                                            wire:click.prevent=" setEditValues({{ $schedule->id }})">
                                                            Edit
                                                        </x-dropdown-button>
    
                                                        <x-dropdown-button-danger class="text-danger" type="button"
                                                            x-on:click.prevent="$dispatch('open-modal', 'modal-delete-schedule-{{ $schedule->id }}')">
                                                            Delete schedule
                                                        </x-dropdown-button-danger>
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
    
                                            <x-modal name="modal-edit-schedule-{{ $schedule->id }}">
                                                <div class="p-6 text-left">
                                                    <div>
                                                        <h2 class="font-medium poppins-semibold text-lg">
                                                            Update submission date
                                                        </h2>
                                                        <p class="mb-1 mt-1 text-sm">
                                                            Update a submission date entry.
                                                        </p>
                                                    </div>
                                                    <form wire:submit.prevent="submitUpdates({{$schedule->id}})">
                                                        <div>
                                                            <div class="font-semibold text-xl text-gray-800 leading-tight">
                                                                <x-input-label for="singleDatePicker" :value="__('Submission date')" />
                                                                <x-input-date type="text"
                                                                    id="singleDatePicker" class="singleDatePicker block" required
                                                                    wire:model="updateDate"/>
                                                                @error('updateDate') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <x-input-label for="note" :value="__('Note')" />
                                                            <x-textarea-box name="note" id="note" rows="4" placeholder="Write your note here"
                                                                wire:model="updateNote">{{ $updateNote }}</x-textarea-box>
                                                            @error('note') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="mt-5 flex">
                                                            <x-primary-button type="submit">
                                                                <div class="relative">
                                                                    <span class="btn-text">Update</span>
                                                                    <div class="dots-loader absolute v-hidden">
                                                                        <span></span><span></span><span></span>
                                                                    </div>
                                                                </div>
                                                            </x-primary-button>
    
                                                            <x-link-generic class="ml-6" href="javascript:void(0);" 
                                                                x-on:click="$dispatch('close')" wire:click="clearUpdates">
                                                                <span>Cancel</span>    
                                                            </x-link-generic>
                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>
    
                                            <x-modal name="modal-delete-schedule-{{ $schedule->id }}" focusable>
                                                <form class="p-6 text-left" wire:submit.prevent="deleteSchedule({{$schedule->id}})">
                                                    <h2 class="poppins-semibold text-xl">
                                                        Are you sure you want to delete this schedule?
                                                    </h2>
    
                                                    <div class="mt-6 flex">
                                                        <x-danger-button type="submit">
                                                            <div class="relative">
                                                                <span class="btn-text">Delete schedule</span>
                                                                <div class="dots-loader absolute v-hidden">
                                                                    <span></span><span></span><span></span>
                                                                </div>
                                                            </div>
                                                        </x-danger-button>
                                                        <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                                            <span>Cancel</span>    
                                                        </x-link-generic>
                                                    </div>
                                                </form>
                                            </x-modal>
    
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h2 class="font-medium poppins-semibold text-lg text-center">
                            No schedules.
                        </h2>
                    @endif
                </div>
            </div>

            <div class="p-6 bg-light border-1 border-gray-300 rounded-4 mt-6">
                <div class="mb-4">
                    <h2 class="font-medium poppins-semibold text-lg">
                        Previous Submission
                    </h2>
                    <p class="mb-1 mt-1 text-sm">
                        Previous submission schedules list
                    </p>
                </div>
                <div class="max-h-60vh">
                    @if ($previousSchedules)
                        <ul>
                            @foreach ($previousSchedules as $schedule)
                                <li class="mb-2">
                                    <div class="border-1 flex line-height-normal p-2 rounded-2 shadow-md">
                                        <div class="ml-1 mr-6 txt-18 w-18">
                                            @if ($schedule->isDone)
                                                <i class="bi bi-check-square-fill text-success"></i>
                                            @endif
                                        </div>
                                        <div class="mr-6 poppins-semibold txt-18">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                                        </div>
                                        <div class="w-65p">
                                            <span class="txt-18">Note: </span>
                                            <span>{{ $schedule->note }}</span>
                                        </div>
                                        <div class="flex-grow-1 text-right">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button class="txt-18">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </x-slot>
    
                                                <x-slot name="content">
                                                    <div>
                                                        @if ($schedule->isDone)
                                                            <x-dropdown-button type="button" wire:click.prevent="toggleStatus({{ $schedule->id }}, false)">
                                                                Undo status
                                                            </x-dropdown-button>
                                                        @else
                                                            <x-dropdown-button type="button" wire:click.prevent="toggleStatus({{ $schedule->id }})">
                                                                Mark as done
                                                            </x-dropdown-button>
                                                        @endif
    
                                                        <x-dropdown-button type="button" 
                                                            x-on:click.prevent="setTimeout(() => { $dispatch('open-modal', 'modal-edit-schedule-{{ $schedule->id }}') }, 1000); "
                                                            wire:click.prevent=" setEditValues({{ $schedule->id }})">
                                                            Edit
                                                        </x-dropdown-button>
    
                                                        <x-dropdown-button-danger class="text-danger" type="button"
                                                            x-on:click.prevent="$dispatch('open-modal', 'modal-delete-schedule-{{ $schedule->id }}')">
                                                            Delete schedule
                                                        </x-dropdown-button-danger>
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
    
                                            <x-modal name="modal-edit-schedule-{{ $schedule->id }}">
                                                <div class="p-6 text-left">
                                                    <div>
                                                        <h2 class="font-medium poppins-semibold text-lg">
                                                            Update submission date
                                                        </h2>
                                                        <p class="mb-1 mt-1 text-sm">
                                                            Update a submission date entry.
                                                        </p>
                                                    </div>
                                                    <form wire:submit.prevent="submitUpdates({{$schedule->id}})">
                                                        <div>
                                                            <div class="font-semibold text-xl text-gray-800 leading-tight">
                                                                <x-input-label for="singleDatePicker" :value="__('Submission date')" />
                                                                <x-input-date type="text"
                                                                    id="singleDatePicker" class="singleDatePicker block" required
                                                                    wire:model="updateDate"/>
                                                                @error('updateDate') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <x-input-label for="note" :value="__('Note')" />
                                                            <x-textarea-box name="note" id="note" rows="4" placeholder="Write your note here"
                                                                wire:model="updateNote">{{ $updateNote }}</x-textarea-box>
                                                            @error('note') <span class="text-danger txt-14">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="mt-5 flex">
                                                            <x-primary-button type="submit">
                                                                <div class="relative">
                                                                    <span class="btn-text">Update</span>
                                                                    <div class="dots-loader absolute v-hidden">
                                                                        <span></span><span></span><span></span>
                                                                    </div>
                                                                </div>
                                                            </x-primary-button>
    
                                                            <x-link-generic class="ml-6" href="javascript:void(0);" 
                                                                x-on:click="$dispatch('close')" wire:click="clearUpdates">
                                                                <span>Cancel</span>    
                                                            </x-link-generic>
                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>
    
                                            <x-modal name="modal-delete-schedule-{{ $schedule->id }}" focusable>
                                                <form class="p-6 text-left" wire:submit.prevent="deleteSchedule({{$schedule->id}})">
                                                    <h2 class="poppins-semibold text-xl">
                                                        Are you sure you want to delete this schedule?
                                                    </h2>
    
                                                    <div class="mt-6 flex">
                                                        <x-danger-button type="submit">
                                                            <div class="relative">
                                                                <span class="btn-text">Delete schedule</span>
                                                                <div class="dots-loader absolute v-hidden">
                                                                    <span></span><span></span><span></span>
                                                                </div>
                                                            </div>
                                                        </x-danger-button>
                                                        <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                                            <span>Cancel</span>    
                                                        </x-link-generic>
                                                    </div>
                                                </form>
                                            </x-modal>
    
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h2 class="font-medium poppins-semibold text-lg text-center">
                            No schedules.
                        </h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'modal-sorting-')">
            <span class="mr-2"><i class="bi bi-repeat"></i></span>
            <span>Sort</span>
    </x-primary-button>

    <x-modal name="modal-sorting-"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="eventCreationModal">
                Sort form sections
            </h2>
            <p class="mb-4 mt-1 text-gray-600 text-sm">Drag items to sort.</p>
            <div wire:ignore>
                <ul class="relative w-100 sortable-list" wire:sortable="reorder">
                    @foreach ($items as $item)
                        <li wire:sortable.handle class="sort-trigger" wire:sortable.item="{{ $item->id }}" wire:key="item-{{ $item->id }}">
                            <div class="sortable-item shadow">
                                <div class="d-flex">
                                    <div>
                                        <div class="dots-trigger">☰</div>
                                    </div>
                                    <div>
                                        <div>{{ $item->survey_section_title }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6 flex justify-start">
                @if($hasUpdated)
                    <x-primary-button wire:click="saveOrder" class="mr-6">
                        Save order
                    </x-primary-button>
                @endif

                <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        </div>
    </x-modal>
</div>
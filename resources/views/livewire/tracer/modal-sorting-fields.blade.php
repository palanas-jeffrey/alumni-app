<div>
    <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'modal-sorting-field-{{$section_id}}')">
        <span class="mr-2"><i class="bi bi-repeat"></i></span>
        <span>Sort questions</span>
    </x-primary-button>

    <x-modal name="modal-sorting-field-{{$section_id}}"
        x-on:close.window="@this.dispatch('close')" focusable>
        <div class="p-4">
            <h2 class="mb-1 modal-title poppins-semibold text-xl" id="eventCreationModal">
                Sort questions of the section
            </h2>
            <p class="mb-4 mt-1 text-gray-600 text-sm">Drag items to sort.</p>
            <div wire:ignore>
                <ul class="relative w-100 sortable-list" wire:sortable="reorderQuestions">
                    @foreach ($items as $item)
                        <li wire:sortable.handle class="sort-field-trigger" wire:sortable.item="{{ $item->id }}" wire:key="item-{{ $item->id }}">
                            <div class="sortable-item shadow">
                                <div class="d-flex">
                                    <div>
                                        <div class="dots-trigger">
                                            ☰
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            {{ $item->field_label }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6 flex justify-start">
                @if($hasUpdated)
                    <x-primary-button wire:click="saveOrder" class="mr-3">
                        Save order
                    </x-primary-button>
                @endif

                <x-link-generic class="ml-3" href="javascript:void(0);" x-on:click="$dispatch('close')">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        </div>
    </x-modal>

    <script> 
        document.addEventListener('DOMContentLoaded', function () {
            new Sortable(document.querySelector('[wire\\:sortable="reorderQuestions"]'), {
                handle: '.sort-field-trigger',
                ghostClass: 'sortable-ghost',
                forceFallback: true,
                fallbackOnBody: true,
            
                onStart: function (evt) {
                },
            
                onEnd: function (evt) {
                },
            
                onMove: function(evt) {
                }
            });
        });
    </script>
</div>
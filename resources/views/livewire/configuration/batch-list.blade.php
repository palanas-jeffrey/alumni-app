<div> 
    <div> 
        <h2 class="font-medium poppins-semibold text-lg">Batch list</h2>
        <p class="text-gray-600 text-sm">Update batch list</p>
    </div>
    <div class="bg-dust-gray mt-2 p-3">
        <form wire:submit.prevent="submit">
            <div>
                <div class="mb-4">
                    <x-input-label for="batch_year" :value="__('Batch year (e.g., 2025-2026)')" />
                    <x-text-input id="batch_year" wire:model="batch_year" name="batch_year" type="text" class="mt-1 block" />
                    @error('batch_year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-primary-button type="submit">
                        <span>Add</span>
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
    <div class="mt-2">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Batch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($batch_list as $batch)
                    <tr>
                        <th scope="col">{{ $loop->index + 1 }}</th>
                        <th scope="col">{{ $batch->batch_year }}</th>
                        <th scope="col">
                            <div class="text-right">
                                <button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $batch->id }}')" 
                                    class="text-danger">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            
                                <x-modal name="confirm-deletion-{{ $batch->id }}" :show="$errors->userDeletion->isNotEmpty()"
                                    @batch-year-deleted.window="$dispatch('close')" focusable>
                                    <div class="p-6">
                                        <h2 class="poppins-semibold text-xl text-left">
                                            {{ __('Are you sure you want to delete this batch year?') }}
                                        </h2>
                            
                                        <div class="mt-6 flex">
                                            <x-danger-button wire:click="delete({{ $batch->id }})">
                                                Delete
                                            </x-danger-button>
                                            <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                                <span>Cancel</span>    
                                            </x-link-generic>
                                        </div>
                                    </div>
                                </x-modal>

                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.addEventListener('batch-year-added', function () {
            showToast("Batch year added successfully!");
        });

        window.addEventListener('batch-year-deleted', function () {
            showToast("Batch year deleted successfully!");
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    </script>
</div>

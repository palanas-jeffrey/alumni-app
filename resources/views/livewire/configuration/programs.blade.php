<div class="bg-white border-1 border-gray-300 rounded-4 p-6">
    <div> 
        <div> 
            <h2 class="font-medium poppins-semibold text-lg">Program list</h2>
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Update program list</p>
                </div>
                <div>
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'add-program-form')">
                        <span>Add</span>
                    </x-primary-button>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Program</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($programs)
                        @foreach($programs as $program)
                            <tr>
                                <td scope="col">{{ $loop->index + 1 }}</td>
                                <td scope="col">{{ $program->program_name }}</td>
                                <td scope="col">{{ $program->program_abbreviation }}</td>
                                <td scope="col">
                                    <button wire:click="setFormToUpdate({{$program->id}})" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'update-program-form-{{$program->id}}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-program-deletion-{{ $program->id }}')" 
                                        class="text-danger ml-2">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>

                                    <x-modal name="update-program-form-{{$program->id}}"
                                        focusable>
                                        <div class="p-6">
                                            <h2 class="poppins-semibold text-xl text-left">
                                                Update program
                                            </h2>

                                            <form wire:submit.prevent="updateProgram({{$program->id}})">
                                                <div>
                                                    <div class="mb-2 p-2 width-full">
                                                        <x-input-label for="program_name" :value="__('Program name')" />
                                                        <x-text-input id="program_name" class="block mt-1 w-full" type="text" name="program_name" 
                                                            wire:model.lazy="program_name" autocomplete="program_name" />
                                                        <x-input-error :messages="$errors->get('program_name')" class="mt-2" />
                                                    </div>
                                    
                                                    <div class="mb-2 p-2 width-half">
                                                        <x-input-label for="program_abbreviation" :value="__('Abbreviation')" />
                                                        <x-text-input id="program_abbreviation" class="block mt-1 w-full" type="text" name="program_abbreviation" 
                                                            wire:model.lazy="program_abbreviation" autocomplete="program_abbreviation"/>
                                                        <x-input-error :messages="$errors->get('program_abbreviation')" class="mt-2" />
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex">
                                                    <x-primary-button type="submit">
                                                        <div class="relative">
                                                            <span class="btn-text">Update</span>
                                                            <div class="dots-loader absolute v-hidden">
                                                                <span></span><span></span><span></span>
                                                            </div>
                                                        </div>
                                                    </x-primary-button>
                                                    <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')" wire:click="resetForm">
                                                        <span>Cancel</span>    
                                                    </x-link-generic>
                                                </div>
                                            </form>
                                        </div>
                                    </x-modal>

                                    <x-modal name="confirm-program-deletion-{{ $program->id }}"
                                        focusable>
                                        <div class="p-6">
                                            <h2 class="poppins-semibold text-xl text-left">
                                                {{ __('Are you sure you want to delete this program?') }}
                                            </h2>
                                
                                            <div class="mt-6 flex">
                                                <x-danger-button wire:click="deleteProgram({{ $program->id }})">
                                                    Delete
                                                </x-danger-button>
                                                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                                                    <span>Cancel</span>    
                                                </x-link-generic>
                                            </div>
                                        </div>
                                    </x-modal>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">
                                <div>Nothing to show.</div>  
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <script>
        </script>
    </div>
                      
    <x-modal name="add-program-form"
        focusable>
        <div class="p-6">
            <h2 class="poppins-semibold text-xl text-left">
                Add a program
            </h2>

            <form wire:submit.prevent="submit">
                <div>
                    <div class="mb-2 p-2 width-full">
                        <x-input-label for="program_name" :value="__('Program name')" />
                        <x-text-input id="program_name" class="block mt-1 w-full" type="text" name="program_name" 
                            wire:model.lazy="program_name" autocomplete="program_name" />
                        <x-input-error :messages="$errors->get('program_name')" class="mt-2" />
                    </div>
    
                    <div class="mb-2 p-2 width-half">
                        <x-input-label for="program_abbreviation" :value="__('Abbreviation')" />
                        <x-text-input id="program_abbreviation" class="block mt-1 w-full" type="text" name="program_abbreviation" 
                            wire:model.lazy="program_abbreviation" autocomplete="program_abbreviation" />
                        <x-input-error :messages="$errors->get('program_abbreviation')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex">
                    <x-primary-button type="submit">
                        <div class="relative">
                            <span class="btn-text">Add</span>
                            <div class="dots-loader absolute v-hidden">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </x-primary-button>
                    <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')" wire:click="resetForm">
                        <span>Cancel</span>    
                    </x-link-generic>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        window.addEventListener('program-added', function () {
            showToast("Program added successfully!");
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });

        window.addEventListener('program-updated', function () {
            showToast("Program updated successfully!");
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });

        window.addEventListener('program-deleted', function () {
            showToast("Program deleted successfully!");
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    </script>
</div>

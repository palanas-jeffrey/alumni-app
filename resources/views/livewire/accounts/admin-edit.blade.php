<div>
    @if ($isVerified)
        <div class="flex"> 
            <div class="bg-white border-1 border-gray-300 flex-grow-1 rounded-4"> 
                <div class="p-6">
                    <div>
                        <h2 class="text-lg font-medium poppins-semibold">
                            Update account
                        </h2>
        
                        <p class="mb-2 mt-1 text-sm">
                            Ensure all fields are filled out accurately and reflect current information.
                        </p>
                    </div>
        
                    <form wire:submit.prevent="submit">
                        <div class="d-flex flex-wrap justify-between">           
                            <div class="mb-2 p-2 width-half">
                                <x-input-label for="last_name" :value="__('Last name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" 
                                    wire:model.lazy="last_name" autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            
                            <div class="mb-2 p-2 width-half">
                                <x-input-label for="first_name" :value="__('First name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" 
                                    wire:model.lazy="first_name" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                    
                            <!-- Email Address -->
                            <div class="mb-2 p-2 width-half">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                                    wire:model.lazy="email" autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                
                        <div class="flex items-center mt-4">
                            <x-primary-button type="submit">
                                <div class="relative">
                                    <span class="btn-text">Update details</span>
                                    <div class="dots-loader absolute v-hidden">
                                        <span></span><span></span><span></span>
                                    </div>
                                </div>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        
            <div class="bg-primary-subtle ml-6 p-4 rounded-4 w-1/3">
                <div>
                    <h2 class="text-lg font-medium poppins-semibold">
                        Update Password
                    </h2>
        
                    <p class="mb-2 mt-1 text-sm">
                        Ensure the account is using a long, random password to stay secure.
                    </p>
                </div>
                <div>
                    <form class="form-password" wire:submit.prevent="submitPassword">
                        <div>
                            <div>
                                <!-- Password -->
                                <div class="mb-2 p-2">
                                    <x-input-label for="admin-password" :value="__('Password')" />
                        
                                    <div class="relative password-input">
                                        <x-text-input id="admin-password" class="block mt-1 w-full"
                                                        type="password"
                                                        name="password"
                                                        wire:model.lazy="password"
                                                        required autocomplete="new-password" />
                                        <button class="absolute password-toggle">
                                            <i class="bi bi-eye-fill"></i>
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                        
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                        
                                <!-- Confirm Password -->
                                <div class="mb-2 p-2">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        
                                    <div class="relative password-input">
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                        type="password"
                                                        name="password_confirmation"
                                                        wire:model.lazy="password_confirmation" required autocomplete="new-password" />
                                        <button class="absolute password-toggle">
                                            <i class="bi bi-eye-fill"></i>
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                        
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
        
                        <div class="flex items-center mt-4">
                            <x-primary-button type="submit">
                                <div class="relative">
                                    <span class="btn-text">Update password</span>
                                    <div class="dots-loader absolute v-hidden">
                                        <span></span><span></span><span></span>
                                    </div>
                                </div>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <div class="bg-danger-subtle p-4 rounded-4 shadow">
                <div>
                    <div>
                        <section class="space-y-6">
                            <header>
                                <h2 class="poppins-semibold text-lg">
                                    {{ __('Delete Account') }}
                                </h2>
                        
                                <p class="mt-1 text-sm">
                                    {{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Before deleting the account, please backup any data or information that you wish to retain.') }}
                                </p>
                            </header>
                            
                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-admin-deletion')">{{ __('Delete Account') }}</x-danger-button>
                        
                            <x-modal name="confirm-admin-deletion" focusable>
                                <form wire:submit.prevent="deleteAdminAccount" class="p-6">
                        
                                    <h2 class="poppins-semibold text-xl">
                                        {{ __('Are you sure you want to delete this account?') }}
                                    </h2>
                        
                                    <p class="mt-2 text-sm">
                                        Once this account is deleted, all of its resources and data will be permanently deleted. Please enter the <strong>admin access key</strong> to confirm you would like to permanently delete this account.
                                    </p>
                        
                                    <div class="mt-6">
                                        <x-input-label for="password" value="{{ __('Admin access key') }}" class="sr-only" />
                        
                                        <x-text-input id="password" name="admin_key" type="password" class="mt-1 block w-3/4"
                                            placeholder="{{ __('Admin access key') }}" wire:model.lazy="admin_access_key" />

                                        <x-input-error :messages="$errors->get('admin_key')" class="mt-2" />
                                    </div>
                        
                                    <div class="mt-6 flex">
                                        <x-danger-button>
                                            <div class="relative">
                                                <span class="btn-text">Delete account</span>
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
                        </section>
                    </div>
                </div>
            </div>
        </div>
    @else
        @livewire('shared.admin-access-lock')
    @endif

    <script>
        window.addEventListener('access-key-invalid', function () {
            showToast("Invalid admin access key.", false);
        });
    </script>
</div>

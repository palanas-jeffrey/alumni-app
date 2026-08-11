<div>
    @if ($isVerified)
        <div class="bg-white border-1 border-gray-300 rounded-4"> 
            <div class="p-6">
                <div>
                    <form wire:submit.prevent="submit">
                    
                        <div class="d-flex flex-wrap justify-between">           
                            <div class="mb-2 p-2 w-1/3">
                                <x-input-label for="last_name" :value="__('Last name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" 
                                    wire:model.lazy="last_name" required autofocus autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            
                            <div class="mb-2 p-2 w-1/3">
                                <x-input-label for="first_name" :value="__('First name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" 
                                    wire:model.lazy="first_name" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                    
                            <!-- Email Address -->
                            <div class="mb-2 p-2 w-1/3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                                    wire:model.lazy="email" autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
            
                        <div class="d-flex flex-wrap">
                            <!-- Password -->
                            <div class="mb-2 p-2 w-1/3">
                                <x-input-label for="password" :value="__('Password')" />
                    
                                <div class="relative password-input">
                                    <x-text-input id="password" class="block mt-1 w-full"
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
                            <div class="mb-2 p-2 w-1/3">
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
            
                        <div class="flex items-center mt-4">
                            <x-primary-button type="submit">
                                <div class="relative">
                                    <span class="btn-text">Register as admin</span>
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
    @else
        @livewire('shared.admin-access-lock')
    @endif

    <script>
        window.addEventListener('admin-registered', function () {
            showToast("Admin registered successfully!");

            var fields = document.querySelectorAll("input, select, textarea");
            
            fields.forEach(function(input) {
                input.value ="";
            });
        });
    </script>
</div>
 
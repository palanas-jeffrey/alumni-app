<div> 
    <x-modal name="change-password-modal" :show="$isShowing" focusable>
        <div class="p-4">
            <div>
                <h2 class="font-medium text-xl">
                    Secure your login
                </h2>
            </div>
            <div class="line-height-normal mb-4 mt-2">
                <p class="mb-2">It is recommended to update your password.</p>
                <p>
                    <strong>Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</strong>
                </p>
            </div>
            <div>
                <form wire:submit.prevent="submit">
                    <div class="">               
                        <div class="width-half mb-4">
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
                
                        <div class="width-half mb-4">
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
                
                    <div class="flex justify-start mt-4">
                        <x-primary-button type="submit" class="mr-3">
                            Update password
                        </x-primary-button>

                        <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')"
                            wire:click="updateFirstLogin"
                            > Cancel </x-link-generic>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
</div>
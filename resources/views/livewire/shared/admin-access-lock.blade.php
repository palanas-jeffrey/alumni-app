<div>
    <section class="bg-primary-subtle mb-6 p-4 rounded-4 space-y-6">
        <div>
            <h2 class="poppins-semibold text-lg">Secure verification required</h2>
            <p class="mt-1 mb-1 text-sm text-gray-600">Please enter the admin access key to continue.</p>
            <form class="mt-4 code-form" wire:submit.prevent="submitPasscode">
                <div class="w-1/3">
                    <x-input-label for="secure-password" :value="__('Admin access key')" />
        
                    <div class="relative password-input">
                        <x-text-input id="secure-password" class="block mt-1 w-full"
                            type="password"
                            name="secure-password"
                            wire:model.lazy="admin_access_key"
                            required />
                                    
                        <button class="absolute password-toggle">
                            <i class="bi bi-eye-fill"></i>
                            <i class="bi bi-eye-slash-fill"></i>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('admin_key')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-primary-button type="submit">
                        <div class="relative">
                            <span class="btn-text">Submit</span>
                            <div class="dots-loader absolute v-hidden">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </section>

    <script>
        window.addEventListener('access-verified', function () {
            showToast("Access verified!");
        });

        window.addEventListener('access-refused', function () {
            showToast("Access refused.", false);
        });
    </script>
</div>

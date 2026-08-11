<div>
    @if ($isVerified)
        <div>
            <section class="bg-mint-green mb-6 p-4 rounded-4 space-y-6">
                <div>
                    <h2 class="poppins-semibold text-lg">Update admin access key</h2>
                    <p class="mt-1 mb-1 text-sm text-gray-600">Please enter the new admin access key.</p>
                    <form class="mt-4 code-form" wire:submit.prevent="submitNewPasscode">
                        <div class="w-1/3">
                            <x-input-label for="secure-password" :value="__('New admin access key')" />
                
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

                            <x-input-error :messages="$errors->get('admin_access_key')" class="mt-2" />
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
        </div>
    @else
        @livewire('shared.admin-access-lock')
    @endif

    <script>
        window.addEventListener('admin-key-updated', function () {
            showToast("Admin access key updated successfully!");
            var form = document.querySelector(".code-form");
            var fields = form.querySelectorAll("input");
            
            fields.forEach(function(input) {
                input.value ="";
            });
        });
    </script>
</div>
 
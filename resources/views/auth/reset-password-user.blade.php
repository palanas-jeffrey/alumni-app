<x-login-main>
    <div class="mt-120 mb-4">
        <h1 class="poppins-semibold text-center text-xl">Reset password</h1>
    </div>
    <div class="login-card px-6 sm:max-w-md">
        <form method="POST" action="{{ route('user.password.store') }}">
            @csrf
            
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('New password')" />
                <div class="relative password-input">
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <button class="absolute password-toggle">
                        <i class="bi bi-eye-fill"></i>
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm new password')" />

                <div class="relative password-input">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                    <button class="absolute password-toggle">
                        <i class="bi bi-eye-fill"></i>
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
<x-login-main>

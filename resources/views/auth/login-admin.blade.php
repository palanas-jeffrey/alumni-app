<x-login-main>
    <div class="mt-120 mb-4">
        <h1 class="poppins-semibold text-center text-xl">Administrator login</h1>
    </div>

    <div class="login-card px-6 sm:max-w-md">

        <form method="POST" action="{{ route('admin-login-auth') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <div class="relative password-input">
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <button class="absolute password-toggle">
                        <i class="bi bi-eye-fill"></i>
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-4">
                <div>
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 " name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('admin.password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-center mt-5">
                <x-primary-button class="w-100">
                    <div class="relative">
                        <span class="btn-text">Log in</span>
                        <div class="dots-loader absolute v-hidden">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </x-primary-button>
            </div>
        </form>
    </div>

    @include('shared.toaster')

     @if (session('status'))
        <script>
            showToast("{{ session('status') }}");
        </script>
    @endif
</x-login-main>
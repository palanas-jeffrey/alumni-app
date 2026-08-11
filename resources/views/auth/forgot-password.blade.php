<x-login-main>
    <div class="mt-120 mb-4">
        <h1 class="poppins-semibold text-center text-xl">Recover account</h1>
    </div>
    <div class="login-card px-6 sm:max-w-md">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-5">
                <x-primary-button class="m-auto">
                    Email password reset link
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

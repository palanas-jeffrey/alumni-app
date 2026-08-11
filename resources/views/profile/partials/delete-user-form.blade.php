<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium poppins-semibold">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="poppins-semibold text-lg">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-3">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative password-input">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}"
                    />
                                
                    <button class="absolute password-toggle">
                        <i class="bi bi-eye-fill"></i>
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex">
                <x-danger-button>
                    {{ __('Delete Account') }}
                </x-danger-button>
                <x-link-generic href="javascript:void(0);" x-on:click="$dispatch('close')" class="ml-6">
                    {{ __('Cancel') }}
                </x-link-generic>
            </div>
        </form>
    </x-modal>
</section>

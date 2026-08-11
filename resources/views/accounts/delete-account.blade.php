@php
    $submissionUrl = isset($submitUrl) ? $submitUrl : route('accounts.account-delete', [$account->id]);
@endphp

<div class="bg-danger-subtle p-4 rounded-4 shadow">
    <div>
        <div>
            <section class="space-y-6">
                <header>
                    <h2 class="poppins-semibold text-lg">
                        {{ __('Delete Account') }}
                    </h2>
            
                    <p class="mt-1 text-sm">
                        {{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Before deleting the account, please download any data or information that you wish to retain.') }}
                    </p>
                </header>
                
                <x-danger-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>
            
                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ $submissionUrl }}" class="p-6">
                        @csrf
                        @method('delete')
            
                        <h2 class="poppins-semibold text-xl">
                            {{ __('Are you sure you want to delete this account?') }}
                        </h2>
            
                        <p class="mt-2 text-sm">
                            {{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this account.') }}
                        </p>
            
                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
            
                            <div class="relative password-input">
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                                    placeholder="{{ __('Password') }}" />
                                <button class="absolute password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                    <i class="bi bi-eye-slash-fill"></i>
                                </button>
                            </div>

                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
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
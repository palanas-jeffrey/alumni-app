<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="/">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    {{ __('Account Details: ') }}
                    {{ $account->first_name }}
                    {{ $account->last_name }}
                </h1>
            </div>
        </div>
    </x-simple-nav>
    <div class="py-12"> 
        @include("accounts.account-details-table")
    </div>
</x-generic-layout>

<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{route('accounts.programs')}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    {{ __('Account Details:') }}
                    {{ $account->first_name }}
                    {{ $account->last_name }}
                </h1>
            </div>
        </div>
    </x-simple-nav>
    
    <div class="py-12"> 
        @include("accounts.account-details-table")

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-4 flex">
                    <div class="mr-6 w-1/3"></div>
                    <div class="flex-1">
                        @include("accounts.delete-account")
                    </div>
                </div>  
            </div>
        </div>
    </div>
</x-generic-layout>

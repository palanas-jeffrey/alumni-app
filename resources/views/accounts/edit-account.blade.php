<x-generic-layout> 
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('accounts.account-details', ['id' => $account->id]) }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Account update
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('accounts.alumnus-edit', ['account_id' => $account->id])
        </div>
    </div>

    @include('shared.toaster')
    @include('shared.js.script-date-picker')
</x-generic-layout>
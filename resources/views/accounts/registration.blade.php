<x-generic-layout> 
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('accounts.programs') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Account registration
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-b-100">
            <div class="bg-white border-1 border-gray-300 rounded-4"> 
                <div class="p-6"> 
                    @livewire('accounts.alumni-registration')
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')

    <script>
        flatpickr(".singleDatePicker", {
            mode: "single",
            dateFormat: "Y-m-d",
        });
    </script>
</x-generic-layout>
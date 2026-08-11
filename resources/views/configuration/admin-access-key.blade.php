<x-generic-layout> 
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{route('configurations')}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Admin access key configuration
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-b-100">
            @livewire('configuration.admin-access-key-config')
        </div>
    </div>

    @include('shared.toaster')
</x-generic-layout>
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
                    Configuration Management
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-b-100">
            <div class="flex">
                <div class="w-1/3">
                    <div class="bg-white border-1 border-gray-300 rounded-4"> 
                        <div class="p-6">
                            @livewire('configuration.batch-list')
                        </div>
                    </div>
                </div>
                <div class="ml-6 flex-grow-1">
                    @livewire('configuration.programs')
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-b-100">
            <div class="flex">
                @if(Auth::guard('admin')->user()->has_main_control)
                    <div class="ml-6">
                        <div class="bg-primary-subtle overflow-hidden rounded-4 shadow-sm">
                            <div class="p-4 relative w-100">
                                <h2 class="font-medium poppins-semibold text-lg">Set admin access key</h2>
                                <p class="mb-3 text-gray-600 text-sm">Set new admin access key.</p>
                                <div class="bottom-0">
                                    <x-link-btn href="{{ route('configuration.admin-key') }}">
                                        <span>Set</span>
                                    </x-link-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('shared.toaster')
</x-generic-layout>
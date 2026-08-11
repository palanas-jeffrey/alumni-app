<x-generic-layout> 
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracer.participation') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                   Tracer completion
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-12 mt-md-5 pb-12">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="font-medium line-height-normal poppins-semibold txt-28">Thank you!</h1>
                    <p class="text-center mb-3 mt-3">We appreciate your participation in our tracer.</p>
                </div>
            </div>
        </div>
    </div>

</x-generic-layout>
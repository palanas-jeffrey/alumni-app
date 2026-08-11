<x-generic-layout>
    <div>
        <x-simple-nav>
            <div class="d-flex">
                <div class="font-semibold leading-tight text-gray-800 text-xl">
                    <a href="{{route('donation')}}">
                        <i class="bi bi-chevron-left"></i>
                        <span>Back</span>
                    </a>
                </div>
            </div>
        </x-simple-nav>
        <main class="min-h-70vh">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-mint-green rounded-4">
                        <div class="p-6 text-gray-900">
                            <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">Thank you!</h1>
                            <p class="mb-3 mt-4 text-center">Your generosity in donating means the world to us, and we deeply appreciate your kindness.</p>
                        </div>
                        <div class="text-center pb-6">
                            <x-link-generic href="/"> Return to home  </x-link-generic> 
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-generic-layout>
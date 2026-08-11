<x-guest-layout>
    <div class="m-auto w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4">
            <h1 class="mb-1 font-medium">You are almost there! </h1>
            <p class="mb-2 text-sm text-gray-600">
                We've received your account request but it's still pending activation. <br>
                If you'd like to get started, simply reach out to our support team and we'll take care of it for you.</p>
            <div class="mt-4 d-flex">
                <x-link-btn href="/"> Return to home </x-link-btn>
    
                <form method="POST" action="{{ route('logout') }}" class="inline-block ml-2">
                    @csrf
    
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-guest-layout>
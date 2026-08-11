<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($uaEvents as $uaEvent)
                <x-event-card :uaEvent="$uaEvent"/>
            @endforeach
        </div>
    </div>
</x-app-layout>


            

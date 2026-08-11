<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tracer Responses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- <div class="mb-3 mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            </div> -->

            @foreach ($groupedResponses as $fieldName => $responses)
                <div class="mb-3 mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900">Question: {{ $fieldName }}</h2> <!-- Display field name -->
                    <p class="mt-1 mb-1 text-sm text-gray-600">Responses:</p>
                    <ul class="response-wrapper">
                        @foreach ($responses as $responseField)
                        <li class="striped">{{ $responseField->value ?? 'No value provided' }}</li> <!-- Display the response value -->
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>

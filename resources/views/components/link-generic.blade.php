@php
    $classes = "text-sm text-gray-600 hover:text-gray-900 rounded-md font-medium inline-flex items-center ml-1 space-x-1 underline underline-offset-4";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

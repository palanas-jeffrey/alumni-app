@php
    $classes = "btn--primary inline-block text-center transition ease-in-out duration-150";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
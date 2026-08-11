<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block btn-option duration-150 ease-in-out p-2 text-sm transition w-100 w-full']) }}>
    {{ $slot }}
</button>
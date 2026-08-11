<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn--danger duration-150 ease-in-out inline-flex transition']) }}>
    {{ $slot }}
</button>

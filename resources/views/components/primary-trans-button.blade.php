<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn--primary-trans inline-block duration-150 ease-in-out transition']) }}>
    {{ $slot }}
</button>
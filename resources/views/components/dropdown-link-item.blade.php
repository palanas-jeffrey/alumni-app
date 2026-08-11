<div class="rounded-md py-1 bg-white">
    <a {{ $attributes->merge(['class' => 'block ease-in-out focus:outline-none leading-5 px-4 py-2 text-[#6365f1] text-sm text-start transition underline underline-offset-4 w-full']) }}
        href="javascript:void(0);">
        {{ $slot }}
    </a>
</div>
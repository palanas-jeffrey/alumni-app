<style>
    .image-fill-text {
        background-image: url("{{ asset('storage/images/alumni.jpg') }}");
    }
</style>

<x-guest-layout>
    <div class="d-flex h-screen">
        <div class="w-50 bg-g-bg bg-g-gr">
            <div class="mt-32 pt-10">
            </div>
            <div>
                <div class="image-fill-text text-center m-auto">
                    <div>ALUMNI</div>
                    <div>connect</div>
                </div>
            </div>
            <div>
                <p class="text-2xl text-center txt-ice">Stay connected.</p>
            </div>
        </div>
        <div class="w-50">
            {{ $slot }}
        </div>
    </div>
</x-guest-layout>

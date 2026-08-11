<style>
    .graduate-bg {
        background-image: 
            linear-gradient(
            to bottom, 
            rgba(173, 216, 230, 0.3) 0%,   /* Light blue tint at the top */
            rgba(12, 35, 64, 0.85) 75%,    /* Deep, dark blue at the bottom for text contrast */
            rgba(12, 35, 64, 1) 100%
            ),
            url('{{ asset('storage/images/alumni.jpg') }}'); 
        background-size: cover;
        background-position: center;
    }
</style>
<x-guest-layout>
    <div class="min-h-screen">
        <nav class="l-shadow">
            <div class="bg-white flex justify-between m-auto max-w-1200 mx-auto p-6 max-h-90 ">
                <div class="flex justify-start">
                    <div class="shrink-0 flex items-center">
                    </div>
                    <div class="min-w-70p ml-4">
                        <h1 class="large-title">ALUMNI connect</h1>
                    </div>
                </div>
                <div>
                    <x-link-btn href="{{ url('/login') }}">Login</x-link-btn>
                </div>
            </div>
        </nav>
        <main>
            <div class="graduate-bg welcome-main">
                <div class="flex flex-col h-100 items-center max-w-1200 mx-auto pb-6 pt-6 sm:justify-center">
                    <div class="w-full">
                        <div class="welcome-img-wrap">
                            <div class="align-items-center flex h-100">
                                <div class="line-height-normal p-5 poppins-semibold text-center txt-36 txt-ice">
                                    <p>"Unite the past, ignite the future—where old friends reconnect and your network grows for tomorrow."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @include('layouts.footer')
</x-guest-layout>

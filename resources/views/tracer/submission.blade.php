
<x-generic-layout>
     <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracerManagement') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Tracer Submissions
                </h1>
            </div>
        </div>
    </x-simple-nav>
    <main>
        @livewire('tracer.submission-date-note')
    </main>
    <script>
        window.addEventListener('schedule-added', event => {
            showToast("Schedule note created!");
        });
        window.addEventListener('schedule-status-updated', event => {
            showToast("Schedule status updated!");
        });        
        window.addEventListener('schedule-updated', event => {
            showToast("Schedule updated!");

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
        window.addEventListener('schedule-deleted', event => {
            showToast("Schedule deleted!");

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    </script>
    @include('shared.toaster')
    @include('shared.js.script-date-picker')
</x-generic-layout>
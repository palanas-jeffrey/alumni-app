<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('tracerManagement') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back to tracer main</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Tracer form
                </h1>
            </div>
        </div>
    </x-simple-nav>

    @include('shared.js.v-bar-chart')

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex mb-4">
                <div class="w-1/3">
                   @livewire('tracer.create-new-tracer-form')
                </div>
                <!-- <div class="w-3/4 ml-6">
                    livewire('tracer.published-tracer')
                </div> -->
            </div>
        </div>

        <!-- <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">
            <div>
                livewire('tracer.tracer-study-table')
            </div>
        </div> -->

        <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">
            <div>
                @livewire('survey.survey-form-table')
            </div>
        </div>
    </div>

    @include('shared.toaster')

    @include('shared.js.script-publish-unpublish-form')

    <script>
        function reloadPage() {
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    </script>
</x-generic-layout>    
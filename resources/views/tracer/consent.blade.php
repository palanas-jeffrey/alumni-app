<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{route('tracer.participation')}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back to main</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Data privacy
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 tracer-mgmt">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="bg-white border-1 border-gray-300 flex-wrap p-6 rounded-4">
                    <div>
                        <div>
                            <h2 class="font-medium poppins-semibold text-lg">Data privacy consent</h2>
                            <p class="mt-3">This survey would take at most ten (10) minutes of your time.  Rest assured, your identity and all the information you have provided will be handled in accordance with the RA 10173 (Data Privacy Act of 2012).</p>
                        </div>
                        <form action="{{route('tracer.process-consent')}}" method="POST">
                            @csrf
                            <p class="mt-4">By clicking "I Agree" and proceeding with this online form, you are giving us consent to collect your data.</p>
                            <div class="mt-2">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 shadow-sm" name="agree">
                                    <span class="ms-2 text-sm text-gray-600">Agree</span>
                                </label>
                                
                                @if ($errors->has('agree'))
                                    <div class="text-red-500 text-sm mt-2">
                                        {{ $errors->first('agree') }}
                                    </div>
                                @endif

                            </div>
                            <div class="mt-5">
                                <x-primary-button type="submit">
                                    <div class="relative">
                                        <span class="btn-text">Agree and participate</span>
                                        <div class="dots-loader absolute v-hidden">
                                            <span></span><span></span><span></span>
                                        </div>
                                    </div>
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-generic-layout>


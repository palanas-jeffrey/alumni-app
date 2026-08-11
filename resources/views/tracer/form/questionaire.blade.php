@php
    $currentUrl = url()->current();
    $previousUrl = url()->previous();
    $redirectUrl = $previousUrl !=  $currentUrl ? $previousUrl : (isset($returnUrl) ? $returnUrl : "/");
@endphp

<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{$redirectUrl}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Questionaire
                </h1>
            </div>
        </div>
    </x-simple-nav>
    <div>
        <div class="q-form">

            <form id="tracer-form" action="">
                <div class="q-container">
                    @admin
                        @if (isset($user))
                            <!-- allow admin to see alumni details -->
                            <div>
                                <p class="txt-18 block text-sm mb-3">
                                    <span>Name:</span>
                                    <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                </p>
                            </div>
                            <div>
                                <p class="txt-18 block text-sm mb-3">
                                    <span>Program:</span>
                                    <strong>{{ $program->program_abbreviation }}</strong>
                                </p>
                            </div>
                        @endif

                        @if (!isset($user))
                            @livewire('tracer.clone-form', ['form_id' => $form->id])
                        @endif
                    @endadmin

                    <div>
                        <h1 class="font-bold mb-2 text-2xl">Tracer study</h1>
                    </div>
                    <div class="pb-4">
                        <p><span>Version:</span> {{ $form->title }}</p>
                    </div>

                    @user
                        <div>
                            <p class="mt-2 text-sm">
                                Fields marked with an asterisk (*) are required.
                            </p>
                        </div>
                    @enduser

                    <div>
                        @livewire('tracer.components.section', 
                            ['form_id' => $form->id])
                    </div>
    
                    @user
                        <!-- allow editing for alumni only -->
                        <div class="pt-10 js-cta-container">
                            <x-primary-button id="responseSubmit" type="button">Submit response</x-primary-button>
                            <x-primary-button id="responseEdit" type="button" class="d-none">Edit response</x-primary-button>
                        </div>
                    @enduser
                </div>
            </form>
        </div>
    </div>

    @user
        <!-- allow editing for alumni only -->
        @include('shared.js.script-tracer-response-submit-handler', ['isResponseUpdate' => $isResponseUpdate ?? false, 'form_id' => $form->id])
    @enduser

    @include('shared.toaster')

    @if (isset($isViewResponse))
        <!-- fill the form with alumni response -->
        @include('shared.js.script-tracer-response-view-handler')
    @endif
</x-generic-layout>

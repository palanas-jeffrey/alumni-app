<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts overview') }}
        </h2>
    </x-slot>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-b-100">
            <div class="flex">
                <section class="bg-dust-gray mb-6 mr-6 p-4 rounded-4 space-y-6 w-3/4">
                    <div>
                        <h2 class="poppins-semibold text-lg">Register a new account</h2>
                        <p class="mt-1 mb-1 text-sm text-gray-600">Register a graduate by entering their details.</p>
                        <div class="flex gap-4 items-center mt-4">
                            <x-link-btn href="{{ route('account.registration') }}">Register</x-link-btn>
                        </div>
                    </div>
                </section>
                <section class="bg-primary-subtle flex-grow-1 mb-6 p-4 rounded-4 space-y-6">
                    <div>
                        <h2 class="poppins-semibold text-lg">Admin accounts</h2>
                        <p class="mt-1 mb-1 text-sm text-gray-600">View administrator accounts</p>
                        <div class="flex gap-4 items-center mt-4">
                            <x-link-btn href="{{ route('accounts.administrators') }}"> View </x-link-btn>
                        </div>
                    </div>
                </section>
            </div>
            <div class="bg-white border-1 border-gray-300 rounded-4"> 
                <div class="pl-6 pr-6 pt-6">
                    <h2 class="poppins-semibold text-lg">Alumni accounts</h2>
                    <p class="mt-1 mb-1 text-sm text-gray-600">Alumni accounts are listed below, organized by academic program.</p>
                </div>
                <div class="p-6"> 
                    @if($programs)
                        @php
                            $triggerCounter=0;
                            $tabpaneCounter=0;
                        @endphp
                        <ul class="nav nav-tabs" id="myTab" role="tablist"> 
                            @foreach($programs as $program) 
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-uppercase {{$triggerCounter == 0 ? 'active' : ''}}" id="home-tab" data-bs-toggle="tab" 
                                        data-bs-target="#tab-pane-{{$triggerCounter}}" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">{{$program->program_abbreviation}}</button>
                                </li>
                                @php
                                    $triggerCounter++;
                                @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            @foreach($programs as $program)
                                <div class="tab-pane fade {{$tabpaneCounter == 0 ? 'show active' : ''}}"  
                                    id="tab-pane-{{$tabpaneCounter}}" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    @livewire('admin.accounts-per-program', ['program_id'=>$program->id])
                                </div>                            
                                @php
                                    $tabpaneCounter++;
                                @endphp
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')

    <script>
        @if(session('success-account-delete'))
            showToast("Account deleted successfully!");
        @endif
    </script>

</x-app-layout>
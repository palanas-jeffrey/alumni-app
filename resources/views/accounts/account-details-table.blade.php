@php
    $profilePhoto = $account->profilePhoto ? $account->profilePhoto->photo_path : null;
@endphp


<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-center">
        <div class="mr-6 w-1/3">
            <div>
                <div class="bg-dust-gray mb-4 overflow-hidden profile-img-container relative rounded-3">
                    @if($profilePhoto)
                        <div class="h-full w-full bg-cover bg-cover bg-center" style="background-image: url('{{ asset('public/storage/' . $profilePhoto) }}');"></div>
                    @else
                        <div class="poppins-semibold tmp-holder">
                            <div>{{substr($account->first_name, 0, 1)}}</div>
                        </div>
                    @endif
                </div>
            </div>

            @admin
                <div>
                    <div class="rounded-4 mt-1">
                        <div class="mb-3">
                            <h2 class="poppins-semibold text-lg">Edit account</h2>
                        </div>
                        <div>
                            <x-link-btn href="{{ route('account.alumni-edit', ['account_id' => $account->id]) }}">Edit</x-link-btn>
                        </div>
                    </div>
                </div>
            @endadmin

        </div>
        <div class="flex-grow-1 style-container">
            <div class="styled-container-head style-container-row"> 
                <h2 class="text-lg font-medium text-gray-900">
                    Profile Information
                </h2>
            </div>
            <div>

                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>First name</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->first_name}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Last name</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->last_name}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Middle name</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->middle_name}} </span>
                    </div>
                </div>

                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Maiden name</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->maiden_name}} </span>
                    </div>
                </div>

                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Alumni ID</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->alumni_id}} </span>
                    </div>
                </div>
                    
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Email</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->email}} </span>
                    </div>
                </div>
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Mobile</span>
                    </div>
                    <div>
                        <span class="txt-darker">+63{{$account->mobile_number}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Date of Birth</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->date_of_birth}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Gender</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->gender}} </span>
                    </div>
                </div>
                

                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Program Taken</span>
                    </div>
                    <div>
                        <span class="txt-darker">
                            @if($account->programTaken)
                                {{$account->programTaken->program_name}}
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Batch year</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->batch_year}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Civil Status</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->civil_status}} </span>
                    </div>
                </div>

                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Permanent Address</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->permanent_address}} </span>
                    </div>
                </div>
                
                <div class="style-container-row common-bottom-border">
                    <div>
                        <span>Current Address</span>
                    </div>
                    <div>
                        <span class="txt-darker">{{$account->current_address}} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
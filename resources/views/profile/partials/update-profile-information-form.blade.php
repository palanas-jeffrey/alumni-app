<section>
    <header>
        <h2 class="text-lg font-medium poppins-semibold">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="update-profile" method="post" action="{{ route('profile.update') }}" class="flex flex-wrap mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="w-50">
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div class="w-50">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        @user
            <div class="w-50">
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" required autofocus autocomplete="middle_name" />
                <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
            </div>
     
            <div class="w-50">
                <x-input-label for="maiden_name" :value="__('Maiden Name (last name & first name)')" />
                <x-text-input id="maiden_name" name="maiden_name" type="text" class="mt-1 block w-full" :value="old('maiden_name', $user->maiden_name)" autofocus autocomplete="maiden_name" />
                <x-input-error class="mt-2" :messages="$errors->get('maiden_name')" />
            </div>
        @enduser

        <div class="w-50">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', $user->email)" required autofocus autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        @user

            <div class="w-50">
                <x-input-label for="alumni_id" :value="__('Alumni ID')" />
                <x-text-input id="alumni_id" name="alumni_id" type="text" class="mt-1 block w-full" :value="$user->alumni_id" readonly/>
            </div>

            <div class="w-50">
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->date_of_birth)" required autofocus autocomplete="date_of_birth" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>

            <div class="w-50 mb-4">
                <x-input-label for="gender" :value="__('Gender')" />
                <x-select id="gender" name="gender" class="mt-1 block w-full" :options="['male' => 'Male', 'female' => 'Female']" :selected="$user->gender" :value="old('gender', $user->gender)"  required autofocus class="def-focus" />
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div> 
       
            <div class="w-50">
                <x-input-label for="program_taken" :value="__('Program Taken')" />
                <x-select 
                    id="program" 
                    name="program_id" 
                    :options="collect($programs)->mapWithKeys(fn($program) => [$program['id'] => $program['program_name']])->toArray()" 
                    :selected="old('program_taken', $user->programTaken->id)" 
                    required 
                    autofocus 
                    class="def-focus" 
                />
                <x-input-error :messages="$errors->get('program_taken')" class="mt-2" />
            </div> 

            <div class="w-50">
                <x-input-label for="batch_year" :value="__('Batch year')" />
                <x-text-input id="batch_year" name="batch_year" type="text" class="mt-1 block w-full" :value="old('batch_year', $user->batch_year)" readonly/>
                <x-input-error :messages="$errors->get('batch_year')" class="mt-2" />
            </div>

            <div class="w-50 mb-4">
                <x-input-label for="civil_status" :value="__('Civil Status')" />
                <x-select id="civil_status" name="civil_status" :options="['single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed', 'seperated' => 'Seperated']" 
                    :selected="$user->civil_status" :value="old('civil_status', $user->civil_status)" />
                <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
            </div> 
        
            <div class="w-50">
                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                <x-text-input id="permanent_address" name="permanent_address" type="text" class="mt-1 block w-full" :value="old('permanent_address', $user->permanent_address)" required autofocus autocomplete="permanent_address" />
                <x-input-error class="mt-2" :messages="$errors->get('permanent_address')" />
            </div>

            <div class="w-50">
                <x-input-label for="current_address" :value="__('Current Address')" />
                <x-text-input id="current_address" name="current_address" type="text" class="mt-1 block w-full" :value="old('current_address', $user->current_address)" required autofocus autocomplete="current_address" />
                <x-input-error class="mt-2" :messages="$errors->get('current_address')" />
            </div>
        
            <!-- Mobile number -->
            <div class="w-50 mb-4">
                <x-input-label for="mobile_number" :value="__('Mobile')" />
                
                <div class="d-flex mobile-input-group">
                    <x-text-input class="mt-1 w-55px" value="+63" disabled/>
                    <x-text-input id="mobile_number" class="mt-1 w-full"
                        type="text" name="mobile_number" :value="old('mobile_number', $user->mobile_number)" />
                </div>
    
                <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
            </div>
        @enduser

        <div class="w-100">
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save changes') }}</x-primary-button>
    
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
    </form>

    @if (session('status') === 'profile-updated')
        <script>
            showToast('Profile updated successfully!'); 
        </script> 
    @endif
 
    @if (session('error'))
         <script>
            showToast("{{ session('error') }}", false); 
        </script> 
    @endif


</section>

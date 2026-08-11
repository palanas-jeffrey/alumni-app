<x-guest-layout>
    <div class="register-container max-w-1000 w-full mt-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf
    
            <div class="d-flex flex-wrap justify-between">           
                <div class="width-half mb-4">
                    <x-input-label for="last_name" :value="__('Last name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
                
                <div class="width-half mb-4">
                    <x-input-label for="first_name" :value="__('First name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="width-half mb-4">
                    <x-input-label for="middle_name" :value="__('Middle name')" />
                    <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" required autofocus autocomplete="middle_name" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>
            
                <div class="width-half mb-4">
                    <x-input-label for="maiden_name" :value="__('Maiden Name')" />
                    <x-text-input id="maiden_name" class="block mt-1 w-full" type="text" name="maiden_name" :value="old('maiden_name')"  autofocus autocomplete="maiden_name" />
                    <x-input-error :messages="$errors->get('maiden_name')" class="mt-2" />
                </div>

                <div class="width-half mb-4">
                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                    <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required autofocus autocomplete="date_of_birth" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>

                <div class="width-half mb-4">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <x-select id="gender" name="gender" :options="['male' => 'Male', 'female' => 'Female']" :selected="'male'" :value="old('gender')"  required autofocus class="def-focus" />
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div> 

                <div class="width-half mb-4">
                    <x-input-label for="program_taken" :value="__('Program Taken')" />
                    <x-select 
                        id="program" 
                        name="program_id" 
                        :options="collect($programs)->mapWithKeys(fn($program) => [$program['id'] => $program['program_name']])->toArray()" 
                        :selected="old('program_taken')" 
                        required 
                        autofocus 
                        class="def-focus" 
                    />
                    <x-input-error :messages="$errors->get('program_taken')" class="mt-2" />
                </div>

                <div class="width-half mb-4">
                    <x-input-label for="civil_status" :value="__('Civil Status')" />
                    <x-select id="civil_status" name="civil_status" :options="['single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed', 'seperated' => 'Seperated']" :selected="'single'" :value="old('civil_status')"  required autofocus class="def-focus" />
                    <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
                </div> 

                <!-- Permanent Address -->
                <div class="w-full mb-4">
                    <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                    <x-text-input id="permanent_address" class="block mt-1 w-full" type="text" name="permanent_address" :value="old('permanent_address')" required autocomplete="permanent_address" />
                    <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
                </div>

                <!-- Current Address -->
                <div class="w-full mb-4">
                    <x-input-label for="current_address" :value="__('Current Address')" />
                    <x-text-input id="current_address" class="block mt-1 w-full" type="text" name="current_address" :value="old('current_address')" required autocomplete="current_address" />
                    <x-input-error :messages="$errors->get('current_address')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="width-half mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mobile number -->
                <div class="width-half mb-4">
                    <x-input-label for="mobile_number" :value="__('Mobile')" />
                    
                    <div class="d-flex mobile-input-group">
                        <x-text-input class="mt-1 w-55px" value="+63" disabled/>
                        <x-text-input id="mobile_number" class="mt-1 w-full"
                                        type="text"
                                        name="mobile_number" required/>
                    </div>
        
                    <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="width-half mb-4">
                    <x-input-label for="password" :value="__('Password')" />
        
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="width-half mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="w-full line-height-14 mt-2">
                    <input name="confirm" type="checkbox">
                    <label for="" class="font-medium text-sm text-gray-700 ml-1">
                        I confirm that the above information is true and correct.
                    </label>
                </div>

                <div class="w-full line-height-14 mt-2">
                    <input name="agree" type="checkbox">
                    <label for="" class="font-medium text-sm text-gray-700 ml-1">
                        I agree to be contacted for alumni-related activities and surveys.
                    </label>
                </div>
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 " href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
    
                <x-primary-button id="registration-submit" class="ms-4" disabled>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        let checkboxAgree = document.querySelector("input[name=agree]");
        let checkboxConfirm = document.querySelector("input[name=confirm]");

        function listenChange(elem) {
            elem.addEventListener("change", function () {
                const btn = document.querySelector("#registration-submit");
                console.log('hi');
                if (checkboxAgree.checked && checkboxConfirm.checked) {
                    btn.removeAttribute("disabled");
                } else {
                    btn.setAttribute("disabled", true);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            listenChange(checkboxAgree);
            listenChange(checkboxConfirm);
        });
    </script>
</x-guest-layout>

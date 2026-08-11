<div> 
    <div class="bg-white border-1 border-gray-300 rounded-4"> 
        <div class="p-6">
            <div>
                <h2 class="text-lg font-medium poppins-semibold">
                    Update account
                </h2>

                <p class="mb-2 mt-1 text-sm">
                    Ensure all fields are filled out accurately and reflect current information.
                </p>
            </div>

            <form wire:submit.prevent="submit">
            
                <div class="d-flex flex-wrap justify-between">           
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="last_name" :value="__('Last name')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" 
                            wire:model.lazy="last_name" autocomplete="last_name" />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>
                    
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="first_name" :value="__('First name')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" 
                            wire:model.lazy="first_name" required autofocus autocomplete="first_name" />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>
            
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="middle_name" :value="__('Middle name')" />
                        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" 
                            wire:model.lazy="middle_name" required autofocus autocomplete="middle_name" />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                    </div>
                
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="maiden_name" :value="__('Maiden Name (last name & first name)')" />
                        <x-text-input id="maiden_name" class="block mt-1 w-full" type="text" name="maiden_name" 
                            wire:model.lazy="maiden_name"  autofocus autocomplete="maiden_name" />
                        <x-input-error :messages="$errors->get('maiden_name')" class="mt-2" />
                    </div>
            
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                        <x-input-date id="date_of_birth" class="block mt-1 w-full" type="text" class="singleDatePicker" 
                            name="date_of_birth" wire:model.lazy="date_of_birth" required autofocus autocomplete="date_of_birth"/>
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                    </div>
            
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <x-select id="gender" name="gender" 
                            :options="['male' => 'Male', 'female' => 'Female']" 
                            :selected="old('gender')" wire:model.lazy="gender"
                            :hasBlank=true
                            required autofocus />
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div> 
            
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="program_taken" :value="__('Program Taken')" />
                        <x-select 
                            id="program_taken" 
                            name="program_id" 
                            :options="collect($programs)->mapWithKeys(fn($program) => [$program['id'] => $program['program_name']])->toArray()" 
                            :selected="old('program_id')" 
                            :hasBlank=true
                            wire:model.lazy="program_id"
                            required 
                            autofocus />
                        <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
                    </div>
        
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="batch_year" :value="__('Batch year')" />
                        <x-select id="batch_year" name="batch_year" 
                            :options="collect($batch_years)->mapWithKeys(fn($batch_year) => [$batch_year => $batch_year])->toArray()" 
                            :selected="old('batch_year')" wire:model.lazy="batch_year"  
                            :hasBlank=true
                            required autofocus />
                        <x-input-error :messages="$errors->get('batch_year')" class="mt-2" />
                    </div>
        
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="alumni_id" :value="__('Alumni ID')" />
                        <x-text-input id="alumni_id" class="block mt-1 w-full" type="text" name="alumni_id" 
                            wire:model.lazy="alumni_id" required autocomplete="alumni_id" readonly/>
                        <x-input-error :messages="$errors->get('alumni_id')" class="mt-2" />
                    </div>
            
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="civil_status" :value="__('Civil Status')" />
                        <x-select id="civil_status" name="civil_status" 
                            :options="['single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed', 'seperated' => 'Seperated']" 
                            :selected="old('civil_status')" wire:model.lazy="civil_status"  
                            :hasBlank=true
                            required autofocus />
                        <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
                    </div>
            
                    <!-- Email Address -->
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                            wire:model.lazy="email" autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    <!-- Mobile number -->
                    <div class="mb-2 p-2 w-1/3">
                        <x-input-label for="mobile_number" :value="__('Mobile')" />
                        
                        <div class="d-flex mobile-input-group">
                            <x-text-input class="mt-1 w-55px" value="+63" disabled/>
                            <x-text-input id="mobile_number" class="mt-1 w-full"
                                wire:model.lazy="mobile_number"
                                type="text" name="mobile_number"/>
                        </div>
            
                        <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
                    </div>
                </div>
        
                <div class="d-flex flex-wrap justify-between">
                    <!-- Permanent Address -->
                    <div class="mb-2 p-2 w-50">
                        <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                        <x-text-input id="permanent_address" class="block mt-1 w-full" type="text" name="permanent_address" 
                            wire:model.lazy="permanent_address" required autocomplete="permanent_address" />
                        <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
                    </div>
            
                    <!-- Current Address -->
                    <div class="mb-2 p-2 w-50">
                        <x-input-label for="current_address" :value="__('Current Address')" />
                        <x-text-input id="current_address" class="block mt-1 w-full" type="text" name="current_address" 
                            wire:model.lazy="current_address" required autocomplete="current_address" />
                        <x-input-error :messages="$errors->get('current_address')" class="mt-2" />
                    </div>
                </div>
        
                <div class="flex items-center mt-4">
                    <x-primary-button type="submit">
                        <div class="relative">
                            <span class="btn-text">Update details</span>
                            <div class="dots-loader absolute v-hidden">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-primary-subtle p-4 rounded-4 mt-6">
        <div>
            <h2 class="text-lg font-medium poppins-semibold">
                Update Password
            </h2>

            <p class="mb-2 mt-1 text-sm">
                Ensure the account is using a long, random password to stay secure.
            </p>
        </div>
        <div>
            <form class="form-password" wire:submit.prevent="submitPassword">
                <div>
                    <div>
                         <!-- Password -->
                        <div class="mb-2 p-2 w-1/3">
                            <x-input-label for="password" :value="__('Password')" />
                
                            <div class="relative password-input">
                                <x-text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                wire:model.lazy="password"
                                                required autocomplete="new-password" />
                                    
                                <button class="absolute password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                    <i class="bi bi-eye-slash-fill"></i>
                                </button>
                            </div>
                
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                
                        <!-- Confirm Password -->
                        <div class="mb-2 p-2 w-1/3">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                
                            <div class="relative password-input">
                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation"
                                                wire:model.lazy="password_confirmation" required autocomplete="new-password" />

                                <button class="absolute password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                    <i class="bi bi-eye-slash-fill"></i>
                                </button>
                            </div>
                
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <x-primary-button type="submit">
                        <div class="relative">
                            <span class="btn-text">Update password</span>
                            <div class="dots-loader absolute v-hidden">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function resetPasswordForm() {
            let form = document.querySelector(".form-password"),
                inputs = form.querySelectorAll("input");

            inputs.forEach(function(input) {
                input.value = "";
            });
        }

        window.addEventListener('account-updated', function () {
            showToast("Account updated successfully!");
        });

        window.addEventListener('password-updated', function () {
            showToast("Password updated successfully!");
            resetPasswordForm();
        });
    </script>
</div>

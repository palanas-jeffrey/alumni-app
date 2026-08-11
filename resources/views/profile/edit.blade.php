<x-app-layout>
    @include('shared.toaster')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="w-1/3">
                <div class="p-4 sm:p-8 sm:rounded-lg txt-center">
                    <div>
                        @include('profile.partials.update-photo')
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-dust-gray p-4 rounded-4 shadow">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
    
                <div class="bg-primary-subtle p-4 rounded-4 shadow">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
    
                @admin
                    <div class="bg-danger-subtle p-4 rounded-4 shadow">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                @endadmin
            </div>
        </div>
    </div>
 
</x-app-layout>

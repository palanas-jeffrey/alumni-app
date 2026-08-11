

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('User accounts') }}
                            </h2>

                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                {{ __("Below is the list of all User accounts.") }}
                            </p>
                        </header>
                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->index }}</th>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>
                                                @if($user->role || strtolower($user->role->name) == 'admin')
                                                    <span>admin</span>
                                                @else
                                                    <span>alumni</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->accountActivation && $user->accountActivation->is_activated)
                                                    <span>activated</span>
                                                @elseif($user->accountActivation && !$user->accountActivation->is_activated)
                                                    <span>pending</span>
                                                @else
                                                    <span>no record</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Account Settings Dropdown -->
                                                @if(strtolower($user->role->name) != 'admin')
                                                    <div class="sm:flex sm:items-center">
                                                        <div class="sm:flex sm:items-center">
                                                            <div class="relative" x-data="{ open: false }" 
                                                                @click.outside="open = false" @close.stop="open = false">
                                                                <div @click="open = ! open">
                                                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                                        <div> Settings </div>
                                                                        <div class="ms-1">
                                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                        </div>
                                                                    </button>
                                                                </div>

                                                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                                                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                                                                    x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg ltr:origin-top-right rtl:origin-top-left end-0"
                                                                    @click="open = false" style="display: none;">
                                                                    <div class="rounded-md py-1 bg-white">
                                                                        <a data-action="activate-account" class="modal-trigger block ease-in-out focus:outline-none leading-5 px-4 py-2 text-[#6365f1] text-sm text-start transition underline underline-offset-4 w-full" 
                                                                            href="javascript:void(0);"
                                                                            data-ctaUrl="{{ route('account.activate-user', $user->id) }}">Activate</a>
                                                                    </div>
                                                                    @if(strtolower($user->role->name) != 'admin')
                                                                        <div class="rounded-md py-1 bg-white">
                                                                            <a data-action="grant-admin-access" class="modal-trigger block ease-in-out focus:outline-none leading-5 px-4 py-2 text-[#6365f1] text-sm text-start transition underline underline-offset-4 w-full" 
                                                                                href="javascript:void(0);"
                                                                                data-ctaUrl="{{ route('account.grant-admin-access', $user->id) }}">Grant admin access</a>
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @include('shared.toaster')
</x-app-layout>

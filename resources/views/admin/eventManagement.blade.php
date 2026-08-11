@php
    $scheduleDates = "";
@endphp

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Management') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white">
                <div class="p-6 text-gray-900">
                    <section class="space-y-6 mb-6">
                        <div>
                            <h2 class="poppins-semibold text-lg">
                                {{ __('Create a new event') }}
                            </h2>

                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                {{ __("Add the new event's information.") }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button type="button" id="createEventButton"
                                data-bs-toggle="modal" data-bs-target="#eventCreationModal">{{ __('Add event') }}</x-primary-button>
                        </div>

                    </section>

                    <section>
                        <div class="upcoming-event events-main pt-6 border-t">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upcoming-events" data-bs-toggle="tab" 
                                        data-bs-target="#upcoming-events-pane" type="button" role="tab" 
                                        aria-controls="upcoming-events-pane" aria-selected="false">
                                        <span class="poppins-semibold text-xl">
                                            Upcoming events
                                        </span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="previous-events" data-bs-toggle="tab" 
                                        data-bs-target="#previous-events-pane" type="button" role="tab" 
                                        aria-controls="previous-events-pane" aria-selected="false">
                                        <span class="poppins-semibold text-xl">
                                            Previous events
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div>
                             <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="upcoming-events-pane" role="tabpanel" 
                                    aria-labelledby="upcoming-events" tabindex="0">
                                    @livewire('events.upcoming-events')
                                </div>
                                <div class="tab-pane fade" id="previous-events-pane" role="tabpanel" 
                                    aria-labelledby="previous-events" tabindex="0">
                                    @livewire('events.previous-events')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- event creation modal -->
    <div class="modal fade" id="eventCreationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="save-event-form" method="POST" action="{{ route('event.save') }}">
                    <div class="modal-header">
                        <h2 class="modal-title poppins-semibold text-xl" id="eventCreationModal">
                            {{ __('Create a new event') }}
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-4 space-y-6">
                            <div>
                                <x-input-label for="event_name" :value="__('Event name')" />
                                <x-text-input id="event_name" name="event_name" type="text" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('event_name')" />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-textarea-box name="description" id="description" rows="4" placeholder="Write your description here"></x-textarea-box>
                            </div>
                            <div>
                                <x-input-label for="multiDatePicker" :value="__('Event date')" />
                                <x-input-date  class="w-100" type="text" id="multiDatePicker" name="selected_dates[]" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="start_time" :value="__('Start time')" />
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>
                           
                            <div>
                                <x-input-label for="venue" :value="__('Venue')" />
                                <x-text-input id="venue" name="venue" type="text" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('venue')" />
                            </div>
                            <div>
                                <x-input-label for="photo" :value="__('Photo')" />
                                <div class="mb-1">
                                    <span class="txt-12">Accepted formats: JPG, JPEG, PNG, GIF. Maximum file size: 2MB.</span>
                                </div>
                                <input id="photo" name="photo" type="file" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex items-center gap-4">
                            <x-primary-button id="saveEventBtn" type="submit" >
                                <div class="relative">
                                    <span class="btn-text">Add event</span>
                                    <div class="dots-loader absolute v-hidden">
                                        <span></span><span></span><span></span>
                                    </div>
                                </div>
                            </x-primary-button>
                        </div>
                        <div>
                            <x-link-generic href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel">
                                <span>Cancel</span>    
                            </x-link-generic>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.js.script-date-picker')
    @include('shared.toaster')

    <script>
        window.addEventListener('event-email-notification-sent', function () {
            showToast('Email notification dispatched successfully.');
        });

        window.addEventListener('event-email-notification-failed', function () {
            showToast('Oops! We encountered an issue sending some emails. Please try again.');
        });

        window.addEventListener('event-email-notification-process-end', function () {
            showToast('All notification emails have been processed.');
            
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    </script>

    @include('admin.eventEditExtras',
    [
        'route' => route('event.save'),
        'redirectRoute' => null
    ])
</x-app-layout>

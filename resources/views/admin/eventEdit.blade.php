

<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{route('eventManagement')}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Edit event
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <form id="save-event-form" method="POST" action="{{ route('save-alumni-event') }}">
                            <div>
                                <div class="flex mt-6 event-card pt-6 f-direction-m">
                                    <div class="test-box date-wrap">
                                        <div>
                                            <div class="font-semibold text-xl text-gray-800 leading-tight">
                                                <x-input-label for="multiDatePicker" :value="__('Event date')" />
                                                <x-input-date  class="w-100" type="text" id="multiDatePicker" name="selected_dates[]" value="{{$eventDatesStr}}" required autofocus />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="img-wrap">
                                        @if ($uaEvent->photo)
                                            @if ($uaEvent->photo->photo_path) {{-- Ensure the photo field is not null --}}
                                                <div>
                                                    <div class="event-img imagePreview" 
                                                        style="background-image: url('{{ asset('public/storage/' . $uaEvent->photo->photo_path) }}"></div>
                                                </div>
                                            @endif
                                        @else
                                            <div>
                                                <div class="event-img imagePreview">
                                                    <div class="txt-no-photo">Upload photo</div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mb-3 pt-2 edit-photo-wrapper">
                                            <x-input-label for="photo" :value="__('Photo')" />
                                            <div class="mb-1">
                                                <span class="txt-12">Accepted formats: JPG, JPEG, PNG, GIF. Maximum file size: 2MB.</span>
                                            </div>
                                            <input id="photo" name="photo" type="file" />
                                        </div>
                                    </div>
                                    <div class="info-wrap">
                                        <div class="fmb-1 font-medium event-heading">
                                            <div class="mb-3">
                                                <x-input-label for="event_name" :value="__('Event name')" />
                                                <x-text-input id="event_name" name="event_name" type="text" class="mt-1 block w-full" value="{{$uaEvent->event_name}}" required autofocus />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <x-input-label for="Description" :value="__('Description')" />
                                            <textarea
                                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                                                name="description"
                                                id="description"
                                                rows="4"
                                                placeholder="Write your description here">{{ old('description', $uaEvent->description) }}</textarea>
                                        </div>
                                        <div class="mt-4">
                                            <div class="mb-3">
                                                <x-input-label for="start_time" :value="__('Start time')" />
                                                <x-text-input
                                                    value="{{ date('H:i', strtotime($uaEvent->start_time)) }}"
                                                    id="start_time" name="start_time" type="time" class="mt-1 block w-full" required autofocus />
                                            </div>
                                            <!-- <div class="mb-3">
                                                <x-input-label for="duration" :value="'Duration'" />
                                                <x-text-input value="$uaEvent->duration"
                                                    id="duration" name="duration" type="number" min=1 class="mt-1 block w-full" required autofocus />
                                            </div> -->
                                            <div class="mb-3">
                                                <x-input-label for="venue" :value="__('Venue')" />
                                                <x-text-input value="{{$uaEvent->venue}}"
                                                    id="venue" name="venue" type="text" class="mt-1 block w-full" required autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit" id="saveEventBtn">{{ __('Update event') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared.js.script-date-picker')
    @include('shared.toaster')

    @include('admin.eventEditExtras', 
    [
        'route' => route('event.update', ['id' => $uaEvent->id]),
        'redirectRoute' => route('eventManagement')
    ])

    <script>
          document.getElementById('photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.querySelector('.imagePreview');
            const placeholder = document.querySelector(".txt-no-photo");

            if (file) {
                // Create a temporary URL for the file
                const objectURL = URL.createObjectURL(file);

                // Set the preview image's src and display it
                //preview.src = "url(" + objectURL + ")";
                preview.style.backgroundImage = "url(" + objectURL + ")";
                preview.style.display = 'block';
                placeholder.style.display = "none";

                // Release the objectURL when done (optional cleanup)
                preview.onload = () => URL.revokeObjectURL(objectURL);
            }
        });
    </script>

</x-generic-layout>

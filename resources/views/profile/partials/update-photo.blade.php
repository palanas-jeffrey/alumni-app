<section>
    <div class="flex justify-center">
        <div class="text-center">
            <div class="txt-center">
                <div class="flex justify-center">
                
                    <div class="bg-dust-gray mb-4 overflow-hidden profile-img-container relative rounded-3">
                        <div class="poppins-semibold tmp-holder">
                            
                            @if($profilePhoto)
                                <div class="h-full w-full bg-cover bg-cover bg-center" style="background-image: url('{{ asset('public/storage/' . $profilePhoto) }}');"></div>
                            @else
                            <div>
                                {{substr($user->first_name, 0, 1)}}
                            </div>
                            @endIf
        
                        </div>
                        <div class="absolute hidden bottom-0 w-full btn-wrapper">
                            <button class="p-4 txt-28 w-full" type="button" id="addQuestion" data-bs-toggle="modal" data-bs-target="#update-photo-modal">
                                <i class="bi bi-camera"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <h2 class="mt-2 poppins-semibold text-gray-900 text-xl">
                    Welcome, {{ $user->first_name }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    To make the most out of your online experience, it's essential to manage your information and passwords effectively.
                </p>
            </div>
        </div>
    </div>

      <!-- form creation modal -->
    <div class="modal fade" id="update-photo-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h2 class="font-medium modal-title poppins-semibold text-lg" id="update-photo-modal">
                        {{ __('Update profile photo') }}
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="space-y-6">
                        <div>
                            <div class="d-flex photo-upload rounded-4">
                                <div id="imagePreview" class="hidden h-full w-full bg-cover bg-cover bg-center"></div>
                                <div class="txt-24 txt-no-photo">Upload photo</div>
                            </div>
                        </div>
                        
                        <form method="POST" id="upload-img-form" action="{{ $uploadRoute }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            
                            <div>
                                <x-input-label for="photo" :value="__('Photo')" />
                                <div class="mb-1">
                                    <span class="txt-12">Accepted formats: JPG, JPEG, PNG, GIF. Maximum file size: 2MB.</span>
                                </div>
                                <x-text-input 
                                    id="photo" 
                                    name="photo" 
                                    type="file" 
                                    class="mt-1 block w-full c-upload" 
                                    accept="image/*" 
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>
                                    {{ __('Save') }}
                                </x-primary-button>

                                @if (session('status') === 'profile-photo-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >
                                        {{ __('Saved.') }}
                                    </p>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const placeholder = document.querySelector(".txt-no-photo");

        if (file) {
            const objectURL = URL.createObjectURL(file);

            preview.style.backgroundImage = "url(" + objectURL + ")";
            preview.style.display = 'block';
            placeholder.style.display = "none";

            preview.onload = () => URL.revokeObjectURL(objectURL);
        }
    });

    const uploadImgForm = document.getElementById('upload-img-form');

    uploadImgForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData();
        const photoInput = document.getElementById('photo');
        formData.append('photo', photoInput.files[0]);

        try {
            const response = await fetch("{{$uploadRoute}}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });

            if (response.ok) {
                const result = await response.json();
                window.location.reload();
            } else {
                console.error('Upload failed:', response);
                alert('Photo upload failed.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred.');
        }
    });
</script>

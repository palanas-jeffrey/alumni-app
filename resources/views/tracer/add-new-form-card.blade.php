<section class="bg-dust-gray h-100 p-4 rounded-4 space-y-6">
    <div>
        <h2 class="poppins-semibold text-lg">Create a new form</h2>
        <p class="mt-1 mb-1 text-sm text-gray-600">Create a new version of tracer.</p>
        <div class="flex gap-4 items-center mt-4">
            <x-primary-button type="button" id="addQuestion" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-new-tracer-form')">Create</x-primary-button>
        </div>
    </div>

    <x-modal name="add-new-tracer-form" focusable>
        <form id="save-form" method="post" action="{{ route('tracerManagement.create-form')}}" class="p-6">

            <h2 class="poppins-semibold text-xl">
                Create a new tracer version
            </h2>

            <p class="mt-2 text-sm">
                Fields marked with an asterisk (*) are required.
            </p>

            <div class="mt-4 space-y-6">
                <div>
                    <x-input-label for="title" :value="__('Version *')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus />
                </div>
                <div>
                    <x-input-label for="description" :value="__('Notes (For admin only):')" />
                    <textarea
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                        name="description"
                        id="description"
                        rows="4"
                        placeholder="Write your description here"></textarea>
                </div>
            </div>


            <div class="mt-6 flex">
                <x-primary-button type="button" id="add-new-tracer-version">{{ __('Create') }}</x-primary-button>

                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close')">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        </form>
    </x-modal>

    <script>
        document.getElementById('add-new-tracer-version').addEventListener('click', function(event) {
            const formElement = document.querySelector("#save-form");
            const formfields = formElement.querySelectorAll("input, textarea");
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            
            event.preventDefault();

            formfields.forEach(field => {
                if (field.name) {
                    formData.append(field.name, field.value.trim());
                } else {
                    console.warn("Field without a name found", field);
                }
            });

            formData.append('_token', token);

            fetch('{{ route('tracerManagement.create-form')}}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        showToast("Invalid input.", false);
                    } else {
                        throw new Error(data.error || 'Something went wrong');
                    }
                }

                return response.json();
            })
            .then(data => {
                showToast("Tracer version added successfully!");

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                showToast("Failed to save tracer version.", false);
            });
        });
    </script>

</section>


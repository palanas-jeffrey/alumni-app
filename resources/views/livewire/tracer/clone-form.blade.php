<div class="pb-2 text-right">
    @if(!$isModalOnly)
        <x-primary-button type="button" x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'modal-clone-survey-form-{{ $form_id }}')">Clone form</x-primary-button>
    @endif

    <x-modal name="modal-clone-survey-form-{{ $form_id }}"
        x-on:close.window="@this.dispatch('close')" focusable>

        @if ($new_form_id)
            <div class="p-4 pb-0 text-left">
                <h2 class="mb-1 modal-title poppins-semibold text-xl">
                    Would you like to view the cloned form?
                </h2>
            </div>
            <div class="flex justify-start p-4">
                <x-link-btn href="{{ route('form', $new_form_id) }}">View</x-link-btn>

                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close');reloadPage();">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        @else
            <div class="p-4 pb-0 text-left">
                <h2 class="mb-1 modal-title poppins-semibold text-xl">
                    Would you like to clone the form?
                </h2>
            </div>
            <div class="flex justify-start p-4">
                <x-primary-button class="clone-form-cta" wire:click="cloneForm">
                    <div class="relative">
                        <span class="btn-text">Clone</span>
                        <div class="dots-loader absolute v-hidden">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </x-primary-button>

                <x-link-generic class="ml-6" href="javascript:void(0);" x-on:click="$dispatch('close');">
                    <span>Cancel</span>    
                </x-link-generic>
            </div>
        @endif
    </x-modal>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.clone-form-cta')) {
                processCloning();
            }
        });

        function processCloning() {
            const submitBtn = document.querySelector(".clone-form-cta");

            if (submitBtn) {
                showBtnLoader(submitBtn);
            }
        }

        function endCloningLoader() {
            const submitBtn = document.querySelector(".clone-form-cta");

            if (submitBtn) {
                hideBtnLoader(submitBtn);
            }
        }

        window.addEventListener('form-cloned', function () {
            endCloningLoader();
            showToast("Form cloned succesfully!");
        });

        window.addEventListener('form-cloning-failed', function () {
            endCloningLoader();
            showToast("Form cloning failed!", false);
        });

        function reloadPage() {
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    </script>
</div>
<x-generic-layout> 
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{ route('accounts.administrators') }}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    Admin account edit
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12 p-b-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @livewire('accounts.admin-edit', ['account_id' => $account->id])
            </div>
        </div>
    </div>

    @include('shared.toaster')
    @include('shared.js.script-date-picker')

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
</x-generic-layout>
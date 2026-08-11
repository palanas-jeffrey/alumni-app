@admin
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-1 border-gray-300 rounded-4">
                <div class="mb-4">
                    <h2 class="font-medium poppins-semibold text-lg">
                        Comprehensive Donation Ledger
                    </h2>

                    <p class="mb-1 mt-1 text-sm">
                        Donation records including financial, resources, and facility support
                    </p>
                </div>
                @include("donation.partials.tab-panel")
            </div>
        </div>
    </div>

    @include('shared.toaster')
        
    <script>
        var updateStatusforms = document.querySelectorAll(".update-donation-status");

        updateStatusforms.forEach( form => {
            form.addEventListener('submit', function(event) {
                var id = form.querySelector("[name=donation_id]").value;
                
                event.preventDefault();

                fetch(form.action, { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        donation_id: id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        showToast('Encountered error');
                        throw new Error(`HTTP status ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    showToast('Donation updated successfully!');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    console.log('Error saving event: ' + error);
                    showToast('Encountered error');
                });
            });
        });

    </script>
</x-app-layout>
@endadmin

@user
<x-generic-layout>
    <x-simple-nav>
        <div class="d-flex">
            <div class="absolute font-semibold leading-tight text-gray-800 text-xl">
                <a href="{{route('donation')}}">
                    <i class="bi bi-chevron-left"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="poppins-semibold text-center text-xl w-100">
                <h1>
                    My Donations
                </h1>
            </div>
        </div>
    </x-simple-nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-1 border-gray-300 rounded-4">
                <div class="mb-4">
                    <h2 class="font-medium poppins-semibold text-lg">
                        Comprehensive Donation Ledger
                    </h2>

                    <p class="mb-1 mt-1 text-sm">
                        Donation records including financial, resources, and facility support
                    </p>
                </div>
                @include("donation.partials.tab-panel")
            </div>
        </div>
    </div>
</x-generic-layout>
@enduser

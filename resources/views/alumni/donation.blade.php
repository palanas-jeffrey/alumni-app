@php
    $userId = Auth::user()->id;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-dust-gray flex justify-between p-5 shadow rounded-4">
                <div class="w-55p">
                    <section>
                        <header>
                            <h2 class="poppins-semibold text-lg font-medium text-gray-900">
                                {{ __('Donation Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Add your donation information.") }}
                            </p>
                        </header>

                        <form action="" id="donationForm" class="mt-6 space-y-6">
                            <div>
                                <div>
                                    <x-input-label for="donation-type" :value="'Donation type'" />
                                    <x-select id="donation-type" name="donation-type" :options="['monetary' => 'Financial', 'inKind' => 'Resources', 'facility' => 'Facility']" :selected="'monetary'" class="" />
                                </div>
                            </div>
                            <div class="monetary-field">
                                <div class="pb-2">
                                    <x-input-label for="donationAmount" :value="__('Amount in Php')" />
                                    <x-text-input id="donationAmount" name="donationAmount" type="number" min="100" class="mt-1 block w-full" :value="''" />
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required and must be at least 100</div>
                                </div>
                                <div class="pb-2">
                                    <x-input-label for="paymentMethod" :value="__('Payment method')" />
                                    <x-select id="paymentMethod" name="paymentMethod" :options="['paypal' => 'Paypal', 'paymongo' => 'Paymongo']" :selected="'paypal'" class="" />
                                </div>
                            </div>
                            <div class="in-kind-field hidden">
                                <div class="pb-2">
                                    <x-input-label for="in-kind-item" :value="'Item'" />
                                    <x-text-input id="in-kind-item" name="in-kind-item" type="text" class="mt-1 block w-full" :value="''"  />
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required</div>
                                </div>
                                <div class="pb-2">
                                    <x-input-label for="quantity" :value="'Quantity'" />
                                    <x-text-input id="quantity" name="quantity" type="number" min="1" class="mt-1 block w-full" :value="''"  />
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required</div>
                                </div>
                                <div class="pb-2">
                                    <x-input-label for="unit" :value="'Unit (pcs, boxes, etc.)'" />
                                    <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" :value="''"  />
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required</div>
                                </div>
                            </div>

                            <div class="facility-field hidden">
                                <div class="pb-2">
                                    <x-input-label for="facility" :value="'Facility'" />
                                    <x-text-input id="facility" name="facility" type="text" class="mt-1 block w-full" :value="''"  />
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required</div>
                                </div>
                                <div class="pb-2">
                                    <x-input-label for="description" :value="'Description'" />
                                    <textarea
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                                        name="description"
                                        id="description"
                                        rows="4"></textarea>
                                    <div class="error-msg text-sm text-red-600 space-y-1">Required</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="button" id="donationBtn">{{ __('Donate') }}</x-primary-button>

                                @if (session('status') === 'donation-submitted')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Donation process succeeded.') }}</p>
                                @endif
                            </div>
                        </form>

                        <!-- PayPal Button Container - rendered outside the form -->
                        <div id="paypal-button-container" class="flex items-center gap-4 mt-6 space-y-6 hidden">
                            <x-primary-button type="button" ></x-primary-button>
                        </div>
                    </section>
                </div>
                @livewire('donation.recent-donation')
            </div>

            <div class="text-center line-height-normal txt-20">
                <blockquote>
                    <p>Give back. Move Forward</p>
                    <p>Every peso you donate helps us lift future generations higher.</p>
                    <p>As proud alumni, your story and your generosity fuels theirs.</p>
                    <p>Reignite your legacy by giving today.</p>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- paymongo donation modal -->
    <div class="modal fade" id="paymongoDonationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <iframe id="paymongoWindow" class="block w-full h-screen border-none pb-4" src="" title="description"></iframe>
            </div>
        </div>
    </div>

    @include('shared.toaster')

    <!-- PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AR_mRTY-1XP3VNpWEoM512vOtkvEhbOdUjLxnufbQFM2RSQVep-XJckbnQpS4QhtOsnqVojcGYfjbzQX&currency=PHP"></script>

    <script>
        //paypal
        // Global variable to track if PayPal buttons are already rendered
        let paypalButtonsRendered = false;
        var paymongo_reference_no = '';
        
        function resetPayPalButtons() {
            // Clear the PayPal button container
            const container = document.getElementById('paypal-button-container');
            container.innerHTML = '';
            container.classList.add('hidden');
            paypalButtonsRendered = false;
        }
        
        function renderPayPalButtons() {
            const amount = document.getElementById('donationAmount').value;

            // Don't render if already rendered
            if (paypalButtonsRendered) {
                return;
            }
            
            const container = document.getElementById('paypal-button-container');
            container.classList.remove('hidden');
            
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'PHP',
                                value: amount
                            },
                            description: 'Alumni Donation'
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        const amount = document.getElementById('donationAmount').value;
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        console.log('Sending donation data to server:', {
                            amount: amount,
                            payment_id: details.id,
                            status: details.status
                        });
                        
                        return fetch('{{route('donations.monetary.save')}}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                user_id: "{{Auth::user()->id}}",
                                mode_of_payment: "Paypal",
                                transaction_id: details.id,
                                amount: amount,
                                currency: "Php",
                            })
                        })
                        .then(response => response.json())
                        .then(result => {
                            console.log('Server response:', result);
                            resetForm();
                            if (result.success) {
                                window.location.href = "/donation-thank-you";
                            } else {
                                showToast('Error: ' + result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Transaction completed, but there was an error saving your donation information.');
                        });
                    });
                },
                onError: function(err) {
                    console.error('PayPal Error:', err);
                    alert('There was an error processing your payment. Please try again.');
                    resetPayPalButtons();
                },
                onCancel: function() {
                    console.log('Payment cancelled by user');
                    resetPayPalButtons();
                }
            }).render('#paypal-button-container');
            
            paypalButtonsRendered = true;
        }

        function initDonationSubmission() {
            document.querySelector('#donationBtn').addEventListener('click', function(event) {
                const donationType = document.querySelector("select[name=donation-type]").value;
                const amountElement = document.querySelector("[name=donationAmount]");

                event.preventDefault();
                event.stopPropagation();

                if (donationType === 'inKind') {
                    processInKindDonation();
                } else if (donationType === 'monetary') {
                    var paymentMethod = document.querySelector('select[name=paymentMethod]').value;
                    var amount = amountElement.value;

                    if (!amount && amount == '') {
                        return amountElement.parentElement.classList.add("has-error");
                    }

                    if (paymentMethod.toLowerCase() == "paypal") {
                        resetPayPalButtons();
                        renderPayPalButtons();
                    } else if (paymentMethod.toLowerCase() == "paymongo"){
                        submitDonationPaymongo();
                    }
                } else if (donationType === 'facility') {
                    processFacilityDonation();
                }

            });
        }

        function processInKindDonation() {
            var inKindFieldBox = document.querySelector(".in-kind-field");
            var fields = inKindFieldBox.querySelectorAll("input");
            var itemName = document.querySelector("input[name=in-kind-item]").value;
            var quantity = document.querySelector("input[name=quantity]").value;
            var unit = document.querySelector("input[name=unit]").value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fields.forEach(input => {
                if (input.value == "") {
                    return input.parentElement.classList.add("has-error");
                }
            });

            if (itemName == "" || quantity == "" || unit == "" ) {
                return;
            }
            
            fetch("{{route('donations.in-kind.save')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    user_id: "{{Auth::user()->id}}",
                    item_name: itemName,
                    quantity: quantity,
                    unit: unit
                })
            })
            .then(async response => {
                const result = await response.json();
                console.log('Server response for in-kind donation:', result);

                if (response.status === 422) {
                    // Validation errors
                    let messages = Object.values(result.errors)
                        .map(errorArray => errorArray.join(' '))
                        .join('\n');
                    showToast('Validation Error:\n' + messages, false);
                } else if (result.success) {
                    showToast('Donation saved successfully!');
                    setTimeout(() => {
                        window.location.href = '/donation-thank-you';
                    }, 1500);
                    resetForm();
                } else {
                    showToast('Error: ' + (result.message || 'Unknown error occurred.'), false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('There was an error processing your donation. Please try again.', false);
            });
        }
        
        function processFacilityDonation() {
            var inKindFieldBox = document.querySelector(".facility-field");
            var fields = inKindFieldBox.querySelectorAll("input");
            var facility = document.querySelector("input[name=facility]").value;
            var description = document.querySelector("textarea[name=description]").value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fields.forEach(input => {
                if (input.value == "") {
                    return input.parentElement.classList.add("has-error");
                } else {
                    return input.parentElement.classList.remove("has-error");
                }
            });

            if (facility == "" || description == "" ) {
                return;
            }
            
            fetch("{{route('donations.facility.save')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    user_id: "{{Auth::user()->id}}",
                    facility: facility,
                    description: description,
                })
            })
            .then(response => response.json())
            .then(result => {
                console.log('Server response for item donation:', result);
                if (result.success) {
                    showToast('Donation saved successfully!');
                    setTimeout(function(){
                        window.location.href = '/donation-thank-you';
                    }, 1500);
                    resetForm();
                } else {
                    alert('Error: ' + result.message);
                    showToast('Error: ' + result.message, false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('There was an error processing your donation. Please try again.', false);
            });
        }

        function submitDonationPaymongo() {
            const amount = document.querySelector('input[name=donationAmount]').value;

            if (amount) {
                fetch('/proccessPaymongo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: amount,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.checkout_url) {
                        paymongo_reference_no = data.linkDetails.attributes.reference_number;
                        showPaymentModal(data.checkout_url);
                    } else {
                        showToast("Invalid JSON response", false);
                    }
                })
                .catch(error => {
                    showToast("Process failed", false);
                });
            } else {
                showToast("Required data is not set.", false);
            }
        }

        function checkPaymongoPaymentStatus() {
            if (paymongo_reference_no && paymongo_reference_no != '') {
                fetch("{{ route('donations.paymongo-payment-status.get')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        paymongo_reference_no: paymongo_reference_no,
                        user_id: "{{$userId}}"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.is_paid) {
                        window.location.href = "/donation-thank-you";
                    } else {
                        location.reload();
                    }
                })
                .catch(error => {
                   location.reload();
                });
            }
        }

        function showPaymentModal(url) {
            var modalEl = document.querySelector('#paymongoDonationModal')
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            if (modalEl && modal) {
                var iframeElem =  document.querySelector("#paymongoWindow");

                if (iframeElem) {
                    iframeElem.setAttribute("src", url);
                }
                modal.show();
            }
        }

        function onTransactionHideModal() {
            document.addEventListener("hidden.bs.modal", function () {
                if (paymongo_reference_no && paymongo_reference_no != '') {
                    checkPaymongoPaymentStatus();
                } else {
                    location.reload();
                }
            });
        }

        function initDonationTypeSelection() {
            const donationSelect = document.querySelector("select[name=donation-type]");
            donationSelect.addEventListener("change", function() {
                const select = document.querySelector("select[name=donation-type]");
                const value = select.value;
                const monetaryBox = document.querySelector(".monetary-field");
                const inKindBox = document.querySelector(".in-kind-field");
                const facilityBox = document.querySelector(".facility-field");
                const paypalBox = document.querySelector("#paypal-button-container");
                const monetryInputs = monetaryBox.querySelectorAll("input");
                const inKindInputs = inKindBox.querySelectorAll("input");
                const facilityInputs = facilityBox.querySelectorAll("input");
                const fnResetinKindInputs = () => {
                    inKindInputs.forEach(input => {
                        input.value = "";
                        input.parentElement.classList.remove("has-error");
                    });
                }
                const fnResetMonetaryInputs = () => {
                    monetryInputs.forEach(input => {
                        input.value = "";
                        input.parentElement.classList.remove("has-error");
                    });
                }
                const fnResetFacilityInputs = () => {
                    facilityInputs.forEach(input => {
                        input.value = "";
                        input.parentElement.classList.remove("has-error");
                    });
                }

                if (value == "monetary") {
                    monetaryBox.style.display = "";
                    inKindBox.style.display = "";
                    facilityBox.style.display = "";
                    fnResetinKindInputs();
                    fnResetFacilityInputs();
                } else if (value == "inKind") {
                    monetaryBox.style.display = "none";
                    inKindBox.style.display = "block";
                    facilityBox.style.display = "";
                    paypalBox.classList.add("hidden");
                    fnResetMonetaryInputs();
                    fnResetFacilityInputs();
                } else if (value == "facility") {
                    monetaryBox.style.display = "none";
                    inKindBox.style.display = ""; 
                    facilityBox.style.display = "block";
                    fnResetinKindInputs();
                    fnResetMonetaryInputs();
                }
            });
        }

        function resetForm() {
            var form = document.querySelector("#donationForm");
            var fields = form.querySelectorAll("input, select");

            fields.forEach(field => {
                field.value = "";
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            onTransactionHideModal();
            initDonationTypeSelection();
            initDonationSubmission();
        });
    </script>
</x-app-layout>

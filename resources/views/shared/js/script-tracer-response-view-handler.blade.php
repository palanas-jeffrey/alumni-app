@php
    $baseUrl = config('app.url');
    $documentPath = $baseUrl . '/public/storage/';
@endphp

<script>

    function viewResponse() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const payload = { 
            response_id : "{{ $response->id }}"
        };

        const endpoint = "{{ route('tracer.get-response') }}";

        fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(payload)
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');

                if (!response.ok) {
                    let errorMessage = `HTTP status ${response.status}`;

                    if (contentType?.includes('application/json')) {
                        const errorData = await response.json();
                        errorMessage = errorData.error || errorData.message || errorMessage;
                    } else {
                        const errorText = await response.text();
                        errorMessage = errorText || errorMessage;
                    }

                    throw new Error(errorMessage);
                }

                return response.json();
            })
            .then(data => {
                setFieldResponses(data)
            })
            .catch(error => {
                console.error('Error retrieving response:', error);
                showToast("Encountered error while retrieving the response.", false);
            });
    }

    function setFieldResponses(data) {    
        const formContainer = document.querySelector("#tracer-form");
        const inputs = formContainer.querySelectorAll("input, textarea, select");
        const element_prefix = "field_";
        
        if (inputs.length > 0) {
            inputs.forEach(function(element){
                element.setAttribute('readonly', true);
                element.setAttribute('disabled', true);
            });
        }

        if (data.response_fields && data.response_fields.length > 0) {
            data.response_fields.forEach(function(field) {
                let input = formContainer.querySelector("[name=" + element_prefix + field.field_id + "]" );

                if (!input) {
                    return;
                }

                if (input.type == "text" ||
                    input.type == "number" ||
                    input.tagName.toLowerCase() === "textarea" ||
                    input.tagName.toLowerCase() === "select"
                ) {
                    input.value = field.value;
                } else if (input.type == "radio") {
                    let fieldName = input.name;
                    let radios = formContainer.querySelectorAll(`input[name="${fieldName}"]`);

                    radios.forEach(function(radio) {
                        if (radio.value.trim() === field.value.trim()) {
                            radio.checked = true;
                        }
                    });
                } else if (input.type == "checkbox") {
                    let fieldName = input.name;
                    let checkboxes = formContainer.querySelectorAll(`input[name="${fieldName}"]`);
                    let selections = field.value.split("|").map(s => s.trim());

                    checkboxes.forEach(function(checkbox) {
                        if (selections.includes(checkbox.value.trim())) {
                            checkbox.checked = true;
                        }
                    });
                } else if (input.type == "file" && field.value) {
                    const parent = input.parentElement;
                    input.classList.add("hidden");
                    input.setAttribute("data-old-value", field.value);
                    input.removeAttribute("required");

                    const linkWrap = parent.querySelector(".view-document");
                    linkWrap.classList.remove("hidden");

                    const link = linkWrap.querySelector("a");
                    link.href = "{{ $documentPath }}" + field.value;
                }
            });
        }
    }

    function setCTA() {
        let btnSubmit = document.querySelector(".js-cta-container #responseSubmit");
        let btnEdit = document.querySelector(".js-cta-container #responseEdit");
        
        if (btnSubmit) btnSubmit.classList.add("d-none");
        if (btnEdit) btnEdit.classList.remove("d-none");
    }

    function initFormEvent() {
        document.addEventListener("click",  function(event) {
            if (event.target.closest(".js-cta-container #responseEdit")) {
               makeFormEditable();
            }
        });
    }

    function makeFormEditable() {
        const formContainer = document.querySelector("#tracer-form");
        const inputs = formContainer.querySelectorAll("input, textarea, select");
                
        if (inputs.length > 0) {
            inputs.forEach(function(element){
                element.removeAttribute('readonly');
                element.removeAttribute('disabled');

                if (element.tagName === "INPUT" && element.type === "file") {
                    const parent = element.parentElement;
                    element.classList.remove("hidden");

                    const linkWrap = parent.querySelector(".view-document");
                    if (linkWrap) {  
                        const link = linkWrap.querySelector("a");
                        const hrefValue = link.href;

                        if (!hrefValue && hrefValue === "") {
                            linkWrap.classList.add("hidden");
                        } else {
                            link.textContent = "Check out the attached file for the previous version.";
                        }
                    }
                }
            });

            let btnSubmit = document.querySelector(".js-cta-container #responseSubmit");
            btnSubmit.classList.remove("d-none");

            let btnEdit = document.querySelector(".js-cta-container #responseEdit");
            btnEdit.classList.add("d-none");

            isResponseUpdate = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        viewResponse();
        setCTA();
        initFormEvent();
    });
</script>
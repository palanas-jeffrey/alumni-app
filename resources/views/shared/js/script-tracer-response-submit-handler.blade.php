<script>
    let isResponseUpdate = {{ json_encode($isResponseUpdate) }};

    async function submitResponse() {
        const formContainer = document.querySelector("#tracer-form");
        const inputs = formContainer.querySelectorAll("input, textarea, select");
        const inputFiles = formContainer.querySelectorAll("input[type=file]");
        let fields = [];
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let uploadCount = 0;

        function addOrUpdateField(newId, newValue, sectionId) {
            let existingField = fields.find(field => field.field_id === newId),
                trimmedValue = newValue.trim();

            if (existingField) {
                existingField.value += "|" + trimmedValue;
            } else {
                fields.push({ "field_id": newId, "value": trimmedValue, "section_id": sectionId });
            }
        }

        // Track validated radio and checkbox groups
        const validatedRadioGroups = new Set();
        const validatedCheckboxGroups = new Set();

        // Validate required fields
        for (let input of inputs) {
            const type = input.type;
            const name = input.name;

            // Radio group validation
            if (type === "radio" && input.required) {
                if (!validatedRadioGroups.has(name)) {
                    const group = formContainer.querySelectorAll(`input[name="${name}"]`);
                    const isChecked = Array.from(group).some(radio => radio.checked);

                    if (!isChecked) {
                        showToast("Please complete all the * required fields.", false);
                        return;
                    }

                    validatedRadioGroups.add(name);
                }
            }

            // Checkbox group validation (marked with data-required-group)
            else if (type === "checkbox" && input.hasAttribute("data-required-group")) {
                if (!validatedCheckboxGroups.has(name)) {
                    const group = formContainer.querySelectorAll(`input[name="${name}"]`);
                    const isChecked = Array.from(group).some(cb => cb.checked);

                    if (!isChecked) {
                        showToast("Please complete all the * required fields.", false);
                        return;
                    }

                    validatedCheckboxGroups.add(name);
                }
            }
            else if (type === "file" && input.required) {
                const file = input.files[0];

                if (!file) {
                    showToast("Please upload a file.");
                    return;
                }
            }

            // Other required fields
            else if (input.required && type !== "radio" && type !== "checkbox" && !input.value) {
                showToast("Please complete all the * required fields.", false);
                return;
            }    
        }

        inputs.forEach(item => {
            const newId = parseInt(item.name.replace('field_', ''), 10);

            if (!isNaN(newId)) { 
                if (item.type === "radio") {
                    const existingField = fields.find(field => field.field_id === newId);

                    if (!existingField) {
                        const checkedRadio = formContainer.querySelector(`input[name="${item.name}"]:checked`);
                        if (checkedRadio) {
                            fields.push({ "field_id": newId, "value": checkedRadio.value , "section_id": checkedRadio.getAttribute("data-section-id")});
                        }
                    }
                } else if (item.type === "checkbox") {
                    let sectionId = item.getAttribute("data-section-id");

                    if (item.checked) {
                        addOrUpdateField(newId, item.value, sectionId);
                    }
                } else if (item.type === "file") {
                    const file = item.files[0];
                    const oldValue = item.getAttribute("data-old-value");

                    if (file){ 
                        uploadCount++;
                    }

                    if (oldValue) {
                        fields.push({ 
                            "field_id": newId, "value": oldValue, 
                            "section_id": item.getAttribute("data-section-id") });
                    }

                } else {
                    fields.push({ "field_id": newId, "value": item.value, "section_id": item.getAttribute("data-section-id") });
                }
            }
        });

        const payload = { 
            fields: fields,
            user_id: "{{Auth::user()->id}}",
            program_id: "{{Auth::user()->program_id}}",
            batch_year: "{{Auth::user()->batch_year}}"
        };

        const endpoint = isResponseUpdate ? 
            "{{ route('tracer.update-response', ['form_id' => $form_id]) }}" : 
            "{{ route('tracer.save-response', ['form_id' => $form_id]) }}";

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(payload)
            });

            const contentType = response.headers.get('content-type');

            if (!response.ok) {
                let errorMessage = `HTTP status ${response.status}`;

                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorData.error || errorMessage;
                } else {
                    const errorText = await response.text();
                    errorMessage = errorText || errorMessage;
                }

                throw new Error(errorMessage);
            }

            const data = await response.json();

            showToast(isResponseUpdate ? 'Question responses updated successfully!' : 'Question responses saved successfully!');

            if (response.ok && inputFiles.length > 0 && uploadCount > 0) {
                setTimeout(() => {
                    showToast('Uploading file/files in progress.');
                }, 1000);
                await processAllDocumentUpload();
            }

            showToast('Submission completed!');

            setTimeout(() => {
                if (isResponseUpdate) {
                    window.location.reload();
                } else {
                    window.location.replace("{{ route('tracer-completion') }}");
                }
            }, 1500);

        } catch (error) {
            showToast("Encountered error while saving the response.", false);
        }
    }

    async function processAllDocumentUpload() {
        const formContainer = document.querySelector("#tracer-form");
        const fileInputs = formContainer.querySelectorAll("input[type=file]");
        const uploadRecord = [];

        // Filter to only inputs with uploaded files
        const uploadedFileInputs = Array.from(fileInputs).filter(input => input.files.length > 0);

        if (uploadedFileInputs.length > 0) {
            for (let i = 0; i < uploadedFileInputs.length; i++) {
                const success = await isUploadDocumentSuccess(uploadedFileInputs[i], i + 1, uploadedFileInputs.length);
                uploadRecord.push(success);
            }

            if (uploadRecord.includes(false)) {
                showToast('The process was completed, but some uploads failed.', false);
            } else {
                showToast('All documents uploaded successfully.');
            }
        }
    }

    async function isUploadDocumentSuccess(inputElement, count = 0, totalFiles = 0) {
        if (!inputElement) return false;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData();
        const file = inputElement.files[0];
        const sectionId = inputElement.getAttribute("data-section-id");
        const fieldId = parseInt(inputElement.name.replace('field_', ''), 10);

        if (!fieldId || !sectionId || !file) return false;

        formData.append('field_id', fieldId);
        formData.append('section_id', sectionId);
        formData.append('user_id', "{{ Auth::user()->id }}");
        formData.append('program_id', "{{ Auth::user()->program_id }}");
        formData.append('batch_year', "{{ Auth::user()->batch_year }}");
        formData.append('document', file);

        try {
            const response = await fetch("{{ route('tracer.save-documents', ['form_id' => $form_id]) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            if (!response.ok) {
                const contentType = response.headers.get('content-type');
                let errorMessage = `HTTP status ${response.status}`;

                if (contentType && contentType.includes('application/json')) {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } else {
                    const errorText = await response.text();
                    errorMessage = errorText || errorMessage;
                }

                throw new Error(errorMessage);
            }

            showToast(`File ${count} of ${totalFiles} uploaded successfully.`);
            return true;
        } catch (error) {
            console.error(error);
            showToast(`Error uploading file ${count}: ${error.message}`, false);
            return false;
        }
    }

    function initEvents() {
        document.addEventListener('click', function(e) {

            if(event.target.closest("#responseSubmit")) {
                e.preventDefault();
                e.stopPropagation();
                submitResponse();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initEvents();
    });
</script>
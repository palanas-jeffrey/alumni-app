<div class="modal fade" id="editFieldModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update-question-form" method="" action="">
                <div class="modal-header">
                    <h2 class="modal-title text-lg font-medium text-gray-900" id="editFieldModal">
                        {{ __('Question builder') }}
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div>
                            <x-input-label for="update-questionLabel" :value="__('Question')" />
                            <!-- <x-text-input id="update-questionLabel" name="questionLabel" type="text" class="mt-1 block w-full" required autofocus /> -->
                            <textarea
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                                    name="update-questionLabel"
                                    id="update-questionLabel"
                                    rows="4"></textarea>
                        </div>
                        <div class="mt-2">
                            <input type="checkbox" id="update-is_required" name="is_required" value="is_required">
                            <label for="update-is_required">Required</label>
                        </div>
                        <div class="w-full mt-3">
                            @php 
                                $options = [
                                    'text' => 'Short answer',
                                    'textarea' => 'Paragraph',
                                    'number' => 'Number',
                                    'radio' => 'Multiple choice',
                                    'checkbox' => 'Checkbox',
                                    'select' => 'Dropdown'
                                ];
                                $selected = 'text';
                            @endphp
                            <x-select disabled id="update-create-question-select" :options="$options" selected="$selected" class="custom-class"/>
                        <div>

                        <div class="option-input-update-container mt-2 mb-3 hidden">
                            <div>
                                <x-input-label for="update-option" :value="__('Options')"/>
                                <x-text-input id="update-option" name="optionInput" type="text" class="mt-1 block w-full" required autofocus />
                            </div>
                            <div>
                                <div class="ml-1 mt-32">
                                    <button id="update-add-option" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#6365f1] ml-1">add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-options-container">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex items-center gap-4">
                        <x-primary-button type="button" id="submitUpdateQuestionBtn">{{ __('Update question') }}</x-primary-button>
                    </div>
                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="modal-cancel inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#6365f1] ml-1">
                        <span>Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('shared.toaster')

<script>
    var retrievedOptions = [];
    var fieldIdData;

    function showEditField(data) {
        var editFieldModal = document.querySelector('#editFieldModal');
        var modal = bootstrap.Modal.getOrCreateInstance(editFieldModal); // Returns a Bootstrap modal instance
        var labelField = document.querySelector("[name=update-questionLabel]");
        var requiredField = document.querySelector("[name=is_required]");
        var selectField = document.querySelector("#update-create-question-select");
        var optionInput = document.querySelector(".option-input-update-container");

        if (modal) {
            modal.show();
            labelField.value = data.label;
            selectField.value = data.type;
            requiredField.checked = data.required ? true : false;
            console.log(data);
            insertIntoRetrievedOptions(editFieldModal); 

            if (data.options && data.options.length > 0) {
                optionInput.style.display = "flex";
            }
        }
    }

    function getFieldData(id) {
        const fieldId = id;
        console.log(id); 

        fetch(`/field-get/${fieldId}`)
        .then((response) => {
            if (!response.ok) {
            throw new Error('Field not found');
            }
            return response.json();
        })
        .then((data) => {
            console.log('Field Data:', data);
            if(data.options && data.options.length > 0) {
                data.options.forEach(item => {
                    retrievedOptions.push(item);
                });

                console.log(data);
            };
            showEditField(data);
        })
        .catch((error) => {
            console.error('Error:', error.message); // Log any errors
        });
    }

    document.addEventListener("click", function(e) {
        if(e.target.closest(".edit-field-trigger")) {
            e.preventDefault();
            var target = e.target.closest(".edit-field-trigger"),
                id =  target.getAttribute('data-editId');

            if (id) {
                getFieldData(id);
                fieldIdData = id;
            }
        }
    });

    function insertOldOptions(parent) {
        const container = parent.querySelector(".field-options-container");
        container.replaceChildren();

        if (retrievedOptions.length > 0) {
            retrievedOptions.forEach(item => {
                var elem = createOptionElem(item.value);
                container.append(elem)
            });
        }
    }

    var updateBtn = document.querySelector("#submitUpdateQuestionBtn");

    updateBtn.addEventListener("click", function(e) {
        var saveQuestionForm = e.target.closest("form");
        var qFields;
        
        if (saveQuestionForm) {
            qFields = saveQuestionForm.querySelectorAll("input, select");
        }

        var label = saveQuestionForm.querySelector("[name=update-questionLabel]").value;
        var type =  saveQuestionForm.querySelector("#update-create-question-select").value;
        var required = saveQuestionForm.querySelector("input[name=is_required]").checked;
        const token = "{{ csrf_token() }}";

        if (!label || !type) {
            return;
        }

        console.log(required);

        const formData = new FormData();
        formData.append('form_id', {{$form->id}});
        formData.append('label', label);
        formData.append('type', type);
        formData.append('required', required);
        formData.append('_token', token);

        if (type == "radio" || type == "checkbox" || type == "select") {
            if (retrievedOptions.length > 0) {
                retrievedOptions.forEach(value => {
                    if (value) {
                        formData.append('id', value.id ? value.id : "");
                        formData.append('value', value.value ? value.value : value);
                    }
                });

                retrievedOptions.forEach((option, index) => {
                    if (option.id) {
                        formData.append(`options[${index}][id]`, option.id); // Add option ID if it exists
                    }
                    formData.append(`options[${index}][value]`, option.value); // Add option value
                });
            }
        }


        // console.log("here");
        fetch(`/field-update/${fieldIdData}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token // Include CSRF token
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || `HTTP status ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            showToast("Field updated saved successfully!");
            console.log('Field update saved successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            showToast("Failed to save field update. Please try again.");
            console.error('Error saving field update:', error);
        });
    });

    var updateRetrievedOptions = document.querySelector("#update-add-option");

    updateRetrievedOptions.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        var parent = event.target.closest("form");
        var inputElem = parent.querySelector("input[name=optionInput]");
        var input = inputElem.value.trim();
        if (input && input !== '') {
            var nItem = {
                value : input 
            };
            retrievedOptions.push(nItem);
            insertIntoRetrievedOptions(parent);
            inputElem.value="";
        }
    });

    document.addEventListener('click',function (e){
        if (e.target.closest(".remove-retrieved-option-item")) {
            event.preventDefault();
            event.stopPropagation();
            var formElem = event.target.closest("form");
            var parent = e.target.closest(".field-options");
            var child = parent.querySelector(".item-txt");
            var txt = child.textContent.trim();
            retrievedOptions = retrievedOptions.filter(item => item.value !== txt);
            insertIntoRetrievedOptions(formElem);
        }

        if (e.target.closest("#addQuestion")) {

        }
    });

    function insertIntoRetrievedOptions(parent) {
        const container = parent.querySelector(".field-options-container");
        container.replaceChildren();

        if (retrievedOptions.length > 0) {
            retrievedOptions.forEach(item => {
                var elem = createRetrievedOptionElem(item.value);
                container.append(elem)
            });
        }
    }

    function createRetrievedOptionElem (item) {
        const fieldOptions = document.createElement("div");
        fieldOptions.className = "field-options";
        const span = document.createElement("span");
        span.textContent = item;
        span.className = "item-txt";
        const button = document.createElement("button");
        const icon = document.createElement("i");
        icon.className = "bi bi-x-circle";
        button.className = "remove-retrieved-option-item";
        button.appendChild(icon);
        fieldOptions.appendChild(span);
        fieldOptions.appendChild(button);
        return fieldOptions;
    }
</script>
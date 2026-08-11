@php
    $is_previous = isset($isPrevious) ? $isPrevious : false;
@endphp

<script>
    document.getElementById('save-event-form').addEventListener('submit', function(event) {
        const formElement = document.querySelector("#save-event-form");
        const formfields = formElement.querySelectorAll("input:not([type=file]):not(#multiDatePicker), textarea");
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const selectedDates = document.getElementById("multiDatePicker").value.split(", ");
        const formData = new FormData();
        const fileInput = formElement.querySelector("input[type=file]");
        const file = fileInput.files[0];
        const redirectRoute = @json($redirectRoute);
        const submitBtn = formElement.querySelector("button[type=submit]");
        
        event.preventDefault();
        event.stopPropagation();
        extraValidation();

        formfields.forEach(field => {
            if (field.name) {
                formData.append(field.name, field.value.trim());
            } else {
                console.warn("Field without a name found", field);
            }
        });

        if (selectedDates.length > 0) {
            selectedDates.forEach(date => formData.append('selected_dates[]', date));
        }

        formData.append('_token', token);

        if (file && file.length != 0) {
            formData.append('photo', file);
        }

        var isPrevious = @json($is_previous) ?? false;

        if (isPrevious) {
            formData.append('is_previous', true);
        }

        showBtnLoader(submitBtn);

        fetch(@json($route), { 
            method: 'POST',
            body: formData
        })
        .then(response => {
            hideBtnLoader(submitBtn);

            if (!response.ok) {
                showToast('Encountered error', false);
                throw new Error(`HTTP status ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            showToast('Event saved successfully!');
            console.log('Event saved successfully!');
            if (redirectRoute) {
                setTimeout(() => {
                    window.location.href = redirectRoute;
                }, 1500);
            } else {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        })
        .catch(error => {
            showToast('Encountered error', false);
        });
    });

    function extraValidation() {
        const startTimeField = document.getElementById('start_time');
        const startTime = startTimeField.value;
        const regex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/; // Regex to match HH:mm format

        if (!regex.test(startTime)) {
            alert('Please enter a valid time in HH:mm format (e.g., 14:30).');
            startTimeField.focus(); // Focus the field to correct input
        }
    }
</script>
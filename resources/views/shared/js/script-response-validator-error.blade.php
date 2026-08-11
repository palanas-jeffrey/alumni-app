<script>
    const sampleError = {
        "message": "Validation failed.",
        "keys": ["name", "email"],
        "errors": {
            "name": [
                "The name field is required.",
                "The name must be at least 3 characters."
            ],
            "email": [
                "The email field is required.",
                "The email must be a valid email address."
            ]
        };
    }
    
    function showValidationErrors(validationErrors, formElement) {
        var errors = validationErrors || null;

        if (errors) {
            for (const field in errors) {
                console.log(`Field: ${field}`);
                (errors[field] || []).forEach((message, index) => {
                    console.log(`Error ${index + 1}: ${message}`);
                });

                var fieldElement = formElement.querySelector("[name=" + CSS.escape(field) + "]");

                if (fieldElement) {
                    fieldElement.style.display = "block";
                }
            }
        }
    };
</script>
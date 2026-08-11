<script>
    function publishForm(elem) {
        if(!elem) return;

        const trigger = elem.closest(".publish-trigger");
        const formId = trigger.dataset.formid;
        const token = "{{ csrf_token() }}";

        if (!formId) {
            return;
        }
        
        fetch("{{ route('form.publish-form') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                form_id: formId
            })
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
            showToast('Form published successfully!');
            setTimeout(function(){
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            showToast('Encountered error while publishing the form.', false);
            console.error('Error saving event:', error);
        });
    }

    function unPublishForm(elem) {
        if(!elem) return;

        var trigger = elem.closest(".unpublish-trigger");
        var formId = trigger.dataset.formid;
        const token = "{{ csrf_token() }}";

        if (!formId) {
            return;
        }

        fetch("{{ route('form.unpublish-form')}}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                form_id: formId
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Failed to delete form');
                });
            }
            return response.json(); 
        })
        .then(data => {
            console.log(data.message);
            showToast('Form unpublished successfully!');
            setTimeout(function(){
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error encountered while unpublishing.');
        });
    }

    function initEventButton() {
        document.addEventListener("click", function(e){
            if (e.target.closest(".publish-trigger")) {
                publishForm(e.target);
            }

            if (e.target.closest(".unpublish-trigger")) {
                unPublishForm(e.target);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initEventButton()
    });
</script>
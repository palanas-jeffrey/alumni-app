<div id="toastEl" class="toast position-fixed bottom-3 end-0 p-1" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<script>
    function showToast(content, isNotError="true") {
        var toastEl = document.getElementById('toastEl');
        var toast = bootstrap.Toast.getOrCreateInstance(toastEl);

        if (toastEl && toast) {
            var body = toastEl.querySelector(".toast-body");
            body.textContent = content;
            
            if (!isNotError && !toastEl.classList.contains("error")) {
                toastEl.classList.add("error");
            } else if (isNotError && toastEl.classList.contains("error")) {
                toastEl.classList.remove("error");
            }

            toast.show();
        }
    }
</script>
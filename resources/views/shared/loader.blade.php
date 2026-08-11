<div id="loader-backdrop" class="loader justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    function showLoader() {
        document.getElementById('loader-backdrop').classList.add("d-flex");
    }

    function hideLoader() {
        document.getElementById('loader-backdrop').classList.remove("d-flex");
    }
</script>
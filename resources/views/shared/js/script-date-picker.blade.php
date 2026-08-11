<script>
    flatpickr("#multiDatePicker", {
        mode: "multiple",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    flatpickr(".singleDatePicker", {
        mode: "single",
        dateFormat: "Y-m-d",
        minDate: "today"
    });
</script>
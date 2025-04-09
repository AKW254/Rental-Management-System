<script>
    function showToast(type, message) {
        const options = {
            positionClass: "toast-top-right",
            timeOut: 4000,
            showDuration: "200",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };

        if (type === 'success') {
            toastr.success(message, "", options);
        } else if (type === 'error') {
            toastr.error(message, "", options);
        } else if (type === 'warning') {
            toastr.warning(message, "", options);
        } else if (type === 'info') {
            toastr.info(message, "", options);
        }
    }
</script>
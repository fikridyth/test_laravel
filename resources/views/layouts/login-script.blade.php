<script>
    var hostUrl = "assets/";
</script>
<script src="{{ asset('metronic/demo2/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('metronic/demo2/assets/js/scripts.bundle.js') }}"></script>
<script>
    function show_alert_dialog(status, message) {
        if (!(typeof message === "string" || message instanceof String))
            message = message.responseText;

        message = message.replace(/(\r\n|\n|\r)/g, " ");

        if (status == "00")
            Swal.fire({
                title: "Berhasil",
                html: message,
                icon: "success",
            });
        else if (status == "000")
            Swal.fire({
                title: "Info",
                html: message,
                icon: "info",
            });
        else
            Swal.fire({
                title: "Proses Gagal",
                html: message,
                icon: "warning",
            });
    }

    function start_loading() {
        $("#loading-dialog").modal("show");
    }

    function stop_loading() {
        $("#loading-dialog").modal("hide");
    }

    const containerLogin = document.querySelector("#kt_body");

    const blockContainerLogin = new KTBlockUI(containerLogin, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
    });

    $("#form-login").on("submit", function() {
        if (!blockContainerLogin.isBlocked()) {
            blockContainerLogin.block();
        }
    });
</script>

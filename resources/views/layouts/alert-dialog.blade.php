<script>
    $(document).ready(function() {
        @if (session('alert.status'))
            show_alert_dialog(`{{ session('alert.status') }}`, `{{ session('alert.message') }}`);
        @endif

        @if ($errors->any())
            var status = `01`;
            var message = ``;
            @foreach ($errors->all() as $error)
                message += `{{ $error }}`;
            @endforeach
            message += ``;
            show_alert_dialog(status, message);
        @endif

        @if (request()->get('alert_status'))
            show_alert_dialog("{{ request()->get('alert_status') }}", "{{ request()->get('alert_message') }}");
        @endif

    });
</script>

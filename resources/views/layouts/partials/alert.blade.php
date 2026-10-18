{{-- Notificaciones Flash con SweetAlert2 --}}
@php
    $flashIcon = null;
    $flashTitle = null;
    $flashTimer = 2000;

    if (session('success')) {
        $flashIcon = 'success';
        $flashTitle = session('success');
        $flashTimer = 1500;
    } elseif (session('error')) {
        $flashIcon = 'error';
        $flashTitle = session('error');
    } elseif (session('warning')) {
        $flashIcon = 'warning';
        $flashTitle = session('warning');
    } elseif (session('info')) {
        $flashIcon = 'info';
        $flashTitle = session('info');
    } elseif (isset($errors) && $errors->any()) {
        $flashIcon = 'error';
        $flashTitle = $errors->first();
        $flashTimer = 2500;
    }
@endphp

@if($flashIcon && $flashTitle)
<script>
    (function() {
        function triggerSwal() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    position: "center",
                    icon: @json($flashIcon),
                    title: @json($flashTitle),
                    showConfirmButton: false,
                    timer: {{ $flashTimer }},
                    heightAuto: false
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', triggerSwal);
        } else {
            triggerSwal();
        }
    })();
</script>
@endif

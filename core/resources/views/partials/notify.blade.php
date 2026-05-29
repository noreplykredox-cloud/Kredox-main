<link rel="stylesheet" href="{{ asset('assets/global/css/iziToast.min.css') }}">
<script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>
<style>
    /* ========== PREMIUM DARK RED & BLACK NOTIFICATIONS (iziToast) ========== */
    .iziToast {
        background: #0d0d0d !important;
        border-radius: 12px !important;
        border: 1px solid rgba(255, 0, 0, 0.15) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8), 0 0 20px rgba(255, 0, 0, 0.1) !important;
        padding: 18px 50px 18px 22px !important; /* Increased right padding */
        overflow: hidden !important;
        min-width: 320px !important;
        max-width: 420px !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }

    .iziToast::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 5px;
        background: linear-gradient(to bottom, #8b0000, #ff0000);
        box-shadow: 2px 0 10px rgba(255, 0, 0, 0.3);
    }

    /* Red (Error) Variant */
    .iziToast-color-red {
        background: #0d0d0d !important;
        border-color: rgba(255, 0, 0, 0.3) !important;
    }

    /* Green (Success) Variant */
    .iziToast-color-green {
        background: #0d0d0d !important;
        border-color: rgba(46, 204, 113, 0.3) !important;
    }
    .iziToast-color-green::after {
        background: linear-gradient(to bottom, #1e8449, #2ecc71) !important;
        box-shadow: 2px 0 10px rgba(46, 204, 113, 0.3);
    }

    .iziToast > .iziToast-body {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        margin: 0 !important;
    }

    .iziToast-icon {
        font-size: 24px !important;
        margin-right: 15px !important;
        color: #ff3333 !important;
        flex-shrink: 0 !important;
    }
    .iziToast-color-green .iziToast-icon { color: #2ecc71 !important; }

    .iziToast-texts { 
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        margin: 0 !important; 
        padding-right: 15px !important; 
    }
    .iziToast-title {
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 14px !important;
        margin-bottom: 2px !important;
        text-transform: uppercase !important;
        float: none !important;
        line-height: 1.2 !important;
        letter-spacing: 1px !important;
    }
    .iziToast-color-green .iziToast-title {
        color: #2ecc71 !important;
    }
    .iziToast-color-red .iziToast-title {
        color: #ff3333 !important;
    }
    .iziToast-message {
        color: #e0e0e0 !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        font-weight: 500 !important;
    }

    .iziToast-close { 
        color: #ffffff !important; 
        opacity: 1 !important; 
        top: 15px !important; /* Fixed at top */
        right: 15px !important;
        background: rgba(255, 255, 255, 0.15) !important;
        border-radius: 50% !important;
        width: 24px !important;
        height: 24px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        background-image: none !important; /* Clear default icon */
    }
    .iziToast-close::before {
        content: "\2715" !important; /* Clean X character */
        color: #fff !important;
        font-size: 14px !important;
        font-weight: bold !important;
        display: block !important;
    }
    .iziToast-close:hover { 
        background: rgba(255, 0, 0, 0.6) !important;
        transform: translateY(-50%) rotate(90deg) !important;
    }
    .iziToast-progressbar { display: none !important; }

    /* Mobile HUD Optimization */
    @media (max-width: 480px) {
        .iziToast {
            width: calc(100% - 30px) !important;
            margin: 15px !important;
            padding: 15px !important;
            left: 0 !important;
            min-width: 0 !important;
        }
        .iziToast-title { font-size: 15px !important; }
        .iziToast-message { font-size: 13px !important; }
    }
</style>
@if(session()->has('notify'))
    @foreach(session('notify') as $msg)
        <script>
            "use strict";
            iziToast.{{ $msg[0] }}({
                title: "{{ strtoupper($msg[0]) }}",
                message: "{{ $msg[0] == 'error' ? 'Oops! ' : '' }}{{ __($msg[1]) }}", 
                position: "topRight",
                close: true,
                icon: "{{ $msg[0] == 'error' ? 'fas fa-exclamation-circle' : ($msg[0] == 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle') }}"
            });
        </script>
    @endforeach
@endif

@if (isset($errors) && $errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $error)
        iziToast.error({
            title: "ERROR",
            message: "Oops! {{ __($error) }}",
            position: "topRight",
            close: true,
            icon: "fas fa-exclamation-circle"
        });
        @endforeach
    </script>

@endif
<script>
    "use strict";
    function notify(status, message) {
        let title = status === 'error' ? 'ERROR' : (status === 'success' ? 'SUCCESS' : status.toUpperCase());
        let iconCls = status === 'error' ? 'fas fa-exclamation-circle' : (status === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle');
        let finalMessage = status === 'error' ? 'Oops! ' + message : message;
        iziToast[status]({
            title: title,
            message: finalMessage,
            position: "topRight",
            close: true,
            icon: iconCls
        });
    }
</script>


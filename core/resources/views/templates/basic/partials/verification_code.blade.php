<div class="mb-3">
    
    <label>@lang('Verification Code')</label>
    
    <div class="verification-code">
        
<input type="text" name="code" id="verification-code" class="form-control overflow-hidden"
       required autocomplete="off" inputmode="numeric" pattern="\d*">
        <div class="boxes">
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
        </div>
    </div>
</div>


@push('style')
 
    <link rel="stylesheet" href="{{ asset('assets/global/css/verification-code.css') }}">
@endpush

@push('script')

    <script>
    $('#verification-code').on('input', function () {
        $(this).val(function (i, val) {
            // Remove any non-numeric characters
            val = val.replace(/\D/g, '');

            if (val.length >= 6) {
                val = val.substring(0, 6);
                $('.submit-form').find('button[type=submit]').html('<i class="fas fa-spinner fa-spin"></i> Verifying...');
                $('.submit-form').submit();
            }

            // Update the displayed boxes
            $('.boxes span').each(function (index) {
                $(this).html(val[index] || '-');
                if (index < val.length) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });

            return val;
        });
    });
</script>

        <style>
footer {
  display: none !important;
}
</style>
@endpush

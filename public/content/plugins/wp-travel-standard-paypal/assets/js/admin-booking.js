jQuery(document).ready(function($) {
    $("input[name='wp_travel_payment_mode']").on('click', function() {
        var form_field = $(this).closest('.wp-travel-form-field ');

        var trip_price = $('#wp-travel-trip-price').val();
        var payment_amount_field = $('#wp-travel-payment-amount');
        var payment_amount = payment_amount_field.val();
        var payment_mode = $(this).val();
        if (!form_field.is('[payment_amount]')) {
            form_field.attr('payment_amount', payment_amount);
        }
        var initial_payment_amount = form_field.attr('payment_amount');

        if ('full' === payment_mode) {
            if (trip_price > 0) {
                payment_amount_field.val(trip_price);
            }
        } else {
            payment_amount_field.val(initial_payment_amount);
        }

    });
});
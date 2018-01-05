jQuery(document).ready(function($) {
    function booking_price_field_display() {
        var price_filed = $('#wp-travel-payment-amount');
        var price_filed_info = $('#wp-travel-payment-amount-info');

        var payment_mode = $("input[name='wp_travel_payment_mode']:checked").val();
        var booking_option = $("input[name='wp_travel_booking_option']:checked").val();
        var is_partial_payment = $('#wp-travel-partial-payment').val();
        if ('full' !== payment_mode && 'booking_only' !== booking_option && 'yes' === is_partial_payment) {
            // price_filed.removeAttr('disabled').closest('.wp-travel-form-field ').show();
            price_filed.removeAttr('disabled').closest('.wp-travel-form-field ');

            price_filed_info.closest('.wp-travel-form-field ').show();
        } else {
            price_filed_info.closest('.wp-travel-form-field ').hide();
            var price_val = price_filed.val();
            if (!price_val) {
                price_val = 0;
            }
            price_val = parseFloat(price_val);
            var min_price_val = parseFloat(price_filed.attr('min'));
            if (price_val < min_price_val) {
                price_filed.val(min_price_val);
                price_filed_info.html(min_price_val);
            }
        }
    }

    function payment_mode_display() {
        // hide price field initially
        var price_filed = $('#wp-travel-payment-amount');
        var price_filed_info = $('#wp-travel-payment-amount-info');
        price_filed.attr('disabled', 'disabled').closest('.wp-travel-form-field ').hide();
        price_filed_info.closest('.wp-travel-form-field ').hide();
        $('#wp-travel-trip-price').closest('.wp-travel-form-field ').hide();

        var booking_option = $("input[name='wp_travel_booking_option']:checked").val();
        var payment_mode = $("input[name='wp_travel_payment_mode']");
        var booking_btn = $('#wp-travel-book-now');

        var trip_price = $('#wp-travel-trip-price_info');
        if (booking_option != 'booking_only' && undefined !== booking_option) {
            payment_mode.removeAttr('disabled').closest('.wp-travel-form-field ').show();
            booking_btn.val(wtp_texts.book_n_pay);
            trip_price.closest('.wp-travel-form-field ').show();
        } else {
            payment_mode.attr('disabled', 'disabled').closest('.wp-travel-form-field ').hide();
            booking_btn.val(wtp_texts.book_now);
            trip_price.closest('.wp-travel-form-field ').hide();
        }
        booking_price_field_display();
    }

    payment_mode_display();

    $("input[name='wp_travel_booking_option'], input[name='wp_travel_payment_mode']").on('change', function() {
        payment_mode_display();
    });

    $('#wp-travel-pax').on('change', function() {
        var no_of_pax = $(this).val();

        var price_per = $('#wp-travel-trip-price').attr('price_per');

        var trip_price = $('#wp-travel-trip-price').attr('trip_price');
        var payment_amount = $('#wp-travel-payment-amount').attr('min');

        var payment_mode = $("input[name='wp_travel_payment_mode']:checked").val();


        if ('person' === price_per) {
            trip_price = parseFloat(trip_price) * parseFloat(no_of_pax);
            payment_amount = parseFloat(payment_amount) * parseFloat(no_of_pax);
        }
        $('#wp-travel-trip-price').val(trip_price);
        // $('#wp-travel-payment-amount').val(payment_amount);
        trip_price = trip_price.toFixed(2);
        payment_amount = payment_amount.toFixed(2);
        var trip_price_info = $('#wp-travel-trip-price_info');
        var payment_amount_info = $('#wp-travel-payment-amount-info');
        trip_price_info.text(trip_price);
        payment_amount_info.text(payment_amount);
    });
});
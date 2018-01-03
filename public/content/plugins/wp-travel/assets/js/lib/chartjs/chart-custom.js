// var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var config = {
    type: 'line',
    data: {
        labels: JSON.parse(wp_travel_chart_data.labels),
        datasets: JSON.parse(wp_travel_chart_data.datasets)
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: wp_travel_chart_data.chart_title
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: false,
                    labelString: 'Year'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: false,
                    labelString: 'Value'
                }
            }]
        }
    }
};

window.onload = function() {
    var ctx = document.getElementById("wp-travel-booking-canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);
};

jQuery(document).ready(function($) {

    $('.wp-travel-max-bookings').html(wp_travel_chart_data.max_bookings);
    $('.wp-travel-max-pax').html(wp_travel_chart_data.max_pax);
    $('.wp-travel-top-countries').html(wp_travel_chart_data.top_countries);

    $('#datepicker-from').val(wp_travel_chart_data.booking_stat_from);
    $('#datepicker-to').val(wp_travel_chart_data.booking_stat_to);

    var edit_url = 'javascript:void(0)';
    if (wp_travel_chart_data.top_itinerary.id) {
        edit_url = 'post.php?post=' + wp_travel_chart_data.top_itinerary.id + '&action=edit';
    }
    $('.wp-travel-top-itineraries').attr('href', edit_url).html(wp_travel_chart_data.top_itinerary.name);

    $('#datepicker-from').datepicker({
        language: 'en',
        maxDate: new Date(),
        onSelect: function(dateStr) {
            newMinDate = null;
            newMaxDate = new Date();
            $('#datepicker-to').removeAttr('required');
            if ('' !== dateStr) {
                $('#datepicker-to').attr('required', 'required');
                new_date_min = new Date(dateStr);
                new_date_max = new Date(dateStr);

                newMinDate = new Date(new_date_min.setDate(new Date(new_date_min.getDate() + 1)));

                maxDate = new Date(new_date_max.setMonth(new Date(new_date_max.getMonth() + 1)));
                if (maxDate < newMaxDate) {
                    newMaxDate = maxDate;
                }
            }
            $('#datepicker-to').datepicker({
                minDate: newMinDate,
                maxDate: newMaxDate,
            });
        }
    }).attr('readonly', 'readonly');

    $('#datepicker-to').datepicker({
        language: 'en',
        maxDate: new Date(),
        onSelect: function(dateStr) {
            newMinDate = new Date();
            newMaxDate = null;
            $('#datepicker-from').removeAttr('required');
            if ('' !== dateStr) {
                $('#datepicker-from').attr('required', 'required');
                new_date_min = new Date(dateStr);
                new_date_max = new Date(dateStr);

                newMinDate = new Date(new_date_max.setMonth(new Date(new_date_max.getMonth() - 1)));
                newMaxDate = new Date(new_date_min.setDate(new Date(new_date_min.getDate() - 1)));

            }
            $('#datepicker-from').datepicker({
                minDate: newMinDate,
                maxDate: newMaxDate,
            });
        }

    }).attr('readonly', 'readonly');

    $('.stat-toolbar-form .dashicons-calendar-alt, .stat-toolbar-form .field-label').on('click', function() {
        $(this).closest('.field-group').children('.form-control').focus();
    });

    // Show more link on top country
    var showChar = wp_travel_chart_data.show_char;
    var ellipsestext = "..";
    var moretext = wp_travel_chart_data.show_more_text;
    var lesstext = wp_travel_chart_data.show_less_text;
    $('.wp-travel-more').each(function() {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

})
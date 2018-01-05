jQuery(document).ready(function($) {

    if ( wp_travel_chart_data.total_sales ) {
        $( '.wp-travel-total-sales' ).text(wp_travel_chart_data.total_sales)
    }
});
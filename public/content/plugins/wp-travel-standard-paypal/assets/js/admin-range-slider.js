jQuery(document).ready(function($) {
    if (!jQuery().slider)
        return;

    var slider = document.getElementById("minimum_partial_payout");
    var output = document.getElementById("minimum_partial_payout_output");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.value = this.value;
    }
});
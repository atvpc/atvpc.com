$(document).ready(function (){

    $('#stats dt').click(function() {

        if ( $('#stats dd').is(":hidden")) {
            $('#stats dt').hide();
            $('#stats dd').fadeIn(600);
        }
    });
});

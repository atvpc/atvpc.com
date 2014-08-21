$(document).ready(function (){

    // Question was clicked...
    $('.faq dt').click(function() {
        // Find the answer to the question clicked
        var answer = $(this).nextUntil('dt');
        
        // Hide answer if visible, or show it if not
        if (answer.is(":hidden")) {
            answer.show(600);
        }
        else {
            answer.hide(600);
        }
    });

});

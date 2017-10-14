$(document).ready(function (){
    $(window).scroll(function() {  
        if($(document).scrollTop() > 300){    
            $('#go-to-top').show(800, function (){
                $('#go-to-top a').fadeIn(600);
            });
        }
        else {
            if ( $('#go-to-top').is(':visible') ){
                $('#go-to-top a').fadeOut(800, function (){
                    $('#go-to-top').hide(600);
                });
            }
        }
    });
});

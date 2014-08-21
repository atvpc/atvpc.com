(function($){

    $.expr[':'].external = function(obj){
        return (obj.href != undefined) && (obj.href != '') && 
               !obj.href.match(/^mailto\:/) && !obj.href.match(/^#/) && 
               (obj.hostname != location.hostname);
    };

    $('main a:external').each(function() {
        $(this).addClass('link-external');
        $(this).attr('target', '_blank');
        $(this).attr('title', 'Link to external website: ' + $(this).attr('href'));
    });

    $('main a[href*="#"]').each(function() {
        $(this).addClass('link-anchor');
        $(this).attr('title', 'Internal page link');
    });

    $('main a[href*="mailto\:"]').each(function() {
        $(this).addClass('link-mailto');
        $(this).attr('title', 'E-mail: ' + $(this).attr('href'));
    });

})(jQuery);

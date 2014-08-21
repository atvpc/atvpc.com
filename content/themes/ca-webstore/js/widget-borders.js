$(document).ready(function() {
    $(".widget").each(function() {
        var content = $(this).html();
        
        content = '<div class="widget-border"><div class="widget-content">' + content + '</div></div>';

        $(this).html(content);
    });
});

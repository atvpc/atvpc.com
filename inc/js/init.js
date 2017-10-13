console.log('INFO: Starting JS/CSS Loader...');

// Load jQuery from Google's CDN, falling back to the local copy if needed
Modernizr.load([{
    load: '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
    complete: function () {
        if ( !window.jQuery ) {
            console.log('WARNING: Failed to load jQuery from CDN, falling back to local copy');
            Modernizr.load('inc/js/jquery.js');
        }

        var THEME_NAME = $('#theme-name').text();

        // Run this stuff when the DOM is done loading... 
        $(document).ready(function() {
            // Load Theme's JS 
            loadresource('content/themes/' + THEME_NAME + '/js/init.js');
        });
    }
}]);

// Our lazy loader function to load extra CSS and JS...
function loadresource(src) {
    var ext = src.split('.').pop().toLowerCase();
    var filename = src.split('/').pop();
    
    if (ext == "js") { //if filename is a external JavaScript file
        $.ajaxSetup({ cache: true, async: false });
        $.getScript(src, function() { 
            $.ajaxSetup({ cache: false, async: true });
        }).done(function( script, textStatus ) {
            console.log( 'SUCCESS: Loaded ' + filename);
        }).fail(function( jqxhr, settings, exception ) {
            if(arguments[0].readyState==0){
                console.log( 'ERROR: Could not load '  + filename);
            }
            else{
                console.log( 'ERROR: Parse error with ' + filename);
                console.log( '      ' + arguments[2].toString());
            }
        });
    }
    else if (ext == "css") { //if filename is an external CSS file
        console.log( 'APPEND: ' + filename);
        $("head").append('<link rel="stylesheet" href="' + src + '">');
    }
}

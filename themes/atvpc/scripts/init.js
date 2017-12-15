console.log('INFO: Starting JS/CSS Loader...');

// Load jQuery from Google's CDN, falling back to the local copy if needed
Modernizr.load([{
    load: '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
    complete: function () {
        if ( !window.jQuery ) {
            console.log('WARNING: Failed to load jQuery from CDN, falling back to local copy');
            Modernizr.load('inc/js/jquery.js');
        }
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

$(document).ready(function() {
    var THEME_NAME = $('#theme-name').text();

    // Load Link Labeler
    loadresource('themes/' + THEME_NAME + '/scripts/label-links.js');

    // Load txtBuch Credits Hider
    loadresource('themes/' + THEME_NAME + '/scripts/credits-hider.js');

    // TODO: fix when code is live
    //// Load Piwik Stats
    //loadresource('themes/' + THEME_NAME + '/scripts/piwik.js');
    //
    //// Google Analytics
    //loadresource('themes/' + THEME_NAME + '/scripts/google-analytics.js');


    // -=[ LAZY LOADER ]===============================================================================================-
    console.log('INFO: Lazy loading JS & CSS based on elements in page...');


    // Break out of jail... wait, I mean frames
    loadresource('themes/' + THEME_NAME + '/scripts/break-frames.js');


    // Load Browser Upgrade Notice
    loadresource('themes/' + THEME_NAME + '/jreject.css');
    loadresource('themes/' + THEME_NAME + '/scripts/jreject.js'),
    $.reject({ 
        reject : { msie9: true },      // block these browser versions
        closeCookie: true,             // use cookies to remmember if window was previously closed
        imagePath: 'themes/' + THEME_NAME + '/img/jreject/', // path where images are located
        overlayBgColor: '#4B000F',     // background color for overlay
        overlayOpacity: 0.7,           // Background transparency (0-1)
    });


    // Image Rotators
    if ($('#slider_makes').length != 0 || $('#slider_products').length != 0) {
        loadresource('themes/' + THEME_NAME + '/caroufredsel.css');
        loadresource('themes/' + THEME_NAME + '/scripts/caroufredsel.js');
        
        $('#slider_makes').removeClass('fouc');
        $('#slider_makes').carouFredSel({
                auto: true,
                direction: 'right',
                align: 'center',
                items: {
                    start: 'random', 
                    visible: 4, 
                    width: 100, 
                    height: 100
                },
                scroll: {
                    duration: 700, 
                    pauseOnHover: true
                }
        });

        $('#slider_products').removeClass('fouc');
        $('#slider_products').carouFredSel({
                auto: true,
                direction: 'left',
                align: 'center',
                items: {
                    start: 'random', 
                    visible: 4, 
                    width: 100, 
                    height: 100
                },
                scroll: {
                    duration: 700, 
                    pauseOnHover: true
                },
                synchronise: ["#slider_makes", true, false, 0]
        });
        
        
    }

    if ($('#slider').length != 0){
        loadresource('themes/' + THEME_NAME + '/nivo-slider.css');
        loadresource('themes/' + THEME_NAME + '/slider.css');
        loadresource('themes/' + THEME_NAME + '/scripts/nivo-slider.js');
        
        $('#slider').removeClass('fouc');
        $('#slider').nivoSlider({
                effect: 'boxRain',
                pauseTime: 6500,
                directionNav: false,
                controlNav: false,
                pauseOnHover: true,
                randomStart: true
        });
    }

    // Store Hours
    if ($('#store-hours').length != 0) {
        loadresource('themes/' + THEME_NAME + '/store-hours.css');
        loadresource('themes/' + THEME_NAME + '/scripts/moment.min.js');
        loadresource('themes/' + THEME_NAME + '/scripts/moment-timezone-with-data.min.js');
        loadresource('themes/' + THEME_NAME + '/scripts/store-hours.js');
    }

    // TODO: convert PHP to JS
    // Content Reloader
    //if ($('#testimonials').length != 0) {
    //    loadresource('themes/' + THEME_NAME + '/testimonials.css');
    //    loadresource('themes/' + THEME_NAME + '/scripts/content-reloader.js');
    //}

    // Modal Window Image Zoom
    if ($('a.gallery').length != 0) {
        loadresource('themes/' + THEME_NAME + '/colorbox.css');
        loadresource('themes/' + THEME_NAME + '/scripts/colorbox.js');
        
        $("a.gallery").colorbox({opacity: .5});
    }

    // Back to Top of Page
    if ($('#go-to-top').length != 0) {
        loadresource('themes/' + THEME_NAME + '/go-to-top.css');
        loadresource('themes/' + THEME_NAME + '/scripts/go-to-top.js');
    }

    // Email Deobfuscator
    if ($('a.deobfuscate').length != 0) {
        loadresource('themes/' + THEME_NAME + '/scripts/deobfuscate.js');
    }

    // FAQ Dropdowns
    if ($('.faq').length != 0) {
        loadresource('themes/' + THEME_NAME + '/faq.css');
        loadresource('themes/' + THEME_NAME + '/scripts/faq.js');
    }
});

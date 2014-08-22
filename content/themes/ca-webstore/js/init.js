var THEME_NAME = $('#theme-name').text();

// Load Link Labeler
loadresource('content/themes/' + THEME_NAME + '/js/label-links.js');

// Load Stats Hider
loadresource('content/themes/' + THEME_NAME + '/js/stats-hider.js');


// -=[ LAZY LOADER ]===============================================================================================-
console.log('INFO: Lazy loading JS & CSS based on elements in page...');


// Break out of jail... wait, I mean frames
loadresource('content/themes/' + THEME_NAME + '/js/break-frames.js');


// Load Browser Upgrade Notice
loadresource('content/themes/' + THEME_NAME + '/css/jreject.css');
loadresource('content/themes/' + THEME_NAME + '/js/jreject.js'),
$.reject({ 
	reject : { msie9: true },      // block these browser versions
	closeCookie: true,             // use cookies to remmember if window was previously closed
	imagePath: 'content/themes' + THEME_NAME + 'img/jreject/', // path where images are located
	overlayBgColor: '#4B000F',     // background color for overlay
	overlayOpacity: 0.7,           // Background transparency (0-1)
});


// Image Rotators
if ($('#slider_makes').length != 0 || $('#slider_products').length != 0) {
	loadresource('content/themes/' + THEME_NAME + '/css/caroufredsel.css');
	loadresource('content/themes/' + THEME_NAME + '/js/caroufredsel.js');
	
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
    loadresource('content/themes/' + THEME_NAME + '/css/nivo-slider.css');
    loadresource('content/themes/' + THEME_NAME + '/css/slider.css');
    loadresource('content/themes/' + THEME_NAME + '/js/nivo-slider.js');
    
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

// Content Reloader
if ($('#hours').length != 0 || $('#testimonials').length != 0) {
    loadresource('content/themes/' + THEME_NAME + '/css/store-hours.css');
    loadresource('content/themes/' + THEME_NAME + '/css/testimonials.css');
    loadresource('content/themes/' + THEME_NAME + '/js/content-reloader.js');
}

// Modal Window Image Zoom
if ($('a.gallery').length != 0) {
    loadresource('content/themes/' + THEME_NAME + '/css/colorbox.css');
    loadresource('content/themes/' + THEME_NAME + '/js/colorbox.js');
    
    $("a.gallery").colorbox({opacity: .5});
}

// Back to Top of Page
if ($('#go-to-top').length != 0) {
    loadresource('content/themes/' + THEME_NAME + '/css/go-to-top.css');
    loadresource('content/themes/' + THEME_NAME + '/js/go-to-top.js');
}

// Email Deobfuscator
if ($('a.deobfuscate').length != 0) {
    loadresource('content/themes/' + THEME_NAME + '/js/deobfuscate.js');
}

// FAQ Dropdowns
if ($('.faq').length != 0) {
	loadresource('content/themes/' + THEME_NAME + '/css/faq.css');
    loadresource('content/themes/' + THEME_NAME + '/js/faq.js');
}

// Google Analytics
loadresource('content/themes/' + THEME_NAME + '/js/analytics.js');

$(document).ready(function (){
	
	$('#hours').load('content/themes/ca-webstore/php/store-hours.php');
	
	var refresh = setInterval(function(){
		$('#hours').load('content/themes/ca-webstore/php/store-hours.php');
		console.log('INFO: Refreshing store hours div...');
	}, 180000); // every 3 minutes

	$('#testimonials').load('content/themes/ca-webstore/php/testimonials.php');
	
	var refresh = setInterval(function(){
		console.log('INFO: Refreshing testimonials div...');
		$('#testimonials').fadeOut('slow', function(){
			$(this).load('content/themes/ca-webstore/php/testimonials.php', 'data', function(){
				$(this).fadeIn('slow');
			});
		});	
	}, 6000); // every 6 seconds

});

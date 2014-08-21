<?php
    $hours = parse_ini_file('../../../hours.ini', TRUE);

	$today   = strtolower(date('l'));
	$time    = date('Gi');

	// Closed: entire day of week
	if ($hours[$today]['open'] == $hours[$today]['close']) {
		$text    = '<div id="hours_status" class="closed">Closed</div>';
		$caption = 'Sorry, we\'re closed on ' . date('l') . 's';
	}
	// Closed: after hours
	elseif ($time < $hours[$today]['open'] || $time >= $hours[$today]['close']) {
		$text    = '<div id="hours_status" class="closed">Closed</div>';
		$caption = 'Sorry, we\'re closed for the day';
	}
	// Closed: holiday
	elseif (isset($hours['holiday']['0000-' . date('m-d')]) || 
	        isset($hours['holiday'][date('Y-m-d')])) {
		$text = '<div id="hours_status" class="closed">Closed</div>';
		$caption = 'Sorry, we\'re closed for the holiday';
	}
	// Open: Opening for half an hour
	elseif ($time - $hours[$today]['open'] <= 30) {
		$text    = '<div id="hours_status" class="warn">Opening</div>';
		$caption = 'If you call is not answered, please try back in a few minutes';
	}
	// Open: Closing in 15 minutes
    elseif ($hours[$today]['close'] - $time - 40 <= 15) {
		$text    = '<div id="hours_status" class="warn">Closing</div>';
		$caption = 'Technical assistance and returns may be asked to call back on the next buisness day';
	}
	else {
		$text    = '<div id="hours_status" class="open">Open</div>';
		$caption = 'Have a question? Call us, we\'re open!';
	}
	
	
	// Determine Shipping
	if ($hours[$today]['shipping'] == 0 || $time >= $hours[$today]['shipping']) {
		if (strpos($text, 'Closed') !== FALSE){
			$text .= '<div id="hours_shipping">Orders Placed Online<br>Ship Next Buisness Day</div>';
		}
		else {
			$text .= '<div id="hours_shipping">Orders Placed Now<br>Ship Next Buisness Day</div>';
		}
	}
	else {
		$text .= '<div id="hours_shipping">Orders Placed Now<br>Ship Today</div>';
	}
	

	// Put everything together and output it...
	echo '<div id="hours" title="' . $caption . '">' . $text . '</div>';
?>

<?php

	$events[] = array('name'  => 'AIMExpo',
					  'url'   => 'http://www.aimexpousa.com',
	                  'start' => '2014-10-16',
					  'end'   => '2014-10-19');

	$upcoming = array();
	foreach ($events as &$event) {
		$today = date_create(date('Y-m-d'));
		$start = date_create($event['start']);
		$end   = date_create($event['end']);
		
		if ($today <= $end) {
			$event['until'] = date_diff($today, $start)->format('%R%a') + 0;
			$upcoming[] = $event;
		}
	}

	if (count($upcoming) > 0) {
		$upcoming = array_sortby($upcoming, 'until');
		
		$event = $upcoming[0];
		
		$img   = 'content/img/events/' . strtolower($event['name']) . '.jpg';
		echo '<a href="' . $event['url'] . '"><img src="' . $img . '" alt="' . $event['name'] . '"></a><br>';
		
		if ($event['until'] <= 0) {
			echo '<span style="color: #1E6997">ATV Parts Connection</span> is currently at<br>' . $event['name'] . '. Stop by and talk to a representative today!';
	    }
		else if ($event['until'] == 1) {
			echo '<span style="color: #1E6997">ATV Parts Connection</span> will be at<br>' . $event['name'] . ' tomorrow!';
		}
		else if ($event['until'] <= 10) {
			echo '<span style="color: #1E6997">ATV Parts Connection</span> will be at<br>' . $event['name'] . ' in ' . $event['until'] . ' days!';
		}
		else {
			echo '<span style="color: #1E6997">ATV Parts Connection</span> will be at<br>' . $event['name'] . ' on ' . date('F jS', strtotime($event['start'])) . '.';
		}
		
	}
?>

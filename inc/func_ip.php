<?php

function better_ip2long($ip) {
	if (filter_var($ip, FILTER_VALIDATE_IP)) {
		return (float) sprintf("%u", ip2long($ip));
	}
	else {
		return FALSE;
	}
}

function log_ip() {
	$ip      = better_ip2long($_SERVER['REMOTE_ADDR']); 
	$ip_file = 'content/db/visitors/ips/' . $ip . '.dat';
	
	if (file_exists($ip_file)) {
		$data = read_flatfile($ip_file);
		
		$data['last_seen'] = time();
		$data['visits']++;
		
		if (!in_array($_SERVER['HTTP_REFERER'], $data['referers'])) {
			$data['referers'][] = $_SERVER['HTTP_REFERER'];
		}
		if (!in_array($_SERVER['HTTP_USER_AGENT'], $data['user_agents'])) {
			$data['user_agents'][] = $_SERVER['HTTP_USER_AGENT'];
		}
		
		write_flatfile($ip_file, $data);
	}
	else {
		$data = array('ip'          => $_SERVER['REMOTE_ADDR'], // intentionally using this instead of ip2long result
					  'first_seen'  => time(),
					  'last_seen'   => time(),
					  'visits'      => 1,
					  'referers'    => array($_SERVER['HTTP_REFERER']),
					  'user_agents' => array($_SERVER['HTTP_USER_AGENT'])
					 );
					 
		write_flatfile($ip_file, $data);
		update_unique();
	}
	
	update_total();
	update_online($ip);
}

function update_unique() {
	$unique_file = 'content/db/visitors/unique.dat';
	
	if (file_exists($unique_file)) {
		$data = read_flatfile($unique_file);
		$data++;
	}
	else {
		$data = 1;
	}
	
	write_flatfile($unique_file, $data);
}

function update_total() {
	$total_file = 'content/db/visitors/total.dat';
	
	if (file_exists($total_file)) {
		$data = read_flatfile($total_file);
		$data++;
	}
	else {
		$data = 1;
	}
	
	write_flatfile($total_file, $data);
}

function update_online($ip) {
	$online_file = 'content/db/visitors/online.dat';
	
	if (file_exists($online_file)) {
		$data = read_flatfile($online_file);
		
		// Set the client's visit time to now
		$data[$ip] = time();

		// Remove old visitors
		foreach ($data as $ip => $last_seen) {
			if (time() - $last_seen > 300) { // Older than 5 minutes
				unset($data[$ip]);
			}
		}

		write_flatfile($online_file, $data);
	}
	else {
		$data = array();
		$data[$ip] = time();
		
		write_flatfile($online_file, $data);
	}
}

?>

<?php

function log_error($event, $context) {
	$severity = array(1 => array('name'    => 'Emergency',
								 'key'     => 'panic',
								 'desc'    => 'System is unusable',
								 'example' => 'condition usually affecting multiple apps and sites'),
					  2 => array('name'    => 'Alert',
								 'key'     => 'alert',
								 'desc'    => 'immediate action is required',
								 'example' => 'entire website down, database unavailable'),
					  3 => array('name'    => 'Critical',
								 'key'     => 'crit',
								 'desc'    => 'critical conditions',
								 'example' => 'app component unavailable, unexpected exception'),
					  4 => array('name'    => 'Error',
								 'key'     => 'err',
								 'desc'    => 'error conditions',
								 'example' => 'errors that do not require immediate attention but should be monitored'),
					  5 => array('name'    => 'Warning',
								 'key'     => 'warn',
								 'desc'    => 'unusual or undesirable occurrences that are not errors',
								 'example' => 'deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong'),
					  6 => array('name'    => 'Notice',
								 'key'     => 'notice',
								 'desc'    => 'normal but significant events',
								 'example' => 'Events that are unusual but not errors conditions; might be summarized in an email to developers to spot potential problems'),
					  7 => array('name'    => 'Informational',
								 'key'     => 'info',
								 'desc'    => 'Informational messages',
								 'example' => 'interesting events such as a user logs in, SQL logs, etc'),
					  8 => array('name'    => 'Debug',
								 'key'     => 'debug',
								 'desc'    => 'Debug-level messages',
								 'example' => 'info useful to developers for debugging the application, not useful during operations.')
					 );
	 
	$msg = '{pri} {time} {ip} ';
	
	switch ($event){
		case 'newuser':
			$pri = 7;
			$msg .= 'user {username} created';
			break;
			
		case '404':
			$pri = 7;
			$msg .= 'file not found: {file} from {referer}';
			break;
			
		default:
			$pri = 8;
			$msg .= '{msg}';
	}
	
	$context['pri']  = $pri;
	$context['ip']   = $_SERVER['REMOTE_ADDR'];
	$context['time'] = date('[Y-m-d H:i:s]');
	
	// Interpolates context values into the message placeholders
	foreach ($context as $key => $value){
		$msg = str_replace('{'. $key .'}', $value, $msg);
	}
	
	$log = $msg . "\n";
	file_put_contents('content/syslog.log', $log, FILE_APPEND);
}

function minify_code($source, $extension, $stats = FALSE){
    $source   = win2unix($source);
    $source   = str_replace("\t", '    ', $source);

    switch ($extension) {
        case 'html':
            $minified = preg_replace('/<!--[\s\S]*?-->/m', '', $source);
            break;
        case 'css':
            $minified = preg_replace('/\/\*[\s\S]*?\*\//m', '', $source);
            $minified = trim_lines($minified);
            $minified = str_replace("\n", "\t", $minified);
            break;
        case 'js':
            $minified = preg_replace('/\/\*[\s\S]*?\*\//m', '', $source);
            $minified = trim_lines($minified);
            break;
        default:
            $minified = $source;
    }

    if ($stats == TRUE) {
        $original_size    = strlen($source);
        $compress_size    = strlen($minified);
        $compress_percent = 100 - ceil((strlen($minified) / strlen($source)) * 100) . '%';

        switch ($extension) {
            case 'html':
                $display = preg_replace('/(<!--[\s\S]*?-->)/m', '~~{$1}~~', $source);
                break;
            case 'css':
                $display = preg_replace('/(\/\*[\s\S]*?\*\/)/m', '~~{$1}~~', $source);
                break;
            case 'js':
                $display = preg_replace('/(\/\*[\s\S]*?\*\/)/m', '~~{$1}~~', $source);
                $display = preg_replace('/[^:](\/\/[\s\S]*?\n)/', '~~{$1}~~', $display);
                break;
        }        

        $lines   = explode("\n", $display);
        foreach ($lines as &$line) {
            if ($line == ''){
                $line = '~~{&nbsp;}~~';
            }
            else if ($line[0] == ' '){
                $spaces = '';
                $i = 0;
                while ($line[$i] == ' ' && $i < strlen($line) - 1){
                    $spaces .= '&nbsp;';
                    $i++;
                }

                $spaces  = '~~{' . $spaces . '}~~';
                $line = $spaces . str_replace(' ', '&nbsp;', substr($line, $i)); 
            }
        }
        $display = implode('<br>', $lines);
        
        $display = str_replace('~~{', '<span style="background-color: #FF8080">', $display);
        $display = str_replace('}~~', '</span>', $display);
        
        return <<< DISPLAY
<table>
    <tr><td>Original: </td><td>$original_size characters</td></tr>
    <tr><td>Compressed: </td><td>$compress_size characters ($compress_percent)</td></tr>
</table>

<p>
    Spaces, tabs, new lines, and comments are removed during the minification process. The original source code is below, 
    with these removals highlighted in red.
</p>

<hr>

<div style="font-family: monospace">$display</div>
DISPLAY;
    }
    else {
        return $minified;
    }
}

function ls_dir($dir, $allowed = '*'){
    $files = scandir($dir);

    if (is_array($allowed) == FALSE){
        $extension = $allowed;
        $allowed = array($extension);
    }

    foreach ($files as $file){
        if ($file == '.' || $file == '..'){
             unset($files[$file]);
        }
        else if ($allowed[0] != '*'){
            if ( in_array(pathinfo($file, PATHINFO_EXTENSION), $allowed) == FALSE){
                unset($files[$file]);
            }
        }
    }

    return $files;
}

function count_files($dir){
    $i = 0;

    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
                $i++;
        }
    }

    return $i;
}

?>

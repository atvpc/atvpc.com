<?php

// For Development, remove later...
ini_set('display_errors', 'ON');
ini_set('error_reporting', E_ALL);

$c = parse_ini_file('content/config.ini', true);
$c['page']['stime'] = microtime(TRUE);

// -=[ INCLUDES ]======================================================================================================-
include 'func_security.php';
include 'func_strarr.php';
include 'func_files.php';
include 'func_datetime.php';
include 'func_page.php';
include 'func_theme.php';

/* -=[ SET CONSTANTS ]=================================================================================================-
 * Set constants that require the above included
 */
 
$c['date']['year'] = date('Y');

// Site copyright start
if (isset($c['site']['established']) && $c['site']['established'] != '') { 
    $c['site']['established'] .= '-';
}
else { 
    $c['site']['established'] = '';
}

// Set the site owner to the site name if it isn't specifically set
if (!isset($c['site']['owner']) || $c['site']['owner'] == '') {
    $c['site']['owner'] = $c['site']['name'];
}

// Include a mailto link with the site owner's name if an email provided
if (isset($c['site']['email']) && $c['site']['email'] != '') {
    
    // Obfuscate the email address if wanted
    if ($c['security']['protect-email'] == TRUE) {
        $c['site']['owner'] = '<a href="mailto:' . encode_mailto_email($c['site']['email']) .'">' . $c['site']['owner'] . '</a>';
    }
    else {
        $c['site']['owner'] = '<a href="mailto:' . $c['site']['email'] .'">' . $c['site']['owner'] . '</a>';
    }
}

?>

<?php

function is_https(){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function browser_info($agent=null) {
    /* Detects common browsers and versions.
     * This function is lighter and faster than the built-in get_browser() that requires a 4MB+ browscap.ini
     * 
     * Based off the examples at http://php.net/manual/en/function.get-browser.php
     */ 
    
    $browsers = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
    
    /* Find the version number for the browser matching different patterns ("Firefox/2.0" or "MSIE 6.0"). Minor version
     * numbers are ignored ("2.0.0.6" is parsed as "2.0")
     */ 
    $agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
    $pattern = '#(?<browser>' . join('|', $browsers) .')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
    
    if (!preg_match_all($pattern, $agent, $matches)) return array();
    
    /* Some user agents include compatible with browsers (Firefox says it's Gecko and Opera 7 says it's IE), ignore 
     * these and use the last one found
     */ 
    $i = count($matches['browser'])-1;
    return array($matches['browser'][$i] => $matches['version'][$i]);
}

function get_ip(){
    $ip = $_SERVER['REMOTE_ADDR'];

    // Proxy IPs
    if (isset($_SERVER['HTTP_CLIENT_IP']))           $proxy_ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 

    // See if Proxy IP isn't a reserved or private network
    if (isset($proxy_ip)){
        $reserved = array('0.',                         // RFC 1700
                          '10.',                        // RFC 1918
                          '100.64.0.0-100.127.255.255', // RFC 6598
                          '127.',                       // RFC 6890
                          '169.254.',                   // RFC 6890
                          '172.16.0.0-172.31.255.255',  // RFC 1918
                          '192.0.0.0-192.0.0.7',        // RFC 6333
                          '192.0.2',                    // RFC 5737
                          '192.88.99',                  // RFC 6333
                          '192.168.',                   // RFC 1918
                          '198.18.0.0-198.19.255.255',  // RFC 2544
                          '198.51.100.',                // RFC 5737
                          '203.0.113.',                 // RFC 5737
                          '224.0.0.0-255.255.255.255'   // RFC 5771, RFC 6890
                         );
        
        $private = FALSE;
        foreach ($reserved as $subnet) {
            if (in_array($subnet, array('-', '*'))) {
                if (ip_in_range($subnet) == TRUE) $private = TRUE;
            }
            else {
                $len = strlen($subnet);
            
                if (substr($proxy_ip, 0, $len) == substr($subnet, 0, $len)) {
                    $private = TRUE;
                    break;
                }
            }
        }

        if ($private == FALSE) return $proxy_ip;
        else                   return $ip;
    }
    else {
        return $ip;
    }
}

Function ip_in_range($ip, $range) {
/* $ip    = the needle, a valid IP address (ex: 192.168.0.1) 
 * $range = the haystack, any valid IP range in wildcard format (ex: 192.168.*.*)
 *          or start and end IP (ex: 192.168.0.0-192.168.255.255)         
 */ 
    if (strpos($range, '*') !== FALSE) { // wildcard format, convert to start and end IP
        $start = str_replace('*', '0', $range);
        $end   = str_replace('*', '255', $range);
    }
    else { // start and end IP format
        list($start, $end) = explode('-', $range, 2);
    }
    
    // Convert 
    $start  = (float) sprintf("%u",ip2long($start));
    $end    = (float) sprintf("%u",ip2long($end));
    $ip     = (float) sprintf("%u",ip2long($ip));

    return ($ip >= $start && $ip <= $end);
}

function log_ip(){
    global $c;
    
    $ip = get_ip();
    
    if (sql_checkVisitorLogged($ip) == FALSE) { // Visitor has not been logged
        if (sql_checkVisitorNew($ip) == FALSE) { // Returning Old Visitor
            sql_chgVisitorCount($ip);
        }
        else { // New Visitor
            sql_addVisitor($ip);
        }
    }
    else { // Visitor has already been logged
        sql_chgVisitorLastSeen($ip);
    }
}

?>

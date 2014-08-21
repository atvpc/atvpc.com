<?php

function runtime(){
    global $c;

    return round(microtime(TRUE) - $c['page']['stime'], 3, PHP_ROUND_HALF_UP);
}

function human_time($time){
    return date('F j, Y \a\t g:ia', $time);
}

function human_time_diff($date1, $date2 = NULL, $verbose = FALSE){
    if ($date2 == NULL) $date2 = time();
    
    $diff = abs($date1 - $date2);

    $units = array('year'   => 31556952,
                   'month'  => 2628000,
                   'week'   => 604800,
                   'day'    => 86400,
                   'hour'   => 3600,
                   'minute' => 60,
                   'second' => 1);

    $output = '';
    
    foreach ($units as $unit => $seconds){
        $multiplier = floor($diff / $seconds);
        
        if ($multiplier > 0){
            $diff -= ($multiplier * $seconds);
            
            if ($multiplier > 1) $unit .= 's';
            
            if ($verbose == FALSE) return $multiplier . ' ' . $unit;
            
            $output .= $multiplier . ' ' . $unit . ' '; 
        }
    }

    return trim($output);
}

?>

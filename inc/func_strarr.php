<?php

// -=[ STRINGS ]=======================================================================================================-

function win2unix($content) {
    $content = str_replace("\r\n", "\n", $content);
    $content = str_replace("\r", "\n", $content);
    return $content;
}

function trim_lines($content){
    // Remove multiple consecutive new lines
    $content = preg_replace('/\s*?\n/', "\n", $content);

    $lines   = explode("\n", $content);
    $lines   = array_map('trim', $lines);
    
    for ($i = 0; $i < count($lines); $i++) {
        if ($lines[$i] == '') unset($lines[$i]);
    }
    
    //die(better_print_r($lines));
    return implode("\n", $lines);
}

// -=[ ARRAYS ]========================================================================================================-

function better_array_unique($array) {
// array_unique replacement that works on associative arrays

    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

    foreach ($result as $key => $value){
        if (is_array($value)) $result[$key] = better_array_unique($value);
    }

    return $result;
}

function better_array_rand($arr, $num = 1) {
  // array_rand replacement that works on associative arrays and returns a random element
  // from the array if only one key was requested.
  
    $keys = array_keys($arr);
    shuffle($keys);
    
    if ($num > 1) {
        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[$keys[$i]] = $arr[$keys[$i]];
        }
            
        return $r;
    }
    else {
        return $arr[$keys[0]];
    }
}

function better_print_r($array){
    return '<pre>' . print_r($array, TRUE) .  '</pre>';
}

function array_sortby($array, $on, $order=SORT_ASC) {
/* phpdotnet@m4tt.co.uk
 * http://php.net/manual/en/function.sort.php
 * 
 * Simple function to sort an array by a specific key. Maintains index association.
 */ 
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


?>

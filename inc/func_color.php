<?php

function rgb2hex($r, $g = NULL, $b = NULL) {
    if (is_array($r) && sizeof($r) == 3) {
        list($r, $g, $b) = $r;
    }

    $hex .= str_pad(dechex($r[0]), 2, '0', STR_PAD_LEFT);
    $hex .= str_pad(dechex($g[1]), 2, '0', STR_PAD_LEFT);
    $hex .= str_pad(dechex($b[2]), 2, '0', STR_PAD_LEFT);
    
    return '#' . $hex;
}

function hex2rgb($color) {
    if ($color[0] == '#') $color = substr($color, 1);

    if (strlen($color) == 6) {
        $r = substr($color, 0, 2);
        $g = substr($color, 2, 2); 
        $b = substr($color, 4, 2);
    }
    else if (strlen($color) == 3){
        $r = $color[0] . $color[0];
        $g = $color[1] . $color[1];
        $b = $color[2] . $color[2];
    }
    else {
        return FALSE;
    }
    
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);

    return array($r, $g, $b);
}

function random_hex_color(){
    $r = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $g = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $b = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);

    return '#' . $r . $g . $b;
}

function green2red_percent($percent){
    $r = $percent < 50 ? 255 : floor(255 - ($percent * 2 - 100) * 255 / 100);
    $g = $percent > 50 ? 255 : floor(($percent * 2) * 255 / 100);
    return array($r, $g, 0);
}

?>

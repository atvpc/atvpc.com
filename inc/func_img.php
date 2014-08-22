<?php

function hash2avatar($hash, $size = 'medium', $squares = 3, $padding = 0){

    if (!is_numeric($size)) {
        $sizes = array('micro' => 16,  'mini' => 24,   'icon' => 48, 
                       'small'  => 64, 'medium' => 96, 'large'  => 128);
               
        if (array_key_exists($size, $sizes)) $size = $sizes[$size];
        else die('Unknown size: ' . $size);
    }

    $im = imagecreatetruecolor($size, $size);


    // Allocate the colors
    $color_trans  = imagecolorallocatealpha($im, 255, 255, 255, 127);
    $color_filled = bettercolorallocate($im, substr($hash, 0, 6));
    $color_blank  = bettercolorallocate($im, substr($hash, 6, 6));
    $color_border = bettercolorallocate($im, substr($hash, 12, 6));

    // Set transparent background
    imagesavealpha($im, true);
    imagefill($im, 0, 0, $color_trans);

    $interval = round($size / $squares) + round($padding / 4); // Spacing between squares
    $padding += 1; // Fix glitch with even numbers

    $spare_hex = substr($hash, 18);

    for ($x = 0; $x < $squares; $x++) {    
        for ($y = 0; $y < $squares; $y++) {
            if ($x == 0) $x1 = $x * $interval;
            else         $x1 = $x * $interval;

            if ($y == 0) $y1 = $y * $interval;
            else         $y1 = $y * $interval;

            $x2 = ($x1 + $interval) - $padding;
            $y2 = ($y1 + $interval) - $padding;
        
            $hex = $spare_hex[0];
            $spare_hex = substr($spare_hex, 1);
            if (hexdec($hex) % 2 == 0) $color = $color_filled;
            else $color = $color_blank;

            imagefilledrectangle($im, $x1, $y1, $x2, $y2, $color);
        
            if ($padding > 1){
                imagerectangle($im, $x1, $y1, $x2, $y2, $color_border);
            }
        }
    }

    ob_start();
    imagepng($im);
    imagedestroy($im);
    $data = ob_get_contents();
    ob_end_clean();
    
    return $data;
}

function bettercolorallocate($im, $color) {
    if (!is_array($color)) $color = hex2rgb($color);
    
    list($r, $g, $b) = $color;
    
    return imagecolorallocate($im, $r, $g, $b);
}

?>

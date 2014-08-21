<?php

function better_password_hash($algo, $password, $salt='', $rounds=1){
/* Built-in functions more or less suck:
 *   md5(), sha1()   Your algorithms are bad and you should feel bad. Why not zoidberg() instead?
 * 
 *   password_hash() Mostly recommended because it forces the use of a salt and multiple rounds make it slow. However, 
 *                   it only uses Eksblowfish (bcrypt), based on blowfish. Bruce Schneier (blowfish's creator) does 
 *                   not recommend using it.
 *   
 *   crypt()         Allows for different algorithms, but it defaults to DES. Does not have multiple rounds or salt
 *   
 *   hash_pbkdf2()   Allows for different algorithms, salts, and rounds but it's newer and not all servers support it. 
 *                   Salts are limited to a size and not automatically generated. Output is not designed to be stored 
 *                   as it does not include the rounds, algorithm, and salt used like password_hash().
 * 
 * better_password_hash()
 *   - All PHP hash algorithms supported
 *   - Salting is support, generated automatically, and not size limited
 *   - Multiple rounds are supported
 *   - Output suitable for storage like password_hash()
 */ 

    if ($salt == ''){
        switch ($algo) {
            case 'md5':
                $bytes = 32;
                break;
            case 'sha1':
                $bytes = 40;
                break;
            case 'whirlpool':
                $bytes = 128;
                break;
            default: 
                // sha256, tiger128, ripemd160, etc...
                $bits = preg_split('#([\W]+|[\d]+)#i', $algo, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
                $bits = $bits[count($bits) - 1];

                if ( is_numeric($bits) && $bits % 8 == 0) {
                    $bytes = (int) $bits / 8;
                }
                // unknown algorithm, default to 512 bits
                else {
                    $bytes = 64;
                }
        }
        
        $salt = bin2hex(rand_bytes($bytes));
    }
    
    $hash = hash($algo, $salt . $password);
    
    for ($i = 1; $i < $rounds; $i++) {
        $hash = hash($algo, $hash);
    }
    
    return '$'. $algo .'$'. $rounds .'$'. $salt .'.'. $hash;
}

function better_password_verify($password, $hash) {
    list($null, $algo, $rounds, $password_hash) = explode('$', $hash);
    list($null, $salt) = explode('.', $password_hash);
    
    $password = better_password_hash($algo, $password, $salt, $rounds);

    if ($hash == $password) return 'TRUE';
    else                    return 'FALSE';
}

function calculate_rounds($target_time = .5) {
    $rounds = 0;
    $start = microtime(true);
    do {
        $rounds++;
        better_password_hash('sha256', 'abc123', '', $rounds);
    }
    while ((microtime(true) - $start) < $target_time);

    return $rounds;
}

function encode_email($email) {
	return '<a href="mailto:'. encode_mailto_email($email) .'">'. encode_printed_email($email) .'</a>';
}

function encode_printed_email($email){
    $encoded = '';

    $email = str_split($email);

    foreach($email as $char){
        switch (mt_rand(0, 2)){
            case 0:
                $encoded .= $char;
                break;

            case 1:
                $encoded .= '&#' . ord($char) . ';';
                break;

            case 2:
                $encoded .= $char . '<span style="display: none">' . rand_letters(3, TRUE) . '</span>';
                break;
        }
	}
	
	return str_replace('@', '&#64;', $encoded);
}

function encode_mailto_email($email) {
    $encoded = '';

    $email = str_split($email);

    foreach($email as $char){
        switch (mt_rand(0, 2)){
            case 0:
                $encoded .= $char;
                break;

            case 1:
                $encoded .= '&#' . ord($char) . ';';
                break;

            case 2:
                $encoded .= '%' . str_pad(dechex(ord($char)), 2, '0', STR_PAD_LEFT);
                break;
        }
    }

    return str_replace('@', '&#64;', $encoded);
}

function rand_letters($num, $rand = FALSE){
	$letters = '';
	
	if ($rand !== FALSE ){
		$num = mt_rand(1, $num);
	}
	
	for ($i = 0; $i < $num; $i++){
		$letters .= chr(97 + mt_rand(0, 25));
	}
	
	return $letters;
}

function make_password($length = 8, $pronounceable = FALSE){
    $vowels           = 'aeiou';
    $consonants       = 'bcdfghjklmnpqrstvwxyz';
    $easy_consonants  = 'bcdfghjklmnprstvwyz';   // easy to speak consonants
    $symbols          = '!?()<>[]{}/\-+*=#%&~.,;:@^_|';
    
    $password = '';

    if ($pronounceable == FALSE) {
        for ($i = 0; $i < $length; $i++) {
            switch (better_rand(1,4)){
                case 1:
                    $password .= $consonants[ better_rand( 0, strlen($consonants) - 1 ) ];
                    break;
                case 2:
                    $password .= $vowels[ better_rand( 0, strlen($vowels) - 1 ) ];
                    break;
                case 3:
                    $password .= $symbols[ better_rand( 0, strlen($symbols) - 1 ) ];
                    break;
                case 4:
                    $password .= better_rand(0, 9);
                    break;
            }
        }
    }
    else {
        $even = $easy_consonants;
        $odd  = $vowels;

        if (better_rand(1, 2) == 2) {
            list($even, $odd) = array($odd, $even);
        }

        for ($i = 0; $i < $length / 2; $i++){
            $password .= $odd[ better_rand(0, strlen($odd) - 1) ];
            $password .= $even[ better_rand(0, strlen($even) - 1) ];
        }
    }

    return $password;
}

function rand_bytes($bytes){
    if (function_exists('openssl_random_pseudo_bytes')){
        $rand = openssl_random_pseudo_bytes($bytes);
    }
    else if (function_exists('mcrypt_create_iv') ) {
        $rand = mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
    }
    else if (function_exists('mt_rand')) {
        $rand = '';
        for ($i = 0; $i < $bytes; $i++) {
            $rand .= printf('%b', mt_rand(0, 255));
        }
    }
    else {
        $rand = '';
        for ($i = 0; $i < $bytes; $i++) {
            $rand .= printf('%b', rand(0, 255));
        }
    }
    
    return $rand;
}

function better_rand($min, $max=0) {
    if ($max == 0){
        $max = $min;
        $min = 0;
    }
    
    $range  = $max - $min + 1;
    $log    = log( $range, 2 );
    $bytes  = (int) ( $log / 8 ) + 1;   // length in bytes

    if (function_exists('openssl_random_pseudo_bytes')){
        do {
            $rand = openssl_random_pseudo_bytes($bytes);
            $rand = hexdec(bin2hex($rand));
        } 
        while ( $rand >= $range );
        
        $rand += $min;
    }
    else if (function_exists('mcrypt_create_iv') ) {
        do {
            $rand = mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
            $rand = hexdec(bin2hex($rand));
        }
        while ( $rand >= $range );
        
        $rand += $min;
    }
    else if (function_exists('mt_rand')) {
        $rand = mt_rand($min, $max);
    }
    else {
        $rand = rand($min, $max);
    }
    
    return $rand;
}

?>

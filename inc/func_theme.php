<?php

function display_theme($template){
    global $c;

    preg_match_all("|\{\{ (.*) \}\}|U", $template, $matches, PREG_SET_ORDER);

    $matches = better_array_unique($matches);

    foreach ($matches as $match){
        $search  = (string) $match[0];
        $found   = (string) $match[1];
        $replace = FALSE;

        $action = explode('_', $found);
        switch (strtolower($action[0])) {
            case 'inc':
                $file = 'content/themes/'. $c['site']['theme'] .'/php/' . str_replace('inc_', '', $found) . '.php';
                
                if (file_exists($file)){
                    ob_start();
                    include $file;
                    $replace = display_theme(ob_get_contents());
                    ob_end_clean();
                }
                break;
                
            case 'func':
                $function = str_replace('func_', '', $found);
            
                if (function_exists($function)) {
                    $replace = display_theme($function());
                }
                break;
                
            default:
                if (sizeof($action) == 1) {
                    if (isset($c[$found])){
                        $replace = $found;
                    }
                }
                else {
                    $parent = $action[0];
                    $child  = $action[1];
                    
                    if (isset($c[$parent][$child])){
						if ($parent == 'site' && $child == 'email') {
							if ($c['security']['protect-email'] == TRUE) {
								$replace = encode_email($c['site']['email']);
							}
						}
						else {
							$replace = $c[$parent][$child];
						}
                    }
                }
        }

        if ($replace === FALSE){
            $replace = 'ERROR: unknown template variable: ' . $found;
        }

        $template = str_replace($search, $replace, $template);
    }

    return $template;
}

function navigation() {
    $nav = parse_ini_file('content/nav.ini', TRUE);
    //die(better_print_r($nav));
    $output = '<ul>';
    foreach ($nav as $item => $link) {
        $output .= '<li><a href="' . 
                  (empty($link['href']) ? '#' : $link['href']) .
                  '" title="' . 
                  (empty($link['hover']) ? '' : $link['hover']) . 
                  '">' . $item . '</a></li>';
    }
    $output .= '</ul>';
    
    return $output;
}

?>

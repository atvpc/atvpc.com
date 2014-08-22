<?php

include 'inc/init.php';

// Set the default page if one isn't specified
$c['page']['id'] = (empty($_GET['p'])) ? 'index' : $_GET['p'];

switch ($c['page']['id']){
    case 'css':
        $css = array('inc/css/normalize.css', 'content/themes/'. $c['site']['theme'] .'/css/style.css');

        $content = '';
        foreach ($css as $desc => $file) {
            $content .= trim(file_get_contents($file));
        }

        $content = win2unix($content);

        if (isset($_GET['display']) && $_GET['display'] == TRUE) {
            header('Content-Type: text/html');
            echo minify_code($content, 'css', TRUE);
        }
        else {
            /*
            $expires = gmdate("D, d M Y H:i:s", time() + $c['cache']['css']);
    
            ob_start ('ob_gzhandler');
            header('Expires: ' . $expires . ' GMT');
            header('Cache-Control: must-revalidate'); 
            */
            header('Content-Type: text/css; charset: UTF-8');
            echo '/* This style sheet has been minified. To view the original source add &display=TRUE to the URL */';
            echo "\n\n";
            echo minify_code($content, 'css');
        }
        break;

    case 'js':
        $js = array('inc/js/modernizr.js', 'inc/js/init.js');

        $content = '';
        foreach ($js as $file) {
            $content .= trim(file_get_contents($file));
        }

        $content = win2unix($content);

        if (isset($_GET['display']) && $_GET['display'] == TRUE) {
            header('Content-Type: text/html');
            echo minify_code($content, 'js', TRUE);
        }
        else {
            header('Content-Type: text/javascript');
            echo '/* This style sheet has been minified. To view the original source add &display=TRUE to the URL */';
            echo "\n\n";
            echo minify_code($content, 'js');
        }
        break;

    default:
        // Unknown Page
        if (array_search($c['page']['id'] . '.md', ls_dir('content/pages/', 'md')) == FALSE) {
			
			$redirect  = parse_ini_file('content/redirect.ini', true);
			$requested = parse_url($_SERVER['REQUEST_URI']);
			
			if (strpos($requested['path'], '.php') !== FALSE) {
				$file = substr($requested['path'], 1, strpos($requested['path'], '.php') + 3);
				
				if (isset($redirect['page'][$file])) {
					header('HTTP/1.1 301 Moved Permanently');
					header('Location: http://'. $requested['host'].'/index.php?p=' . $redirect['page'][$file]);
		
					echo '<h1>Content Moved</h1>';
					echo '<p>Sorry, that page has moved. You should be redirected automatically, but if not <a href="http://'. $requested['host'].'/index.php?p=' . $redirect['page'][$file] . '">click here</a>.</p>';
					die();
				}
			}

			log_error('404', $_SERVER['REQUEST_URI']);
			
            header('HTTP/1.0 404 Not Found');
            $c['page']['file'] = 'content/pages/404.md';
        }
        else {
            $c['page']['file'] = 'content/pages/' . $c['page']['id'] . '.md';
        }
        
        get_page_info();

        $template = file_get_contents('content/themes/' . $c['site']['theme'] . '/template.html');
        echo display_theme($template);
}


?>

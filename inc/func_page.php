<?php

function get_page_info(){
    global $c;

    // Get the raw data for the page
    $parsed = parse_page_section( file_get_contents($c['page']['file']), '<!-- SIDEBAR -->', '<!-- END SIDEBAR -->');
    $c['page']['content'] = parse_markdown(display_theme($parsed['content'])); 
    $c['page']['sidebar'] = parse_markdown($parsed['section']);
    
    $c['page']['hash']    = hash_file('sha256', $c['page']['file']);

    // See if the page is in out DB, if not add it
    $metainfo = sql_getPage($c['page']['id']);
    
    if ($metainfo == FALSE){
        // Generate & set page title
        $c['page']['title'] = gen_page_title($c['page']['id']);
        $c['page']['ctime'] = filemtime($c['page']['file']);
        $c['page']['mtime'] = NULL;
        
        // Add to metainfo database
        sql_addPage(array(':id'    => $c['page']['id'], 
                          ':title' => $c['page']['title'],
                          ':ctime' => $c['page']['ctime'],
                          ':hash'  => $c['page']['hash']));
    }
    else {
        $c['page']['title'] = $metainfo['title'];
        $c['page']['ctime'] = $metainfo['created'];
        $c['page']['description'] =  (empty($metainfo['description'])) ? '' : $metainfo['description'];
        
        if ($c['page']['hash'] != $metainfo['hash']) { // File has changed, update metainfo
            $c['page']['mtime'] = filemtime($c['page']['file']);
            
            sql_chgPageMTime(array(':id'    => $c['page']['id'],
                                   ':mtime' => filemtime($c['page']['file']), 
                                   ':hash'  => $c['page']['hash']));
                          
        }
        else {
            $c['page']['mtime'] = $metainfo['modified'];
        }
    }
}

function gen_page_title($text){
    $dont_capitalize = array('a', 'an', 'and', 'at', 'but', 'by', 'down', 'for', 'in', 'nor', 'on', 'or', 'over', 
                             'so', 'the', 'to', 'with', 'yet');

    $title = explode('-', $text);
    
    foreach ($title as &$word) {
        if (array_search($word, $dont_capitalize) === FALSE){
            $word = ucfirst($word);
        }
    }
    
    // First and last word always are capitalized
    $title[0] = ucfirst($title[0]);
    $title[count($title) - 1] = ucfirst($title[count($title) - 1]);

    return implode(' ', $title);
}

function parse_page_section($raw, $start, $end){
    // If section exists...
    if (strpos($raw, $start) !== FALSE){
        // Get the start of the section and everything after (including content)
        $section = substr(strstr($raw, $start), strlen($start));

        // Remove the page content from the end of the section
        $section = strstr($section, $end, TRUE);

        // Set page content to everything before section
        $content  = strstr($raw, $start, TRUE);

        // Add to the content everything after config section
        $content .= substr(strstr($content, $end), strlen($end));
    
        return array('content' => $content, 'section' => $section);
    }
    else {
         return array('content' => $raw, 'section' => '');
    }
}

function parse_markdown($markdown){
    // Parse Markdown content
    include_once 'inc/libs/parsedown.php';
    $parsedown = new Parsedown();
    return $parsedown->text($markdown);
}

?>

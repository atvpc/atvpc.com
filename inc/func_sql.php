<?php

// -=[ PAGE METADATA ]=================================================================================================-

function sql_getPage($page_id) {
    $sql = 'SELECT title, description, strftime("%s", create_time) AS created, strftime("%s", modify_time) AS modified, hash, version ' 
         . 'FROM pages WHERE id=?';
    
    $result = db_stmt($sql, $page_id);
    
    if (isset($result[0])) return $result[0];
    else return FALSE;
}

function sql_addPage($bind) {
    $sql = 'INSERT INTO pages (id, title, create_time, hash) VALUES (:id, :title, DATETIME(:ctime, "unixepoch"), :hash)';
    db_stmt($sql, $bind);
}

function sql_chgPageMTime($bind) {
    $sql = 'UPDATE pages SET modify_time=DATETIME(:mtime, "unixepoch"), hash=:hash, version=version + 1 WHERE id=:id';
    db_stmt($sql, $bind);
}

// -=[ PAGE & SITE STATS ]=============================================================================================-

function sql_getVisitorsOnline() {
    return db_stmt('SELECT COUNT(*) FROM visitors WHERE last_seen >= date("now", "-15 minutes")');
}

function sql_getTotalVisits(){
    $result = db_stmt('SELECT sum(visits) AS total_visits FROM visitors');
    return $result[0]['total_visits'];
}

function sql_getUniqueVisits() {
    return db_stmt('SELECT COUNT(*) AS unique_visits FROM visitors');
}

// -=[ VISITOR LOGGING ]===============================================================================================-

function sql_checkVisitorNew($ip) {
    $sql = 'SELECT COUNT(*) FROM visitors WHERE ip=? LIMIT 1';
    $result = db_stmt($sql, $ip);
    
    if ($result == 1) return FALSE;
    else              return TRUE;
}

function sql_checkVisitorLogged($ip) {
    $sql = 'SELECT COUNT(*) FROM visitors WHERE last_seen >= date("now", "-15 minutes") AND ip = ? LIMIT 1';
    $result = db_stmt($sql, $ip);
    if ($result == 1) return TRUE;
    else              return FALSE;
}

function sql_addVisitor($ip) {
    db_stmt('INSERT INTO visitors (ip) VALUES (?)', $ip);
}

function sql_chgVisitorCount($ip) {
    $sql = 'UPDATE visitors SET visits = visits + 1, last_seen = DATETIME(\'now\') WHERE ip=?';
    db_stmt($sql, $ip);
}

function sql_chgVisitorLastSeen($ip) {
    db_stmt('UPDATE visitors SET last_seen = DATETIME(\'now\') WHERE ip=?', $ip);
}

?>

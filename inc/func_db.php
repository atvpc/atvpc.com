<?php

// Connect if not connected already
if (!isset($db)){
    $db = db_connect();
}

// SQL Statements in seperate file
include 'func_sql.php';

function db_log($msg, $sql = ''){
    global $c;
    $file = 'content/db/db.log';

    if ($sql != '') $msg .= ' [ ' . $sql . ' ]';

    file_put_contents($file, date('[Y-m-d H:i:s] ') . $msg . "\n", FILE_APPEND);
}

function db_stmt($sql, $bind = NULL){
    global $db;
    global $c;
    
    $c['database']['counter']++;

    $cmd = explode(' ', strtolower($sql));

    if ($bind != NULL){
        if (!is_array($bind)){
            $tmp = $bind;
            $bind = array($tmp);
        }

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($bind);
        
            if ($cmd[0] == 'select'){
                if (strtolower(substr($cmd[1], 0, 5)) == 'count'){
                    try {
                        $results = $stmt->fetchColumn();
                    }
                    catch(PDOException $e){
                        db_log($e->getMessage(), $sql);
                    }
                }
                else {
                    try {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch(PDOException $e){
                        db_log($e->getMessage(), $sql);
                    }
                }
                return $results;
            }
        }
        catch(PDOException $e){
            db_log($e->getMessage(), $sql);
        }
    }
    else {
        if ($cmd[0] == 'select'){
            if (strtolower(substr($cmd[1], 0, 5)) == 'count'){
                try {
                    return $db->query($sql)->fetchColumn();
                }
                catch(PDOException $e){
                    db_log($e->getMessage(), $sql);
                }
            }
            else {
                try {
                    return $db->query($sql)->fetchAll();
                }
                catch(PDOException $e){
                    db_log($e->getMessage(), $sql);
                }
            }
        }
        else {
            try {
                return $db->exec($sql);
            }
            catch(PDOException $e){
                db_log($e->getMessage(), $sql);
            }
        }
    }
}

function db_connect(){
    global $c;

    switch ($c['database']['engine']){
        case 'sqlite':
            $con_str = 'sqlite:' . $c['database']['location'];
            break;

        case 'mysql':
            $con_str = array($c['database']['engine'] . ':host=' .
                             $c['database']['location'] . ';dbname=' .
                             $c['database']['database'], $c['database']['username'],
                             $c['database']['password']);
            break;

        default:
            $con_str = $c['database']['engine'] . ':host=' . $c['database']['location'] .
                       ';dbname=' . $c['database']['database'] . ', ' .
                       $c['database']['username'] . ', ' . $c['database']['password'];
    }

    try {
        $db = new PDO($con_str);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(PDOException $e){
        db_log($e->getMessage());
    }

    if (!isset($e)){
        $c['database']['counter'] = 0;
        return $db;
    }
    else {
        die('ERROR: An error occurred connecting to the database.');
    }
}

?>

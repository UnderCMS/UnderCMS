<?php
session_start(); 
//try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME , USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
    //echo 'A database error occured when loading UnderCMS.' ;
    //exit;
//}
?>

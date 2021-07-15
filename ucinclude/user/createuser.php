<?php
require "../ucinclude/db/con.php";
require "../uc-config.php";
//This file is only used to create an usrer
function createUser($username, $password, $email){
    global $db;
    $options = [
        "cost" => 12,
    ];
    $hashpass = password_hash($password, PASSWORD_BCRYPT, $options);
    $query = $db->prepare("INSERT INTO `" . DB_PREFIX . "users`(`username`, `password`, `email`, `datecreated`) VALUES  ('".$username."','". $hashpass. "','".$email."','". time() ."')");
    $query->execute();
}
?>
<?php
//This file is only used to create an usrer
function createUser($username, $password, $email, $db){
    $hashpass = password_hash($password, PASSWORD_ARGON2ID);
    $query = $db->prepare("INSERT INTO `" . DB_PREFIX . "users`(`username`, `password`, `email`, `datecreated`) VALUES  ('".$username."','". $hashpass. "','".$email."','". time() ."')");
    $query->execute();
}
?>
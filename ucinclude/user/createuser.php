<?php
require "../db/con.php";
//This file is only used to create an usrer
function createUser($username, $password, $email){
    $query = $db->prepare("INSERT INTO `users`(`id`, `username`, `email`, `datecreated`) VALUES ('".$username."','". $password. "','".$email."','". date() ."')");
    $query->execute();
}
?>
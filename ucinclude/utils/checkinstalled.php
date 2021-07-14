<?php
//This file checks if UnderCMS is installed or not
@$check = include "./uc-config.php";
if($check){
    //Installed
    return;
}else{
    //Not installed
    header("Location: /ucadmin/install.php");
}
?>
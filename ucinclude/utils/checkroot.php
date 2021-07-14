<?php
//This file checks if UnderCMS is on the root dir
@$check = include "./uc-test-file.php";
if($check){
    return;
}else{
    echo("Sorry webmaster, but you need to have the UnderCMS files on the root of your Apache2 php documents folder.");
    exit();
}
?>
<?php
function checkTheme($themename){
    @$check = include "./uccontent/themes/". $themename ."/manifest.php";
    if($check){
        return true;
    }else{
        return false;
    }
}
?>
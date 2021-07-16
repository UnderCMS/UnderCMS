<?php
function getUserDataByID($id, $db){
    $query = $db->prepare("SELECT * FROM `".DB_PREFIX."users` WHERE `id`=:id");
    $query->execute([
        "id" => $id
    ]);
    $result = $query->fetch();
    return $result;
}
?>
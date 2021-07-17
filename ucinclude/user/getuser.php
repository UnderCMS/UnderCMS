<?php
function getUserDataByID($id, $db){
    $query = $db->prepare("SELECT * FROM `".DB_PREFIX."users` WHERE `id`=:id");
    $query->execute([
        "id" => $id
    ]);
    $result = $query->fetch();
    return $result;
}
function getUserDataByToken($token, $db){
    $query = $db->prepare("SELECT * FROM `".DB_PREFIX."tokens` WHERE `token`=:token");
    $query->execute([
        "token" => $token
    ]);
    $result = $query->fetch();
    $finalresult = getUserDataByID($result['forid'], $db);
    return $finalresult;
}
?>
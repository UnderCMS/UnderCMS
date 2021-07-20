<?php
class User{
    public function createUser($username, $password, $email, $db){
        $hashpass = password_hash($password, PASSWORD_ARGON2ID);
        $query = $db->prepare("INSERT INTO `" . DB_PREFIX . "users`(`username`, `is_pseudonym`, `pseudonym`,`password`, `email`, `datecreated`) VALUES  ('".$username."', 0, '', '". $hashpass. "','".$email."','". time() ."')");
        $query->execute();
    }
    public function getUserDataByID($id, $db){
        $query = $db->prepare("SELECT * FROM `".DB_PREFIX."users` WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
        $result = $query->fetch();
        return $result;
    }
    public function getUserDataByToken($token, $db){
        $query = $db->prepare("SELECT * FROM `".DB_PREFIX."tokens` WHERE `token`=:token");
        $query->execute([
            "token" => $token
        ]);
        $result = $query->fetch();
        $userclass = new User;
        $finalresult = $userclass->getUserDataByID($result['forid'], $db);
        return $finalresult;
    }
    public function changeNickname($isnickname, $nickname, $id,$db){
        if($isnickname){
            $query = $db->prepare("UPDATE `".DB_PREFIX."users` SET `is_pseudonym`=1, `pseudonym`=:nickname WHERE `id`=:id");
            $query->execute([
                "nickname" => $nickname,
                "id" => $id
            ]);
        }else{
            $query = $db->prepare("UPDATE `".DB_PREFIX."users` SET `is_pseudonym`=0 WHERE `id`=:id");
            $query->execute([
                "id" => $id
            ]);
        }
    }
    public function changePassword($currentpass, $password, $id, $db){
        $userclass = new User;
        $user = $userclass->getUserDataByID($id, $db);
        if(password_verify($currentpass, $user['password'])){
            $hashpass = password_hash($password, PASSWORD_ARGON2ID);
            $query = $db->prepare("UPDATE `".DB_PREFIX."users` SET `password`=:password WHERE `id`=:id");
            $query->execute([
                "password" => $hashpass,
                "id" => $id
            ]);
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }
}
?>
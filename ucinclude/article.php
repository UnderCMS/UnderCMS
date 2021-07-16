<?php
class Article{
    public function fetchAll($db){
        $query = $db->prepare("SELECT * FROM `".DB_PREFIX."articles`");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public function fetchOnlyOne($articleurl, $db){
        try{
            $query = $db->prepare("SELECT * FROM `".DB_PREFIX."articles` WHERE `article_url`=:article_url");
            $query->execute([
                "article_url" => $articleurl
            ]);
            $result = $query->fetch();
        }catch(PDOExeception $e){
            $result = false;
        }
        return $result;
    }
}
?>
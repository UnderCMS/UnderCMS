<?php
function RemoveSpecialChar($str) {
      
    // Using str_replace() function 
    // to replace the word 
    $res = str_replace( array( '\'', '"',
    ',' , ';', '<', '>' ), ' ', $str);
      
    // Returning the result 
    return $res;
}
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
    public function fetchOnlyOneByID($articleid, $db){
        try{
            $query = $db->prepare("SELECT * FROM `".DB_PREFIX."articles` WHERE `id`=:article_id");
            $query->execute([
                "article_id" => $articleid
            ]);
            $result = $query->fetch();
        }catch(PDOExeception $e){
            $result = false;
        }
        return $result;
    }
    public function createArticle($title, $content, $authorid, $db){
        $articleurl = RemoveSpecialChar($title);
        $content = nl2br($content);
        $query = $db->prepare("INSERT INTO `".DB_PREFIX."articles`(`author_id`, `title`, `content`, `datecreated`, `article_url`) VALUES (:authorid, :title, :content, :datecreated, :articleurl)");
        $query->execute([
            "authorid" => $authorid,
            "title" => $title,
            "content" => $content,
            "datecreated" => time(),
            "articleurl" => $articleurl
        ]);
    }
    public function deleteArticle($id, $db){
        $query = $db->prepare("DELETE FROM `".DB_PREFIX."articles` WHERE `id`=:id");
        $query->execute([
            "id" => $id
        ]);
    }
}
?>
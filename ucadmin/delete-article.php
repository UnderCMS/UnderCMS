<?php
require "./ucinclude/article.php";
$articleclass = new Article;
$query = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='current-theme'");
$query->execute();
$result = $query->fetch();
$article = $articleclass->fetchOnlyOneByID($articleid, $db);
if(!$article){
    require "./uccontent/themes/".$result['valuecontent']."/404.php";
    exit();
}
require "inc/header.php";
?>
<div class="container masthead-followup px-4 px-md-3">
    <section class="row mb-5 pb-md-4 align-items-center">
        <div class="col-md-5">
            <div class="masthead-followup-icon d-inline-block mb-2">        
                <h2 class="display-5 fw-normal">Delete an article</h3>
                <p>Are you sure to delete this article?</p>
                <form method="POST">
                    <input type="submit" name="submit" class="btn btn-outline-danger" value="Delete the article">
                </form>
                <?php
                if(isset($_POST['submit'])){
                    $articleclass->deleteArticle($articleid, $db);
                    echo "<div class='alert alert-danger' role='alert'>
                        Succefully deleted the article!
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>
</div>
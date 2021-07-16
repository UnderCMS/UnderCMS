<?php
require("inc/header.php");
require "./ucinclude/article.php";
$article = new Article;
$articles = $article->fetchAll($db);
if(empty($articles)){ ?>
    <div class="jumbotron text-center">
        <p>No articles found.</p>
    </div>
<?php }
foreach($articles as $article){?>
    <div class="jumbotron text-center">
        <a href="/articles/<?php echo $article['article_url'] ?>"><?php echo $article['title'] ?></a> - <small>posted <?php echo date("l jS", $article['datecreated']) ?></small>
    </div>
<?php
}
require("inc/footer.php");
?>
<?php
require "./ucinclude/article.php";
$articleclass = new Article;
$article = $articleclass->fetchOnlyOne($articleurl, $db);
if(!$article){
    require "404.php";
    exit();
}
require "inc/header.php";
require "./ucinclude/user/getuser.php";
$author = getUserDataByID($article['author_id'], $db);
?>
<body>
    <center>
        <div class="jumbotron text-center">
            <h3><?php echo $article['title'] ?></h3>
            <p><?php echo $article['content'] ?></p>
            <small>By <?php echo $author['username'] ?>, posted <?php echo date("l jS", $article['datecreated']) ?></small>
        </div>
        <a href="/" name="submit" class="btn btn-outline-success">Go to the website's home</a>
    </center>
</body>
<?php
require "inc/footer.php";
?>
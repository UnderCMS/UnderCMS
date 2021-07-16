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
        <div class="container masthead-followup px-4 px-md-3">
            <section class="row mb-5 pb-md-4 align-items-center">
                <div class="col-md-5">
                    <div class="masthead-followup-icon d-inline-block mb-2">        
                        <h2 class="display-5 fw-normal"><?php echo $article['title'] ?></h3>
                        <p class="lead fw-normal"><?php echo $article['content'] ?></p>
                        <small>By <?php echo $author['username'] ?>, posted <?php echo date("l jS", $article['datecreated']) ?></small>
                    </div>
                </div>
            </section>
        </div>
</body>
<?php
require "inc/footer.php";
?>
<?php
require("inc/header.php");
require "./ucinclude/article.php";
$article = new Article;
$articles = $article->fetchAll($db);
if(empty($articles)){ ?>
    <div class="text-center container masthead-followup px-4 px-md-3">
        <section class="row mb-5 pb-md-4 align-items-center">
            <div class="col-md-5">
                <div class="masthead-followup-icon d-inline-block mb-2">        
                    <h2>No articles found.</h2>
                </div>
            </div>
        </section>
    </div>
<?php }
foreach($articles as $article){?>
    <div class="container masthead-followup px-4 px-md-3">
        <section class="row mb-5 pb-md-4 align-items-center">
            <div class="col-md-5">
                <div class="masthead-followup-icon d-inline-block mb-2">        
                    <h2><a href="/articles/<?php echo $article['article_url'] ?>" class="display-5 fw-normal"><?php echo $article['title'] ?></a></h2> <p class="lead fw-normal">Posted <?php echo date("l jS", $article['datecreated']) ?></small>
                </div>
            </div>
        </section>
    </div>
<?php
}
require("inc/footer.php");
?>
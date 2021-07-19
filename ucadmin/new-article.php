<?php
require "inc/header.php";
require "./ucinclude/article.php";
$article = new Article;
$user = $userclass->getUserDataByToken($_SESSION['token'], $db);
?>
<div class="container masthead-followup px-4 px-md-3">
    <section class="row mb-5 pb-md-4 align-items-center">
        <div class="col-md-5">
            <div class="masthead-followup-icon d-inline-block mb-2">        
                <h2 class="display-5 fw-normal">Create a new article</h3>
                <form method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Title</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Title" name="title" aria-describedby="basic-addon1">
                    </div>   
                    <div class="input-group">
                        <span class="input-group-text">Content</span>
                        <textarea class="form-control" placeholder="Content of the article" name="content" aria-label="With textarea"></textarea>
                    </div>
                    <input type="submit" name="submit" class="btn btn-outline-success" value="Create the article">
                </form>
                <?php
                if(isset($_POST['submit'])){
                    if(!empty($_POST['title']) && !empty($_POST['content'])){
                        try{
                            $article->createArticle($_POST['title'], $_POST['content'], $user['id'], $db);
                        }catch(PDOException $e){
                            echo "<div class='alert alert-danger' role='alert'>
                        Failed to create the article: do you have an article already named with the title you want to use?
                    </div>";
                            exit();
                        }
                        echo "<div class='alert alert-success' role='alert'>
                        Succefully created the article!
                    </div>";
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                        Some fields are incomplete!
                    </div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>
</div>
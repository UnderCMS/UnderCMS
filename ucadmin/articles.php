<?php
require "inc/header.php";
require "./ucinclude/article.php";
$article = new Article;
$articles = $article->fetchAll($db);
?>
<div class="container masthead-followup px-4 px-md-3">
    <section class="row mb-5 pb-md-4 align-items-center">
        <div class="col-md-5">
            <div class="masthead-followup-icon d-inline-block mb-2">        
                <h2 class="display-5 fw-normal">Articles</h3>
                <p>List of articles</p>
                <a href="/uc-admin/articles/new" name="submit" class="btn btn-outline-success">Create a article</a>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">By</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($articles as $article){ 
                                $user = $userclass->getUserDataByID($article['author_id'], $db);
                                if(strlen($article['content']) > 100){
                                    $article['content'] = substr($article['content'],0,100) . "...";
                                }?>
                                <tr>
                                <td scope="row"><?php echo $article['title'] ?></td>
                                <td><?php echo $article['content'] ?></td>
                                <td><?php if(is_null($user['pseudonym']) || $user['is_pseudonym']==0){echo $user['username'];}else{echo $user['pseudonym'];} ?></td>
                                <td><a href="/uc-admin/articles/delete/<?php echo $article['id'] ?>" name="submit" class="btn btn-outline-danger">Delete</a></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>
<?php
require "inc/footer.php";
?>
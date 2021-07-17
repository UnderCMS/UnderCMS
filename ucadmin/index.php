<?php
require "inc/header.php";
$user = getUserDataByToken($_SESSION['token'], $db);
?>
<div class="container masthead-followup px-4 px-md-3">
    <section class="row mb-5 pb-md-4 align-items-center">
        <div class="col-md-5">
            <div class="masthead-followup-icon d-inline-block mb-2">        
                <h2 class="display-5 fw-normal">Welcome, <?php echo $user['title'] ?></h3>
                <p class="lead fw-normal">Today is the <?php echo date("l jS, Y") ?></p>
                <small>UnderCMS 0.1.5</small>
            </div>
        </div>
    </section>
</div>
<?php
require "inc/footer.php";
?>

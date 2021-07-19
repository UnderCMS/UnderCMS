<?php
require "inc/header.php";
$user = $userclass->getUserDataByToken($_SESSION['token'], $db);
?>
<div class="container masthead-followup px-4 px-md-3">
    <section class="row mb-5 pb-md-4 align-items-center">
        <div class="col-md-5">
            <div class="masthead-followup-icon d-inline-block mb-2">        
                <h2 class="display-5 fw-normal">Settings</h3>
                <form method="POST">
                    <p>Do you want to have a pseudonym instead of your direct username? <?php if($user['is_pseudonym']==0){ ?><input type="checkbox" name="ispseudonym"><?php }else{ ?><input type="checkbox" name="ispseudonym" checked><?php } ?></p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Pseudonym</span>
                        </div>
                        <?php if(!is_null($user['pseudonym'])){ ?>
                            <input type="text" class="form-control" placeholder="Pseudonym" name="pseudonym" aria-describedby="basic-addon1" value="<?php echo $user['pseudonym'] ?>">
                        <?php }else{ ?>
                            <input type="text" class="form-control" placeholder="Pseudonym" name="pseudonym" aria-describedby="basic-addon1">
                        <?php } ?>
                    </div>
                    <input type="submit" name="submit" class="btn btn-outline-success" value="Save settings">
                </form>
                <?php
                if(isset($_POST['submit'])){
                    if(isset($_POST['ispseudonym'])){
                        if(!empty($_POST['pseudonym'])){
                            $userclass->changeNickname($_POST['ispseudonym'], $_POST['pseudonym'], $user['id'], $db);
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                        Some fields are incomplete!
                    </div>";
                        }
                    }
                    echo "<div class='alert alert-success' role='alert'>
                        Succefully changed the settings!
                    </div>";
                }
                ?>
        </div>
    </section>
</div>
<?php
require "inc/footer.php";
?>
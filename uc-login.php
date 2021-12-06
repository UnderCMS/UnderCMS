<?php
//UnderCMS login page
//Import libraries/functions/classes
require "ucinclude/utils/checkroot.php";
require "ucinclude/utils/checkinstalled.php";
require "uc-config.php";
require "ucinclude/db/dbcon.php";
require "ucinclude/TokenGenerator.php";
if(isset($_SESSION['token'])){
    header("Location: /uc-admin");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="ucadmin/css/bootstrap.min.css">
        <script src="../uccontent/themes/basictheme/assets/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div style="position: absolute; top: 25%; left: 50%; transform: translate(-50%, -50%);">
            <h3>UnderCMS</h3>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Login</h3>
            <p>Please enter your username and password.</p>
            <form method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Username</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" name="username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="basic-addon1">
                </div>
                <input type="submit" name="submit" class="btn btn-outline-success" value="Login">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    if(!empty($_POST['username']) && !empty($_POST['password'])){
                        $query = $db->prepare("SELECT * FROM `".DB_PREFIX."users` WHERE `username`=:username");
                        $query->execute([
                            "username" => $_POST['username']
                        ]);
                        $result = $query->fetch();
                        if($result==true){
                            if(password_verify($_POST['password'], $result['password'])){
                                $token = tokenGen(20);
                                $query = $db->prepare("INSERT INTO `".DB_PREFIX."tokens`(`forid`, `token`) VALUES (:id, :token)");
                                $query->execute([
                                    "id" => $result['id'],
                                    "token" => $token
                                ]);
                                $_SESSION['token'] = $token;
                                header("Location: /");
                            }else{
                                echo "<div class='alert alert-danger' role='alert'>
                                Wrong username/password!
                            </div>";
                            }
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Wrong username/password!
                        </div>";
                        }
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                            Some fields are incomplete!
                        </div>";
                    }
                }
            ?>
        </div>
    </body>
</html>

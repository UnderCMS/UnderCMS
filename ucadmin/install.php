<?php
//The installation file of UnderCMS
// Check if already installed
@$check = include "../uc-config.php";
if($check && $_GET['step']!=3){
    //Installed
    ?>
    <html>
    <head>
        <title>Error</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="jumbotron text-center">
            <h3>Uh oh!</h3>
            <p>Looks like you have already installed UnderCMS...</p>
            <a href="/" name="submit" class="btn btn-outline-success">Go to your website's home</a>
        </div>
    </body>

<?php exit();}else{
    //Not installed
}
?>
<html>
    <head>
        <title>Welcome!</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
    </head>
    <body>
        <?php
        if($_GET['step']){
            if($_GET['step']==1){ ?>
                <div class="jumbotron text-center">
                    <h3>Step 1: Enter your MySQL/MariaDB details</h3>
                    <p>Please enter your MySQL/MariaDB details here.</p>
                    <form method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">User</span>
                            </div>
                            <input type="text" class="form-control" placeholder="User" name="user" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Password</span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Database server URL</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Database server URL" name="databaseurl" aria-describedby="basic-addon1" value="localhost">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Database name</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Database name" name="databasename" aria-describedby="basic-addon1" value="undercms">
                        </div>
                        <input type="submit" name="submit" class="btn btn-outline-success" value="Next">
                    </form>
                    <?php
                    if(isset($_POST['submit'])){
                        if(!empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['databaseurl']) && !empty($_POST['databasename'])){
                            try {
                                $db = new PDO("mysql:host=" . $_POST['databaseurl'] .";dbname=" . $_POST['databasename'] , $_POST['user'], $_POST['password']);
                                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            } catch (PDOException $e) {
                                echo "<div class='alert alert-danger' role='alert'>
                            Could not connect to the database!
                        </div>";
                                exit();
                            }
                            header("Location: /ucadmin/install.php?step=2&dburl=".$_POST['databaseurl']. "&dbname=". $_POST['databasename'] ."&user=".$_POST['user']."&password=".$_POST['password']);
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Some fields are incomplete!
                        </div>";
                        }
                    }
                    ?>
                </div>
            <?php }else if($_GET['step']==2){ ?>
                <div class="jumbotron text-center">
                    <h3>Step 2: Enter your website details</h3>
                    <p>Please enter your website details here.</p>
                    <form method="post">
                    <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Site name</span>
                            </div>
                            <input type="text" class="form-control" placeholder="sitename" name="sitename" aria-describedby="basic-addon1" value="UnderCMS website">
                        </div>
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">E-mail</span>
                            </div>
                            <input type="email" class="form-control" placeholder="E-mail" name="email" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Database Prefix</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Database prefix" name="dbprefix" aria-describedby="basic-addon1" value="uc_">
                        </div>
                        <p>And then, just click install and wait for the process to complete!</p>
                        <input type="submit" name="submit" class="btn btn-outline-success" value="Install">
                    </form>
                    <?php
                    if(isset($_POST['submit'])){
                        if(!empty($_POST['sitename']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['dbprefix'])){
                            $configfile = fopen("../uc-config.php", "w");
                            $configtext = "
<?php
//Main configuration file of UnderCMS
// Define DB details
define('HOST', '". $_GET['dburl'] ."');
define('DB_NAME', '". $_GET['dbname'] ."');
define('USER', '". $_GET['user'] ."');
define('PASS', '". $_GET['password'] ."');
define('DB_PREFIX', '". $_POST['dbprefix'] ."');

?>
                            ";
                            fwrite($configfile, $configtext);
                            fclose($configfile);
                            require "../ucinclude/db/con.php";
                            $query = $db->prepare("CREATE TABLE `".$_POST['dbprefix']."users` (
                            `id` int NOT NULL,
                                `username` varchar(255) COLLATE utf8_bin NOT NULL,
                                `password` varchar(255) COLLATE utf8_bin NOT NULL,
                                `email` varchar(255) COLLATE utf8_bin NOT NULL,
                                `datecreated` int NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;
                            ALTER TABLE `".$_POST['dbprefix']."users`
                                ADD PRIMARY KEY (`id`),
                                ADD UNIQUE KEY `id` (`id`,`username`),
                                ADD UNIQUE KEY `email` (`email`);
                            ALTER TABLE `".$_POST['dbprefix']."users`
                                MODIFY `id` int NOT NULL AUTO_INCREMENT;
                            CREATE TABLE `".$_POST['dbprefix']."options` (
                                `valuename` varchar(255) COLLATE utf8_bin NOT NULL,
                                `valuecontent` varchar(255) COLLATE utf8_bin NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;
                            ALTER TABLE `".$_POST['dbprefix']."options`
                                ADD UNIQUE KEY `valuename` (`valuename`);
                            COMMIT;");
                            $query->execute();
                            header("Location: /ucadmin/install.php?step=3");
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Some fields are incomplete!
                        </div>";
                        }
                    }
                    ?>

                </div>
            <?php }else{ ?>
                <div class="jumbotron text-center">
                    <h3>Congratulations!</h3>
                    <p>Your UnderCMS installation is done.</p>
                    <p>Click the button below to go to your website's home!</p>
                    <a href="/" name="submit" class="btn btn-outline-success">Finish Install</a>
                </div>
            <?php } ?>
        <?php }else{?>
            <div class="jumbotron text-center">
                <h3>Welcome to UnderCMS!</h3>
                <p>This is the first time you launch UnderCMS, right?</p>
                <p>We will help you setup your UnderCMS installation through some easy steps.</p>
                <p>You only need:</p>
                <ul class="list-group">
                    <li class="list-group-item">A MySQL/MariaDB installation</li>
                    <li class="list-group-item">A MySQL/MariaDB user</li>
                    <li class="list-group-item">A MySQL/MariaDB database</li>
                </ul>
                <p>If you're ready, let's setup your UnderCMS installation!</p>
                <a type="button" class="btn btn-outline-success" href="/ucadmin/install.php?step=1">Let's Go!</a>
            </div>
        <?php } ?>
    </body>
</html>

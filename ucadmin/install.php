<?php
//The installation file of UnderCMS
// Check if already installed
@$check = include "../uc-config.php";
@$check2 = include "../setup-in-progress.php";
if($check && $_GET['step']!=3 && !$check2){
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Database Prefix</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Database prefix" name="dbprefix" aria-describedby="basic-addon1" value="uc_">
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
                            $configfile = fopen("../uc-config.php", "w");
                            $configtext = "<?php
//Main configuration file of UnderCMS
// Define DB details
define('HOST', '". $_POST['databaseurl'] ."');
define('DB_NAME', '". $_POST['databasename'] ."');
define('USER', '". $_POST['user'] ."');
define('PASS', '". $_POST['password'] ."');
define('DB_PREFIX', '". $_POST['dbprefix'] ."');

?>";    
                            fwrite($configfile, $configtext);
                            fclose($configfile);
                            require "../uc-config.php";
                            require "../ucinclude/db/dbcon.php";
                            $query = $db->prepare("CREATE TABLE `".$_POST['dbprefix']."users` (
                            `id` int NOT NULL,
                                `username` varchar(255) COLLATE utf8_bin NOT NULL,
                                `is_pseudonym` tinyint(1) NOT NULL,
                                `pseudonym` varchar(255) COLLATE utf8_bin NOT NULL,
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
                            CREATE TABLE `".$_POST['dbprefix']."articles` (
                                `id` int NOT NULL,
                                `author_id` int NOT NULL,
                                `title` varchar(255) COLLATE utf8_bin NOT NULL,
                                `content` text COLLATE utf8_bin NOT NULL,
                                `article_url` varchar(255) COLLATE utf8_bin NOT NULL,
                                `datecreated` int NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;
                            ALTER TABLE `".$_POST['dbprefix']."articles`
                                ADD PRIMARY KEY (`id`),
                                ADD UNIQUE KEY `article_url` (`article_url`),
                                ADD UNIQUE KEY `title` (`title`);
                            ALTER TABLE `".$_POST['dbprefix']."articles`
                                MODIFY `id` int NOT NULL AUTO_INCREMENT;
                            CREATE TABLE `".$_POST['dbprefix']."tokens` (
                                `forid` int NOT NULL,
                                `token` varchar(255) COLLATE utf8_bin NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;");
                            $query->execute();
                            $setupinprogress = fopen("../setup-in-progress.php", "w");
                            fclose($setupinprogress);
                            header("Location: /ucadmin/install.php?step=2");
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
                        <p>And then, just click install and wait for the process to complete!</p>
                        <input type="submit" name="submit" class="btn btn-outline-success" value="Install">
                    </form>
                    <?php
                    if(isset($_POST['submit'])){
                        if(!empty($_POST['sitename']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
                            require "../uc-config.php";
                            require "../ucinclude/db/con.php";
                            $query = $db->prepare('INSERT INTO `'.DB_PREFIX.'options`(`valuename`, `valuecontent`) VALUES ("site-title", "'.$_POST['sitename'].'")');
                            $query->execute();
                            $query = $db->prepare('INSERT INTO `'.DB_PREFIX.'options`(`valuename`, `valuecontent`) VALUES ("site-description", "A website made on UnderCMS!")');
                            $query->execute();
                            $query = $db->prepare('INSERT INTO `'.DB_PREFIX.'options`(`valuename`, `valuecontent`) VALUES ("current-theme", "basictheme")');
                            $query->execute();
                            $query = $db->prepare("INSERT INTO `".DB_PREFIX."articles` (`id`, `author_id`, `title`, `content`, `article_url`, `datecreated`) VALUES
                            (1, 1, 'My Article', 'This is a test article. Do anything you want with this!', 'my-article', ".time().");");
                            $query->execute();
                            require "../ucinclude/user.php";
                            $userclass = new User;
                            $userclass->createUser($_POST['username'], $_POST['password'], $_POST['email'], $db);
                            unlink("../setup-in-progress.php");
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

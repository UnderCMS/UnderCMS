<?php
require "./ucinclude/db/con.php";
$query = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='site-title'");
$query->execute();
$result = $query->fetch();
$query2 = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='site-description'");
$query2->execute();
$result2 = $query2->fetch();
?>
<html>
    <head>
        <link rel="stylesheet" href="../uccontent/themes/basictheme/assets/bootstrap.min.css">
        <script src="../uccontent/themes/basictheme/assets/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><?php echo $result['valuecontent'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <?php if(isset($_SESSION['token'])){ ?>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/uc-admin">Dashboard</a>
                    </li>
                <?php }else{ ?>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/uc-login">Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    </body>
</html>
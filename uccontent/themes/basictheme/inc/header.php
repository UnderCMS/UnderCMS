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
    </head>
    <body>
        <div class="jumbotron text-center">
            <h3><?php echo $result['valuecontent']; ?></h3>
            <h4><?php echo $result2['valuecontent']; ?></h4>
        </div>
    </body>
</html>
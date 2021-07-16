<?php
require "./ucinclude/db/con.php";
$query = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='site-title'");
$query->execute();
$result = $query->fetch();
?>
<body>
    <div class="jumbotron text-center">
        <footer><p>&#169; Copyright <?php echo $result['valuecontent']; ?> | Propulsed by UnderCMS</p></footer>
    </div>
</body>
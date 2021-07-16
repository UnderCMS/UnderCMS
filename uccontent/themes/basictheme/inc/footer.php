<?php
require "./ucinclude/db/con.php";
$query = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='site-title'");
$query->execute();
$result = $query->fetch();
?>
<body>
    <footer style="position: fixed; bottom: 0; left: 0; right: 0;" class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © Copyright:
            <a class="text-reset fw-bold" href="/"><?php echo $result['valuecontent'] ?></a>
            | Propulsed by UnderCMS
        </div>
    </footer>
</body>
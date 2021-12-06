<?php
//The loader of UnderCMS

//Import libraries/functions/classes
require "ucinclude/utils/checkroot.php";
require "ucinclude/utils/checkinstalled.php";
require "ucinclude/db/dbcon.php";
require "ucinclude/utils/checktheme.php";
require "ucinclude/AltoRouter.php";
require "uc-config.php";

//Prepare current theme
$query = $db->prepare("SELECT * FROM `".DB_PREFIX."options` WHERE `valuename`='current-theme'");
$query->execute();
$result = $query->fetch();
// Check if current theme exists
if(!checkTheme($result['valuecontent'])){?>
    <head><title>Error</title><link rel="stylesheet" href="ucadmin/css/bootstrap.min.css"></head>
    <body>
        <div class="jumbotron text-center">
            <h3>Error!</h3>
            <div class='alert alert-danger' role='alert'>The theme <?php echo $result['valuecontent'] ?> doesn't exists!</div>
        </div>
    </body>
<?php exit();}
require "uccontent/themes/".$result['valuecontent']."/manifest.php";
//Initialize routes
$router = new AltoRouter;

//Routes

$router->map('GET', '/', 'uccontent/themes/'.$result['valuecontent'].'/'.$THEME_MAIN_FILE);
$router->map('GET|POST', '/articles/[*:articleurl]', 'uccontent/themes/'.$result['valuecontent'].'/'.$THEME_ARTICLE_FILE);
$router->map('GET|POST', '/uc-login', 'uc-login.php');
$router->map('GET', '/uc-admin', 'ucadmin/index.php');
$router->map('GET|POST', '/uc-admin/themes', 'ucadmin/themes.php');
$router->map('GET|POST', '/uc-admin/settings', 'ucadmin/settings.php');
$router->map('GET', '/uc-admin/articles', 'ucadmin/articles.php');
$router->map('GET|POST', '/uc-admin/articles/new', 'ucadmin/new-article.php');
$router->map('GET|POST', '/uc-admin/articles/delete/[*:articleid]', 'ucadmin/delete-article.php');
$router->map('GET', '/logout', 'ucadmin/logout.php');


// Match the current request
$match = $router->match(urldecode($_SERVER['REQUEST_URI']));
if ($match) {
    foreach ($match['params'] as &$param) {
        ${key($match['params'])} = $param;
    }
    require_once $match['target'];
} else {
    http_response_code(404);
    exit(require 'uccontent/themes/'.$result['valuecontent'].'/'.$THEME_404_FILE);
}
?>

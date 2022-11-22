<?php

declare(strict_types=1);

session_start();


require_once("classes/Pages.php");
require_once("classes/Game.php");
require_once("classes/Member.php");
require_once("classes/Permission.php");
require_once("classes/User.php");

/** The root of the url also the path of the current folder
 * 
 * ROOT is defined in `.htaccess`
 */
define("ROOT", $_SERVER["REDIRECT_ROOT"]);

/** The rest of the url after `ROOT`
 * 
 * ROUTE is defined in `.htaccess`
 */
define("ROUTE", $_SERVER["REDIRECT_ROUTE"]);

/** `ROOT` and `ROUTE` combined for convienience */
define("PATH", ROOT . ROUTE);

/** Gets the pdo instance */
function getPDO(): PDO
{
    static $pdo = new PDO("mysql:host=localhost;dbname=de-blauwe-loper", "root", "");

    return $pdo;
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="./public/img/Logo.png">

    <link rel="stylesheet" href="<?= ROOT ?>/style.css">
    <title>De Blauwe Loper</title>
</head>

<body>
    <?php
    
    /** `ROUTE` split on '/' */
    $route = explode("/", trim(ROUTE, "/"));

    $finalRoute = (ROUTE !== "/")
        ? ROUTE
        : header("Location: " . ROOT . "/member/start");

    require_once("required/header.php");
    require_once("pages".$finalRoute.".php");
    ?>
</body>

</html>
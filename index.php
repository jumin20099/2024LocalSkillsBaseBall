<?php
include("./api/DBconnect.php");

session_start();

$request = $_SERVER['REQUEST_URI'];
$path = explode("?", $request);
$path[1] = isset($path[1]) ? $path[1] : null;
$resource = explode("/", $path[0]);

$pages = "";
switch ($resource[1]) {
    case '':
        $pages = './pages/index.php';
        break;
    case 'information':
        $pages = './pages/sub01.php';
        break;
    case 'statistics':
        $pages = './pages/sub02.php';
        break;
    case 'reservation':
        $pages = './pages/sub03.php';
        break;
    case 'goods':
        $pages = './pages/sub04.php';
        break;
    case 'signup':
        $pages = './pages/signup.php';
        break;
    case 'signin':
        $pages = './pages/signin.php';
        break;
    case 'logout':
        $pages = './pages/logout.php';
        break;

    case 'mypage':
        $pages = './pages/mypage.php';
        break;

    case 'sub03_admin':
        $pages = './pages/sub03_admin.php';
        break;

    case 'sub03_manager':
        $pages = './pages/sub03_manager.php';
        break;

    default:
        echo "ㄴㄴ";
        return 0;
}
include($pages);

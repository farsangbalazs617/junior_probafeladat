<?php

switch ($uri['path'][0]) {
    case "":
        include(__DIR__ . "/pages/home.php");
        break;
    case "home":
        include(__DIR__ . "/pages/home.php");
        break;
    case "create_edit":
        include(__DIR__ . "/pages/create_edit.php");
        break;
    default:
        include(__DIR__ . "/pages/404.php");
}
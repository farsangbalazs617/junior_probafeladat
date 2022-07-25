<?php

$page = match($uri['path']) {
    "", "home" => "/pages/home.php",
    "create_edit" => "/pages/create_edit.php",
    default => "/pages/404.php",
};

include(__DIR__ . $page);

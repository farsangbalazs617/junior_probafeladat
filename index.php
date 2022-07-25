<?php

$uri = $_SERVER['REQUEST_URI'];

$uri = parse_url($uri);

$uri['path'] = trim($uri['path'], '/');

include(__DIR__ . "/pages/main.php");
<?php

session_start();
require_once 'config.php';
require_once 'vendor/autoload.php';

$core = new Core\Core();
$core->run();
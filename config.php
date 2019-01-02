<?php

require 'environment.php';

$config = [];

if(ENVIRONMENT == 'development') {
    define('BASE_URL', 'http://localhost/mvc_boilerplate_php');
    $config['database_name'] = 'devbook';
    $config['host'] = 'localhost';
    $config['database_user'] = 'root';
    $config['database_password'] = '';
} else {
    define('BASE_URL', 'http://mywebsite.com');
    $config['database_name'] = 'mvc_boilerplate_php';
    $config['host'] = 'localhost';
    $config['database_user'] = 'root';
    $config['database_password'] = '';
}

global $database;

try {
    $dsn = 'mysql:dbname='.$config['database_name'].';host='.$config['host'];
    $database = new PDO($dsn, $config['database_user'], $config['database_password']);
} catch(PDOException $e) {
    die($e->getMessage());
}
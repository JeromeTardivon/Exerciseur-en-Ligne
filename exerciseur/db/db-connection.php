<?php
//add the file .env to the project to load the environment variables
use config\DotEnv;

include_once __DIR__ . '/../config/DotEnv.php';
$env = new DotEnv();
$env->load(__DIR__ . '../../..');
$host = getenv('HOST_DB');
$port = getenv('PORT_DB');
$dbName = getenv('NAME_DB');
$user = getenv('USER_DB');
$pass = getenv('PASSWORD_DB');

// DSN
$dsn = "mysql:host=$host;port=$port;dbname=$dbName";

try {
    $db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
    // Connection successful
    //echo "Connected to bd mariadb via PDO\n";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage() . "\n";
}
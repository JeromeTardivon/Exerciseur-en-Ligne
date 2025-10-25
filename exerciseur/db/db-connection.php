<?php
//add the file .env to the project to load the environment variables
include_once __DIR__ .'/../config/DotEnv.php';
new config\DotEnv()->load(__DIR__ . '../../..');
$host = getenv('HOST_DB');
$port = getenv('PORT_DB');
$db   = getenv('NAME_DB');
$user = getenv('USER_DB');
$pass = getenv('PASSWORD_DB');
$sslmode = 'require';

// DSN
$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=$sslmode";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    // Connection successful
    //echo "Connected to Supabase Postgres via PDO\n";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage() . "\n";
}
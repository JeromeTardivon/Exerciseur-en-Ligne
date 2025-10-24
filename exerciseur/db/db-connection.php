<?php
// Replace these with your project's values
$host = 'db.cpedsmroqzcwzmqmktjg.supabase.co';
$port = '5432';
$db   = 'postgres';
$user = 'postgres';
$pass = 'Xercizor3000';
$sslmode = 'require';

// DSN
$dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode={$sslmode}";   

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    // Connection successful
    echo "Connected to Supabase Postgres via PDO\n";
} catch (PDOException $e) {
    // Handle error (do not expose $e->getMessage() in production)
    echo "Connection failed: " . $e->getMessage() . "\n";
}
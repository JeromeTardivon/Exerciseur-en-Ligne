<?php
//add the file .env to the project to load the environment variables
include_once __DIR__ . '/../db/Database.php';
use \db\Database;

$dbInstance = Database::getInstance();
$db = $dbInstance->getDb();
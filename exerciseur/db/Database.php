<?php

namespace db;
include_once __DIR__ . '/../config/DotEnv.php';

use config\DotEnv;
use PDO;
use PDOException;

class Database
{
    private $db = null;
    private static $instance;

    private function __construct()
    {
        $env = new DotEnv();
        $env->load(__DIR__ . '../../..');
        $host = getenv('HOST_DB');
        $port = getenv('PORT_DB');
        $dbName = getenv('NAME_DB');
        $user = getenv('USER_DB');
        $pass = getenv('PASSWORD_DB');
        $dsn = "mysql:host=$host;port=$port;dbname=$dbName";

        try {
            $this->db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            // Connection successful
            //echo "Connected to bd mariadb via PDO\n";
        } catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage() . "\n";
        }
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getDb(): PDO
    {
        return $this->db;
    }
}
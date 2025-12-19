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

    function getClasses($teacherId): array
    {
        $listClasses = array();
        $statement = $this->getDb()->prepare("SELECT * FROM inclass WHERE id_user LIKE '$teacherId'");
        $statement->execute();
        $classes = $statement->fetchAll();
        foreach ($classes as $class) {
            $listClasses[] = $this->getClass($class['id_class']);
        }
        return $listClasses;
    }
    function getClass($idClass)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM class WHERE id = :id");
        $statement->execute(['id' => $idClass]);
        return $statement->fetch();
    }

    function getStudents(): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users");
        $statement->execute();
        return $statement->fetchAll();
    }

    function getUser($userId)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $userId]);
        return $statement->fetch();
    }

    function getResponsableFromClass($classId)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM inclass WHERE id_class = '$classId' AND responsible LIKE 1");
        $statement->execute();
        return $this->getUser($statement->fetch()['id_user']);
    }

    function addStudentsToClassDB($listIdStudents, $classId): void
    {
        foreach ($listIdStudents as $student) {
            $statement = $this->getDb()->prepare("SELECT COUNT(id_user) as nb FROM inclass WHERE id_user = '$student' AND id_class = '$classId'");
            $statement->execute();
            $existStudent = $statement->fetch();
            if ($existStudent['nb'] == 0) {
                $statement = $this->getDb()->prepare("INSERT INTO inclass (id_user, id_class, responsible) VALUES ('$student', '$classId', 0)");
                $statement->execute();
            }
        }
    }

    function addStudentToClassByCode($studentId, $code): void
    {
        $statement = $this->getDb()->prepare("SELECT id_associated FROM codes_class WHERE code = '$code' AND num_usage > 0");
        $statement->execute();
        $class = $statement->fetch();
        if ($class) {
            $this->getDb()->beginTransaction();
            $statement = $this->getDb()->prepare("UPDATE codes_class SET num_usage := num_usage - 1 WHERE code = '$code'");
            $statement->execute();
            $this->addStudentsToClassDB([$studentId], $class['id_associated']);
            $this->getDb()->commit();
        }
    }

    function getStudentsFromClass($classId): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM inclass WHERE id_class = '$classId' AND responsible LIKE 0");
        $statement->execute();
        return $statement->fetchAll();
    }
    function deleteStudentFromClassDB($classId, $studentId): void
    {
        $statement = $this->getDb()->prepare("DELETE FROM inclass WHERE id_class = '$classId' AND id_user = '$studentId'");
        $statement->execute();
    }

    function updateClass($classId, $name, $description): void
    {
        $statement = $this->getDb()->prepare("UPDATE class SET description = '$description', name = '$name' WHERE id = '$classId'");
        $statement->execute();
    }

    function generateCode($idAssociated, $nUses): string
    {
        $code = bin2hex(random_bytes(5));
        $statement = $this->getDb()->prepare("SELECT * FROM codes_class WHERE code = '$code'");
        $statement->execute();
        $codeClass = $statement->fetch();
        if ($codeClass) {
            while ($codeClass['code'] == $code) {
                $code = bin2hex(random_bytes(5));
            }
        }
        $statement = $this->getDb()->prepare("INSERT INTO codes_class (code,num_usage, id_associated) VALUES ('$code', '$nUses', '$idAssociated')");
        $statement->execute();
        return $code;
    }


    function getClassCodes($classId): array
    {
        $statement = $this->getDb()->prepare("SELECT code, num_usage FROM codes_class WHERE id_associated = '$classId' AND num_usage > 0");
        $statement->execute();
        return $statement->fetchAll();
    }

    function getGrades($id): array
    {
        $command = $this->getDb()->prepare("SELECT e.id, c.title, r.grade, r.created_at FROM result r JOIN exercise e ON r.id_exercise = e.id JOIN chapter c ON r.id_subject = c.id WHERE r.id_user = :user");
        $command->execute(["user" => $id]);
        return $command->fetchAll();
    }

    function getChaptersClass($idClass): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM chapter WHERE class = '$idClass'");
        $statement->execute();
        return $statement->fetchAll();
    }

    function getChaptersTeacher($idTeacher): array
    {
        $listChapters = [];
        $listClasses = $this->getClasses($idTeacher);
        foreach ($listClasses as $class) {
            foreach ($this->getChaptersClass($class['id']) as $chapter) {
                $listChapters[] = $chapter;
            }
        }
        return $listChapters;
    }

    public function studentSearchFromClass($classId, $search) {
        $statement = $this->getDb()->prepare("SELECT * FROM users u JOIN inclass i ON u.id = i.id_user
                                             WHERE u.name LIKE concat('%', :search, '%') AND
                                             i.id_class = '$classId' AND responsible LIKE 0");
        $statement->execute([
            "search" => $search
        ]);
        return $statement->fetchAll();
    }

    public function classSearchFromTeacher($teacherId, $search) {
        $listClasses = array();
        $statement = $this->getDb()->prepare("SELECT * FROM inclass i JOIN class c ON i.id_class = c.id
                                             WHERE id_user LIKE '$teacherId' AND c.name LIKE concat('%', :search, '%')");
        $statement->execute([
            "search" => $search
        ]);
        $classes = $statement->fetchAll();
        foreach ($classes as $class) {
            $listClasses[] = $this->getClass($class['id_class']);
        }
        return $listClasses;
    }
}
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

    public function getClasses($teacherId): array
    {
        $listClasses = array();
        $statement = $this->getDb()->prepare("SELECT * FROM users_classses WHERE id_user LIKE '$teacherId'");
        $statement->execute();
        $classes = $statement->fetchAll();
        foreach ($classes as $class) {
            $listClasses[] = $this->getClass($class['id_class']);
        }
        return $listClasses;
    }
    public function getClass($idClass)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM classses WHERE id = :id");
        $statement->execute(['id' => $idClass]);
        return $statement->fetch();
    }

    public function getStudents(): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getUser($userId)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $userId]);
        return $statement->fetch();
    }

    public function getResponsableFromClass($classId): array
    {
        $teachers = [];
        $statement = $this->getDb()->prepare("SELECT * FROM users_classses WHERE id_class = '$classId' AND responsible LIKE 1");
        $statement->execute();
        foreach ($statement->fetchAll() as $teacher) {
            $teachers[]= $this->getUser($teacher['id_user']);
        }
        return $teachers;
    }

    public function addStudentsToClassDB($listIdStudents, $classId): void
    {
        foreach ($listIdStudents as $student) {
            $statement = $this->getDb()->prepare("SELECT COUNT(id_user) as nb FROM users_classses WHERE id_user = '$student' AND id_class = '$classId'");
            $statement->execute();
            $existStudent = $statement->fetch();
            if ($existStudent['nb'] == 0) {
                $statement = $this->getDb()->prepare("INSERT INTO users_classses (id_user, id_class, responsible) VALUES ('$student', '$classId', 0)");
                $statement->execute();
            }
        }
    }

    public function addStudentToClassByCode($studentId, $code): void
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

    public function getStudentsFromClass($classId): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users_classses WHERE id_class = '$classId' AND responsible LIKE 0");
        $statement->execute();
        return $statement->fetchAll();
    }
    public function deleteFromClass($classId, $id): void
    {
        $statement = $this->getDb()->prepare("DELETE FROM users_classses WHERE id_class = '$classId' AND id_user = '$id'");
        $statement->execute();
    }

    public function updateClass($classId, $name, $description): void
    {
        $statement = $this->getDb()->prepare("UPDATE class SET description = '$description', name = '$name' WHERE id = '$classId'");
        $statement->execute();
    }

    public function generateCode($idAssociated, $nUses): string
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


    public function getClassCodes($classId): array
    {
        $statement = $this->getDb()->prepare("SELECT code, num_usage FROM codes_class WHERE id_associated = '$classId' AND num_usage > 0");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getGrades($id): array
    {
        $command = $this->getDb()->prepare("SELECT e.id, c.title, r.grade, r.created_at FROM result r JOIN exercises e ON r.id_exercise = e.id JOIN chapters c ON r.id_subject = c.id WHERE r.id_user = :user");
        $command->execute(["user" => $id]);
        return $command->fetchAll();
    }

    public function getChaptersClass($idClass): array
    {
        $statement = $this->getDb()->prepare("SELECT * FROM chapters WHERE class = '$idClass'");
        $statement->execute();
        return $statement->fetchAll();
    }

    function getChapter($idChapter)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM chapters WHERE id = :id");
        $statement->execute(['id' => $idChapter]);
        return $statement->fetch();
    }

    function getChaptersTeacher($idTeacher): array
    {
        $listChapters = [];
        $statement = $this->getDb()->prepare("SELECT id_chapter FROM owns WHERE id_user='$idTeacher'");
        $statement->execute();

        $listidChapters=$statement->fetchAll();
        foreach ($listidChapters as $idChapter) {
            $listChapters[] = $this->getChapter($idChapter['id_chapter']);
        }
        return $listChapters;
    }

    public function studentSearch($search, $exemptClass) {
        $statement = $this->getDb()->prepare("(SELECT u.id, u.name, u.surname, u.email, u.type, u.schoolId FROM users u
                                             WHERE (u.name LIKE concat('%', :search, '%') OR u.surname LIKE concat('%', :search, '%'))
                                             EXCEPT
                                             SELECT u.id, u.name, u.surname, u.email, u.type, u.schoolId FROM users u JOIN users_classses i ON u.id = i.id_user
                                             WHERE i.id_class = :exemptClass)
                                             ORDER BY surname ASC");
        $statement->execute([
            "search" => $search,
            "exemptClass" => $exemptClass
        ]);
        return $statement->fetchAll();
    }

    public function teacherSearch($search, $exemptClass) {
        $statement = $this->getDb()->prepare("(SELECT u.id, u.name, u.surname, u.email, u.type, u.schoolId FROM users u
                                             WHERE (u.name LIKE concat('%', :search, '%') OR u.surname LIKE concat('%', :search, '%')) AND u.type NOT LIKE 'student'
                                             EXCEPT
                                             SELECT u.id, u.name, u.surname, u.email, u.type, u.schoolId FROM users u JOIN users_classses i ON u.id = i.id_user
                                             WHERE i.id_class = :exemptClass AND u.type NOT LIKE 'student')
                                             ORDER BY surname ASC");
        $statement->execute([
            "exemptClass" => $exemptClass
        ]);
        return $statement->fetchAll();
    }

    public function classSearchFromTeacher($teacherId, $search) {
        $listClasses = array();
        $statement = $this->getDb()->prepare("SELECT * FROM users_classses i JOIN classses c ON i.id_class = c.id
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

    public function chapterSearchFromTeacher($teacherId, $search) {
        $statement = $this->getDb()->prepare("SELECT * FROM owns o JOIN chapters c ON o.id_chapter = c.id
                                             WHERE o.id_user LIKE '$teacherId' AND c.title LIKE concat('%', :search, '%')");
        $statement->execute([
            "search" => $search
        ]);
        return $statement->fetchAll();
    }

    public function createUser($lastname, $name, $email, $password, $type, $userSchoolId, $teacherCode): void
    {
        $statement = $this->getDb()->prepare("SELECT email FROM users s WHERE s.email LIKE :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();
        if (!$user) {
            if ($type == 'teacher') {
                $statement =  $this->getDb()->prepare("SELECT code FROM codes_class WHERE code = :code ");
                $statement->execute(['code' => $teacherCode]);
                $code = $statement->fetch();
                if ($code) {
                    var_dump($code['code']);
                    $this->getDb()->beginTransaction();
                    $statement =  $this->getDb()->prepare("DELETE FROM codes_class WHERE code = :code");
                    $statement->execute(['code' => $code['code']]);
                    $statement =  $this->getDb()->prepare("INSERT INTO users (name, surname, email, password, type, schoolId) VALUES (:lastname, :surName, :email, :password, :type, :schoolId)");
                    $statement->execute(['email' => $email, 'lastname' => $lastname, 'surName' => $name, 'password' => password_hash($password, PASSWORD_DEFAULT), 'type' => $type, 'schoolId' => $userSchoolId]);
                    $this->getDb()->commit();
                }
            } else {
                $statement =  $this->getDb()->prepare("INSERT INTO users (name, surname, email, password, type, schoolId) VALUES (:lastname, :surName, :email, :password, :type, :schoolId)");
                $statement->execute(['email' => $email, 'lastname' => $lastname, 'surName' => $name, 'password' => password_hash($password, PASSWORD_DEFAULT), 'type' => $type, 'schoolId' => $userSchoolId]);
            }
        }
    }

    public function getExercisesNumberFromChapter($chapterId): int
    {
        $statement = $this->getDb()->prepare("SELECT COUNT(id) as nb FROM exercises WHERE id_chapter = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return (int)$result['nb'];
    }

    public function chapterBelongsToTeacher($chapterId, $teacherId): bool
    {
        $statement = $this->getDb()->prepare("SELECT * FROM owns WHERE id_chapter = :chapterId AND id_user = :teacherId");
        $statement->execute(['chapterId' => $chapterId, 'teacherId' => $teacherId]);
        $result = $statement->fetch();
        return $result !== false;
    }


    public function getExerciseIdFromNum($chapterId, $exerciseNum): string
    {
        $statement = $this->getDb()->prepare("SELECT id FROM exercises WHERE id_chapter = :chapterId ORDER BY created_at ASC");
        $offset = $exerciseNum - 1;
    
        $statement->execute(
            ['chapterId' => $chapterId]
        );

        for ($i = 0; $i < $offset; $i++) {

            $result = $statement->fetch();
        }
        $result = $statement->fetch();
         
        
        
        return $result['id'];
    }

    public function getExerciseContent($exerciseId): string
    {
        $statement = $this->getDb()->prepare("SELECT content FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return $result['content'];
    }

    public function searchClassByTitleDesc($word): array

    {
        $command = $this->getDb()->prepare("SELECT name, id FROM classses WHERE name LIKE concat('%', :title, '%')");
        $command->execute([
            "title" => $word
        ]);
        return $command->fetchAll();
    }
    public  function searchChapitreByTitleDesc($word): array
    {
    $command = $this->getDb()->prepare("SELECT title, description, id FROM chapters WHERE 

        (title LIKE concat('%', :title, '%') OR description LIKE concat('%', :title, '%')) AND visible = TRUE");
        $command->execute([
            "title" => $word
        ]);
        return $command->fetchAll();
    }


    public function getTitleExercise($exerciseId): string
    {
        $statement = $this->getDb()->prepare("SELECT title FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return $result['title'];
    }

    public function addResponsible($idTeacher, $idClass): void
    {
        $statement = $this->getDb()->prepare("SELECT id_user FROM users_classses WHERE id_user LIKE :user AND id_class LIKE :class");
        $statement->execute(['user' => $idTeacher, 'class' => $idClass]);
        $user = $statement->fetch();
        if ($user) {
            $this->getDb()->beginTransaction();
            $statement = $this->getDb()->prepare("UPDATE users_classses SET responsible = 1 WHERE id_user LIKE :user AND id_class LIKE :class");
            $statement->execute(['user' => $idTeacher, 'class' => $idClass]);
            $this->getDb()->commit();
        }else{
            $statement =  $this->getDb()->prepare("INSERT INTO users_classses (id_user, id_class, responsible) VALUES (:user, :class, 1)");
            $statement->execute(['user' => $idTeacher, 'class' => $idClass]);
        }
    }
    public function getExerciseCoefficient($exerciseId): float
    {
        $statement = $this->getDb()->prepare("SELECT coef FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return (float)$result['coef'];
    }

    public function getExerciseTimeLimit($exerciseId): int
    {
        $statement = $this->getDb()->prepare("SELECT timesec FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return (int)$result['timesec'];
    }

    public function getExerciseTriesLimit($exerciseId): ?int
    {
        $statement = $this->getDb()->prepare("SELECT tries FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return $result['tries'] !== null ? (int)$result['tries'] : null;
    }
    public function getExerciseAnsDef($exerciseId): int
    {
        $statement = $this->getDb()->prepare("SELECT ansdef FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return (int)$result['ansdef'];
    }
    public function getExerciseShowAns($exerciseId): int
    {
        $statement = $this->getDb()->prepare("SELECT showans FROM exercises WHERE id = :exerciseId");
        $statement->execute(['exerciseId' => $exerciseId]);
        $result = $statement->fetch();
        return (int)$result['showans'];
    }
  
    public function getChapterVisibility($chapterId): int
    {
        $statement = $this->getDb()->prepare("SELECT visible FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return (int)$result['visible'];
    }

    public function getChapterLevel($chapterId): int
    {
        $statement = $this->getDb()->prepare("SELECT level FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return (int)$result['level'];
    }

    public function getChapterTimeLimit($chapterId): ?int
    {
        $statement = $this->getDb()->prepare("SELECT secondstimelimit FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['secondstimelimit'] !== null ? (int)$result['secondstimelimit'] : null;
    }

    public function getChapterClass($chapterId): string
    {
        $statement = $this->getDb()->prepare("SELECT class FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['class'];
    }

    public function getClassName($classId): string
    {
        $statement = $this->getDb()->prepare("SELECT name FROM classses WHERE id = :classId");
        $statement->execute(['classId' => $classId]);
        $result = $statement->fetch();
        return $result['name'];
    }

    public function getChapterWeight($chapterId): ?int
    {
        $statement = $this->getDb()->prepare("SELECT weight FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['weight'] == null||$result['weight']=='' ?  null : $result['weight'];
    }

    public function getChapterTries($chapterId): ?int
    {
        $statement = $this->getDb()->prepare("SELECT tries FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['tries'] == null||$result['tries']=='' ?  null : $result['tries'];
    }

    public function getChapterCorrend($chapterId): int
    {
        $statement = $this->getDb()->prepare("SELECT corrend FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return (int)$result['corrend'];
    }
    public function getChapterTitle($chapterId): string
    {
        $statement = $this->getDb()->prepare("SELECT title FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['title'];
    }
    public function getChapterDescription($chapterId): string
    {
        $statement = $this->getDb()->prepare("SELECT description FROM chapters WHERE id = :chapterId");
        $statement->execute(['chapterId' => $chapterId]);
        $result = $statement->fetch();
        return $result['description'];
    }
  
    public function getUserByEmail($email)
    {
        $statement = $this->getDb()->prepare("SELECT * FROM users WHERE email = :emailUser");
        $statement->execute(['emailUser' => $email]);
        return $statement->fetch();
    }

    public function haveUserDoneExercise($idUser, $idChapter, $exerciseNum): bool{
        $idExercise=$this->getExerciseIdFromNum($idChapter,$exerciseNum);
        $statement=$this->getDb()->prepare("SELECT * FROM users_exercises WHERE id_user= :iduser AND id_exercise= :idexercise");

        $statement->execute(['iduser'=>$idUser, 'idexercise'=>$idExercise]);
        if($statement->fetch()){
            return true;
        }
        return false;
    }
}
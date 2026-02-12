DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS inclass, result;
DROP TABLE IF EXISTS exercise;
DROP TABLE IF EXISTS users, class, chapter;

CREATE TABLE users (
  id uuid PRIMARY KEY DEFAULT SYS_GUID(),
  name varchar(50),
  surname varchar (50),
  email varchar(100) NOT NULL UNIQUE,
  password text NOT NULL,
  type varchar(20) NOT NULL DEFAULT 'student',
  schoolId varchar(15),
  created_at timestamp NOT NULL DEFAULT now(),
  updated_at timestamp NOT NULL DEFAULT now()
);


CREATE TABLE classses(
  id uuid PRIMARY KEY DEFAULT SYS_GUID(),
  name varchar(100) NOT NULL,
  created_at timestamp NOT NULL DEFAULT now(),
  updated_at timestamp NOT NULL DEFAULT now()
);

CREATE TABLE `chapters` (
  `id` uuid NOT NULL DEFAULT sys_guid(),
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `level` int(11) NOT NULL DEFAULT 0,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `secondstimelimit` int(11) DEFAULT NULL,
  `corrend` int(11) DEFAULT 0,
  `tries` int(11) DEFAULT 0,
  `weight` int(11) DEFAULT NULL,
  `class` uuid DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
)

CREATE TABLE `exercises` (
  `id` uuid NOT NULL DEFAULT sys_guid(),
  `title` varchar(100) DEFAULT NULL,
  `random` tinyint(1) NOT NULL DEFAULT 0,
  `coef` int(11) DEFAULT 1,
  `timesec` int(11) DEFAULT NULL,
  `tries` varchar(100) DEFAULT NULL,
  `content` text NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT 0,
  `ansdef` tinyint(1) NOT NULL DEFAULT 0,
  `showans` tinyint(1) DEFAULT NULL,
  `grade` float DEFAULT NULL,
  `id_chapter` uuid NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_exercise__chapter` (`id_chapter`),
  CONSTRAINT `FK_exercise__chapter` FOREIGN KEY (`id_chapter`) REFERENCES `chapter` (`id`)
)

CREATE TABLE users_classses(
  id_user uuid NOT NULL,
  id_class uuid NOT NULL,
  responsible BOOLEAN NOT NULL DEFAULT false,
  joined_at timestamp NOT NULL DEFAULT now(),
  CONSTRAINT FK_inClass__user FOREIGN KEY (id_user) REFERENCES users(id),
  CONSTRAINT FK_inclass__class FOREIGN KEY (id_class) REFERENCES class(id),
  PRIMARY KEY (id_user,id_class)
);


CREATE TABLE results(
  id uuid PRIMARY KEY DEFAULT SYS_GUID(),
  id_subject uuid,
  id_user uuid,
  id_exercise uuid,
  id_class uuid,
  created_at timestamp NOT NULL DEFAULT now(),
  grade INT NOT NULL DEFAULT 0,
  CONSTRAINT FK_result__chapter FOREIGN KEY (id_subject) REFERENCES chapter(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__exercise FOREIGN KEY (id_exercise) REFERENCES exercise(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__class FOREIGN KEY (id_class) REFERENCES class(id) ON DELETE SET NULL
);



CREATE TABLE `owns` (
  `id_user` uuid NOT NULL,
  `id_chapter` uuid NOT NULL,
  PRIMARY KEY (`id_user`,`id_chapter`)
)

CREATE TABLE tags(
id uuid PRIMARY KEY DEFAULT SYS_GUID(),
tag VARCHAR(20),
weight INT DEFAULT 1
);

CREATE TABLE chapters_tags(
tag_id uuid,
chapter_id uuid,
CONSTRAINT PRIMARY KEY (tag_id,chapter_id)
);

INSERT INTO tags (tag,weight) VALUES ("maths",2),("mathématiques",2),("stats",4),("statistiques",4),
("probablilitées",4),("proba",4),("programation",2),("java",3),("javascript",3),("processing",3),
("c++",3),("html",3),("css",3),("php",3),("qt",4),("arduino",3),("ensembles",5),("dénombrement",5),
("proba élémentaires",5),("probailitées élémentaires",5),("proba conditionelles",5),("probailitées conditionelles",5),
("variables aléatoires",4),("variables aléatoires discrètes",5),("variables aléatoires continues",5),("lois de proba",4),
("lois de probabilitéées",4),("lois discrètes",5),("lois continues",5),("loi de bernoulli",6),("loi binomiale",6)
,("loi géométrique",6),("loi de pascal",6),("loi hypergéométrique",6),("loi de poisson",6),("loi uniforme",6)
,("loi exponentielle",6),("loi normales",6),("loi normale",6);

CREATE TABLE `users_exercises` (
  `id_user` uuid NOT NULL,
  `id_exercise` uuid NOT NULL,
  `answer` text NOT NULL,
  `grade` double DEFAULT NULL,
  PRIMARY KEY (`id_user`,`id_exercise`),
  KEY `users_exercises_exercise_FK` (`id_exercise`),
  CONSTRAINT `users_exercises_exercise_FK` FOREIGN KEY (`id_exercise`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_exercises_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)

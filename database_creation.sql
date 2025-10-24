DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS inclass, result;
DROP TABLE IF EXISTS exercise;
DROP TABLE IF EXISTS users, class, chapter;

CREATE TABLE users (
  id INT NOT NULL ,
  name varchar(50),
  surname varchar (50),
  mail varchar(50),
  password varchar(20),
  type varchar(20),
  PRIMARY KEY (id)
);


CREATE TABLE class(
  id INT NOT NULL,
  name varchar(100),
  PRIMARY KEY (id)
);

CREATE TABLE chapter(
  id INT NOT NULL,
  visible BOOLEAN,
  level INT,
  title VARCHAR(100),
  description VARCHAR(2000),
  timelimit INT,
  coef INT,
  PRIMARY KEY (id)
);

CREATE TABLE exercise(
  id INT NOT NULL,
  random BOOLEAN,
  coef INT,
  content TEXT,
  type INT NOT NULL,
  id_chapter INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_exercise__chapter FOREIGN KEY (id_chapter) REFERENCES chapter(id)
);

CREATE TABLE inclass(
  id_user INT NOT NULL,
  id_class INT NOT NULL,
  responsible BOOLEAN,
  CONSTRAINT FK_inClass__user FOREIGN KEY (id_user) REFERENCES users(id),
  CONSTRAINT FK_inclass__class FOREIGN KEY (id_class) REFERENCES class(id)
);


CREATE TABLE result(
  id INT NOT NULL,
  id_subject INT NOT NULL,
  id_user INT NOT NULL,
  id_exercise INT NOT NULL,
  id_class INT,
  CONSTRAINT FK_grade__chapter FOREIGN KEY (id_subject) REFERENCES chapter(id),
  CONSTRAINT FK_grade__user FOREIGN KEY (id_user) REFERENCES users(id),
  CONSTRAINT FK_grade__exercise FOREIGN KEY (id_exercise) REFERENCES exercise(id),
  CONSTRAINT FK_grade__class FOREIGN KEY (id_class) REFERENCES class(id),
  PRIMARY KEY (id)
);

CREATE TABLE course(
  id INT NOT NULL,
  id_chapter INT NOT NULL,
  content TEXT,
  PRIMARY KEY (id),
  CONSTRAINT FK_course__chapter FOREIGN KEY (id_chapter) REFERENCES chapter(id)
);


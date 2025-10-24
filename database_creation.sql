DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS inclass, result;
DROP TABLE IF EXISTS exercise;
DROP TABLE IF EXISTS users, class, chapter;

CREATE TABLE users (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name varchar(50),
  surname varchar (50),
  mail varchar(100) NOT NULL UNIQUE,
  password text NOT NULL,
  type varchar(20) NOT NULL DEFAULT 'student',
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now()
);


CREATE TABLE class(
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name varchar(100) NOT NULL,
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now()
);

CREATE TABLE chapter(
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  visible BOOLEAN NOT NULL DEFAULT true,
  level INT NOT NULL DEFAULT 0,
  title VARCHAR(100) NOT NULL,
  description text,
  minutestimelimit INT, 
  coef INT DEFAULT 1,
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now()
);

CREATE TABLE exercise(
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  random BOOLEAN NOT NULL DEFAULT false,
  coef INT DEFAULT 1,
  content TEXT NOT NULL,
  type INT NOT NULL,
  id_chapter uuid NOT NULL,
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT FK_exercise__chapter FOREIGN KEY (id_chapter) REFERENCES chapter(id)
);

CREATE TABLE inclass(
  id_user uuid NOT NULL,
  id_class uuid NOT NULL,
  responsible BOOLEAN NOT NULL DEFAULT false,
  joined_at timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT FK_inClass__user FOREIGN KEY (id_user) REFERENCES users(id),
  CONSTRAINT FK_inclass__class FOREIGN KEY (id_class) REFERENCES class(id),
  PRIMARY KEY (id_user,id_class)
);


CREATE TABLE result(
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  id_subject uuid,
  id_user uuid,
  id_exercise uuid,
  id_class uuid,
  created_at timestamptz NOT NULL DEFAULT now(),
  grade INT NOT NULL DEFAULT 0,
  CONSTRAINT FK_result__chapter FOREIGN KEY (id_subject) REFERENCES chapter(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__exercise FOREIGN KEY (id_exercise) REFERENCES exercise(id) ON DELETE SET NULL,
  CONSTRAINT FK_result__class FOREIGN KEY (id_class) REFERENCES class(id) ON DELETE SET NULL
);

CREATE TABLE course(
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  id_chapter uuid NOT NULL,
  content TEXT,
  created_at timestamptz NOT NULL DEFAULT now(),
  updated_at timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT FK_course__chapter FOREIGN KEY (id_chapter) REFERENCES chapter(id)
);

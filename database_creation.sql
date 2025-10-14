
DROP TABLE IF EXISTS Class;
DROP TABLE IF EXISTS public.Admin, public.Professor, public.Student;
DROP TABLE IF EXISTS public.User;

CREATE TABLE public.User (
  id INT NOT NULL ,
  name varchar(50),
  surname varchar (50),
  PRIMARY KEY (id)
);

CREATE TABLE Admin (
  id INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_Admin__User FOREIGN KEY  (id) REFERENCES public.User(id)
);

CREATE TABLE Student (
  id INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_Student__User FOREIGN KEY  (id) REFERENCES public.User(id)
);

CREATE TABLE Professor (
  id INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_Professor__User FOREIGN KEY  (id) REFERENCES public.User(id)
);

CREATE TABLE CLASS(
  id INT NOT NULL,
  
  PRIMARY KEY (id),

)


USE cmsphp;

DROP TABLE IF EXISTS posts;
CREATE TABLE IF NOT EXISTS posts (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(64) NOT NULL,
  content text(8192) NOT NULL,
  authorId int NOT NULL,
  imageId int,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id int NOT NULL AUTO_INCREMENT,
  email varchar(32) NOT NULL,
  firstName varchar(32) NOT NULL,
  lastName varchar(32) NOT NULL,
  password varchar(64) NOT NULL,
  roles varchar(32) NOT NULL DEFAULT 'ROLE_USER',
  PRIMARY KEY (id)
);
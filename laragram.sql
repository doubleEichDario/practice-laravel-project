CREATE DATABASE IF NOT EXISTS laragram;
USE laragram;

CREATE TABLE IF NOT EXISTS users(

  id                  int(255) auto_increment not null,
  role                varchar(20),
  name                varchar(100),
  surname             varchar(200),
  nick                varchar(100),
  email               varchar(255),
  password            varchar(255),
  image               varchar(255),
  created_at          datetime,
  updated_at          datetime,
  remember_token      varchar(255),

  CONSTRAINT pk_users PRIMARY KEY(id)

)ENGINE = InnoDb;

INSERT INTO users VALUES(null, 'user', 'Darío', 'Hernández', 'Dar', 'ledario.hernandez@gmail.com', '123', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'John', 'Doe', 'Doe', 'doe_rocks@fakemail.net', '456', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Raymond', 'Reddington', 'Red', 'red_reddington@cabal.com', '789', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Thomas', 'Kirkman', 'Tom', 'thomas_kirkman@thewhitehouse.gov', '321', null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images(

  id            int(255) auto_increment not null,
  user_id       int(255),
  image_path    varchar(255),
  description   text,
  created_at    DATETIME,
  updated_at    DATETIME,

  CONSTRAINT pk_images PRIMARY KEY(id),
  CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)

)ENGINE = InnoDb;

INSERT INTO images VALUES(null, 1, 'test1.jpg', 'Test description 1.', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 2, 'test2.jpg', 'Test description 2.', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 3, 'test3.jpg', 'Test description 3.', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 4, 'test4.jpg', 'Test description 4.', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'beach.jpg', 'Description of a trip to the beach.', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments(

  id            int(255) auto_increment NOT NULL,
  user_id       int(255),
  image_id      int(255),
  content       TEXT,
  created_at    DATETIME,
  updated_at    DATETIME,

  CONSTRAINT pk_comments PRIMARY KEY(id),
  CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
  CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)

)ENGINE = InnoDb;

INSERT INTO comments VALUES(null, 2, 5, 'Great day at the beach!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 1, 4, 'Just a comment to fill database', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 1, 3, 'Comment comment comment!', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(

  id            INT(255) auto_increment NOT NULL,
  user_id       INT(255),
  image_id      INT(255),
  created_at    DATETIME,
  updated_at    DATETIME,

  CONSTRAINT pk_likes PRIMARY KEY(id),
  CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
  CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)

)ENGINE = InnoDb;

INSERT INTO likes VALUES(null, 4, 5, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 5, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 1, CURTIME(), CURTIME());

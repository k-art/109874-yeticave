CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE categories (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  name  CHAR(32)
);

CREATE TABLE lot (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  creation_date  DATETIME,
  name  CHAR(128),
  description  TEXT,
  img_url  CHAR(128),
  init_price  INT,
  expire_date  DATETIME,
  bet_step  INT,
  favorites INT,

  autor_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE bets (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  date  DATETIME,
  price INT,

  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  registr_date DATETIME,
  email CHAR(128),
  name CHAR(128),
  password CHAR(128),
  avatar_url CHAR(128),
  contacts CHAR(128)
);

CREATE INDEX category on categories(name);
CREATE INDEX lot_id on lot(id);
CREATE UNIQUE INDEX lot_name on lot(name);
CREATE UNIQUE INDEX user_email ON users(email);
CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE IF NOT EXISTS categories (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(128)
);

CREATE TABLE IF NOT EXISTS lots (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  creation_date  DATETIME,
  lot_name  VARCHAR(128),
  description  TEXT,
  lot_image  VARCHAR(255),
  init_price  DECIMAL,
  expire_date  DATETIME,
  bet_step  INT,
  favorites_count INT,

  author_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE IF NOT EXISTS bets (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  date  DATETIME,
  price DECIMAL,

  user_id INT,
  lot_id INT
);

CREATE TABLE IF NOT EXISTS users (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  email VARCHAR(128),
  name VARCHAR(128),
  password CHAR(60),
  avatar VARCHAR(255),
  user_contacts VARCHAR(255)
);

CREATE INDEX category on categories(id);
CREATE INDEX lot_id on lots(id);
CREATE UNIQUE INDEX user_email ON users(email);
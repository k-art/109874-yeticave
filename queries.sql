USE yeticave;

INSERT INTO
  categories(name)
VALUES
  ('Доски и лыжи'),
  ('Крепления'),
  ('Ботинки'),
  ('Одежда'),
  ('Инструменты'),
  ('Разное');

INSERT INTO
  users(creation_date, name, email, password, avatar)
VALUES
  ('2017-09-01 10:00:00', 'Игнат', 'ignat.v@gmail.com', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', 'img/user.jpg'),
  ('2017-09-09 10:00:00', 'Леночка', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', null),
  ('2017-09-02 10:00:00', 'Руслан', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'img/user.jpg');

INSERT INTO
  bets(date, price, user_id, lot_id)
VALUES
  ('2017-09-16 10:00:00', 12000, 3, 1),
  ('2017-09-10 12:00:00', 13000, 2, 1),
  ('2017-09-20 14:00:00', 165000, 2, 2),
  ('2017-09-26 19:00:00', 170000, 1, 2),
  ('2017-09-16 12:00:00', 8100, 2, 3),
  ('2017-09-17 12:00:00', 8200, 3, 3),
  ('2017-09-19 13:00:00', 12000, 1, 4),
  ('2017-09-20 12:00:00', 8500, 3, 5),
  ('2017-09-18 11:00:00', 6000, 3, 6);

INSERT INTO lots SET
  creation_date = '2017-09-11 00:00:00',
  lot_name = '2014 Rossignol District Snowboard',
  description = 'Легкий маневренный сноуборд...',
  lot_image = 'img/lot-1.jpg',
  init_price = 10999,
  expire_date = '2017-10-05 12:00:00',
  bet_step = 200,
  favorites_count = 0,
  category_id = 1,
  author_id = 1;

INSERT INTO lots SET
  creation_date = '2017-09-13 00:00:00',
  lot_name = 'DC Ply Mens 2016/2017 Snowboard',
  description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
  lot_image = 'img/lot-2.jpg',
  init_price = 159999,
  expire_date = '2017-10-30 12:00:00',
  bet_step = 500,
  favorites_count = 5,
  category_id = 1,
  author_id = 3;

INSERT INTO lots SET
  creation_date = '2017-09-12 13:00:00',
  lot_name = 'Крепления Union Contact Pro 2015 года размер L/XL',
  description = 'Шикарные крепления...',
  lot_image = 'img/lot-3.jpg',
  init_price = 8000,
  expire_date = '2017-10-27 12:00:00',
  bet_step = 100,
  favorites_count = 2,
  category_id = 2,
  author_id = 1;

INSERT INTO lots SET
  creation_date = '2017-09-14 14:00:00',
  lot_name = 'Ботинки для сноуборда DC Mutiny Charocal',
  description = 'Удобные ботинки...',
  lot_image = 'img/lot-4.jpg',
  init_price = 10999,
  expire_date = '2017-10-10 12:00:00',
  bet_step = 300,
  favorites_count = 2,
  category_id = 3,
  author_id = 3;

INSERT INTO lots SET
  creation_date = '2017-09-13 12:00:00',
  lot_name = 'Куртка для сноуборда DC Mutiny Charocal',
  description = 'Теплая куртка...',
  lot_image = 'img/lot-5.jpg',
  init_price = 7500,
  expire_date = '2017-12-29 12:00:00',
  bet_step = 200,
  favorites_count = 4,
  category_id = 4,
  author_id = 1;

INSERT INTO lots SET
  creation_date = '2017-09-10 12:00:00',
  lot_name = 'Маска Oakley Canopy',
  description = 'Супер маска...',
  lot_image = 'img/lot-6.jpg',
  init_price = 5400,
  expire_date = '2017-10-16 12:00:00',
  bet_step = 500,
  favorites_count = 1,
  category_id = 6,
  author_id = 2;

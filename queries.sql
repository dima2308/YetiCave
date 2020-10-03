USE yeticave;

INSERT INTO
  category(cat_name, cat_img)
VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

INSERT INTO
  lot(
    data_create,
    name,
    description,
    url,
    start_price,
    data_stop,
    bet_step,
    likes,
    author_id,
    category_id
  )
VALUES
  (
    NOW(),
    '2014 Rossignol District Snowboard',
    'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и
    четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд
    отличной гибкостью и отзывчивостью  , а симметричная геометрия в сочетании с классическим
    прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня
    сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от
    Шона Кливера еще никого не оставляла равнодушным.',
    'img/lot-1.jpg',
    10999,
    NOW() + INTERVAL 10 DAY,
    300,
    0,
    1,
    1
  ),
  (
    NOW(),
    'DC Ply Mens 2016/2017 Snowboard',
    'Нет описания',
    'img/lot-2.jpg',
    159999,
    NOW() + INTERVAL 9 DAY,
    500,
    0,
    2,
    1
  ),
  (
    '2019-01-15',
    'Крепления Union Contact Pro 2015 года размер L/X',
    'Нет описания',
    'img/lot-3.jpg',
    8000,
    NOW() + INTERVAL 8 DAY,
    200,
    0,
    3,
    2
  ),
  (
    '2019-01-14',
    'Ботинки для сноуборда DC Mutiny Charocal',
    'Нет описания',
    'img/lot-4.jpg',
    10990,
    NOW() + INTERVAL 7 DAY,
    300,
    0,
    1,
    3
  ),
  (
    '2019-01-13',
    'Куртка для сноуборда DC Mutiny Charocal',
    'Нет описания',
    'img/lot-5.jpg',
    10990,
    NOW() + INTERVAL 6 DAY,
    300,
    0,
    2,
    4
  ),
  (
    '2019-01-18',
    'Маска Oakley Canopy',
    'Нет описания',
    'img/lot-6.jpg',
    5400,
    NOW() + INTERVAL 5 DAY,
    200,
    0,
    3,
    6
  );

INSERT INTO
  bet(data_bet, price, lot_id, user_id)
VALUES
  ('2019-01-17', 10000, 2, 1),
  ('2019-01-17', 20000, 3, 2),
  ('2019-01-17', 25000, 2, 3);

INSERT INTO
  users(data_reg, email, name, password, url, contact)
VALUES
  (
    '2019-01-17',
    'ignat.v@gmail.ru',
    'Игнат',
    '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
    '',
    ''
  ),
  (
    '2019-01-17',
    'kitty_93@li.ru',
    'Леночка',
    '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa',
    '',
    ''
  ),
  (
    '2019-01-17',
    'warrior07@mail.ru',
    'Руслан',
    '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
    '',
    ''
  );

/* Получить все категории 
 SELECT name FROM category;
 */
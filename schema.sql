USE yeticave;

DROP TABLE IF EXISTS category;

DROP TABLE IF EXISTS lot;

DROP TABLE IF EXISTS users;

DROP TABLE IF EXISTS bet;

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	cat_name CHAR(50) not null,
	cat_img CHAR(30)
);

CREATE UNIQUE INDEX category_id on category(id);

CREATE TABLE lot (
	id INT AUTO_INCREMENT PRIMARY KEY,
	data_create DATETIME not null,
	name CHAR(60) not null,
	description VARCHAR(1000) not null,
	url CHAR(100),
	start_price INT not null,
	data_stop DATETIME not null,
	bet_step INT not null,
	likes INT not null,
	author_id INT not null,
	winner_id INT,
	category_id INT not null
);

CREATE INDEX lot_name on lot(name);

CREATE TABLE bet (
	id INT AUTO_INCREMENT PRIMARY KEY,
	data_bet DATETIME not null,
	price INT not null,
	user_id INT,
	lot_id INT
);

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	data_reg DATETIME,
	email CHAR(80) not null,
	name CHAR(50) not null,
	password CHAR(100),
	url CHAR(100),
	contact VARCHAR(300)
);

CREATE UNIQUE INDEX email on users(email);

CREATE FULLTEXT INDEX name_descr ON lot (name, description);
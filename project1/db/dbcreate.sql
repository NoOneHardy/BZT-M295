DROP DATABASE IF EXISTS M295;
CREATE DATABASE IF NOT EXISTS M295;
USE M295;

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    price INT,
    kraftstoff VARCHAR(255),
    farbe VARCHAR(7),
    bauart VARCHAR(255),
    tank INT,
    jahrgang DATE,
    createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active TINYINT NOT NULL DEFAULT 1
);

INSERT INTO cars (name, price, kraftstoff, farbe, bauart, tank, jahrgang) VALUES
('Audi', 52642, 'Diesel', '#00ffff', 'Limousine', 0, '2019-08-07'),
('BMW', 60000, 'Benzin', '#ff0000', 'SUV', 0, '2018-07-06'),
('Mercedes', 70000, 'Diesel', '#00ff00', 'Limousine', 0, '2017-06-05'),
('Volkswagen', 50000, 'Benzin', '#0000ff', 'Kombi', 0, '2016-05-04'),
('Porsche', 80000, 'Diesel', '#ffff00', 'Sportwagen', 0, '2015-04-03'),
('Opel', 40000, 'Benzin', '#ff00ff', 'Kleinwagen', 0, '2014-03-02'),
('Ford', 45000, 'Diesel', '#00ffff', 'Limousine', 0, '2013-02-01'),
('Fiat', 35000, 'Benzin', '#ff0000', 'Kombi', 0, '2012-01-31'),
('Peugeot', 40000, 'Diesel', '#00ff00', 'SUV', 0, '2011-12-30'),
('Renault', 45000, 'Benzin', '#0000ff', 'Sportwagen', 0, '2010-11-29'),
('Tesla', 45000, 'Elektro', '#0000ff', 'Sportwagen', 0, '2015-10-23');

CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    vorname VARCHAR(255),
    adresse VARCHAR(255),
    plz VARCHAR(255),
    ort VARCHAR(255),
    createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active TINYINT NOT NULL DEFAULT 1
);

INSERT INTO customers (name, vorname, adresse, plz, ort) VALUES
('Muster', 'Max', 'Musterstrasse 1', '1234', 'Musterhausen'),
('Kahn', 'Hubert', 'Musterstrasse 6', '9000', 'Münchhausen'),
('Müller', 'Hans', 'Musterstrasse 3', '1234', 'Musterhausen'),
('Schmidt', 'Peter', 'Musterstrasse 4', '1234', 'Musterhausen'),
('Schulz', 'Karl', 'Musterstrasse 5', '1234', 'Musterhausen'),
('Fischer', 'Klaus', 'Musterstrasse 2', '1234', 'Musterhausen');

CREATE TABLE IF NOT EXISTS rental (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    customer_id INT NOT NULL,
    start_date DATE,
    end_date DATE,
    createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (car_id) REFERENCES cars(id),
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

INSERT INTO rental (car_id, customer_id, start_date, end_date) VALUES
(1, 1, '2023-08-07', '2023-08-08'),
(2, 2, '2023-07-06', '2023-07-07'),
(3, 3, '2023-06-05', '2023-06-06');

CREATE TABLE IF NOT EXISTS users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255)NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_Rights INT NOT NULL DEFAULT 9
) ENGINE=InnoDB;

INSERT INTO users (user_name, user_password, user_Rights) VALUES ('admin', '1234', 1);
INSERT INTO users (user_name, user_password, user_Rights) VALUES ('user', '1234', 5);
INSERT INTO users (user_name, user_password, user_Rights) VALUES ('guest', '1234', 9);